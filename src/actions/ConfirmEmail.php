<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   proprietary
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
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

    /** {@inheritdoc} */
    protected function beforeRun()
    {
        Yii::$app->user->logout();

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
            $this->session->addFlash('success', $this->getSuccessMessage());
            if ($this->user->login($user)) {
                $token->remove();
            }
        }

        return $this->controller->goBack();
    }

    private function getSuccessMessage(): string
    {
        return $this->successMessage ?: Yii::t('hiam', 'Your email was confirmed!');
    }

    private function getErrorMessage(): string
    {
        return $this->errorMessage ?: Yii::t('hiam', 'Failed confirm email. Please start over.');
    }
}
