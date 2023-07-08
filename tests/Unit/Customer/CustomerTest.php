<?php


namespace Tests\Unit\Customer;

require_once 'vendor/autoload.php';

use App\CustomerClass;
use Tests\Support\UnitTester;

class CustomerTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testEmptyFieldMethod()
    {
        $customer = new CustomerClass();

        $customer->setFirst('Peter');
        $customer->setLast('Luitjens');
        $customer->setTel('4805554321');
        $customer->setEmail('peterluitjens@gmail.com');
        $customer->setAddress_Line('108 W Main St.');
        $customer->setCity('Mesa');
        $customer->setState('AZ');
        $customer->setZip('85201');

        $this->assertFalse($customer->customerHasEmptyFields());
    }

    public function testFormatTelephoneNumberMethod()
    {
        $customer = new CustomerClass();

        verify($customer->formatTelephoneNumber('(123) 456-7890'))->equals('11234567890');
    }
}