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
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 128],
            ['username', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('hiam', 'Login or email'),
        ];
    }

    public function maskEmail($email)
    {
        if (empty($email)) {
            return '';
        }

        $result = mb_substr($email, 0, 1); // First letter
        $result .= str_repeat('*', rand(5, 10)); // Mask

        $localLength = mb_strpos($email, '@'); // When login is longer than 3 chars - show
        if ($localLength > 3) {
            $result .= mb_substr($email, $localLength-1, 1);
        }
        $result .= '@';
        $result .= mb_substr($email, mb_strpos($email, '@')+1, 1);
        $result .= mb_substr($email, mb_strlen($email));
        $result .= str_repeat('*', rand(2, 5));
        $result .= mb_substr($email, mb_strrpos($email, '.'));

        return $result;
    }
}
