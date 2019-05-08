<?php

namespace App\MarsRover;

class RoverPosition
{
    private $position;
    private $direction;

    private $directions = ['n', 'w', 's', 'e'];
    /**
     * RoverPosition constructor.
     * @param array  $position
     * @param string $direction
     * @throws InvalidRoverPositionException
     */
    public function __construct(array $position, string $direction)
    {
        if (!isset($position[0]) || ($position[0] < 0 && $position[0] > GridConstantsInterface::GRID_WIDTH)) {
            throw new InvalidRoverPositionException("Invalid width");
        }

        if (!isset($position[1]) || ($position[1] < 0 && $position[1] > GridConstantsInterface::GRID_HEIGHT)) {
            throw new InvalidRoverPositionException("Invalid height");
        }

        if (!in_array($direction, $this->directions)) {
            throw new InvalidRoverPositionException("Invalid direction");
        }

        $this->position = $position;
        $this->direction = $direction;
    }


}
