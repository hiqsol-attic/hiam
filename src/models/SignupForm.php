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
 * Signup form.
 */
class SignupForm extends \yii\base\Model
{
    //public $username;
    public $first_name;
    public $last_name;
    public $email;
    public $username;
    public $password;
    public $password_retype;
    public $agree;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 64],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => Identity::class, 'message' => 'This email address has already been taken.'],
            ['email', 'string', 'min' => 2, 'max' => 255],

            ['password',        'string', 'min' => 6],
            ['password_retype', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],

            [['first_name', 'last_name', 'email', 'password', 'password_retype'], 'required'],

            ['agree', 'required', 'requiredValue' => 1, 'message' => 'Please consider terms of use'],
        ];
    }

    /**
     * Signs user up.
     * @return Identity|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new Identity;
        $user->setAttributes($this->getAttributes());
        $user->username = $this->email;

        return $user->save() ? $user : null;
    }
}
