<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\components;

use DateTimeImmutable;
use filsh\yii2\oauth2server\models\OauthAccessTokens;
use filsh\yii2\oauth2server\models\OauthRefreshTokens;
use yii\db\ActiveQueryInterface;

/**
 * Class ActiveRecordTokenRevoker.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class ActiveRecordTokenRevoker implements TokenRevokerInterface
{
    /** {@inheritdoc} */
    public function revokeAllUserTokens(string $userId, ?string $clientId, ?string $typeHint = null): bool
    {
        $accessTokens = $this->buildQuery(OauthAccessTokens::find(), $userId, $clientId)->all();
        $refreshTokens = $this->buildQuery(OauthRefreshTokens::find(), $userId, $clientId)->all();
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

    private function buildQuery(ActiveQueryInterface $query, string $userId, ?string $clientId): ActiveQueryInterface
    {
        $query->where(['user_id' => $userId]);
        $query->andWhere(['>', 'expires', (new DateTimeImmutable())->format(DATE_ATOM)]);
        $query->andFilterWhere(['client_id' => $clientId]);

        return $query;
    }
}
