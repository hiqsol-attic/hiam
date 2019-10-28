<?php


namespace hiam\components;


use vintage\recaptcha\helpers\RecaptchaConfig;
use vintage\recaptcha\validators\InvisibleRecaptchaValidator;
use Yii;

/**
 * Class CaptchaCache
 * @package hiam\components
 */
final class CaptchaCache
{
    const SIGNUP_CACHE_NAME = 'SignUpCaptcha';

    const SIGNIN_CACHE_NAME = 'SignInCaptcha';

    const RESTORE_PASSWORD_CACHE_NAME = 'RestorePasswordCaptcha';

    const SIGNUP_CACHE_DURATION = 24 * 3600;

    const SIGNIN_CACHE_DURATION = 24 * 3600;

    const RESTORE_PASSWORD_CACHE_DURATION = 24 * 3600;

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

    /**
     * Handling captcha enable status
     *
     * @param string $cacheType
     * @param int $cacheDuration
     * @return bool
     */
    public static function handleCaptcha(string $cacheType, int $cacheDuration): bool
    {
        if (empty(Yii::$app->params[RecaptchaConfig::SITE_KEY])) {
            return true;
        }
        if (!static::getCaptchaCache($cacheType)) {
            static::setCaptchaCache($cacheType, $cacheDuration);
            return true;
        }
        $validator = new InvisibleRecaptchaValidator(Yii::$app->getRequest()->post());
        return (bool)$validator->validate();
    }
}
