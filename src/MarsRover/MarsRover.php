<?php

declare(strict_types=1);

namespace App\MarsRover;

/**
 * Class MarsRover
 *
 * @package App\MarsRover\src
 */
class MarsRover
{
    /**
     * @var array
     */
    private $grid;

    /**
     * @var RoverPosition
     */
    private $roverPosition;

    /**
     * MarsRover constructor.
     *
     * @param array         $grid
     * @param RoverPosition $roverPosition
     */
    public function __construct(array $grid, RoverPosition $roverPosition)
    {
        $this->grid = $grid;
        $this->roverPosition = $roverPosition;
    }

    /**
     * Navigates rover.
     *
     * @param RoverCommandList $commandList
     *
     * @throws Exception\InvalidRoverPositionException
     */
    public function navigate(RoverCommandList $commandList)
    {
        $commands = $commandList->getCommands();

        foreach ($commands as $command) {
            if ($command == GridConstantsInterface::COMMAND_TURN_LEFT
                || $command == GridConstantsInterface::COMMAND_TURN_RIGHT) {
                $this->rotate($command);
            } else {
                $this->move($command);
            }
        }
    }

    /**
     * @return RoverPosition
     */
    public function getPosition()
    {
        return $this->roverPosition;
    }

    /**
     * Moves rover.
     *
     * @param $command
     *
     * @throws Exception\InvalidRoverPositionException
     */
    private function move($command)
    {
        $direction = $this->roverPosition->getDirection();
        $x = $this->roverPosition->getX();
        $y = $this->roverPosition->getY();

        if ($command == GridConstantsInterface::COMMAND_MOVE_FORWARD) {
            switch ($direction) {
                case GridConstantsInterface::NORTH:
                    $x -= 1;
                    break;
                case GridConstantsInterface::WEST:
                    $y -= 1;
                    break;
                case GridConstantsInterface::SOUTH:
                    $x += 1;
                    break;
                case GridConstantsInterface::EAST:
                    $y += 1;
                    break;
            }
        }

        if ($command == GridConstantsInterface::COMMAND_MOVE_BACKWARD) {
            switch ($direction) {
                case GridConstantsInterface::NORTH:
                    $x += 1;
                    break;
                case GridConstantsInterface::WEST:
                    $y += 1;
                    break;
                case GridConstantsInterface::SOUTH:
                    $x -= 1;
                    break;
                case GridConstantsInterface::EAST:
                    $y -= 1;
                    break;
            }
        }

        $this->roverPosition = new RoverPosition(
            $x,
            $y,
            $direction
        );
    }

    /**
     * Rotates rover.
     *
     * @param $command
     *
     * @throws Exception\InvalidRoverPositionException
     */
    private function rotate($command)
    {
        $direction = $this->roverPosition->getDirection();

        if ($command == GridConstantsInterface::COMMAND_TURN_RIGHT) {
            $key = array_search($direction, GridConstantsInterface::DIRECTIONS);
            $direction = GridConstantsInterface::DIRECTIONS[($key + 1) % count(GridConstantsInterface::DIRECTIONS)];
        }

        if ($command == GridConstantsInterface::COMMAND_TURN_LEFT) {
            $reversedDirections = array_reverse(GridConstantsInterface::DIRECTIONS);
            $key = array_search($direction, $reversedDirections);
            $direction = $reversedDirections[($key + 1) % count($reversedDirections)];
        }

        $this->roverPosition = new RoverPosition(
            $this->roverPosition->getX(),
            $this->roverPosition->getY(),
            $direction
        );
    }
}
