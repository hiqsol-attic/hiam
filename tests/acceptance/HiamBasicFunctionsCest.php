<?php
/**
 * Identity and Access Management server providing OAuth2, multi-factor authentication and more
 *
 * @link      https://github.com/hiqdev/hiam
 * @package   hiam
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiam\tests\acceptance;

use hiam\tests\_support\AcceptanceTester;
use hiam\tests\_support\Page\SignUp;
use yii\helpers\FileHelper;
use Yii;

class HiamBasicFunctionsCest
{
    private $username;

    private $password = '123456';

    private $identity;

    public function __construct()
    {
        $this->username = mt_rand(100000, 999999) . '+testuser@example.com';
    }

    public function cleanUp(AcceptanceTester $I)
    {
        try {
            FileHelper::removeDirectory($I->getMailsDir());
            FileHelper::removeDirectory($this->getTokensDir());
        } catch (\Throwable $exception) {
            // seems to be already removed. it's fine
        }
    }

    /**
     * @before cleanUp
     */
    public function signup(AcceptanceTester $I)
    {
        $signupPage = new SignUp($I);
        $I->wantTo('signup to hiam');
        $I->amOnPage('/site/signup');
        $info = $this->getUserInfo();
        $signupPage->tryFillContactInfo($info);
        $signupPage->tryClickAdditionalCheckboxes();
        $signupPage->tryClickAgreeTermsPrivacy();
        $I->clickWithLeftButton(['css' => 'button[type=submit]']);
        $token = $this->findLastToken();
        $I->assertNotEmpty($token, 'token exists');
        $I->amOnPage('/site/confirm-email?token=' . $token);
        $I->waitForText('Your email was confirmed!');
        $I->see($this->username);
    }

    /**
     * @before cleanUp
     * @depends signup
     */
    public function login(AcceptanceTester $I)
    {
        $I->wantTo('login to hiam');
        $I->amOnPage('/site/login');
        $I->fillField(['name' => 'LoginForm[username]'], $this->username);
        $I->fillField(['name' => 'LoginForm[password]'], $this->password);
        $I->click(['css' => '#login-form button']);
        $I->waitForText($this->username);
        $I->see($this->username);
        $this->identity = $I->grabCookie('_identity');
        $I->assertNotEmpty($this->identity, 'cookie grabbed');
    }

    /**
     * @depends login
     */
    public function logout(AcceptanceTester $I)
    {
        $I->wantTo('Logout from hiam');
        $I->setCookie('_identity', $this->identity);
        $I->amOnPage('/site/lockscreen');
        $I->see($this->username);
        $I->click('a[href="/site/logout"]');
        $I->see('Sign in');
    }

    /**
     * @depends logout
     * @before cleanUp
     */
    public function restorePassword(AcceptanceTester $I)
    {
        $I->wantTo('Restore password');
        $I->amOnPage('/site/restore-password');
        $I->fillField(['name' => 'RestorePasswordForm[username]'], $this->username);
        $I->clickWithLeftButton(['css' => 'button[type=submit]']);
        $I->wait(1);
        $message = $I->getLastMessage();
        $I->assertNotEmpty($message, 'make sure that the mail received');
        $resetTokenLink = $I->getResetTokenUrl($message);
        $I->assertNotEmpty($resetTokenLink, 'make sure that reset token link received');
        $I->amOnUrl($resetTokenLink);
        $this->password = '654321';
        $I->fillField(['name' => 'ResetPasswordForm[password]'], $this->password);
        $I->fillField(['name' => 'ResetPasswordForm[password_retype]'], $this->password);
        $I->clickWithLeftButton(['css' => 'button[type=submit]']);
        $I->waitForText('New password was saved.');
    }

    protected function getUserInfo(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'identity' => $this->identity,
        ];
    }

    private function findLastToken(): ?string
    {
        $tokensDir = $this->getTokensDir();

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

    private function getTokensDir()
    {
        return Yii::getAlias('@runtime/tokens');
    }
}
