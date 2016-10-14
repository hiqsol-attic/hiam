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

/**
 * Login form.
 */
class LoginForm extends \yii\base\Model
{
    public $username;
    public $password;
    public $remember_me = true;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['remember_me', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('hiam', 'Login or Email'),
            'password' => Yii::t('hiam', 'Password'),
            'remember_me' => Yii::t('hiam', 'Remember me'),
        ];
    }
}
