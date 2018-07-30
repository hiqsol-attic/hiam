<?php

use hiam\tests\_support\AcceptanceTester;
use yii\helpers\FileHelper;

class HiamBasicFunctionsCest
{
    private $username;

    private $password = '123456';

    private $identity;

    private $mailsDir;

    public function __construct()
    {
        $this->username = mt_rand(100000, 999999) . "+testuser@example.com";
    }

    public function cleanUp(AcceptanceTester $I)
    {
        try {
            FileHelper::removeDirectory($I->getMailsDir());
            FileHelper::removeDirectory(Yii::getAlias('@runtime/tokens'));
        } catch (Exception $exception) {
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
        $I->see('Signup');
        $I->fillField(['name' => 'SignupForm[first_name]'], 'Test User First Name');
        $I->fillField(['name' => 'SignupForm[last_name]'], 'Test User Last Name');
        $I->fillField(['name' => 'SignupForm[email]'], $this->username);
        $I->fillField(['name' => 'SignupForm[password]'], $this->password);
        $I->fillField(['name' => 'SignupForm[password_retype]'], $this->password);
        $I->clickWithLeftButton(['css' => '.field-signupform-i_agree']);
        $I->clickWithLeftButton(['css' => '.field-signupform-i_agree_privacy_policy']);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $I->seeElement('#login-form');
        $token = $this->_findLastToken();
        $I->assertNotEmpty($token, 'token exists');

        $I->amOnPage('/site/confirm-email?token=' . $token);
        $I->makeScreenshot();
        $I->waitForText($this->username);
        $I->see($this->username);
    }

    /**
     * @before cleanUp
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
        $I->wantTo('Restore passwrod');
        $I->amOnPage('/site/restore-password');
        $I->fillField(['name' => 'RestorePasswordForm[username]'], $this->username);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $message = $I->getLastMessage();
        $I->assertNotEmpty($message);
        $resetTokenLink = $I->getResetTokenUrl($message);
        $I->assertNotEmpty($resetTokenLink);
        $I->amOnUrl($resetTokenLink);
        $I->seeElement('#login-form');
        $this->password = '654321';
        $I->fillField(['name' => 'ResetPasswordForm[password]'], $this->password);
        $I->fillField(['name' => 'ResetPasswordForm[password_retype]'], $this->password);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $I->seeElement('#login-form');
        $I->clearMessages();
    }

    private function _findLastToken()
    {
        foreach (range(1, 15) as $try) {
            sleep(2);
            $res = exec('find runtime/tokens -type f -cmin -1 | cut -sd / -f 4 | tail -1');
            if ($res) return $res;
        }

        return null;
    }
}

