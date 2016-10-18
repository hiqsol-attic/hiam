<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
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
