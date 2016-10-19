<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\forms;

use Yii;
use yii\helpers\Html;

/**
 * Signup form.
 */
class SignupForm extends \yii\base\Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_retype;
    public $i_agree;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'trim'],
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 64],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'min' => 2, 'max' => 255],
            ['email', function ($attribute) {
                if (!empty(Yii::$app->user->findIdentityByEmail($this->email))) {
                    $this->addError($attribute, Yii::t('hiam', 'This email has already been taken') . '.');
                }
            }],

            ['password',        'string', 'min' => 6],
            ['password_retype', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('hiam', "Passwords don't match.")],

            [['first_name', 'last_name', 'email', 'password', 'password_retype'], 'required'],

            ['i_agree', 'boolean'],
            ['i_agree', 'required', 'requiredValue' => 1, 'message' => Yii::t('hiam', 'Please consider terms of use.')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('hiam', 'First Name'),
            'last_name' => Yii::t('hiam', 'Last Name'),
            'email' => Yii::t('hiam', 'Email'),
            'password' => Yii::t('hiam', 'Password'),
            'password_retype' => Yii::t('hiam', 'Retype password'),
            'i_agree' => Yii::t('hiam', 'I agree to the') . ' ' . Html::a(Yii::t('hiam', 'terms'), '/site/terms'),
        ];
    }
}
