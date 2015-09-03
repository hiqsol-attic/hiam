<?php

$params = array_merge(
    require(Yii::getAlias('@hiam/common/config/params.php')),
    require(Yii::getAlias('@project/common/config/params.php')),
    require(Yii::getAlias('@project/common/config/params-local.php')),
    require(Yii::getAlias('@hiam/console/config/params.php')),
    require(Yii::getAlias('@project/console/config/params.php')),
    require(Yii::getAlias('@project/console/config/params-local.php'))
);

return [
    'id' => 'hiamc',
    'name' => 'HIAM console',
    'basePath' => dirname(__DIR__),
    'runtimePath' => '@project/console/runtime',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'hiam\console\controllers',
/*
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
*/
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
