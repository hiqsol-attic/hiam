<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\forms;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Signup form.
 */
class SignupForm extends Model
{
    public $first_name;

    public $last_name;

    public $email;

    public $password;

    public $password_retype;

    public $i_agree;

    public $i_agree_privacy_policy;

    public $i_agree_terms_and_privacy;

    public $send_me_news;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password'], 'trim'],
            [['first_name', 'last_name', 'password'], 'string', 'min' => 2, 'max' => 64],

            ['email', 'email'],
            ['email', 'filter', 'filter' => 'strtolower'],
            ['email', 'string', 'min' => 2, 'max' => 255],
            ['email', function ($attribute) {
                if (!empty(Yii::$app->user->findIdentityByEmail($this->email))) {
                    $this->addError($attribute, Yii::t('hiam', 'This email has already been taken.'));
                }
            }],

            ['password_retype', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('hiam', "Passwords don't match.")],

            [['email', 'password'], 'required', 'on' => ['default', 'short']],
            [['first_name', 'last_name', 'password_retype'], 'required', 'on' => ['default']],

            [['i_agree', 'i_agree_privacy_policy', 'i_agree_terms_and_privacy', 'send_me_news'], 'boolean'],
            ['i_agree', 'required', 'requiredValue' => 1, 'message' => Yii::t('hiam', 'Please consider terms of use.'), 'on' => ['default']],
            ['i_agree_privacy_policy', 'required', 'requiredValue' => 1, 'message' => Yii::t('hiam', 'Please consider Privacy Policy.'), 'on' => ['default']],
            ['i_agree_terms_and_privacy', 'required', 'requiredValue' => 1, 'message' => Yii::t('hiam', 'Please consider Terms of Use, Privacy Policy and cookies.'), 'on' => ['short', 'social']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('hiam', 'First Name'),
            'last_name' => Yii::t('hiam', 'Last Name'),
            'email' => Yii::t('hiam', 'Email'),
            'password' => Yii::t('hiam', 'Password'),
            'password_retype' => Yii::t('hiam', 'Retype password'),
            'i_agree' => Yii::t('hiam', 'I agree to the') . ' ' . Html::a(Yii::t('hiam', 'terms'), '/site/terms'),
            'i_agree_privacy_policy' => Yii::t('hiam', 'I agree to the') . ' ' . Html::a(Yii::t('hiam', 'Privacy Policy'), '/site/privacy-policy'),
            'send_me_news' => Yii::t('hiam', 'Send me important news and special offers'),
            'i_agree_terms_and_privacy' => Yii::t('hiam', 'I agree to the {terms_of_services}, {privacy_policy} and the collection of cookies on the website', [
                'terms_of_services' => Html::a(Yii::t('hiam', 'Terms of Services'), '/site/terms'),
                'privacy_policy' => Html::a(Yii::t('hiam', 'Privacy Policy'), '/site/privacy-policy'),
            ]),
        ];
    }
}
