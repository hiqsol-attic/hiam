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

/**
 * Login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getIdentity();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $duration = isset(Yii::$app->params['login_duration']) ? Yii::$app->params['login_duration'] : 3600 * 24 * 31;
            return Yii::$app->user->login($this->getIdentity(), $this->rememberMe ? $duration : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]].
     * @return Identity|null
     */
    public function getIdentity()
    {
        if (!$this->_user) {
            $this->_user = call_user_func([Yii::$app->user->identityClass, 'findByUsername'], $this->username);
        }

        return $this->_user;
    }
}
