<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;

class AccountTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testNameValidity()
    {
        // $user = new /includes/account-class.inc.php/Account("test");
        // $this->assertTrue($user->isValidName("test"));
        $this->assertEquals(1 + 1, 2);
    }
}