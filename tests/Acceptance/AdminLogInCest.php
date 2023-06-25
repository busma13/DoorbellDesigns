<?php
namespace Tests\Acceptance;

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// echo $_ENV['ADMIN_USERNAME'];

use Tests\Support\AcceptanceTester;

use \Codeception\Step\Argument\PasswordArgument;

class AdminLogInCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function signInSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/admin.php');
        $I->fillField('userName',new PasswordArgument($_ENV['ADMIN_USERNAME']));
        $I->fillField('password',new PasswordArgument($_ENV['ADMIN_PASSWORD']));
        $I->click('Log in');
        $I->see('Admin Panel');
    }

    public function signInWrongUserName(AcceptanceTester $I)
    {
        $I->amOnPage('/admin.php');
        $I->fillField('userName', 'non-existant-admin');
        $I->fillField('password',new PasswordArgument($_ENV['ADMIN_PASSWORD']));
        $I->click('Log in');
        $I->see('Your username or password was incorrect. Please try again.');
    }

    public function signInWrongPassword(AcceptanceTester $I)
    {
        $I->amOnPage('/admin.php');
        $I->fillField('userName',new PasswordArgument($_ENV['ADMIN_USERNAME']));
        $I->fillField('password','IncorrectPASSWORD');
        $I->click('Log in');
        $I->see('Your username or password was incorrect. Please try again.');
    }
}
