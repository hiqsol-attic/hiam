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

use hiam\models\ContactForm;
use hiam\models\LoginForm;
use hiam\models\PasswordResetRequestForm;
use hiam\models\RemoteUser;
use hiam\models\ResetPasswordForm;
use hiam\models\SignupForm;
use hiam\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller.
 */
class SiteController extends Controller
{
    public $defaultAction = 'lockscreen';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
        ];
    }

    public function denyCallback()
    {
        return $this->redirect([Yii::$app->user->getIsGuest() ? 'login' : 'lockscreen']);
    }

    /** {@inheritdoc} */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function successCallback($client)
    {
        $user = User::findIdentityByAuthClient($client);
        if ($user) {
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return;
        };
        return;
    }

    public function actionLockscreen()
    {
        return $this->render('lockscreen');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    protected function doLogin($view, $username = null)
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            if ($username) {
                $model->username = $username;
            }
            return $this->render($view, compact('model'));
        }
    }

    public function actionLogin($confirm = false)
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if ($client) {
            return $this->redirect(['remote-proceed']);
        };

        return $this->doLogin('login');
    }

    public function actionConfirm()
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if (!$client) {
            return $this->redirect(['login']);
        };

        $email = $client->getUserAttributes()['email'];
        $user = User::findOne(['email' => $email]);

        $res = $this->doLogin('confirm', $user ? $user->email : null);
        $user = Yii::$app->getUser()->getIdentity();
        if ($user) {
            RemoteUser::set($client, $user);
        };
        return $res;
    }

    public function actionRemoteProceed()
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if (!$client) {
            return $this->redirect(['login']);
        };
        $email = $client->getUserAttributes()['email'];
        $user = User::findByEmail($email);
        if ($user) {
            return $this->redirect(['confirm']);
        };
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
                    };
                    return $this->goBack();
                }
            }
        } else {
            if ($client) {
                $model->load([$model->formName() => $client->getUserAttributes()]);
            };
        };

        return $this->render('signup', compact('model'));
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->getSession()->destroy();
        $post = Yii::$app->request->post('back');
        $back = isset($post) ? $post : Yii::$app->request->get('back');

        return $back ? $this->redirect($back) : $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
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

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
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

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
