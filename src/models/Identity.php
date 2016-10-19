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

use filsh\yii2\oauth2server\models\OauthAccessTokens;
use OAuth2\Storage\UserCredentialsInterface;
use Yii;
use yii\web\IdentityInterface;

/**
 * Identity model.
 *
 * @property integer $id
 * @property string $type
 * @property string $state
 * @property string $email
 * @property string $password
 * @property string $username
 * @property string $last_name
 * @property string $first_name
 * @property string $auth_key
 */
class Identity extends ProxyModel implements IdentityInterface, UserCredentialsInterface
{
    public $id;
    public $type;
    public $state;
    public $email;
    public $password;
    public $username;
    public $last_name;
    public $first_name;

    public $allowed_ips;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id',              'integer'],

            ['username',        'trim'],
            ['username',        'string', 'min' => 2, 'max' => 64],

            ['email',           'trim'],
            ['email',           'email'],

            ['password',        'trim'],
            ['password',        'string', 'min' => 2, 'max' => 64],

            ['allowed_ips',     'string'],

            [['type', 'state'], 'string', 'min' => 2, 'max' => 10],

            [['first_name', 'last_name'], 'trim'],
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 64],
        ];
    }

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getUserDetails($username)
    {
        $data = $this->findIdentity($username)->toArray();
        if (empty($data)) {
            return false;
        }

        $data['user_id'] = $data['id'];
        return $data;
    }

    public function checkUserCredentials($username, $password)
    {
        $check = $this->findIdentity($username, $password);

        return (bool) $check->id;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $username ID or username or email to be looked for
     * @param string $password when given the password is checked
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($username, $password = null)
    {
        $cond = ['username' => $username];
        if ($password) {
            $cond['password'] = $password;
        }

        return static::findOne($cond);
    }

    public static function findIdentityByEmail($email)
    {
        return static::findOne(compact('email'));
    }

    public static function primaryKey()
    {
        return ['username'];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($access_token, $type = null)
    {
        $token = OauthAccessTokens::findOne(compact('access_token'));

        return static::findIdentity($token->user_id);
    }

    /**
     * Finds out if password reset token is valid.
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return 'DUMMY';
        //return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $model = static::findIdentity($this->username, $password);
        return (bool) $model->id;
    }

    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        //$this->auth_key = Yii::$app->security->generateRandomString();
        $this->auth_key = 'DUMMY';
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
