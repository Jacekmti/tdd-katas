<?php

declare(strict_types=1);

namespace App\MarsRover;

use App\MarsRover\Exception\InvalidRoverPositionException;

/**
 * Class MarsRover
 *
 * @package App\MarsRover\src
 */
class MarsRover
{
    /**
     * @var string
     */
    const ROVER_READY = 'Rover ready!';

    /**
     * @var string
     */
    const ROVER_COLLISION_DETECTED = 'Collision detected!';

    /**
     * @var array
     */
    private $grid;

    /**
     * @var RoverPosition
     */
    private $roverPosition;

    /**
     * @var string
     */
    private $status;

    /**
     * MarsRover constructor.
     *
     * @param array         $grid
     * @param RoverPosition $roverPosition
     *
     * @throws InvalidRoverPositionException
     */
    public function __construct(array $grid, RoverPosition $roverPosition)
    {
        $this->grid = $grid;
        $this->roverPosition = $roverPosition;
        $this->status = self::ROVER_READY;

        $this->validate();
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
            if ($this->status === self::ROVER_COLLISION_DETECTED) {
                break;
            }
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
    public function getPosition(): RoverPosition
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

        $gridWidth = count($this->grid) - 1;
        $gridHeight = count($this->grid[0]) - 1;

        if ($command == GridConstantsInterface::COMMAND_MOVE_FORWARD) {
            switch ($direction) {
                case GridConstantsInterface::NORTH:
                    $x--;
                    break;
                case GridConstantsInterface::WEST:
                    $y--;
                    break;
                case GridConstantsInterface::SOUTH:
                    $x++;
                    break;
                case GridConstantsInterface::EAST:
                    $y++;
                    break;
            }
        }

        if ($command == GridConstantsInterface::COMMAND_MOVE_BACKWARD) {
            switch ($direction) {
                case GridConstantsInterface::NORTH:
                    $x++;
                    break;
                case GridConstantsInterface::WEST:
                    $y++;
                    break;
                case GridConstantsInterface::SOUTH:
                    $x--;
                    break;
                case GridConstantsInterface::EAST:
                    $y--;
                    break;
            }
        }

        if ($this->grid[$x][$y] == GridConstantsInterface::GRID_OBSTACLE) {
            $this->status = self::ROVER_COLLISION_DETECTED;
            return;
        }

        $this->roverPosition = new RoverPosition(
            $this->correctPosition($x, $gridHeight),
            $this->correctPosition($y, $gridWidth),
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

    /**
     * Corrects coordinates, wraps them around grid (when out of bounds).
     *
     * @param int $value
     * @param int $max
     *
     * @return int
     */
    private function correctPosition(int $value, int $max): int
    {
        $value = $value > $max ? 0 : $value;
        $value = $value < 0 ? $max : $value;
        return $value;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Validate rover position on grid.
     *
     * @throws InvalidRoverPositionException
     */
    private function validate()
    {
        $x = $this->roverPosition->getX();
        $y = $this->roverPosition->getY();

        if ($x < 0 || $x > count($this->grid) -1) {
            throw new InvalidRoverPositionException('Invalid rover grid position.');
        }

        if ($y < 0 || $y > count($this->grid[0]) -1) {
            throw new InvalidRoverPositionException('Invalid rover grid position.');
        }

        if ($this->grid[$x][$y] === GridConstantsInterface::GRID_OBSTACLE) {
            throw new InvalidRoverPositionException('Rover can\'t land on obstacle.');
        }
    }
}
