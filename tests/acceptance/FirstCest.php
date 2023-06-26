<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function homepageTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Shop Categories');
        $I->see('Featured Products');
        $I->see('New Arrivals');
    }
}
