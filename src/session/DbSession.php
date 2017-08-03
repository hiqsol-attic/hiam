<?php

namespace hiam\session;

use Yii;

class DbSession extends \yii\web\DbSession
{
    public function init()
    {
        if ($this->writeCallback === null) {
            $this->writeCallback = function ($fields) {
                return [
                    'client_id' => Yii::$app->user->isGuest ? null : Yii::$app->user->id,
                    'ip' => Yii::$app->request->getUserIp(),
                ];
            };
        }

        parent::init();
    }
}
