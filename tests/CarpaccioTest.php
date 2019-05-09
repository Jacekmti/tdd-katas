<?php

namespace Test;

use App\Carpaccio\Order;
use PHPUnit\Framework\TestCase;

class CarpaccioTest extends TestCase
{

    public function itemPriceProvider()
    {
        return [
            [1000, 1000],
            [2000, 2000],
            [0, 0]
        ];
    }

    public function itemQuantityProvider()
    {
        return [
            [1, 1000],
            [2, 2000],
            [17, 17000]
        ];
    }

    /**
     * @dataProvider itemPriceProvider
     *
     * @param $price
     * @param $expected
     */
    public function testItemPrice($price, $expected)
    {
        $order= new Order($price, 1, 'UT');
        $this->assertEquals($order->getValue(), $expected);
    }

    /**
     * @dataProvider itemQuantityProvider
     *
     * @param $quantity
     * @param $expected
     */
    public function testItemQuantity($quantity, $expected)
    {
        $order = new Order(1000, $quantity, 'UT');
        $this->assertEquals($order->getValue(), $expected);
    }
}