<?php

use hiam\tests\_support\AcceptanceTester;

class HiamBasicFunctionsCest
{
    private $username;

    private $password = '123456';

    private $token;

    private $identity;

    private $mailsDir;

    public function __construct()
    {
        $this->username = mt_rand(100000, 999999) . "+testuser@example.com";
        $this->mailsDir = getcwd() . '/runtime/debug/mail';
    }

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
        $I->wait(1);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $I->wait(2);
        $I->seeElement('#login-form');
        $token = $this->_findLastToken();
        $I->assertNotEmpty($token, 'token exists');
        $this->token = $token;
    }


    /**
     * @before signup
     */
    public function emailConfirm(AcceptanceTester $I)
    {
        $I->amOnPage('/site/confirm-email?token=' . $this->token);
        $I->wait(2);
        $I->see($this->username);
    }


    /**
     * @depends emailConfirm
     */
    public function login(AcceptanceTester $I)
    {
        $I->wantTo('login to hiam');
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', [
            'LoginForm' => [
                'username' => $this->username,
                'password' => $this->password,
            ]
        ]);
        $I->fillField(['name' => 'LoginForm[username]'], $this->username);
        $I->fillField(['name' => 'LoginForm[password]'], $this->password);
        $I->wait(1);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $I->wait(1);
        $I->see($this->username);
        $this->identity = $I->grabCookie('_identity');
    }

    /**
     * @depends login
     */
    public function logout(AcceptanceTester $I)
    {
        $I->wantTo('Logout from hiam');
        $I->setCookie('_identity', $this->identity);
        $I->amOnPage('/site/lockscreen');
        $I->wait(1);
        $I->see($this->username);
        $I->click('a[href="/site/logout"]');
        $I->wait(1);
        $I->see('Sign in');
    }

    /**
     * @after login
     */
    public function restorePassword(AcceptanceTester $I)
    {
        $I->wantTo('Restore passwrod');
        $I->amOnPage('/site/restore-password');
        $I->wait(1);
        $I->fillField(['name' => 'RestorePasswordForm[username]'], $this->username);
        $I->wait(1);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $I->wait(2);
//        $I->see('Sign in'); // todo:
        $message = $this->getLastMessage();
        $resetTokenLink = $this->getResetTokenUrl($message);
        $I->amOnUrl($resetTokenLink);
        $I->wait(1);
        $I->seeElement('#login-form');
        $this->password = '654321';
        $I->fillField(['name' => 'ResetPasswordForm[password]'], $this->password);
        $I->fillField(['name' => 'ResetPasswordForm[password_retype]'], $this->password);
        $I->wait(1);
        $I->clickWithLeftButton(['css' => '#login-form button']);
        $I->wait(1);
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
        foreach (scandir($this->mailsDir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($this->mailsDir . '/' . $file);
        }

        arsort($files);
        $files = array_keys($files);

        return ($files) ? $files : false;
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
        return exec('find runtime/tokens -type f -cmin -1 | cut -sd / -f 4 | tail -1');
    }
}

