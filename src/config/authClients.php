<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

$authClients = [];

if (!empty($params['facebook_client_id'])) {
    $authClients['facebook'] = [
        'class'        => \yii\authclient\clients\Facebook::class,
        'clientId'     => $params['facebook_client_id'],
        'clientSecret' => $params['facebook_client_secret'],
    ];
}

if (!empty($params['google_client_id'])) {
    $authClients['google'] = [
        'class'        => \yii\authclient\clients\Google::class,
        'clientId'     => $params['google_client_id'],
        'clientSecret' => $params['google_client_secret'],
        'normalizeUserAttributeMap' => [
            'email'      => ['emails', 0, 'value'],
            'first_name' => ['name', 'givenName'],
            'last_name'  => ['name', 'familyName'],
        ],
    ];
}

if (!empty($params['github_client_id'])) {
    $authClients['github'] = [
        'class'        => \yii\authclient\clients\GitHub::class,
        'scope'        => '',
        'clientId'     => $params['github_client_id'],
        'clientSecret' => $params['github_client_secret'],
        'normalizeUserAttributeMap' => [
            'first_name' => function ($a) {
                return explode(' ',$a['name'])[0];
            },
            'last_name'  => function ($a) {
                return explode(' ',$a['name'])[1];
            },
        ],
    ];
}

if (!empty($params['linkedin_client_id'])) {
    $authClients['linkedin'] = [
        'class'        => \yii\authclient\clients\LinkedIn::class,
        'clientId'     => $params['linkedin_client_id'],
        'clientSecret' => $params['linkedin_client_secret'],
    ];
}

if (!empty($params['vkontakte_client_id'])) {
    $params['vk_client_id']     = $params['vkontakte_client_id'];
    $params['vk_client_secret'] = $params['vkontakte_client_secret'];
}

if (!empty($params['vk_client_id'])) {
    $authClients['vk'] = [
        'class'        => \yii\authclient\clients\VKontakte::class,
        'clientId'     => $params['vk_client_id'],
        'clientSecret' => $params['vk_client_secret'],
    ];
}

if (!empty($params['yandex_client_id'])) {
    $authClients['yandex'] = [
        'class'        => \yii\authclient\clients\Yandex::class,
        'clientId'     => $params['yandex_client_id'],
        'clientSecret' => $params['yandex_client_secret'],
    ];
}

if (!empty($params['twitter_consumer_key'])) {
    $authClients['twitter'] = [
        'class'          => \yii\authclient\clients\Twitter::class,
        'consumerKey'    => $params['twitter_consumer_key'],
        'consumerSecret' => $params['twitter_consumer_secret'],
    ];
}

if (!empty($params['live_client_id'])) {
    $authClients['live'] = [
        'class'        => \yii\authclient\clients\Live::class,
        'clientId'     => $params['live_client_id'],
        'clientSecret' => $params['live_client_secret'],
    ];
}

return $authClients;
