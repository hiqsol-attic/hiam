<?php

namespace hiam\actions;

use hiqdev\php\confirmator\ServiceInterface;
use Yii;
use yii\base\Action;
use yii\web\Session;
use yii\web\User;

class ConfirmEmail extends Action
{
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
     * @var User
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

    public function run()
    {
        $token = $this->confirmator->findToken(Yii::$app->request->get('token'));
        if ($token && $token->check([$this->actionAttributeName => $this->actionAttributeValue])) {
            $user = $this->user->findIdentity($token->get($this->usernameAttributeName));
        }
        if (empty($user)) {
            $this->session->addFlash('error', $this->getErrorMessage());
        } else {
            $user->setEmailConfirmed($token->get('email'));
            $this->session->addFlash('success', $this->getSuccessMessage());
            if ($this->user->login($user)) {
                $token->remove();
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
