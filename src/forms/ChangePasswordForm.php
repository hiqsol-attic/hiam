<?php

namespace hiam\forms;

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
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['login', 'current_password', 'new_password', 'confirm_password'], 'string'],
            [['login', 'current_password', 'new_password', 'confirm_password'], 'required'],
            [
                'current_password',
                function ($attribute, $params) {
                    $check = Yii::$app->db->createCommand("
                    SELECT      zc.obj_id
                    FROM        zclient zc
                    WHERE       zc.state_id = ANY(state_ids('client', 'ok,active,new'))
                                AND NOT check_password('', zc.password)
                                AND login = :login AND check_password(:password, zc.password)
                ")->bindValues([
                        ':login' => $this->login,
                        ':password' => $this->current_password,
                    ])->queryScalar();
                    if (!$check) {
                        $this->addError($attribute, Yii::t('hiam', 'The current password is incorrect'));
                    }
                }],
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
}
