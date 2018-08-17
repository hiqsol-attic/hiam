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

use Yii;
use yii\base\Application;
use yii\base\Event;

/**
 * SetReturnUrl behavior.
 */
class SetReturnUrl extends \yii\base\Behavior
{
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

        $back = $request->get('redirect_uri');
        if (!$back) {
            return;
        }

        Yii::$app->user->setReturnUrl($back);
    }
}
