<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\storage;

/**
 * Default identity storage model.
 *
 * @property integer $id PK
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $type
 * @property string $state
 * @property string $first_name
 * @property string $last_name
 */
class HiamIdentity extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['id', 'integer'],

            [['username', 'email', 'password', 'first_name', 'last_name'], 'trim'],
        ];
    }
}
