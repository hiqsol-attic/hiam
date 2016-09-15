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

use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use Yii;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class OauthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'only' => ['resource'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
//                  'application/xml' => Response::FORMAT_XML,
                ],
            ],
/*
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className()
            ],
*/
        ]);
    }

    public function getModule()
    {
        return Yii::$app->getModule('oauth2');
    }

    public function getServer()
    {
        return $this->getModule()->getServer();
    }

    public function getRequest()
    {
        return $this->getModule()->getRequest();
    }

    public function getResponse()
    {
        return $this->getModule()->getResponse();
    }

    /**
     * Get request parameter from POST then GET.
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestValue($name, $default = null)
    {
        $request = $this->getModule()->getRequest();
        return isset($request->request[$name]) ? $request->request[$name] : $request->query($name, $default);
    }

    public function getTokenParamName()
    {
        return $this->getServer()->getConfig('token_param_name');
    }

    public function findUser($access_token)
    {
        /* @var $class IdentityInterface */
        $class = Yii::$app->getUser()->identityClass;
        return $class::findIdentityByAccessToken($access_token);
    }

    public function actionToken()
    {
        $response = $this->getServer()->handleTokenRequest($this->getRequest());
        $access_token = $response->getParameter($this->getTokenParamName());
        if ($access_token) {
            $user_attributes = $this->findUser($access_token)->getAttributes();
            $response->addParameters(compact('user_attributes'));
        }
        return $response->send();
    }

    public function actionResource()
    {
        $ok = $this->getServer()->verifyResourceRequest($this->request);
        if (!$ok) {
            return $this->getServer()->getResponse()->send();
        }
        $access_token = $this->getRequestValue($this->getTokenParamName());
        $user = $this->findUser($access_token);

        if (!is_object($user)) { /// TODO fix error returning
            return ['error' => 'no user'];
        }
/*
        $command = $this->getRequestValue('command');
        if (!Yii::$app->authManager->checkAccess($user->id,$command)) return ['error' => 'not allowed command','command' => $command];
*/
        return $user->getAttributes();
    }

    public function isAuthorizedClient($client)
    {
        return !empty(Yii::$app->params['hiam.authorizedClients']);
    }

    public function actionAuthorize()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if (!$this->getServer()->validateAuthorizeRequest($request, $response)) {
            return $response->send();
        }

        $id = Yii::$app->getUser()->id;
        if (!$id) {
            Yii::$app->user->setReturnUrl(Yii::$app->getRequest()->getUrl());
            return $this->redirect(['/site/login']);
        }

        $is_authorized = $this->isAuthorizedClients($this->getRequestValue('client_id'));

        if (!$is_authorized) {
            if (empty($_POST)) {
                return $this->render('authorizeClient', [
                    'client_id' => 'THE CLIENT_ID',
                ]);
            }

            if (!Yii::$app->getRequest()->validateCsrfToken()) {
                throw new BadRequestHttpException(Yii::t('yii', 'Unable to verify your data submission.'));
            }
            $is_authorized = ($_POST['authorized'] === 'yes');
        }

        $this->getServer()->handleAuthorizeRequest($request, $response, $is_authorized, $id);

        return $response->send();
    }
}
