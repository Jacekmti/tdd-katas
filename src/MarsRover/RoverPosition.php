<?php

namespace App\MarsRover;

use App\MarsRover\Exception\InvalidRoverPositionException as InvalidRoverPositionExceptionAlias;

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
    const DIRECTIONS = ['n', 'w', 's', 'e'];

    /**
     * RoverPosition constructor.
     *
     * @param int    $x
     * @param int    $y
     * @param string $direction
     *
     * @throws InvalidRoverPositionExceptionAlias
     */
    public function __construct(int $x, int $y, string $direction)
    {
        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;

        $this->validate();
    }

    /**
     * Validate rover position and direction parameters.
     *
     * @throws InvalidRoverPositionExceptionAlias
     */
    private function validate()
    {
        $this->validateCoordinates();
        $this->validateDirection();
    }

    /**
     * Validate direction.
     *
     * @throws InvalidRoverPositionExceptionAlias
     */
    private function validateDirection()
    {
        if (!in_array($this->direction, self::DIRECTIONS)) {
            throw new InvalidRoverPositionExceptionAlias("Invalid direction.");
        }
    }

    /**
     * Validate position coordinates.
     *
     * @throws InvalidRoverPositionExceptionAlias
     */
    private function validateCoordinates()
    {
        if ($this->x < 0 && $this->x > GridConstantsInterface::GRID_WIDTH) {
            throw new InvalidRoverPositionExceptionAlias("Invalid x.");
        }
        if ($this->y < 0 && $this->y > GridConstantsInterface::GRID_HEIGHT) {
            throw new InvalidRoverPositionExceptionAlias("Invalid y.");
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
