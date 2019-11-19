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
 * SaveReturnUrl behavior.
 *
 * @package hiam\behaviors
 */
class SaveReferralParams extends \yii\base\Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest',
        ];
    }

    public function beforeRequest(Event $event)
    {
        $session = Yii::$app->session;
        $params = Yii::$app->request->getQueryParams();

        foreach ($params as $name => $value) {
            if (strstr($name, 'utm_')) {
                $session->set($name, $value);
            }
        }
    }
}
