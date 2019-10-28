<?php


namespace hiam\components;


use hiam\controllers\SiteController;
use yii\base\Behavior;
use yii\base\Event;
use yii\filters\RateLimiter;

class CaptchaBehavior extends RateLimiter
{
    const SIGNUP_CACHE_NAME = 'SignUpCaptcha';
    const SIGNIN_CACHE_NAME = 'SignInCaptcha';
    const RESTORE_PASSWORD_CACHE_NAME = 'RestorePasswordCaptcha';
    const SIGNUP_CACHE_DURATION = 24 * 3600;
    const SIGNIN_CACHE_DURATION = 24 * 3600;
    const RESTORE_PASSWORD_CACHE_DURATION = 24 * 3600;


    public function events()
    {
        return [
            SiteController::EVENT_BEFORE_ACTION => 'beforeRestorePassword',
        ];
    }

    public function beforeRestorePassword(Event $e)
    {
        $kek = 1;
    }


    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if ($this->user === null && Yii::$app->getUser()) {
            $this->user = Yii::$app->getUser()->getIdentity(false);
        }

        if ($this->user instanceof RateLimitInterface) {
            Yii::debug('Check rate limit', __METHOD__);
            $this->checkRateLimit($this->user, $this->request, $this->response, $action);
        } elseif ($this->user) {
            Yii::info('Rate limit skipped: "user" does not implement RateLimitInterface.', __METHOD__);
        } else {
            Yii::info('Rate limit skipped: user not logged in.', __METHOD__);
        }

        return true;
    }

    /**
     * Checks whether the rate limit exceeds.
     * @param RateLimitInterface $user the current user
     * @param Request $request
     * @param Response $response
     * @param \yii\base\Action $action the action to be executed
     * @throws TooManyRequestsHttpException if rate limit exceeds
     */
    public function checkRateLimit($user, $request, $response, $action)
    {

    }
}
