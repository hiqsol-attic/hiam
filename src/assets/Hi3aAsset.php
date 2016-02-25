<?php

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
