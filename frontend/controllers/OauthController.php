<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\filters\ContentNegotiator;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;

class OauthController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
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
     * Get request parameter from POST then GET
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestValue($name, $default = null)
    {
        $request = $this->getModule()->getRequest();
        return isset($request->request[$name]) ? $request->request[$name] : $request->query($name,$default);
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
        if ($access_token) { /// returning user_attributes together with token
            $user_attributes = $this->findUser($access_token)->getAttributes();
            $response->addParameters(compact('user_attributes'));
        };
        return $response->send();
    }

    public function actionResource()
    {
        $ok = $this->getServer()->verifyResourceRequest($this->request);
        if (!$ok) return $this->getServer()->getResponse()->send();
        $access_token = $this->getRequestValue($this->getTokenParamName());
        $user = $this->findUser($access_token);

        if (!is_object($user)) { /// TODO fix error returning
            return ['error' => 'no user'];
        };
/*
        $command = $this->getRequestValue('command');
        if (!Yii::$app->authManager->checkAccess($user->id,$command)) return ['error' => 'not allowed command','command' => $command];
*/
        return $user->getAttributes();
    }

    public function actionAuthorize () {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if (!$this->getServer()->validateAuthorizeRequest($request, $response)) {
            return $response->send();
        };

        $id = Yii::$app->getUser()->id;
        if (!$id) {
            Yii::$app->user->setReturnUrl(Yii::$app->getRequest()->getUrl());
            return $this->redirect(['/site/login']);
        };

        if ($this->getRequestValue('client_id') === 'sol-hipanel-master') {
            $is_authorized = true;
        };

        if (!$is_authorized && empty($_POST)) {
            return $this->render('Authorize',[
                'client_id' => 'THE CLIENT_ID',
            ]);
        };

        if (!$is_authorized) {
            if (!Yii::$app->getRequest()->validateCsrfToken()) {
                throw new BadRequestHttpException(Yii::t('yii', 'Unable to verify your data submission.'));
            };
            $is_authorized = ($_POST['authorized'] === 'yes');
        };

        $this->getServer()->handleAuthorizeRequest($request, $response, $is_authorized, $id);
        return $response->send();
    }

}
