<?php

namespace App\MarsRover;

class RoverPosition
{
    /**
     * @var array
     */
    private $position;

    /**
     * @var string
     */
    private $direction;

    const DIRECTIONS = ['n', 'w', 's', 'e'];
    
    /**
     * RoverPosition constructor.
     * @param array  $position
     * @param string $direction
     * @throws InvalidRoverPositionException
     */
    public function __construct(array $position, string $direction)
    {
        $this->position = $position;
        $this->direction = $direction;

        $this->validate();
    }

    /**
     * @throws InvalidRoverPositionException
     */
    private function validate()
    {
        $this->validatePosition();
        $this->validateDirection();
    }

    /**
     * @throws InvalidRoverPositionException
     */
    private function validateDirection()
    {
        if (!in_array($this->direction, self::DIRECTIONS)) {
            throw new InvalidRoverPositionException("Invalid direction.");
        }
    }

    /**
     * @throws InvalidRoverPositionException
     */
    private function validatePosition()
    {
        if (!isset($this->position[0]) || ($this->position[0] < 0
                && $this->position[0] > GridConstantsInterface::GRID_WIDTH)) {
            throw new InvalidRoverPositionException("Invalid x.");
        }
        if (!isset($this->position[1]) || ($this->position[1] < 0
                && $this->position[1] > GridConstantsInterface::GRID_HEIGHT)) {
            throw new InvalidRoverPositionException("Invalid y.");
        }
    }
}
