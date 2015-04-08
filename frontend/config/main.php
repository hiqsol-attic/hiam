<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'hi3a',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'HiPanel',
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site',
    'components' => [
        'request' => [
            'class' => 'frontend\components\MyRequest',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
        ],
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/adminlte'],
                'baseUrl' => '@web/themes/adminlte',
            ],
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
    ],
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'options' => [
                'enforce_state'     => false,
                'access_lifetime'   => 3600 * 24,
            ],
            'storageMap' => [
                'user_credentials'  => 'common\models\User',
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
    'params' => $params,
];
