<?php


namespace hiam\tests\_support\Page;


use hiam\tests\_support\AcceptanceTester;

/**
 * Class AbstractHiamPage
 * @package hiam\tests\_support\Page
 */
abstract class AbstractHiamPage
{
    /**
     * @var AcceptanceTester
     */
    protected $tester;

    /**
     * AbstractHiamPage constructor.
     * @param AcceptanceTester $I
     */
    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * @param array $info
     * @throws \Exception
     */
    abstract public function tryFillContactInfo(array $info): void;

    /**
     * @throws \Exception
     */
    public function tryClickSubmitButton(): void
    {
        $this->tester->clickWithLeftButton(['css' => 'button[type=submit]']);
    }

    /**
     * @throws \Exception
     */
    public function tryLogout(): void
    {
        $this->tester->click('a[href="/site/logout"]');
    }
}
