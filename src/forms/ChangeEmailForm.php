<?php

namespace hiam\forms;

use Yii;
use yii\base\Model;

class ChangeEmailForm extends Model
{
    /**
     * @var string
     */
    public $login;

    /**
     * @var integer
     */
    public $seller_id;

    /**
     * @var integer
     */
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['seller_id', 'integer'],
            ['login', 'string'],
            ['email', 'email'],
            [['login', 'seller_id', 'email'], 'required'],
            [
                'email', 'unique',
                'targetClass' => Yii::$app->user->storageClasses['identity'],
                'targetAttribute' => ['email', 'seller_id'],
                'message' => Yii::t('yii', '{attribute} "{value}" has already been taken.'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('hiam', 'Email'),
        ];
    }
}
