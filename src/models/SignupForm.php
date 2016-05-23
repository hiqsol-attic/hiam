<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\models;

use Yii;

/**
 * Signup form.
 */
class SignupForm extends \yii\base\Model
{
    //public $username;
    public $seller;
    public $first_name;
    public $last_name;
    public $email;
    public $username;
    public $password;
    public $password_retype;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
/* TODO TODO login
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
*/

            ['seller', 'filter', 'filter' => 'trim'],
            ['seller', 'string'],

            [['first_name', 'last_name'], 'filter', 'filter' => 'trim'],
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 64],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'string'],

            ['password',        'string', 'min' => 6],
            ['password_retype', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],

            [['first_name', 'last_name', 'email', 'password', 'password_retype'], 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User(['scenario' => 'insert']);
            $user->login = $this->username ?: $this->email;
            $user->email = $this->email;
            $user->password = $this->password;
            $seller = User::findByUsername($this->seller ?: Yii::$app->params['user.seller']);
            if (!$seller->obj_id) {
                throw new InvalidParamException('wrong seller given');
            }
            $user->seller_id = $seller->obj_id;

            if (!$user->save()) {
                return null;
            }

            $contact = Contact::findOne($user->obj_id);
            $contact->load([$contact->formName() => $this->getAttributes()]);
            $contact->save();

            return $user;
        }

        return null;
    }
}
