<?php

namespace hiam\components;

use DateTimeImmutable;
use filsh\yii2\oauth2server\models\OauthAccessTokens;
use filsh\yii2\oauth2server\models\OauthRefreshTokens;
use yii\db\ActiveQueryInterface;

/**
 * Class ActiveRecordTokenRevoker
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class ActiveRecordTokenRevoker implements TokenRevokerInterface
{
    /** {@inheritDoc} */
    public function __invoke(string $token, ?string $clientId = null, ?string $typeHint = null): bool
    {
        $buildQuery = static function (ActiveQueryInterface $query, ?string $clientId): ActiveQueryInterface {
            $query->andWhere(['>', 'expires', (new DateTimeImmutable())->format(DATE_ATOM)]);
            $query->andFilterWhere(['client_id' => $clientId]);

            return $query;
        };

        /** @var OauthAccessTokens $accessToken */
        $accessToken = $buildQuery(OauthAccessTokens::find(), $clientId)->andWhere(['access_token' => $token])->one();
        if ($typeHint === 'access_token') {
            return $this->revokeAccessToken($accessToken);
        }

        /** @var OauthRefreshTokens $refreshToken */
        $refreshToken = $buildQuery(OauthRefreshTokens::find(), $clientId)->andWhere(['refresh_token' => $token])->one();
        if ($typeHint === 'refresh_token') {
            return $this->revokeRefreshToken($refreshToken);
        }

        return $this->revokeAccessToken($accessToken) || $this->revokeRefreshToken($refreshToken);
    }

    /** {@inheritDoc} */
    public function revokeAllUserTokens(string $userId, ?string $clientId, ?string $typeHint = null): bool
    {
        $buildQuery = static function (ActiveQueryInterface $query, string $userId, ?string $clientId): ActiveQueryInterface {
            $query->where(['user_id' => $userId]);
            $query->andWhere(['>', 'expires', (new DateTimeImmutable())->format(DATE_ATOM)]);
            $query->andFilterWhere(['client_id' => $clientId]);

            return $query;
        };

        $accessTokens = $buildQuery(OauthAccessTokens::find(), $userId, $clientId)->all();
        $refreshTokens = $buildQuery(OauthRefreshTokens::find(), $userId, $clientId)->all();
        if (empty($accessTokens) && empty($refreshTokens)) {
            return false;
        }

        foreach (array_merge($accessTokens, $refreshTokens) as $token) {
            /** @var OauthAccessTokens|OauthRefreshTokens $token */
            $token->expires = (new DateTimeImmutable())->format(DATE_ATOM);
            $token->save();
        }

        return true;
    }

    private function revokeAccessToken(?OauthAccessTokens $token): bool
    {
        if ($token === null) {
            return false;
        }

        $token->expires = (new DateTimeImmutable())->format(DATE_ATOM);
        return $token->save();
    }

    private function revokeRefreshToken(?OauthRefreshTokens $token): bool
    {
        if ($token === null) {
            return false;
        }

        $token->expires = (new DateTimeImmutable())->format(DATE_ATOM);
        return $token->save();
    }
}
