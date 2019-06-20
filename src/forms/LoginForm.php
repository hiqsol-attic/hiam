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

use hiam\validators\LoginValidatorInterface;
use Yii;
use yii\base\Model;

/**
 * Login form.
 */
class LoginForm extends Model
{
    public $username;

    public $password;

    public $remember_me = true;

    /**
     * @var LoginValidatorInterface
     */
    private $loginValidator;

    /**
     * @param LoginValidatorInterface $loginValidator
     * @param array $config
     */
    public function __construct(LoginValidatorInterface $loginValidator, $config = [])
    {
        parent::__construct($config);
        $this->loginValidator = $loginValidator;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'strtolower'],
            ['username', $this->loginValidator->inlineFor($this)],
            [['username', 'password'], 'trim'],
            [['username', 'password'], 'required'],
            ['remember_me', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('hiam', 'Login or Email'),
            'password' => Yii::t('hiam', 'Password'),
            'remember_me' => Yii::t('hiam', 'Remember me'),
        ];
    }
}
