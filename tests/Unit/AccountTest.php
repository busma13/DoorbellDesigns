<?php


namespace Tests\Unit;

require_once 'vendor/autoload.php';

use App\AccountClass;
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
        $user = new AccountClass();
        // $user->addAccount('Peter', 'abc123');
        $this->assertTrue($user->isNameValid("test"));
    }
}