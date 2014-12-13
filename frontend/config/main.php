<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

function d ($a) { die(var_dump($a)); }

return [
    'id' => 'hi3a',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'site/<action:\w+>'     => 'site/<action>',
                'oauth2/<action:\w+>'   => 'oauth2/oauth2/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;port=5432;dbname=old_mrdp',
            'username' => 'sol',
            'password' => 'cnhju45l',
            'charset' => 'utf8',
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
