<?php

function d ($a) { print "<pre>";die(var_dump($a)); }

$params = array_merge(
    require(Yii::getAlias('@hiam/common/config/params.php')),
    require(Yii::getAlias('@project/common/config/params.php')),
    require(Yii::getAlias('@project/common/config/params-local.php'))
);

return [
    'vendorPath' => '@project/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class'         => 'yii\db\Connection',
            'dsn'           => 'pgsql:host=localhost;port=5432;dbname=mrdp',
            'charset'       => 'utf8',
        ],
        'authManager' => [
            'class'             => 'hiam\common\rbac\HiDbManager',
            'itemTable'         => '{{%rbac_item}}',
            'itemChildTable'    => '{{%rbac_item_child}}',
            'assignmentTable'   => '{{%rbac_assignment}}',
            'ruleTable'         => '{{%rbac_rule}}',
        ],
    ],
];
