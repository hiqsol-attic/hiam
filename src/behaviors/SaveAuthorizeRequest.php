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

use hiam\components\OauthInterface;
use Yii;
use yii\base\Application;
use yii\base\Event;

/**
 * SaveAuthorizeRequest behavior.
 */
class SaveAuthorizeRequest extends \yii\base\Behavior
{
    /**
     * @var OauthInterface
     */
    private $oauth;

    public function __construct(OAuthInterface $oauth, $config = [])
    {
        $this->oauth = $oauth;
        parent::__construct($config);
    }

    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest',
        ];
    }

    public function beforeRequest(Event $event)
    {
        $request = Yii::$app->request;
        $path = $request->getPathInfo();
        if ($path !== 'oauth/authorize') {
            return;
        }

        $back = $this->oauth->saveAuthorizeRequest($request);
        if ($back) {
            Yii::$app->user->setReturnUrl($back);
        }
    }
}
