<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\providers;

use yii\web\IdentityInterface;

interface ClaimsProviderInterface
{
    /**
     * Fetches $claims for $identity.
     *
     * @param string $claims space-separated list of claims
     * @see https://connect2id.com/products/server/docs/api/userinfo
     */
    public function getClaims(IdentityInterface $identity, string $claims): \stdClass;

    public function claimBuilders(): array;
}
