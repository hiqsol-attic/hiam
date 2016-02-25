<?php

return [
    'id'          => 'hiam',
    'name'        => 'HIAM',
    'basePath'    => dirname(__DIR__),
    'vendorPath'  => '@vendor',
    'runtimePath' => '@vendor/../runtime',
    'bootstrap'   => ['log'],
    'controllerNamespace' => 'hiam\controllers',
    'defaultRoute' => 'site',
    'layout'       => 'mini',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class'         => 'yii\db\Connection',
            'dsn'           => 'pgsql:dbname=' . $params['db_name'],
            'charset'       => 'utf8',
            'username'      => $params['db_user'],
            'password'      => $params['db_password'],
        ],
        'user' => [
            'class'           => 'yii\web\User',
            'identityClass'   => 'hiam\common\models\User',
            'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@hiam/common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'authManager' => [
            'class'             => 'hiam\common\rbac\HiDbManager',
            'itemTable'         => '{{%rbac_item}}',
            'itemChildTable'    => '{{%rbac_item_child}}',
            'assignmentTable'   => '{{%rbac_assignment}}',
            'ruleTable'         => '{{%rbac_rule}}',
        ],
        'request' => [
            'class'               => 'hiam\web\Request',
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'authClientCollection' => [
            'class' => 'hiam\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class'        => 'yii\authclient\clients\Facebook',
                    'clientId'     => $params['facebook_client_id'],
                    'clientSecret' => $params['facebook_client_secret'],
                ],
                'google' => [
                    'class'        => 'yii\authclient\clients\GoogleOAuth',
                    'clientId'     => $params['google_client_id'],
                    'clientSecret' => $params['google_client_secret'],
                    'normalizeUserAttributeMap' => [
                        'email'      => ['emails',0,'value'],
                        'first_name' => ['name','givenName'],
                        'last_name'  => ['name','familyName'],
                    ],
                ],
                'github' => [
                    'class'        => 'yii\authclient\clients\GitHub',
                    'clientId'     => $params['github_client_id'],
                    'clientSecret' => $params['github_client_secret'],
                    'normalizeUserAttributeMap' => [
                        'first_name' => function ($a) { return explode(' ',$a['name'])[0]; },
                        'last_name'  => function ($a) { return explode(' ',$a['name'])[1]; },
                    ],
                ],
                'linkedin' => [
                    'class'        => 'yii\authclient\clients\LinkedIn',
                    'clientId'     => $params['linkedin_client_id'],
                    'clientSecret' => $params['linkedin_client_secret'],
                ],
                'vk' => [
                    'class'        => 'yii\authclient\clients\VKontakte',
                    'clientId'     => $params['vkontakte_client_id'],
                    'clientSecret' => $params['vkontakte_client_secret'],
                ],

                'yandex' => [
                    'class'        => 'yii\authclient\clients\YandexOAuth',
                    'clientId'     => $params['yandex_client_id'],
                    'clientSecret' => $params['yandex_client_secret'],
                ],
/*
                'windows' => [
                    'class'        => 'yii\authclient\clients\Live',
                    'clientId'     => $params['live_client_id'],
                    'clientSecret' => $params['live_client_secret'],
                ],
*/
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
        ],
        'view' => [
            'class' => 'hiqdev\thememanager\View',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'themeManager' => [
            'class'  => 'hiqdev\thememanager\ThemeManager',
            'assets' => [
                'hiam\assets\AppAsset',
                'hiqdev\assets\icheck\iCheckAsset',
            ],
        ],
        'menuManager' => [
            'class' => 'hiqdev\menumanager\MenuManager',
            'items' => [
                'breadcrumbs' => [
                    'saveToView' => 'breadcrumbs',
                ],
            ],
        ],
    ],
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'options' => [
                'enforce_state'     => false,
                'access_lifetime'   => 3600 * 24,
            ],
            'storageMap' => [
                'user_credentials'  => 'hiam\common\models\User',
            ],
            'grantTypes' => [
///             'client_credentials' => [
///                 'class' => 'OAuth2\GrantType\ClientCredentials',
///                 'allow_public_clients' => false
///             ],
                'authorization_code' => [
                    'class' => 'OAuth2\GrantType\AuthorizationCode'
                ],
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials'
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true,
                ]
            ],
        ],
    ],
];
