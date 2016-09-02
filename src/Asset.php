<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam;

use yii\web\AssetBundle;

/**
 * Most basic asset for the app:
 * - own hiam.css
 * - bootstrap+plugins
 * - font-awesome
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@hiam/assets';
    public $css = [
        '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
        'css/hiam.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
