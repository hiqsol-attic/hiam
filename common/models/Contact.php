<?php
/**
 * @link    http://hiqdev.com/hi3a
 * @license http://hiqdev.com/hi3a/license
 * @copyright Copyright (c) 2014-2015 HiQDev
 */

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * User model
 *
 * @property integer $obj_id PK
 * @property string $first_name
 * @property string $last_name
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

/*
    public function attributes () {
        return array_merge(parent::attributes());
    }
*/

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['first_name','last_name'], 'filter', 'filter' => 'trim'],
            [['first_name','last_name'], 'string', 'min' => 2, 'max' => 64],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
        ];
    }

}
