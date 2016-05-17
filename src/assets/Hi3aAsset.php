<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\assets;

use yii\web\AssetBundle;

class Hi3aAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte';
    public $css = [
        'plugins/iCheck/square/blue.css',
        'dist/css/AdminLTE.css',
    ];

    public $js = [
        'plugins/iCheck/icheck.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'hiam\assets\AppAsset',
    ];
}
