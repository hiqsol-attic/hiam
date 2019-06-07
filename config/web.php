<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

$authClients = require __DIR__ . '/authClients.php';

return [
    'id' => 'hiam',
    'name' => 'HIAM',
    'layout' => 'mini',
    'controllerNamespace' => 'hiam\controllers',
    'bootstrap' => array_filter([
        'language' => 'language',
    ]),
    'as saveAuthorizeRequest' => \hiam\behaviors\SaveAuthorizeRequest::class,
    'components' => [
        'db' => [
            'class'     => \yii\db\Connection::class,
            'charset'   => 'utf8',
            'dsn'       => 'pgsql:'
                                . 'dbname=' . (empty($params['db.name']) ? 'hiam' : $params['db.name'])
                                . (!empty($params['db.host']) ? (';host=' . $params['db.host']) : '')
                                . (!empty($params['db.port']) ? (';port=' . $params['db.port']) : ''),
            'username'  => empty($params['db.user']) ? 'hiam' : $params['db.user'],
            'password'  => empty($params['db.password']) ? '*' : $params['db.password'],
        ],
        'user' => array_filter([
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
            'as checkEmailConfirmed' => $params['user.checkEmailConfirmed'] ? \hiam\behaviors\CheckEmailConfirmed::class : null,
        ]),
        'authClientCollection' => [
            'class' => \hiam\authclient\Collection::class,
            'clients' => $authClients,
        ],
        'themeManager' => [
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
            'components' => [
                'request' => function () {
                    return \filsh\yii2\oauth2server\Request::createFromGlobals();
                },
                'response' => [
                    'class' => \filsh\yii2\oauth2server\Response::class,
                ],
            ],
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
    ],
    'container' => [
        'definitions' => [
            \hiqdev\thememanager\widgets\LoginForm::class => [
                'disables' => [
                    'signup' => $params['user.disableSignup'],
                    'restore-password' => $params['user.disableRestorePassword'],
                ],
            ],
            \hiam\components\AuthKeyGenerator::class => [
                [],
                [
                    $params['user.authKeySecret'],
                    $params['user.authKeyCipher'],
                ],
            ],
        ],
        'singletons' =>     [
            \hiqdev\php\confirmator\ServiceInterface::class => [
                'class' => \hiqdev\yii2\confirmator\Service::class,
            ],
            \hiqdev\php\confirmator\StorageInterface::class => function () {
                return new \hiqdev\php\confirmator\FileStorage(\hiqdev\yii\compat\yii::getAlias('@runtime/tokens'));
            },
            \yii\web\Session::class => function (\yii\di\Container $container, $diParams, $config) use ($params) {
                if (isset($params['session.db'])) {
                    return $container->get(\yii\web\DbSession::class, [], array_merge([
                        'db' => $params['session.db'],
                        'sessionTable' => $params['session.table'] ?? 'hiam_session',
                    ], $config));
                }

                return new \yii\web\Session($config);
            },
            \yii\web\User::class => function ($container, $params, $config) {
                return Yii::$app->getUser();
            },
            \hiam\components\OauthInterface::class => [
                'class' => \hiam\components\Oauth::class,
            ],
        ],
    ],
];
