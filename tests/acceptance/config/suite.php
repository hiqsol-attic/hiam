<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

use hiqdev\composer\config\Builder;

$config = \yii\helpers\ArrayHelper::merge(
    require Builder::path('web-test'),
    require Builder::path('codeception'),
    [
        'bootstrap' => [
            'debug' => new \yii\helpers\UnsetArrayValue(),
        ],
        'modules' => [
            'debug' => new \yii\helpers\UnsetArrayValue(),
        ],
        'components' => [
            'errorHandler' => [
                'errorAction' => new \yii\helpers\UnsetArrayValue(),
            ],
        ],
    ]
);

return $config;
