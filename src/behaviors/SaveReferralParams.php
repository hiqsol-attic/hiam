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
 * SaveReturnUrl behavior.
 *
 * @package hiam\behaviors
 */
class SaveReferralParams extends \yii\base\Behavior
{
    /**
     * @inheritDoc
     */
    public function events(): array
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest',
        ];
    }

    /**
     * @param Event $event
     */
    public function beforeRequest(Event $event): void
    {
        $params = Yii::$app->request->getQueryParams();
        if (empty($params['atid'])) {
            return;
        }
        $session = Yii::$app->session;
        $utmParams = [];
        foreach ($params as $name => $value) {
            if (strstr($name, 'utm_')) {
                $utmParams[$name] = $value;
            }
        }
        $session->set('utm_params', [
            'atid' => $params['atid'],
            'params' => \yii\helpers\Json::htmlEncode($utmParams),
        ]);
    }
}
