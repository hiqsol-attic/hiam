<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiam\forms;

use Yii;

/**
 * Password password form.
 */
class RestorePasswordForm extends \yii\base\Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'email', 'message' => Yii::t('hiam', 'The entered value is not an email address.')],
            ['email', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('hiam', 'Email'),
        ];
    }
}
