<?php

declare(strict_types=1);

namespace Test;

use App\Carpaccio\Exception\WrongPriceException;
use App\Carpaccio\Exception\WrongQuantityException;
use App\Carpaccio\Order;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CarpaccioTest
 *
 * @package Test
 */
class CarpaccioTest extends TestCase
{

    /**
     * @return array
     */
    public function itemPriceProvider()
    {
        return [
            [1000, 1000],
            [2000, 2000],
            [0, 0]
        ];
    }

    /**
     * @return array
     */
    public function itemPriceValidationProvider()
    {
        return [
            [-1, 1000, WrongPriceException::class],
            ['2000', 2000, TypeError::class],
            [0, 0]
        ];
    }

    /**
     * @return array
     */
    public function itemQuantityProvider()
    {
        return [
            [1, 1000],
            [2, 2000],
            [17, 17000]
        ];
    }

    /**
     * @return array
     */
    public function itemQuantityValidationProvider()
    {
        return [
            [1, 1000],
            [-2, 2000, WrongQuantityException::class],
            ['17', 17000, TypeError::class]
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

    /**
     * @dataProvider itemPriceValidationProvider
     *
     * @param $price
     * @param $expected
     * @param $exception
     */
    public function testValidatePrice($price, $expected, $exception = '')
    {
        if ($exception) {
            $this->expectException($exception);
            new Order($price, 1, 'UT');
        } else {
            $order = new Order($price, 1, 'UT');
            $this->assertEquals($order->getValue(), $expected);
        }
    }

    /**
     * @dataProvider itemQuantityValidationProvider
     *
     * @param $qty
     * @param $expected
     * @param $exception
     */
    public function testValidateQty($qty, $expected, $exception = '')
    {
        if ($exception) {
            $this->expectException($exception);
            new Order(1, $qty, 'UT');
        } else {
            $order= new Order(1000, $qty, 'UT');
            $this->assertEquals($order->getValue(), $expected);
        }
    }
}