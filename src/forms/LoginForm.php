<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\forms;

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
            ['username', 'filter', 'filter' => 'strtolower'],
            [['username', 'password'], 'trim'],
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
