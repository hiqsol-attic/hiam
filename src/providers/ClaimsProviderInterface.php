<?php

namespace hiam\providers;

use yii\web\IdentityInterface;

interface ClaimsProviderInterface
{
    /**
     * Fetches $claims for $identity
     *
     * @param IdentityInterface $identity
     * @param string $claims space-separated list of claims
     * @return \stdClass
     * @see https://connect2id.com/products/server/docs/api/userinfo
     */
    public function getClaims(IdentityInterface $identity, string $claims): \stdClass;

    public function claimBuilders(): array;
}
