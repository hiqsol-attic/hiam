<?php

namespace hiam\actions;

use Yii;
use yii\base\Action;

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

    public function run()
    {
        $token = Yii::$app->confirmator->findToken(Yii::$app->request->get('token'));
        if ($token && $token->check([$this->actionAttributeName => $this->actionAttributeValue])) {
            $user = Yii::$app->user->findIdentity($token->get($this->usernameAttributeName));
        }
        if (empty($user)) {
            Yii::$app->session->addFlash('error', $this->getErrorMessage());
        } else {
            $user->setEmailConfirmed($token->get('email'));
            Yii::$app->session->addFlash('success', $this->getSuccessMessage());
            if (Yii::$app->user->login($user)) {
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
