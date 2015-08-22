<?php

namespace hiam;

use Yii;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
    ];

    public function init()
    {
        parent::init();
        $version = Yii::$app->extensions['hiqdev/hiam-core']['version'];
        if ($version=='9999999-dev') {
            $v = file_get_contents(Yii::getAlias('@hiam/../.git/refs/heads/master'));
            $version = $v ? substr($v, 0, 7) : $version;
        }
        Yii::$app->params['poweredByVersion'] = $version;
    }
}
