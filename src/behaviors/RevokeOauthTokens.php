<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\behaviors;

use hiam\components\TokenRevokerInterface;
use Yii;
use yii\base\ActionFilter;

/**
 * RevokeOauthTokens behavior for SiteController
 *
 * Shluld listens to the logout action, and remove access tokens
 */
class RevokeOauthTokens extends ActionFilter
{
    /**
     * @var TokenRevokerInterface
     */
    private $tokenRevoker;

    public function __construct(TokenRevokerInterface $tokenRevoker, $config = [])
    {
        parent::__construct($config);
        $this->tokenRevoker = $tokenRevoker;
    }

    public function beforeAction($action)
    {
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return true;
        }

        $this->tokenRevoker->revokeAllUserTokens($user->identity->getId(), null);

        return true;
    }
}
