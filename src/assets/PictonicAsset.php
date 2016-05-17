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

class PictonicAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/pictonic';
    public $css = [
        'css/pictonic.css',
    ];
    public $js = [
        'js/pictonic.min.js',
    ];

    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
//        'assets\AppAsset',
    ];
}
