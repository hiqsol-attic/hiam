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

use Yii;
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
            ['password_retype', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('hiam', "Passwords don't match.")],
        ];
    }

    /**
     * Resets password.
     * @return boolean if password was reset
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

    public function attributeLabels()
    {
        return [
            'password' => Yii::t('hiam', 'Password'),
            'password_retype' => Yii::t('hiam', 'Retype password'),
        ];
    }
}
