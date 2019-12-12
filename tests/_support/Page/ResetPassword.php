<?php


namespace hiam\tests\_support\Page;


use hiam\tests\_support\AcceptanceTester;

/**
 * Class ResetPassword
 * @package hiam\tests\_support\Page
 */
class ResetPassword extends AbstractHiamPage
{
    /**
     * ResetPassword constructor.
     * @param AcceptanceTester $I
     * @param string $tokenUrl
     */
    public function __construct(AcceptanceTester $I, string $tokenUrl)
    {
        parent::__construct($I);
        $I->amOnUrl($tokenUrl);
    }

    /**
     * @inheritDoc
     */
    public function tryFillContactInfo(array $info): void
    {
        $this->tester->fillField(['name' => 'ResetPasswordForm[password]'], $info['password']);
        $this->tester->fillField(['name' => 'ResetPasswordForm[password_retype]'], $info['password']);
    }
}
