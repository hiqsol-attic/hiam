<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\controllers;

use hiam\actions\ConfirmEmail;
use hiam\actions\OpenapiAction;
use hiam\base\User;
use hiam\forms\ChangeEmailForm;
use hiam\forms\ConfirmPasswordForm;
use hiam\forms\LoginForm;
use hiam\forms\ResetPasswordForm;
use hiam\forms\RestorePasswordForm;
use hiam\forms\SignupForm;
use hiam\models\Identity;
use hiqdev\php\confirmator\ServiceInterface;
use hiqdev\yii2\mfa\filters\ValidateAuthenticationFilter;
use hisite\actions\RedirectAction;
use hisite\actions\RenderAction;
use hisite\actions\ValidateAction;
use ReflectionClass;
use Yii;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use hiam\forms\ChangePasswordForm;
use hiam\components\OauthInterface;

/**
 * Site controller.
 *
 * @property User $user
 */
class SiteController extends \hisite\controllers\SiteController
{
    public $defaultAction = 'lockscreen';

    /**
     * @var ServiceInterface
     */
    private $confirmator;

    /**
     * @var OauthInterface
     */
    private $oauth;

    public function __construct($id, $module, ServiceInterface $confirmator, OauthInterface $oauth, $config = [])
    {
        parent::__construct($id, $module, $config = []);

        $this->confirmator = $confirmator;
        $this->oauth = $oauth;
    }

    public function behaviors()
    {
        $actions = [
            'signup', 'login', 'remote-proceed',
            'confirm-password', 'restore-password', 'reset-password',
            'terms', 'privacy-policy',
        ];

        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'only' => array_merge($actions, ['lockscreen']),
                'denyCallback' => function () {
                    return $this->redirect([$this->user->getIsGuest() ? 'login' : 'lockscreen']);
                },
                'rules' => [
                    // ? - guest
                    [
                        'actions' => $actions,
                        'roles' => ['?'],
                        'allow' => true,
                    ],
                    // @ - authenticated
                    [
                        'actions' => ['lockscreen', 'privacy-policy', 'terms', 'resend-verification-email'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
            ],
            'validateAuthentication' => [
                'class' => ValidateAuthenticationFilter::class,
                'only' => ['lockscreen', 'change-password', 'change-email'],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => function (ClientInterface $client) {
                    $user = $this->user->findIdentityByAuthClient($client);
                    if ($user) {
                        $this->user->login($user);
                    }
                },
            ],
            'lockscreen' => [
                'class' => RenderAction::class,
            ],
            'terms' => [
                'class' => RedirectAction::class,
                'url' => Yii::$app->params['terms.url'],
            ],
            'privacy-policy' => [
                'class' => RedirectAction::class,
                'url' => Yii::$app->params['privacy.policy.url'],
            ],
            'signup-validate' => [
                'class' => ValidateAction::class,
                'form' => SignupForm::class,
            ],
            'confirm-email' => [
                'class' => ConfirmEmail::class,
            ],
            'openapi.yaml' => [
                'class' => OpenapiAction::class,
            ],
            'openapi.yml' => [
                'class' => OpenapiAction::class,
            ],
        ]);
    }

    public function actionLogin($username = null)
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if ($client) {
            return $this->redirect(['remote-proceed']);
        }

        return $this->doLogin(Yii::createObject(['class' => LoginForm::class]), 'login', $username);
    }

    protected function doLogin($model, $view, $username = null)
    {
        $model->username = $username;
        /** @noinspection NotOptimalIfConditionsInspection */
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $identity = $this->user->findIdentity($model->username, $model->password);
            if ($identity && $this->login($identity, $model->remember_me)) {
                return $this->goBack();
            }

            $model->addError('password', Yii::t('hiam', 'Incorrect password.'));
            $model->password = null;
        }

        return $this->render($view, compact('model'));
    }

    /**
     * Logs user in and preserves return URL.
     */
    private function login(Identity $identity, $sessionDuration = 0): bool
    {
        $returnUrl = $this->user->getReturnUrl();

        $result = $this->user->login($identity, $sessionDuration ? null : 0);
        if ($result && $returnUrl !== null) {
            $this->user->setReturnUrl($returnUrl);
        }

        return $result;
    }

    public function actionConfirmPassword()
    {
        $client = Yii::$app->authClientCollection->getActiveClient();
        if (!$client) {
            return $this->redirect(['login']);
        }

        try {
            $email = $client->getUserAttributes()['email'];
            $user = $this->user->findIdentityByEmail($email);
        } catch (\Exception $e) {
            return $this->redirect(['logout']);
        }

        $res = $this->doLogin(new ConfirmPasswordForm(), 'confirmPassword', $user ? $user->email : null);
        $user = $this->user->getIdentity();
        if ($user) {
            $this->user->setRemoteUser($client, $user);
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
            $user = $this->user->findIdentityByEmail($email);
        } catch (\Exception $e) {
            return $this->redirect(['logout']);
        }

        if ($user) {
            return $this->redirect(['confirm-password']);
        }

        return $this->redirect(['signup']);
    }

    public function actionSignup($scenario = SignupForm::SCENARIO_DEFAULT)
    {
        if ($this->user->disableSignup) {
            Yii::$app->session->setFlash('error', Yii::t('hiam', 'Sorry, signup is disabled.'));

            return $this->redirect(['login']);
        }

        if ($scenario === SignupForm::SCENARIO_SOCIAL) {
            return $this->redirect(['site/auth', 'authclient' => 'google']);
        }

        $client = Yii::$app->authClientCollection->getActiveClient();

        $model = new SignupForm(compact('scenario'));
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $this->user->signup($model)) {
                if ($client) {
                    $this->user->setRemoteUser($client, $user);
                }
                $this->sendConfirmEmail($user);
                Yii::$app->session->setFlash('success', Yii::t('hiam', 'Your account has been successfully created.'));

                return $this->goBack();
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
            if ($username = Yii::$app->request->get('username')) {
                $model->email = $username;
            }
        }

        return $this->render('signup', compact('model'));
    }

    public function actionRestorePassword($username = null)
    {
        if ($this->user->disableRestorePassword) {
            Yii::$app->session->setFlash('error', Yii::t('hiam', 'Sorry, password restore is disabled.'));

            return $this->redirect(['login']);
        }

        $model = new RestorePasswordForm();
        $model->username = $username;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $this->user->findIdentityByUsername($model->username);
            if ($this->confirmator->mailToken($user, 'restore-password')) {
                Yii::$app->session->setFlash('success',
                    Yii::t('hiam', 'Check your email {maskedMail} for further instructions.', [
                        'maskedMail' => $model->maskEmail($user->email),
                    ])
                );

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('hiam', 'Sorry, we are unable to reset password for the provided username or email. Try to contact support team.'));
            }
        }

        return $this->render('restorePassword', compact('model'));
    }

    public function actionResetPassword($token = null)
    {
        $model = new ResetPasswordForm();
        $reset = $this->resetPassword($model, $token);

        if (isset($reset)) {
            if ($reset) {
                Yii::$app->session->setFlash('success', Yii::t('hiam', 'New password was saved.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('hiam', 'Failed reset password. Please start over.'));
            }

            return $this->goHome();
        }

        return $this->render('resetPassword', compact('model', 'token'));
    }

    public function actionChangePassword()
    {
        $model = Yii::createObject(['class' => ChangePasswordForm::class]);
        $model->login = Yii::$app->user->identity->username;

        return $this->changeRoutine($model);
    }

    public function actionChangeEmail()
    {
        $model = new ChangeEmailForm();
        $identity = Yii::$app->user->identity;
        $model->seller_id = $identity->seller_id;
        $model->login = $identity->username;

        return $this->changeRoutine($model);
    }

    public function actionResendVerificationEmail()
    {
        $user = $this->user->getIdentity();
        $this->sendConfirmEmail($user);

        return $this->goBack();
    }

    public function resetPassword($model, $token)
    {
        $token = $this->confirmator->findToken($token);
        if (!$token || !$token->check(['action' => 'restore-password'])) {
            return false;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $this->user->findIdentity($token->get('username'));
            if (!$user) {
                return false;
            }
            $user->password = $model->password;
            $res = $user->save();
            if ($res) {
                $token->remove();
            }

            return $res;
        }

        return null;
    }

    /**
     * @param ChangePasswordForm|ChangeEmailForm $model
     */
    private function changeRoutine($model)
    {
        $map = [
            ChangePasswordForm::class => [
                'method' => 'changePassword',
                'view' => 'change-password',
                'label' => Yii::t('hiam', 'Password'),
            ],
            ChangeEmailForm::class => [
                'method' => 'changeEmail',
                'view' => 'change-email',
                'label' => Yii::t('hiam', 'Email'),
            ],
        ];
        $sender = $map[get_class($model)];
        $request = Yii::$app->request;

        if ($request->isPost) {
            if ($model->load($request->post()) && $model->validate() && $this->user->{$sender['method']}($model)) {
                Yii::$app->session->setFlash('success', Yii::t('hiam', '{label} has been successfully changed', ['label' => $sender['label']]));

                return $this->goBack();
            }
            $errors = implode("; \n", $model->getFirstErrors());
            if (!$errors) {
                $errors = Yii::t('hiam', "{label} has not been changed", ['label' => $sender['label']]);
            }
            Yii::$app->session->setFlash('error', $errors);
        }

        return $this->render($sender['view'], ['model' => $model]);
    }

    public function actionBack()
    {
        return $this->goBack(Yii::$app->params['site_url']);
    }

    public function goBack($defaultUrl = null)
    {
        $response = $this->oauth->goBack() ?? parent::goBack($defaultUrl);
        if (empty($response)) {
            return $response;
        }
        if (Yii::$app->session->hasFlash('success')) {
            $response->headers['location'] .= '?success=true';
        }
        $requestHost = $this->getHost(Yii::$app->request->hostInfo);
        $responseHost = $this->getHost($response->headers['location']);
        if (strcmp($requestHost, $responseHost)) {
            Yii::$app->session->removeAllFlashes();
        }
        return $response;
    }

    private function getHost(string $url): ?string
    {
        $parsedArray = parse_url($url);
        return $parsedArray['host'] ?? null;
    }

    protected function sendConfirmEmail($user)
    {
        if ($this->confirmator->mailToken($user, 'confirm-email')) {
            Yii::$app->session->setFlash('warning',
                Yii::t('hiam', 'Please confirm your email address!') . '<br/>' .
                Yii::t('hiam',
                    'An email with confirmation instructions was sent to <b>{email}</b>',
                    ['email' => $user->email]
                )
            );
        } else {
            Yii::error('Failed to send email confirmation letter', __METHOD__);
        }
    }
}
