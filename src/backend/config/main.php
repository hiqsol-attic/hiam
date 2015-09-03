<?php
$params = array_merge(
    require(Yii::getAlias('@hiam/common/config/params.php')),
    require(Yii::getAlias('@project/common/config/params.php')),
    require(Yii::getAlias('@project/common/config/params-local.php')),
    require(Yii::getAlias('@hiam/backend/config/params.php')),
    require(Yii::getAlias('@project/backend/config/params.php')),
    require(Yii::getAlias('@project/backend/config/params-local.php'))
);

return [
    'id' => 'app-backend',
    'name' => 'HIAM backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'hiam\backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'class'               => 'hiam\web\Request',
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'user' => [
            'identityClass' => 'hiam\common\models\User',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
