<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\storage;

/**
 * Contact model.
 *
 * @property integer $obj_id PK
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $email
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 64],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
        ];
    }
}
