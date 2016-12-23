<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

$authClients = require __DIR__ . '/authClients.php';

return [
    'id' => 'hiam',
    'name' => 'HIAM',
    'layout' => 'mini',
    'controllerNamespace' => 'hiam\controllers',
    'bootstrap' => array_filter([
        'language' => 'language',
        'debug' => defined('YII_DEBUG') && YII_DEBUG ? 'debug' : null,
    ]),
    'components' => [
        'db' => [
            'class'     => \yii\db\Connection::class,
            'charset'   => 'utf8',
            'dsn'       => 'pgsql:dbname=' . (empty($params['db_name']) ? 'hiam' : $params['db_name']),
            'username'  => empty($params['db_user']) ? 'hiam' : $params['db_user'],
            'password'  => empty($params['db_password']) ? '*' : $params['db_password'],
        ],
        'user' => [
            'class'           => \hiam\base\User::class,
            'identityClass'   => \hiam\models\Identity::class,
            'remoteUserClass' => \hiam\models\RemoteUser::class,
            'storageClasses'  => [
                'identity'   => \hiam\storage\HiamIdentity::class,
                'remoteUser' => \hiam\storage\HiamRemoteUser::class,
            ],
            'loginDuration'   => $params['user.loginDuration'],
            'enableAutoLogin' => $params['user.enableAutoLogin'],
            'disableSignup'   => $params['user.disableSignup'],
            'disableRestorePassword' => $params['user.disableRestorePassword'],
            'as checkEmailConfirmed' => \hiam\behaviors\CheckEmailConfirmed::class,
        ],
        'mailer' => [
            'useFileTransport' => false,
            'messageClass' => \hiam\base\Message::class,
            'messageConfig' => [
                'from' => [$params['supportEmail'] => $params['organizationName']],
                'bcc'  => ['sol@hiqdev.com'],
            ],
        ],
        'authClientCollection' => [
            'class' => \hiam\authclient\Collection::class,
            'clients' => $authClients,
        ],
        'confirmator' => [
            'class' => \hiqdev\yii2\confirmator\Service::class,
            'storage' => [
                'class' => \hiqdev\php\confirmator\FileStorage::class,
                'path' => '@runtime/tokens',
            ],
        ],
        'themeManager' => [
            'assets' => [],
            'widgets' => [
                'LoginForm' => [
                    'disables' => [
                        'signup' => $params['user.disableSignup'],
                        'restore-password' => $params['user.disableRestorePassword'],
                    ],
                ],
            ],
            'pathMap' => [
                '$themedViewPaths' => ['@hiam/views'],
            ],
        ],
        'i18n' => [
            'translations' => [
                'hiam' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hiam/messages',
                ],
            ],
        ],
    ],
    'modules' => [
        'oauth2' => [
            'class' => \filsh\yii2\oauth2server\Module::class,
            'options' => [
                'enforce_state'     => true,
                'access_lifetime'   => 3600 * 24,
            ],
            'storageMap' => [
                'user_credentials'  => \hiam\models\Identity::class,
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
        'language' => [
            'languages' => [
                'ru' => 'Русский',
                'en' => 'English',
            ],
        ],
        'debug' => [
            'class' => \yii\debug\Module::class,
            'allowedIPs' => $params['debug.allowedIps'],
        ],
    ],
];
