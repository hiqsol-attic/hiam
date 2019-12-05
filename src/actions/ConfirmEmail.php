<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\actions;

use hiqdev\php\confirmator\ServiceInterface;
use hiqdev\php\confirmator\Token;
use Yii;
use yii\base\Action;
use yii\web\Session;
use yii\web\User;

class ConfirmEmail extends Action
{
    const SESSION_VAR_NAME = 'confirming_email';

    /**
     * @var string
     */
    public $actionAttributeName = 'action';

    /**
     * @var string
     */
    public $actionAttributeValue = 'confirm-email';

    /**
     * @var string
     */
    public $usernameAttributeName = 'username';

    /**
     * @var string
     */
    public $successMessage;

    /**
     * @var string
     */
    public $errorMessage;

    /**
     * @var ServiceInterface
     */
    private $confirmator;

    /**
     * @var User|\hiam\base\User
     */
    private $user;

    /**
     * @var Session
     */
    private $session;

    public function __construct($id, $controller, ServiceInterface $confirmator, User $user, Session $session, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->confirmator = $confirmator;
        $this->user = $user;
        $this->session = $session;
    }

    /** @inheritDoc */
    protected function beforeRun()
    {
        $identity = $this->user->identity ?? null;
        if ($identity) {
            if ($identity->email !== $this->session->get(static::SESSION_VAR_NAME)) {
                $this->user->logout();
            }
        }
        return parent::beforeRun();
    }

    public function run()
    {
        /** @var Token $token */
        $token = $this->confirmator->findToken(Yii::$app->request->get('token'));
        if ($token && $token->check([$this->actionAttributeName => $this->actionAttributeValue])) {
            $user = $this->user->findIdentity($token->get($this->usernameAttributeName));
        }
        if (!isset($user)) {
            $this->session->addFlash('error', $this->getErrorMessage());
        } else {
            $user->setConfirmedEmail($token->get('email'));
            $token->remove();
            $this->session->addFlash('success', $this->getSuccessMessage());
            if ($user->email === $this->session->get(static::SESSION_VAR_NAME)) {
                $this->user->login($user);
            }
        }

        return $this->controller->goBack();
    }

    /**
     * @return string
     */
    private function getSuccessMessage(): string
    {
        return $this->successMessage ?: Yii::t('hiam', 'Your email was confirmed!');
    }

    /**
     * @return string
     */
    private function getErrorMessage(): string
    {
        return $this->errorMessage ?: Yii::t('hiam', 'Failed confirm email. Please start over.');
    }
}
