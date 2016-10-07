<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Password reset request form.
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'required'],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        $user = Identity::findByUsername($this->email);

        if (!$user) {
            return false;
        }

        if (Yii::$app->has('authManager')) {
            $auth = Yii::$app->authManager;
            if ($auth->getItem('restore-password') && !$auth->checkAccess($user->id, 'restore-password')) {
                return false;
            }
        }

        $token = 'token';

        return Yii::$app->mailer->compose()
            ->renderHtmlBody('passwordResetToken', compact('user', 'token'))
            ->setTo($this->email)
            ->send()
        ;
    }
}
