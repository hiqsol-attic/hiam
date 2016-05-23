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
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\helpers\Json;

/**
 * Password reset form.
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_retype;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_retype', 'required'],
            ['password_retype', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],

            ['rawBag', 'safe'],
        ];
    }

    /**
     * Resets password.
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $bag = Yii::$app->request->get();
        $url = Yii::$app->params['api_url'] . '/clientSetPassword?' . http_build_query([
            'client'        => $bag['login'],
            'new_password'  => $this->password,
            'confirm_data'  => $bag,
        ]);
        $res = Json::decode(file_get_contents($url));

        return !isset($res['_error']);
    }
}
