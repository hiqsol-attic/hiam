<?php


namespace hiam\tests\_support\Page;


use hiam\tests\_support\AcceptanceTester;

/**
 * Class Login
 * @package hiam\tests\_support\Page
 */
class Login extends AbstractHiamPage
{
    /**
     * SignUp constructor.
     * @param AcceptanceTester $I
     */
    public function __construct(AcceptanceTester $I)
    {
        parent::__construct($I);
        $I->amOnPage('/site/login');
    }

    /**
     * @inheritDoc
     */
    public function tryFillContactInfo(array $info): void
    {
        $I = $this->tester;
        $I->fillField(['name' => 'LoginForm[username]'], $info['username']);
        $I->fillField(['name' => 'LoginForm[password]'], $info['password']);
    }
}
