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

use filsh\yii2\oauth2server\models\OauthAccessTokens;
use filsh\yii2\oauth2server\Request;
use hiam\base\User;
use hiam\components\OauthInterface;
use hiam\components\TokenRevokerInterface;
use hiqdev\yii2\mfa\filters\ValidateAuthenticationFilter;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\IdentityInterface;
use yii\web\Response;

class OauthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    /**
     * @var OauthInterface
     */
    private $oauth;
    /**
     * @var TokenRevokerInterface
     */
    private $tokenRevoker;

    public function __construct($id, $module, OauthInterface $oauth, TokenRevokerInterface $tokenRevoker, $config = [])
    {
        parent::__construct($id, $module, $config = []);

        $this->oauth = $oauth;
        $this->tokenRevoker = $tokenRevoker;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['resource'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'validateAuthentication' => [
                'class' => ValidateAuthenticationFilter::class,
                'only' => ['authorize'],
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'revoke' => ['POST'],
                ],
            ],
        ]);
    }

    public function getTokenParamName()
    {
        return $this->oauth->getConfig('token_param_name');
    }

    /**
     * @param OauthAccessTokens $token
     * @return IdentityInterface|User
     */
    public function findIdentityByToken(OauthAccessTokens $token)
    {
        return Yii::$app->user->findIdentity($token->user_id);
    }

    /** @return OauthAccessTokens */
    public function findToken($access_token)
    {
        return OauthAccessTokens::findOne($access_token);
    }

    public function actionToken()
    {
        $response = $this->oauth->handleTokenRequest();
        $access_token = $response->getParameter($this->getTokenParamName());
        if ($access_token) {
            $token = $this->findToken($access_token);
            $attributes = $this->findIdentityByToken($token)->getAttributes();
            $response->addParameters([
                'user_attributes' => $this->cleanAttributes($attributes),
            ]);
        }

        return $this->oauth->sendResponse();
    }

    /// Should base on token `scope`
    private function cleanAttributes($arr): array
    {
        unset($arr['password'], $arr['password_hash'], $arr['totp_secret'], $arr['email_new']);

        return $arr;
    }

    public function actionResource()
    {
        $ok = $this->oauth->verifyResourceRequest();
        if (!$ok) {
            return $this->oauth->sendResponse();
        }
        $access_token = $this->oauth->getRequestValue($this->getTokenParamName());
        $token = $this->findToken($access_token);
        $user = $this->findIdentityByToken($token);

        if (!is_object($user)) { /// TODO fix error returning
            return ['error' => 'no user'];
        }

        return array_merge(array_filter($user->getAttributes()), [
            'token' => $token,
        ]);
    }

    public function actionRevoke()
    {
        $this->oauth->handleRevokeTokenRequest();
        return $this->oauth->sendResponse();
    }

    public function isAuthorizedClient($client)
    {
        return !empty(Yii::$app->params['hiam.authorizedClients'][$client]);
    }

    public function actionAuthorize()
    {
        if (!$this->oauth->validateAuthorizeRequest()) {
            return $this->oauth->sendResponse();
        }

        $id = Yii::$app->getUser()->id;
        if (!$id) {
            $dest = $_REQUEST['prefer_signup'] ? 'signup' : 'login';
            return $this->redirect(["/site/$dest"]);
        }

        $client_id = $this->oauth->getRequestValue('client_id');
        $is_authorized = $this->isAuthorizedClient($client_id);
        if (!$is_authorized) {
            if (empty($_POST)) {
                return $this->render('authorizeClient', [
                    'client_id' => $client_id,
                ]);
            }

            if (!Yii::$app->getRequest()->validateCsrfToken()) {
                throw new BadRequestHttpException(Yii::t('hiam', 'Unable to verify your data submission.'));
            }
            $is_authorized = ($_POST['authorized'] === 'yes');
        }

        $user_id = $this->oauth->getRequestValue('user_id');
        if ($user_id && $this->canImpersonate()) {
            $id = $user_id;
        }

        return $this->oauth->handleAuthorizeRequest($is_authorized, $id);
    }

    private function canImpersonate()
    {
        return Yii::$app->user->can('client.impersonate'); // TODO: more wise check
    }
}
