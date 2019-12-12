<?php


namespace hiam\tests\_support\Page;


use hiam\tests\_support\AcceptanceTester;

/**
 * Class LockscreenPage
 * @package hiam\tests\_support\Page
 */
class Lockscreen extends AbstractHiamPage
{
    /**
     * LockscreenPage constructor.
     * @param AcceptanceTester $I
     */
    public function __construct(AcceptanceTester $I)
    {
        parent::__construct($I);
        $I->amOnPage('/site/lockscreen');
    }

    /**
     * @inheritDoc
     */
    public function tryFillContactInfo(array $info): void
    {
    }
}
