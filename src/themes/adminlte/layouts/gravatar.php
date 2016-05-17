<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * Created by PhpStorm.
 * User: tofid
 * Date: 04.03.15
 * Time: 12:32.
 */
if (\Yii::$app->user->identity->email) {
    echo \cebe\gravatar\Gravatar::widget([
        'email'        => isset($email) ? $email : \Yii::$app->user->identity->email,
        'defaultImage' => 'identicon',
        'options'      => [
            'alt' => isset($alt) ? $alt : \Yii::$app->user->identity->username,
            'class' => !isset($class) ? 'img-circle' : $class,
        ],
        'size'         => !isset($size) ? 25 : $size,
    ]);
}
