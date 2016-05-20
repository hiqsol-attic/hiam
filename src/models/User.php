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
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $new_password write-only password
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface, UserCredentialsInterface
{
    const STATUS_ACTIVE  = 'ok';
    const STATUS_DELETED = 'deleted';

    public function getUserDetails($username)
    {
        $data = $this->findByUsername($username)->toArray();
        $conv = [
            'user_id'       => 'id',
            'username'      => 'login',
        ];
        foreach ($conv as $k => $v) {
            $data[$k] = $data[$v];
        }
        return $data;
    }

    public function checkUserCredentials($username, $password)
    {
        $check = $this->findByUsername($username, $password);
        return (bool) $check->id;
    }

    public static function findByUsername($username, $password = null)
    {
        $query = static::find()
            ->select(['c.obj_id AS id', 'c.obj_id', 'c.login', 'c.type_id', 'c.state_id', 'c.seller_id',
                        'r.login AS seller', 'y.name AS type', 'z.name AS state', 'c.login AS username',
                        'coalesce(c.email,k.email) AS email', 'k.name', ])
            ->from('client        c')
            ->innerJoin('client        r', 'r.obj_id=c.seller_id')
            ->innerJoin('ref           y', 'y.obj_id=c.type_id')
            ->innerJoin('ref           z', "z.obj_id=c.state_id AND z.name IN ('ok')")
            ->leftJoin('contact       k', 'k.obj_id=c.obj_id')
            ->where(['or', 'c.login=:username', 'c.email=:username', 'c.obj_id=:id'])
            ->addParams([':username' => $username, ':id' => (int) $username ?: null]);
        if ($password) {
            $query
            ->leftJoin('value         t', "t.obj_id=c.obj_id AND t.prop_id=prop_id('client,access:tmp_pwd')")
            ->andWhere('check_password(:password,c.password) OR check_password(:password,t.value)')
            ->addParams([':password' => $password]);
        }
        $user = $query->one();
        return $user;
    }

    /**
     * Find where login=$email or email=$email.
     */
    public static function findByEmail($email)
    {
        if (!$email) {
            return null;
        };
        return static::findOne(['login' => $email]) ?: static::findOne(compact('email'));
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * {@inheritdoc}
     */
/*
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
*/

    public function attributes()
    {
        // return array_unique(array_merge(parent::attributes(),['id','type','state','seller','username']));
        foreach (self::rules() as $ds) {
            $d = reset($ds);
            $ds = is_array($d) ? $d : [$d];
            foreach ($ds as $k) {
                $attributes[$k] = $k;
            }
        };
        return array_values($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['obj_id',          'integer'],

            ['id',              'integer'],
            ['id',              'required'],

            [['login', 'seller'], 'filter', 'filter' => 'trim'],
            [['login', 'seller'], 'string', 'min' => 2, 'max' => 64],

            ['name',            'filter', 'filter' => 'trim'],

            ['email',           'filter', 'filter' => 'trim'],
            ['email',           'email'],

            ['password',        'filter', 'filter' => 'trim'],
            ['password',        'string', 'min' => 2, 'max' => 64],

            ['seller_id',       'integer'],
            ['seller_id',       'required'],

            ['referer_id',      'integer'],
            ['type_id',         'integer'],
            ['state_id',        'integer'],

            [['type', 'state'],  'string', 'min' => 2, 'max' => 10],
            ['username',        'string', 'min' => 2, 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findByUsername($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($access_token, $type = null)
    {
        $token = OauthAccessTokens::findOne(compact('access_token'));
        return static::findByUsername($token->user_id);
    }

    /**
     * Finds user through RemoteUser.
     */
    public static function findIdentityByAuthClient($client)
    {
        $provider   = RemoteUser::toProvider($client->getId());
        if (!$provider) {
            return null;
        }
        $attributes = $client->getUserAttributes();
        $remoteid   = $attributes['id'];
        $email      = $attributes['email'];
        $remote     = RemoteUser::findOne(compact('provider', 'remoteid'));
        if ($remote) {
            return static::findOne($remote->client_id);
        };
        $user = static::findByEmail($email);
        if (!$user) {
            return null;
        };
        if (RemoteUser::isTrustedEmail($provider, $email)) {
            return RemoteUser::set($client, $user);
        };
        #Yii::$app->getSession()->set('');
        return null;
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => 'ok',
        ]);
    }

    /**
     * Finds out if password reset token is valid.
     *
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
        return $this->getPrimaryKey();
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
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //die(var_dump( Yii::$app->security->validatePassword($password, $this->password_hash)));
        //return Yii::$app->security->validatePassword($password, $this->password_hash);
        $model = static::findByUsername($this->login, $password);
        return (bool) $model->id;
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
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

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
