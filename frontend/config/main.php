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
            'rules' => [
                'site/<action:\w+>'     => 'site/<action>',
                'oauth2/<action:\w+>'   => 'oauth2/oauth2/<action>',
            ],
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
        'dump' => [
            'class' => 'hiqdev\hiphp\Dump',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'oauth2' => [
            'class' => 'hiqdev\yii2\oauth2server\Module',
            'options' => [
                'enforce_state'     => false,
                'access_lifetime'   => 3600 * 24,
            ],
            'storageMap' => [
                'user_credentials'  => 'common\models\User',
            ],
            'storageConfig' => [
                'scope_table'           => 'oauth_scope',
                'client_table'          => 'oauth_client',
                'access_token_table'    => 'oauth_access_token',
                'refresh_token_table'   => 'oauth_refresh_token',
                'code_table'            => 'oauth_authorization_code',
            ],
        ],
    ],
    'params' => $params,
];
