<?php

declare(strict_types=1);

namespace App\Carpaccio;

use App\Carpaccio\Exception\WrongPriceException;
use App\Carpaccio\Exception\WrongQuantityException;

/**
 * Class Order
 *
 * @package App\Carpaccio
 */
class Order
{
    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $state;

    /**
     * @var int
     */
    private $qty;

    /**
     * Order constructor.
     *
     * @param int    $price
     * @param int    $qty
     * @param string $state
     *
     * @throws WrongPriceException
     * @throws WrongQuantityException
     */
    public function __construct(int $price, int $qty, string $state)
    {
        $this->price = $price;
        $this->qty = $qty;
        $this->state = $state;

        $this->validate();
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->price * $this->qty;
    }

    /**
     * @throws WrongPriceException
     * @throws WrongQuantityException
     */
    private function validate()
    {
        if ($this->price < 0) {
            throw new WrongPriceException();
        }

        if ($this->qty < 0) {
            throw new WrongQuantityException();
        }
    }
}
