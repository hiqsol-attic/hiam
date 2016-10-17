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
use hiam\models\RestorePasswordForm;
use hiam\models\ResetPasswordForm;
use hiam\models\SignupForm;
use hisite\actions\RenderAction;
use hisite\actions\RedirectAction;
use Yii;
use yii\authclient\AuthAction;
use yii\filters\AccessControl;
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
                'only' => ['login', 'signup', 'restore-password', 'remote-proceed', 'lockscreen'],
                'denyCallback' => [$this, 'denyCallback'],
                'rules' => [
                    // ? - guest
                    [
                        'actions' => ['login', 'confirm', 'signup', 'restore-password', 'remote-proceed'],
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
            'terms' => [
                'class' => RedirectAction::class,
                'url' => Yii::$app->params['terms_url'],
            ],
        ]);
    }

    public function successCallback($client)
    {
        $user = Yii::$app->user->findIdentityByAuthClient($client);
        if ($user) {
            Yii::$app->user->login($user);
        }
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
        $model->username = $username;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Yii::$app->user->findIdentity($model->username, $model->password);
            if ($user) {
                Yii::$app->user->login($user, $model->rememberMe ? null : 0);
                return $this->goBack();
            }
            $model->addError('password', 'Incorrect username or password.');
            $model->password = null;
        }

        return $this->render($view, compact('model'));
    }

    public function actionConfirm()
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if (!$client) {
            return $this->redirect(['login']);
        }

        try {
            $email = $client->getUserAttributes()['email'];
            $user = Yii::$app->user->findIdentityByEmail($email);
        } catch (\Exception $e) {
            return $this->redirect(['logout']);
        }

        $res = $this->doLogin('confirm', $user ? $user->email : null);
        $user = Yii::$app->user->getIdentity();
        if ($user) {
            Yii::$app->user->setRemoteUser($client, $user);
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
            $user = Yii::$app->user->findIdentityByEmail($email);
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
        if (Yii::$app->user->disableSignup) {
            Yii::$app->session->setFlash('error', Yii::t('hiam', 'Sorry, signup is disabled.'));
            return $this->redirect(['login']);
        }

        $client = Yii::$app->authClientCollection->getActiveClient();

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->user->login($user)) {
                    if ($client) {
                        Yii::$app->user->setRemoteUser($client, $user);
                    }
                    Yii::$app->session->setFlash('success', Yii::t('hiam', 'Your account has been successfully created.'));

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

    public function actionRestorePassword($username = null)
    {
        if (Yii::$app->user->disableRestorePassword) {
            Yii::$app->session->setFlash('error', Yii::t('hiam', 'Sorry, password restore is disabled.'));
            return $this->redirect(['login']);
        }

        $model = new RestorePasswordForm();
        $model->email = $username;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('hiam', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('hiam', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('restorePassword', compact('model'));
    }

    public function actionResetPassword()
    {
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->resetPassword()) {
                Yii::$app->session->setFlash('success', 'New password was saved.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed reset password. Please start over.');
            }

            return $this->goHome();
        }

        return $this->render('resetPassword', compact('model'));
    }

}
