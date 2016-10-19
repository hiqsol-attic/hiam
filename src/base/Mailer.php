<?php

namespace hiam\base;

use Yii;
use yii\helpers\Inflector;

class Mailer extends \yii\swiftmailer\Mailer
{
    public function sendToken($user, $action)
    {
        if (!$user) {
            return false;
        }

        if (Yii::$app->has('authManager')) {
            $auth = Yii::$app->authManager;
            if ($auth->getItem($action) && !$auth->checkAccess($user->id, $action)) {
                return false;
            }
        }

        $token = Yii::$app->confirmator->issueToken([
            'action'    => $action,
            'email'     => $user->email,
            'username'  => $user->username,
            'notAfter'  => '+ 3 days',
        ])->toString();

        $view = lcfirst(Inflector::id2camel($action . '-token'));

        return Yii::$app->mailer->compose()
            ->renderHtmlBody($view, compact('user', 'token'))
            ->setTo([$user->email => $user->name])
            ->send()
        ;
    }
}
