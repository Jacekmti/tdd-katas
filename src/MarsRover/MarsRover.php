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
    private $grid;
    private $roverPosition;


    public function __construct(array $grid, RoverPosition $roverPosition)
    {
        $this->grid = $grid;
        $this->roverPosition = $roverPosition;
    }

    /**
     * @param RoverCommand $command
     *
     * @throws Exception\InvalidRoverPositionException
     */
    public function navigate(RoverCommand $command)
    {
        $commandMoves = $command->getCommands();

        $x = $this->roverPosition->getX();
        $y = $this->roverPosition->getY();

        foreach ($commandMoves as $command) {
            if ($command == GridConstantsInterface::COMMAND_TURN_LEFT
                || $command == GridConstantsInterface::COMMAND_TURN_RIGHT) {
                $this->rotate($command);
            }

            $direction = $this->roverPosition->getDirection();



            if ($command == 'f') {
                switch ($direction) {
                    case 'n':
                        $x -= 1;
                        break;
                    case 'w':
                        $y -= 1;
                        break;
                    case 's':
                        $x += 1;
                        break;
                    case 'e':
                        $y += 1;
                        break;
                }
            }

            if ($command == 'b') {
                switch ($direction) {
                    case 'n':
                        $x += 1;
                        break;
                    case 'w':
                        $y += 1;
                        break;
                    case 's':
                        $x -= 1;
                        break;
                    case 'e':
                        $y -= 1;
                        break;
                }
            }

            $this->roverPosition = new RoverPosition($x, $y, $direction);
        }
    }

    public function getPosition()
    {
        return $this->roverPosition;
    }

    /**
     * @param $command
     *
     * @throws Exception\InvalidRoverPositionException
     */
    private function rotate($command)
    {
        $direction = $this->roverPosition->getDirection();

        if ($command == GridConstantsInterface::COMMAND_TURN_LEFT) {
            switch ($direction) {
                case GridConstantsInterface::NORTH:
                    $direction = GridConstantsInterface::WEST;
                    break;
                case GridConstantsInterface::WEST:
                    $direction = GridConstantsInterface::SOUTH;
                    break;
                case GridConstantsInterface::SOUTH:
                    $direction = GridConstantsInterface::EAST;
                    break;
                case GridConstantsInterface::EAST:
                    $direction = GridConstantsInterface::NORTH;
                    break;
            }
        }

        if ($command == GridConstantsInterface::COMMAND_TURN_RIGHT) {
            switch ($direction) {
                case GridConstantsInterface::NORTH:
                    $direction = GridConstantsInterface::EAST;
                    break;
                case GridConstantsInterface::WEST:
                    $direction = GridConstantsInterface::NORTH;
                    break;
                case GridConstantsInterface::SOUTH:
                    $direction = GridConstantsInterface::WEST;
                    break;
                case GridConstantsInterface::EAST:
                    $direction = GridConstantsInterface::SOUTH;
                    break;
            }
        }

        $this->roverPosition = new RoverPosition(
            $this->roverPosition->getX(),
            $this->roverPosition->getY(),
            $direction
        );
    }
}
