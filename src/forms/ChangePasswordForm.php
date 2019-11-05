<?php

namespace hiam\forms;

use hiam\models\Identity;
use hiam\validators\PasswordValidatorInterface;
use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $current_password;

    /**
     * @var string
     */
    public $new_password;

    /**
     * @var string
     */
    public $confirm_password;

    /**
     * @var PasswordValidatorInterface
     */
    private $passwordValidator;

    /**
     * @param PasswordValidatorInterface $passwordValidator
     * @param array $config
     */
    public function __construct(PasswordValidatorInterface $passwordValidator, $config = [])
    {
        parent::__construct($config);
        $this->passwordValidator = $passwordValidator;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['login', 'current_password', 'new_password', 'confirm_password'], 'string'],
            [['login', 'current_password', 'new_password', 'confirm_password'], 'required'],
            ['current_password', $this->passwordValidator->inlineFor($this)],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'current_password' => Yii::t('hiam', 'Current password'),
            'new_password' => Yii::t('hiam', 'New password'),
            'confirm_password' => Yii::t('hiam', 'Confirm password'),
        ];
    }

    public function applyTo(Identity $identity): bool
    {
        return $identity->changePassword($this->new_password);
    }
}
