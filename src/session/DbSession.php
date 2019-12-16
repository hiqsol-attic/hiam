<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\session;

use Yii;

class DbSession extends \yii\web\DbSession
{
    public function init()
    {
        if ($this->writeCallback === null) {
            $this->writeCallback = function ($fields) {
                return [
                    'client_id' => Yii::$app->user->getIsGuest() ? null : Yii::$app->user->id,
                    'ip' => Yii::$app->request->getUserIp(),
                ];
            };
        }

        parent::init();
    }
}
