<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\models;

/**
 * RemoteUser model.
 *
 * @property string  $provider
 * @property string  $remoteid
 * @property integer $client_id
 */
class RemoteUser extends ProxyModel
{
    public $provider;
    public $remoteid;
    public $client_id;

    public static function primaryKey()
    {
        return ['provider', 'remoteid'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provider'],  'string'],
            [['remoteid'],  'string'],
            [['client_id'], 'integer'],
            [['provider', 'remoteid', 'client_id'], 'required'],
        ];
    }

    /**
     * Returns if given email is provided with appropriate service so it can be trusted.
     * @param string email address
     * @return bool is trusted
     */
    public function isTrustedEmail($email)
    {
        static $trustedEmails = [
            '@gmail.com'    => 'Google',
            '@yandex.ru'    => 'Yandex',
        ];
        foreach ($trustedEmails as $domain => $trusted) {
            if ($this->provider === static::toProvider($trusted) && substr($email, -strlen($domain)) === $domain) {
                return true;
            }
        }

        return false;
    }

    public static function toProvider($name)
    {
        $class = static::getStorageClass();

        return $class::toProvider($name);
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
