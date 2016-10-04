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
            return $name;
        }
        return static::$_providers[strtolower($name)];
    }

    public static function isTrustedEmail($provider, $email)
    {
        static $trustedEmails = [
            '@gmail.com'    => 'google',
            '@yandex.ru'    => 'yandex',
        ];
        foreach ($trustedEmails as $domain => $trusted) {
            if (static::toProvider($provider) === static::toProvider($trusted) && substr($email, -strlen($domain)) === $domain) {
                return true;
            }
        }
        return false;
    }

    /**
     * Inserts or updates RemoteUser.
     * @return user
     */
    public static function set(ClientInterface $client, IdentityInterface $user)
    {
        $data = [
            'provider' => static::toProvider($client->getId()),
            'remoteid' => $client->getUserAttributes()['id'],
        ];
        $model = static::findOne($data) ?: new static($data);
        $model->client_id = $user->getId();
        $model->save();

        return $user;
    }
}
