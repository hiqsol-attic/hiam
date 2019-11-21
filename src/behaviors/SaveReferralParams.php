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

use hiam\mrdp\models\Identity;
use Yii;
use yii\base\Application;
use yii\base\Event;
use yii\helpers\Json;

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
            Identity::EVENT_BEFORE_SAVE => 'beforeSave',
        ];
    }

    /**
     * @param Event $event
     */
    public function beforeRequest(Event $event): void
    {
        $params = Yii::$app->request->getQueryParams();
        $session = Yii::$app->session;
        $utmTags = [];
        foreach ($params as $name => $value) {
            if (strstr($name, 'utm_')) {
                $utmTags[$name] = $value;
            }
        }
        $utm_tags = empty($utmTags) ? null : Json::htmlEncode($utmTags);
        $session->set('referralParams', [
            'referer' => $params['atid'],
            'utm_tags' => $utm_tags,
        ]);
    }


    public function beforeSave()
    {
        $this->owner->referralParams = \Yii::$app->session->get('referralParams');
    }
}
