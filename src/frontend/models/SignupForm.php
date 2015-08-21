<?php

namespace hiam\frontend\models;

use Yii;
use hiam\common\models\User;
use hiam\common\models\Contact;

/**
 * Signup form
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
/* TODO TODO login
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
*/

            [['first_name','last_name'], 'filter', 'filter' => 'trim'],
            [['first_name','last_name'], 'string', 'min' => 2, 'max' => 64],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'string'],

            ['password',        'string', 'min' => 6],
            ['password_retype', 'string', 'min' => 6],

            [['first_name','last_name','email','password'],'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup ()
    {
        if ($this->validate()) {
            $user = new User();
            $user->login = $this->username ?: $this->email;
            $user->email = $this->email;
            $user->password = $this->password;
            $seller = User::findByUsername($this->seller ?: 'ahnames');
            if (!$seller->id) {
                throw new InvalidParamException('wrong seller given');
            };
            $user->seller_id = $seller->id;
            //$user->setPassword($this->password);
            //$user->generateAuthKey();
            $user->save();
            $user = User::findByUsername($user->login);
            if (!$user) {
                throw new IntegrityException('failed create user');
            };

            $contact = Contact::findOne($user->id);
            $contact->load([$contact->formName() => $this->getAttributes()]);
            $contact->save();
            
            return $user;
        }

        return null;
    }
}
