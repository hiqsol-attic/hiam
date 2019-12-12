<?php


namespace hiam\tests\_support\Page;


use hiam\tests\_support\AcceptanceTester;

/**
 * Class ChangeEmail
 * @package hiam\tests\_support\Page
 */
class ChangeEmail extends AbstractHiamPage
{
    /**
     * ChangePassword constructor.
     * @param AcceptanceTester $I
     */
    public function __construct(AcceptanceTester $I)
    {
        parent::__construct($I);
        $I->amOnPage('/site/change-email');
    }

    /**
     * @inheritDoc
     */
    public function tryFillContactInfo(array $info): void
    {

    }
}
