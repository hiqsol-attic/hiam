<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\controllers;

use hiam\models\LoginForm;
use hiam\models\PasswordResetRequestForm;
use hiam\models\RemoteUser;
use hiam\models\ResetPasswordForm;
use hiam\models\SignupForm;
use hiam\models\Identity;
use hisite\actions\RenderAction;
use hisite\actions\RedirectAction;
use Yii;
use yii\authclient\AuthAction;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Site controller.
 */
class SiteController extends \hisite\controllers\SiteController
{
    public $defaultAction = 'lockscreen';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'signup', 'request-password-reset', 'remote-proceed', 'lockscreen'],
                'denyCallback' => [$this, 'denyCallback'],
                'rules' => [
                    // ? - guest
                    [
                        'actions' => ['login', 'confirm', 'signup', 'request-password-reset', 'remote-proceed'],
                        'roles' => ['?'],
                        'allow' => true,
                    ],
                    // @ - authenticated
                    [
                        'actions' => ['lockscreen'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
            ],
        ]);
    }

    public function denyCallback()
    {
        return $this->redirect([Yii::$app->user->getIsGuest() ? 'login' : 'lockscreen']);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'successCallback'],
            ],
            'lockscreen' => [
                'class' => RenderAction::class,
            ],
            'back' => [
                'class' => RedirectAction::class,
                'url' => Yii::$app->params['site_url'],
            ],
        ]);
    }

    public function successCallback($client)
    {
        $user = Identity::findIdentityByAuthClient($client);
        if ($user) {
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return;
        }
        return;
    }

    public function actionLogin($confirm = false)
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if ($client) {
            return $this->redirect(['remote-proceed']);
        }

        return $this->doLogin('login');
    }

    protected function doLogin($view, $username = null)
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            if ($username !== null) {
                $model->username = $username;
            }
            $model->password = null;
            return $this->render($view, compact('model'));
        }
    }

    public function actionConfirm()
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if (!$client) {
            return $this->redirect(['login']);
        }

        try {
            $email = $client->getUserAttributes()['email'];
            $user = Identity::findByEmail($email);
        } catch (\Exception $e) {
            return $this->redirect(['logout']);
        }

        $res = $this->doLogin('confirm', $user ? $user->email : null);
        $user = Yii::$app->getUser()->getIdentity();
        if ($user) {
            RemoteUser::set($client, $user);
        }
        return $res;
    }

    public function actionRemoteProceed()
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if (!$client) {
            return $this->redirect(['login']);
        }

        try {
            $email = $client->getUserAttributes()['email'];
            $user = Identity::findByEmail($email);
        } catch (\Exception $e) {
            return $this->redirect(['logout']);
        }

        if ($user) {
            return $this->redirect(['confirm']);
        }

        return $this->redirect(['signup']);
    }

    public function actionSignup()
    {
        $client = Yii::$app->authClientCollection->getActiveClient();

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    if ($client) {
                        RemoteUser::set($client, $user);
                    }
                    return $this->goBack();
                }
            }
        } else {
            if ($client) {
                try {
                    $data = $client->getUserAttributes();
                } catch (\Exception $e) {
                    return $this->redirect(['logout']);
                }
                $model->load([$model->formName() => $data]);
            }
        }

        return $this->render('signup', compact('model'));
    }

    public function actionSignupValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new SignupForm();
        $model->load(Yii::$app->request->post());

        return ActiveForm::validate($model);
    }

    public function actionRequestPasswordReset($username = null)
    {
        $model = new PasswordResetRequestForm();
        if ($username) {
            $model->email = $username;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', compact('model'));
    }

    public function actionResetPassword($login)
    {
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->resetPassword()) {
                Yii::$app->getSession()->setFlash('success', 'New password was saved.');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Failed reset password. Please start over.');
            }

            return $this->goHome();
        }

        return $this->render('resetPassword', compact('model'));
    }

}
