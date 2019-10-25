<?php


namespace hiam\components;


use Yii;

/**
 * Trait CaptchaCache
 * @package hiam\components
 */
trait CaptchaCache
{
    /**
     * Set captcha cache while signin
     */
    public function setCaptchaCache(): void
    {
        $requestIp = Yii::$app->request->getUserIP();

        Yii::$app->cache->set('SignupIpCaptcha' . $requestIp, $requestIp, 60 * 60);
    }

    /**
     * Get captcha cache while signin
     */
    public function getCaptchaCache(): string
    {
        $requestIp = Yii::$app->request->getUserIP();

        return Yii::$app->cache->get('SignupIpCaptcha' . $requestIp);
    }
}
