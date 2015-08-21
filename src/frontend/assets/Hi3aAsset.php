<?php
/**
 * Created by PhpStorm.
 * User: tofid
 * Date: 01.04.15
 * Time: 17:02
 */

namespace hiam\frontend\assets;

use yii\web\AssetBundle;

class Hi3aAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte';
    public $css = [
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
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
        'hiam\frontend\assets\AppAsset',
    ];
}
