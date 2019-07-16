<?php

namespace hiam\tests\_support\Page;

use hiam\tests\_support\AcceptanceTester;

class SignUp
{
    /** @var AcceptanceTester */
    private $tester;

    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * @param array
     * @throws \Exception
     */
    public function tryFillContactInfo(array $info): void
    {
        $I = $this->tester;
        $I->fillField(['name' => 'SignupForm[email]'], $info['username']);
        $I->fillField(['name' => 'SignupForm[password]'], $info['password']);
        try {
            $I->fillField(['name' => 'SignupForm[first_name]'], $info['username']);
            $I->fillField(['name' => 'SignupForm[last_name]'], $info['username']);
            $I->fillField(['name' => 'SignupForm[password_retype]'], $info['password']);
        } catch (\Exception $e) {
        }
    }

    /**
     * @throws \Exception
     */
    public function tryClickAdditionalCheckboxes(): void
    {
        $I = $this->tester;
        try {
            $I->clickWithLeftButton(['css' => '.field-signupform-i_agree']);
            $I->clickWithLeftButton(['css' => '.field-signupform-i_agree_privacy_policy']);
        } catch (\Exception $e) {
        }
    }

    /**
     * @throws \Exception
     */
    public function tryClickAgreeTermsPrivacy(): void
    {
        $I = $this->tester;
        try {
            $I->clickWithLeftButton(['css' => 'label[for=\'i_agree_terms_and_privacy-email\']']);
        } catch (\Exception $e) {
            $I->clickWithLeftButton(['css' => 'input[name*=i_agree_terms_and_privacy][type=checkbox]']);
        }
    }
}
