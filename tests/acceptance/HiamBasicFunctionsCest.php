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
        $I->wantTo('signup to hiam');
        $I->amOnPage('/site/signup');
//        $I->see('Sign up to Advanced Hosting');
        try {
            $I->fillField(['name' => 'SignupForm[first_name]'], $this->username);
            $I->fillField(['name' => 'SignupForm[last_name]'], $this->username);
            $I->fillField(['name' => 'SignupForm[password_retype]'], $this->password);
        }
        catch (\Exception $e) {

        }
        $I->fillField(['name' => 'SignupForm[email]'], $this->username);
        $I->fillField(['name' => 'SignupForm[password]'], $this->password);
        try {
            $I->clickWithLeftButton(['css' => '.field-signupform-i_agree']);
            $I->clickWithLeftButton(['css' => '.field-signupform-i_agree_privacy_policy']);
        }
        catch (\Exception $e) {

        }
        $I->clickWithLeftButton(['css' => 'input[name*=i_agree_terms_and_privacy][type=checkbox]']);


//        $I->waitForText('Your account has been successfully created.');
        $I->clickWithLeftButton(['css' => 'button[type=submit]']);
        $I->waitForText('Your account has been successfully created.');
        $token = $this->findLastToken();
        $I->assertNotEmpty($token, 'token exists');
//        $I->waitForText('Your account has been successfully created.');
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

    private function findLastToken(): ?string
    {
        foreach (range(1, 31) as $try) {
            codecept_debug($try . ' try to get Token by path: ' . $this->getTokensDir());
            sleep(2);
            $res = exec('find ' . $this->getTokensDir() . '  -type f -cmin -1 -exec basename {} \; | tail -1');

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
