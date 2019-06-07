<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\components;

use Yii;
use yii\web\Request;

class Oauth implements OauthInterface
{
    const SESSION_PARAM_NAME = 'oauth.authorize.request.data';

    public function goBack()
    {
        if (empty($this->getUser()->id) || !$this->restoreAuthorizeRequest()) {
            return null;
        }

        return $this->handleAuthorizeRequest(true, $this->getUser()->id);
    }

    /**
     * @return bool true if authorize request was restored (it was saved before)
     */
    private function restoreAuthorizeRequest(): bool
    {
        $params = $this->getSession()->get(self::SESSION_PARAM_NAME);
        if (empty($params['redirect_uri'])) {
            return false;
        }

        $this->getRequest()->query = $params;

        return true;
    }

    /**
     * @return \filsh\yii2\oauth2server\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('oauth2');
    }

    public function getServer()
    {
        return $this->getModule()->getServer();
    }

    /**
     * @return \filsh\yii2\oauth2server\Request
     */
    public function getRequest()
    {
        return $this->getModule()->getRequest();
    }

    /**
     * @return \filsh\yii2\oauth2server\Response
     */
    public function getResponse()
    {
        return $this->getModule()->getResponse();
    }

    /**
     * Get request parameter from POST then GET.
     *
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getRequestValue($name, $default = null)
    {
        $request = $this->getModule()->getRequest();

        return $request->request[$name] ?? $request->query($name, $default);
    }

    public function sendResponse()
    {
        $oauthResponse = $this->getResponse();
        $yiiResponse = Yii::$app->response;

        foreach ($oauthResponse->getHttpHeaders() as $name => $value) {
            $yiiResponse->headers->set($name, $value);
        }
        $yiiResponse->setStatusCode($oauthResponse->getStatusCode(), $oauthResponse->getStatusText());

        return $oauthResponse->getResponseBody();
    }

    public function validateAuthorizeRequest()
    {
        return $this->getServer()->validateAuthorizeRequest($this->getRequest(), $this->getResponse());
    }

    public function verifyResourceRequest($scope = null)
    {
        return $this->getServer()->verifyResourceRequest($this->getRequest(), $this->getResponse(), $scope);
    }

    public function handleAuthorizeRequest($is_authorized, $id)
    {
        $this->getServer()->handleAuthorizeRequest($this->getRequest(), $this->getResponse(), $is_authorized, $id);

        return $this->sendResponse();
    }

    public function handleTokenRequest()
    {
        return $this->getServer()->handleTokenRequest($this->getRequest(), $this->getResponse());
    }

    public function getConfig($name)
    {
        return $this->getServer()->getConfig($name);
    }

    /**
     * @return string|null redirect_uri or null if request is invalid
     */
    public function saveAuthorizeRequest(Request $request): ?string
    {
        if (!$this->validateAuthorizeRequest()) {
            return null;
        }

        $this->getSession()->set(self::SESSION_PARAM_NAME, $request->get());

        return $request->get('request_uri');
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return Yii::$app->user;
    }

    private function getSession()
    {
        return Yii::$app->getSession();
    }
}
