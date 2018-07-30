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
        $this->mailsDir = getcwd() . '/runtime/mail';
    }

    public function cleanUp()
    {
        try {
            FileHelper::removeDirectory(Yii::getAlias('@runtime/mail'));
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
        $message = $this->getLastMessage();
        $I->assertNotEmpty($message);
        $resetTokenLink = $this->getResetTokenUrl($message);
        $I->assertNotEmpty($resetTokenLink);
        $I->amOnUrl($resetTokenLink);
        $I->seeElement('#login-form');
        $this->password = '654321';
        $I->fillField(['name' => 'ResetPasswordForm[password]'], $this->password);
        $I->fillField(['name' => 'ResetPasswordForm[password_retype]'], $this->password);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $I->seeElement('#login-form');
        $this->clearMessages();
    }

    protected function getResetTokenUrl($f)
    {
        if (preg_match("|<a.*(?=href=\"([^\"]*)\")[^>]*>([^<]*)</a>|i", $f['body'], $matches)) {
            return $matches[1];
        }

        return false;
    }

    protected function getMessages()
    {
        $ignored = ['.', '..', '.svn', '.htaccess'];
        $files = [];
        $tries = 0;
        while (!file_exists($this->mailsDir)) {
            if ($tries++ > 15) {
                return null;
            }
            sleep(1);
        }
        foreach (scandir($this->mailsDir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($this->mailsDir . '/' . $file);
        }

        arsort($files);
        $files = array_keys($files);

        return $files ? $files : null;
    }

    protected function getLastMessage()
    {
        $messages = $this->getMessages();

        if ($messages) {
            $f = $this->mailsDir . '/' . reset($messages);
            $mime = mailparse_msg_parse_file($f);
            $struct = mailparse_msg_get_structure($mime);
            if (in_array('1.1', $struct)) {
                $info = mailparse_msg_get_part_data(mailparse_msg_get_part($mime, '1'));
                ob_start();
                mailparse_msg_extract_part_file(mailparse_msg_get_part($mime, '1.2'), $f);
                $body = ob_get_contents();
                ob_end_clean();

                return compact('info', 'body');
            }
        }

        return false;
    }

    protected function clearMessages(): void
    {
        $files = glob($this->mailsDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
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

