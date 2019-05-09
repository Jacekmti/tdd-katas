<?php

declare(strict_types=1);

namespace App\MarsRover;

use App\MarsRover\Exception\InvalidRoverPositionException;

/**
 * Class RoverPosition
 *
 * @package App\MarsRover
 */
class RoverPosition
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var array
     */
    const DIRECTIONS = [
        GridConstantsInterface::NORTH,
        GridConstantsInterface::EAST,
        GridConstantsInterface::SOUTH,
        GridConstantsInterface::WEST
    ];

    /**
     * RoverPosition constructor.
     *
     * @param int    $x
     * @param int    $y
     * @param string $direction
     *
     * @throws InvalidRoverPositionException
     */
    public function __construct(int $x, int $y, string $direction)
    {
        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;

        $this->validate();
    }

    /**
     * Validate rover direction.
     *
     * @throws InvalidRoverPositionException
     */
    private function validate()
    {
        if (!in_array($this->direction, self::DIRECTIONS)) {
            throw new InvalidRoverPositionException("Invalid direction.");
        }
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

}
