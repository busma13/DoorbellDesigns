<?php

namespace Tests\Unit\Order;

require 'vendor/autoload.php';

use Tests\Support\UnitTester;
use App\Utils;

class SetItemNameTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSetItemNameFunction()
    {
        // require_once __DIR__ . '/../../../src/Order.php';

        $optionsObject = (object) [
            '17' => 2,
            'optionsIDString' => '2',
            'optionsPairStrings' => [
                (object) [
                    'stringKey' => 'Color:',
                    'stringValue' => 'Blue Azure'
                ]
            ]
        ];
        $itemObj = (object) [
            'itemNameString' => 'Air Plant Cradle',
            'options' => $optionsObject
        ];
        $this->assertTrue(Utils::setItemName($itemObj) == 'Air Plant Cradle, Color: Blue Azure');
    }
}