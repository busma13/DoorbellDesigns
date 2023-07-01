<?php


namespace Tests\Unit\Order;

use Tests\Support\UnitTester;

// require_once __DIR__. '/../../../includes.order.inc.php';

class SetItemNameTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSetItemNameFunction()
    {
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
        $this->assertTrue(setItemName($itemObj) == 'Air Plant Cradle, Color: Blue Azure');
    }
}
