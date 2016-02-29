<?php

return [
    'id'          => 'hiam',
    'name'        => 'HIAM',
    'basePath'    => dirname(__DIR__),
    'vendorPath'  => dirname(__DIR__, 3),
    'runtimePath' => dirname(__DIR__, 4) . '/runtime',
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
            'dsn'           => 'pgsql:dbname=hiam',
            'charset'       => 'utf8',
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
        'authClientCollection' => [
            'class' => 'hiam\authclient\Collection',
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
            'traceLevel' => 0,
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
