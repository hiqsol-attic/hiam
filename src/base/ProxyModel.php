<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\base;

use Yii;

abstract class ProxyModel extends \yii\base\Model
{
    abstract public static function primaryKey();

    public static function findOne($cond)
    {
        $class = static::getStorageClass();
        $store = $class::findOne($cond);

        if (!$store) {
            return null;
        }

        $model = new static;
        $model->setAttributes($store->getAttributes($model->attributes()));

        return $model;
    }

    public function save()
    {
        $class = static::getStorageClass();
        $cond = $this->getAttributes(static::primaryKey());
        $store = $class::findOne($cond) ?: Yii::createObject($class);
        $store->setAttributes($this->getAttributes());
        if (!$store->save()) {
            return false;
        }
        $model = static::findOne($cond);
        $this->setAttributes($model->getAttributes());

        return true;
    }

    public static function getStorageClass()
    {
        return Yii::$app->user->getStorageClass(get_called_class());
    }
}
