<?php


namespace hiam\components;


use Yii;

/**
 * Trait CaptchaCache
 * @package hiam\components
 */
final class CaptchaCache
{
    const SIGNUP_CACHE_NAME = 'SignUpIpCaptcha';

    const SIGNIN_CACHE_NAME = 'SignInIpCaptcha';

    const PASSWORD_RESET_CACHE_NAME = 'SignInIpCaptcha';

    const SIGNUP_CACHE_DURATION = 24 * 3600;

    const SIGNIN_CACHE_DURATION = 24 * 3600;

    const PASSWORD_RESET_CACHE_DURATION = 24 * 3600;

    /**
     * Set captcha cache while signin
     *
     * @param string $cacheType
     * @param int $cacheDuration
     */
    public static function setCaptchaCache(string $cacheType, int $cacheDuration): void
    {
        $requestIp = Yii::$app->request->getUserIP();

        Yii::$app->cache->set($cacheType . $requestIp, $requestIp, $cacheDuration);
    }

    /**
     * Get captcha cache while signin
     *
     * @param string $cacheType
     * @return string|null
     */
    public static function getCaptchaCache(string $cacheType): ?string
    {
        $requestIp = Yii::$app->request->getUserIP();

        return Yii::$app->cache->get($cacheType . $requestIp);
    }
}
