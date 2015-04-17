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
    'name' => 'AHnames',
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
        'authClientCollection' => [
            'class' => 'hi3a\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class'         => 'yii\authclient\clients\Facebook',
                    'clientId'      => $params['facebook_client_id'],
                    'clientSecret'  => $params['facebook_client_secret'],
                ],
                'google' => [
                    'class'         => 'yii\authclient\clients\GoogleOAuth',
                    'clientId'      => $params['google_client_id'],
                    'clientSecret'  => $params['google_client_secret'],
                    'normalizeUserAttributeMap' => [
                        'email'      => ['emails',0,'value'],
                        'first_name' => ['name','givenName'],
                        'last_name'  => ['name','familyName'],
                    ],
                ],
                'github' => [
                    'class'         => 'yii\authclient\clients\GitHub',
                    'clientId'      => $params['github_client_id'],
                    'clientSecret'  => $params['github_client_secret'],
                    'normalizeUserAttributeMap' => [
                        'first_name' => function ($a) { return explode(' ',$a['name'])[0]; },
                        'last_name'  => function ($a) { return explode(' ',$a['name'])[1]; },
                    ],
                ],
                'linkedin' => [
                    'class'         => 'yii\authclient\clients\LinkedIn',
                    'clientId'      => $params['linkedin_client_id'],
                    'clientSecret'  => $params['linkedin_client_secret'],
                ],
                'vk' => [
                    'class'         => 'yii\authclient\clients\VKontakte',
                    'clientId'      => $params['vkontakte_client_id'],
                    'clientSecret'  => $params['vkontakte_client_secret'],
                ],
/* TODO icons and css for these
                'yandex' => [
                    'class'             => 'yii\authclient\clients\YandexOAuth',
                    'clientId'          => $params['yandex_client_id'],
                    'clientSecret'      => $params['yandex_client_secret'],
                ],
                'windows' => [
                    'class'             => 'yii\authclient\clients\Live',
                    'clientId'          => $params['live_client_id'],
                    'clientSecret'      => $params['live_client_secret'],
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
