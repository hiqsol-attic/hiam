<?php

namespace hiam\assets;

use yii\web\AssetBundle;

/**
 * Most basic asset for the app: bootstrap+plugins, font-awesome, ionic
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@hiam/frontend/assets/AppAssetFiles';
    public $baseUrl = '@web';
    public $css = [
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
