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

if (isset($params['facebook_client_id']) && $params['facebook_client_id']) {
    $authClients['facebook'] = [
        'class'        => \yii\authclient\clients\Facebook::class,
        'clientId'     => $params['facebook_client_id'],
        'clientSecret' => $params['facebook_client_secret'],
    ];
}

if (isset($params['google_client_id']) && $params['google_client_id']) {
    $authClients['google'] = [
        'class'        => \yii\authclient\clients\GoogleOAuth::class,
        'clientId'     => $params['google_client_id'],
        'clientSecret' => $params['google_client_secret'],
        'normalizeUserAttributeMap' => [
            'email'      => ['emails', 0, 'value'],
            'first_name' => ['name', 'givenName'],
            'last_name'  => ['name', 'familyName'],
        ],
    ];
}

if (isset($params['github_client_id']) && $params['github_client_id']) {
    $authClients['github'] = [
        'class'        => \yii\authclient\clients\GitHub::class,
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

if (isset($params['linkedin_client_id']) && $params['linkedin_client_id']) {
    $authClients['linkedin'] = [
        'class'        => \yii\authclient\clients\LinkedIn::class,
        'clientId'     => $params['linkedin_client_id'],
        'clientSecret' => $params['linkedin_client_secret'],
    ];
}

if (isset($params['vk_client_id']) && $params['vk_client_id']) {
    $authClients['vk'] = [
        'class'        => \yii\authclient\clients\VKontakte::class,
        'clientId'     => $params['vkontakte_client_id'],
        'clientSecret' => $params['vkontakte_client_secret'],
    ];
}

if (isset($params['yandex_client_id']) && $params['yandex_client_id']) {
    $authClients['yandex'] = [
        'class'        => \yii\authclient\clients\YandexOAuth::class,
        'clientId'     => $params['yandex_client_id'],
        'clientSecret' => $params['yandex_client_secret'],
    ];
}

return [
    'id' => 'hiam',
    'name' => 'HIAM',
    'layout' => 'mini',
    'controllerNamespace' => 'hiam\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => [
            'class'     => \yii\db\Connection::class,
            'charset'   => 'utf8',
            'dsn'       => 'pgsql:dbname=' . (isset($params['db_name']) ? $params['db_name'] : 'hiam'),
            'username'  => isset($params['db_user']) ? $params['db_user'] : '',
            'password'  => isset($params['db_password']) ? $params['db_password'] : '',
        ],
        'user' => [
            'class'           => \yii\web\User::class,
            'identityClass'   => \hiam\models\User::class,
            'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'viewPath' => '@hiam/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'authManager' => [
            'class'             => \hiam\rbac\HiDbManager::class,
            'itemTable'         => '{{%rbac_item}}',
            'itemChildTable'    => '{{%rbac_item_child}}',
            'assignmentTable'   => '{{%rbac_assignment}}',
            'ruleTable'         => '{{%rbac_rule}}',
        ],
        'authClientCollection' => [
            'class' => \hiam\authclient\Collection::class,
            'clients' => $authClients,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
        ],
        'themeManager' => [
            'assets' => [
                \hiam\assets\AppAsset::class,
                \hiqdev\assets\icheck\iCheckAsset::class,
            ],
        ],
    ],
    'modules' => [
        'oauth2' => [
            'class' => \filsh\yii2\oauth2server\Module::class,
            'options' => [
                'enforce_state'     => false,
                'access_lifetime'   => 3600 * 24,
            ],
            'storageMap' => [
                'user_credentials'  => \hiam\models\User::class,
            ],
            'grantTypes' => [
///             'client_credentials' => [
///                 'class' => \OAuth2\GrantType\ClientCredentials::class,
///                 'allow_public_clients' => false
///             ],
                'authorization_code' => [
                    'class' => \OAuth2\GrantType\AuthorizationCode::class,
                ],
                'user_credentials' => [
                    'class' => \OAuth2\GrantType\UserCredentials::class,
                ],
                'refresh_token' => [
                    'class' => \OAuth2\GrantType\RefreshToken::class,
                    'always_issue_new_refresh_token' => true,
                ],
            ],
        ],
    ],
];
