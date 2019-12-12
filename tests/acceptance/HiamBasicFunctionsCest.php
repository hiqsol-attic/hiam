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
use hiam\tests\_support\Helper\TokenHelper;
use hiam\tests\_support\Page\Lockscreen;
use hiam\tests\_support\Page\Login;
use hiam\tests\_support\Page\ResetPassword;
use hiam\tests\_support\Page\RestorePassword;
use hiam\tests\_support\Page\SignUp;
use yii\helpers\FileHelper;

class HiamBasicFunctionsCest
{
    /** @var string */
    private $username;

    /** @var string */
    private $password = '123456';

    /** @var string */
    private $identity;

    public function __construct()
    {
        $this->username = mt_rand(100000, 999999) . '+testuser@example.com';
    }

    /**
     * @param AcceptanceTester $I
     */
    public function cleanUp(AcceptanceTester $I): void
    {
        try {
            FileHelper::removeDirectory($I->getMailsDir());
            FileHelper::removeDirectory(TokenHelper::getTokensDir());
        } catch (\Throwable $exception) {
            // seems to be already removed. it's fine
        }
    }

    /**
     * @before cleanUp
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function signup(AcceptanceTester $I): void
    {
        $I->wantTo('signup to hiam');
        $signupPage = new SignUp($I);
        $info = $this->getUserInfo();
        $signupPage->tryFillContactInfo($info);
        $signupPage->tryClickAdditionalCheckboxes();
        $signupPage->tryClickAgreeTermsPrivacy();
        $signupPage->tryClickSubmitButton();
        $I->waitForText($info['username']);
    }

    /**
     * @before cleanUp
     * @depends signup
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function login(AcceptanceTester $I): void
    {
        $I->wantTo('login to hiam');
        $loginPage = new Login($I);
        $info = $this->getUserInfo();
        $loginPage->tryFillContactInfo($info);
        $loginPage->tryClickSubmitButton();
        $I->waitForText($info['username']);
        $this->identity = $I->grabCookie('_identity');
        $I->assertNotEmpty($this->identity, 'cookie grabbed');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function logout(AcceptanceTester $I): void
    {
        $I->wantTo('Logout from hiam');
        $I->setCookie('_identity', $this->identity);
        $lockscreenPage = new Lockscreen($I);
        $I->see($this->username);
        $lockscreenPage->tryLogout();
        $I->see('Sign in');
    }

    /**
     * @depends logout
     * @before cleanUp
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function restorePassword(AcceptanceTester $I): void
    {
        $I->wantTo('Restore password');
        $restorePasswordPage = new RestorePassword($I);
        $info = $this->getUserInfo();
        $restorePasswordPage->tryFillContactInfo($info);
        $restorePasswordPage->tryClickSubmitButton();
        $I->wait(1);
        $resetTokenLink = TokenHelper::getTokenUrl($I);
        $resetPasswordPage = new ResetPassword($I, $resetTokenLink);
        $resetPasswordPage->tryFillContactInfo($info);
        $resetPasswordPage->tryClickSubmitButton();
        $I->waitForText('New password was saved.');
    }

    /**
     * @return array
     */
    protected function getUserInfo(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
