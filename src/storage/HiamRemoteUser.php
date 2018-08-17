<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\storage;

/**
 * RemoteUser model.
 *
 * @property string  $provider
 * @property string  $remoteid
 * @property integer $client_id
 */
class HiamRemoteUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provider'],  'string', 'min' => 1, 'max' => 1],
            [['remoteid'],  'string', 'min' => 1, 'max' => 99],
            [['client_id'], 'integer'],
            [['provider', 'remoteid', 'client_id'], 'required'],
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
}
