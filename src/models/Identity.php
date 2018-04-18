<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiam\models;

use filsh\yii2\oauth2server\models\OauthAccessTokens;
use hiam\components\AuthKeyGenerator;
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
    public $password_hash;

    public $allowed_ips;
    public $totp_secret;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id',              'integer'],

            [['username', 'email', 'password', 'first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['username', 'email'], 'filter', 'filter' => 'strtolower'],
            [['username', 'password', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 64],
            ['email', 'email'],

            [['type', 'state'], 'string', 'min' => 2, 'max' => 10],

            ['allowed_ips',     'string'],
            ['totp_secret',     'string'],

            ['password_hash',        'string'],
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

        return static::findActive($cond);
    }

    public static function findIdentityByEmail($email)
    {
        return static::findActive(compact('email'));
    }

    public static function findIdentityByUsername($username)
    {
        return static::findActive(compact('username'));
    }

    /**
     * This function is here for redifining to change behaviour.
     */
    public static function findActive($cond)
    {
        return static::findOne($cond);
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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return AuthKeyGenerator
     */
    protected function getAuthKeyGenerator()
    {
        return Yii::createObject(AuthKeyGenerator::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->getAuthKeyGenerator()->generateForUser($this->id, $this->password_hash);
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKeyGenerator()->validateForUser($this->id, $this->password_hash, $authKey);
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
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * This function is here for redifining to change behaviour.
     * @see beforeLogin
     */
    public function isEmailConfirmed()
    {
        return true;
    }

    public function setEmailConfirmed($email)
    {
        return true;
    }

    public function __sleep()
    {
        return $this->attributes();
    }
}
