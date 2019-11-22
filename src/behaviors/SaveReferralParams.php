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
        $utmTags = [];
        foreach ($params as $name => $value) {
            if (strstr($name, 'utm_')) {
                $utmTags[$name] = $value;
            }
        }
        $referalParams = array_filter([
            'referer' => $params['atid'],
            'utmTags' => $utmTags,
        ]);
        if (!empty($referalParams)) {
            Yii::$app->session->set('referralParams', $referalParams);
        }
    }


    public function beforeSave()
    {
        $this->owner->referralParams = \Yii::$app->session->get('referralParams');
    }
}
