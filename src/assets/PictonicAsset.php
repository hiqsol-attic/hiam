<?php

namespace hiam\assets;

use yii\web\AssetBundle;

class PictonicAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/pictonic';
    public $css = [
        'css/pictonic.css',
    ];
    public $js = [
        'js/pictonic.min.js'
    ];

    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
//        'assets\AppAsset',
    ];
}
