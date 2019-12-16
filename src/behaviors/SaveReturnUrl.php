<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\behaviors;

use hiam\components\OauthInterface;
use Yii;
use yii\base\Application;
use yii\base\Event;

/**
 * SaveReturnUrl behavior.
 *
 * Saves Return URL to session for returning user back to an application
 * after performing tasks in the access server, e.g. after login or changing email.
 *
 * Return URL can be provided in two different ways:
 *
 * - with `redirect_uri` parameter provided within OAuth2 Authorization Code Request,
 *   usually used during login procedure
 * - with `back` POST or GET request parameter within any request, usually used for
 *   everything besides login, e.g. logout, change email and so on.
 */
class SaveReturnUrl extends \yii\base\Behavior
{
    /**
     * @var OauthInterface
     */
    private $oauth;

    public function __construct(OauthInterface $oauth, $config = [])
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

        $back = $this->saveAuthorizeRequest($request);
        if ($back) {
            Yii::$app->user->setReturnUrl($back);

            return;
        }

        $back = $request->post('back') ?? $request->get('back') ?? null;
        if ($back) {
            $this->oauth->cleanAuthorizeRequest();
            Yii::$app->user->setReturnUrl($back);
        }
    }

    private function saveAuthorizeRequest($request): ?string
    {
        $path = $request->getPathInfo();
        if ($path !== 'oauth/authorize') {
            return null;
        }

        return $this->oauth->saveAuthorizeRequest($request);
    }
}
