<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\models;

use Yii;

abstract class ProxyModel extends \yii\base\Model
{
    const EVENT_BEFORE_SAVE = 'beforeSave';

    abstract public static function primaryKey();

    public static function findOne($cond)
    {
        $class = static::getStorageClass();
        $store = $class::findOne($cond);

        if (!$store) {
            return null;
        }

        $attributes = [];
        $model = Yii::createObject(static::class);
        foreach ($model->attributes() as $attribute) {
            $attributes[$attribute] = $store->$attribute;
        }
        $model->setAttributes($attributes);

        return $model;
    }

    public function save()
    {
        $this->trigger(static::EVENT_BEFORE_SAVE);
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
