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

use yii\authclient\ClientInterface;
use yii\web\IdentityInterface;

/**
 * RemoteUser model.
 *
 * @property string  $provider
 * @property string  $remoteid
 * @property integer $client_id
 */
class RemoteUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hiam_remote_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provider'],          'string'],
            [['remoteid'],          'safe'],
            [['client_id'],         'integer'],
            [['provider', 'remoteid', 'client_id'],   'required'],
        ];
    }

    private static $_providers = [
        'google'    => 'g',
        'facebook'  => 'f',
        'linkedin'  => 'l',
        'github'    => 'h',
        'vk'        => 'v',
        'yandex'    => 'y',
        'live'      => 'w',
    ];

    public static function toProvider($name)
    {
        if (strlen($name) === 1) {
            $keys = array_flip(static::$_providers);
            return isset($keys[$name]) ? $name : null;
        }
        $key = strtolower($name);

        return isset(static::$_providers[$key]) ? static::$_providers[$key] : null;
    }

    public function isTrustedEmail($email)
    {
        static $trustedEmails = [
            '@gmail.com'    => 'google',
            '@yandex.ru'    => 'yandex',
        ];
        foreach ($trustedEmails as $domain => $trusted) {
            if ($this->provider === static::toProvider($trusted) && substr($email, -strlen($domain)) === $domain) {
                return true;
            }
        }
        return false;
    }

    public static function findOrCreate($provider, $remoteid)
    {
        $data = [
            'provider' => static::toProvider($provider),
            'remoteid' => $remoteid,
        ];

        return static::findOne($data) ?: new static($data);
    }
}
