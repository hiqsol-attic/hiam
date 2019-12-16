<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hiam\forms;

use hiam\models\Identity;
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
                'when' => function () {
                    return $this->login && $this->seller_id;
                },
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

    public function applyTo(Identity $identity): bool
    {
        return $identity->setNewUnconfirmedEmail($this->email);
    }
}
