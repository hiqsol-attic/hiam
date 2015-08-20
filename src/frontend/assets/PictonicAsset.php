<?php
/**
 * @link http://hiqdev.com/...
 * @copyright Copyright (c) 2015 HiQDev
 * @license http://hiqdev.com/.../license
 */

namespace frontend\assets;

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
//        'frontend\assets\AppAsset',
    ];
}
