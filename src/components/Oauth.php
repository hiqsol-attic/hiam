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

class Oauth implements OauthInterface
{
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
     * @return Request
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
        return $this->getServer()->handleAuthorizeRequest($this->getRequest(), $this->getResponse(), $is_authorized, $id);
    }

    public function handleTokenRequest()
    {
        return $this->getServer()->handleTokenRequest($this->getRequest(), $this->getResponse());
    }

    public function getConfig($name)
    {
        return $this->getServer->getConfig($name);
    }
}
