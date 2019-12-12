<?php


namespace hiam\tests\_support\Helper;


use hiam\tests\_support\AcceptanceTester;
use Yii;

/**
 * Class TokenHelper
 * @package hiam\tests\_support\Helper
 */
final class TokenHelper
{
    /**
     * @return string|null
     */
    public static function findLastToken(): ?string
    {
        $tokensDir = static::getTokensDir();

        foreach (range(1, 31) as $try) {
            codecept_debug("$try try to get Token by path: $tokensDir");
            sleep(2);
            $res = exec("find $tokensDir -type f -cmin -1 -exec basename {} \; | tail -1");

            if ($res) {
                return $res;
            }
        }

        return null;
    }

    /**
     * @return bool|string
     */
    public static function getTokensDir()
    {
        return Yii::getAlias('@runtime/tokens');
    }

    /**
     * @param AcceptanceTester $I
     * @return string
     */
    public static function getTokenUrl(AcceptanceTester $I): string
    {
        $message = $I->getLastMessage();
        $I->assertNotEmpty($message, 'make sure that the mail received');
        $resetTokenLink = $I->getResetTokenUrl($message);
        $I->assertNotEmpty($resetTokenLink, 'make sure that reset token link received');

        return $resetTokenLink;
    }
}
