<?php


namespace hiam\tests\_support\Page;


use hiam\tests\_support\AcceptanceTester;

/**
 * Class RestorePassword
 * @package hiam\tests\_support\Page
 */
class RestorePassword extends AbstractHiamPage
{
    /**
     * RestorePassword constructor.
     * @param AcceptanceTester $I
     */
    public function __construct(AcceptanceTester $I)
    {
        parent::__construct($I);
        $I->amOnPage('/site/restore-password');
    }

    /**
     * @inheritDoc
     */
    public function tryFillContactInfo(array $info): void
    {
        $this->tester->fillField(['name' => 'RestorePasswordForm[username]'], $info['username']);
    }
}
