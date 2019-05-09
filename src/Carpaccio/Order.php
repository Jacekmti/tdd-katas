<?php

declare(strict_types=1);

namespace App\Carpaccio;

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
     */
    public function __construct(int $price, int $qty, string $state)
    {
        $this->price = $price;
        $this->qty = $qty;
        $this->state = $state;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->price * $this->qty;
    }
}
