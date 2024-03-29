<?php

declare(strict_types=1);

namespace App\MarsRover;

use App\MarsRover\Exception\InvalidRoverCommandException;

/**
 * Class RoverCommandList
 *
 * @package App\MarsRover
 */
class RoverCommandList
{
    /**
     * @var array
     */
    const VALID_COMMANDS = [
        GridConstantsInterface::COMMAND_TURN_LEFT,
        GridConstantsInterface::COMMAND_TURN_RIGHT,
        GridConstantsInterface::COMMAND_MOVE_FORWARD,
        GridConstantsInterface::COMMAND_MOVE_BACKWARD
    ];

    /**
     * @var array
     */
    private $commands;

    /**
     * RoverCommandList constructor.
     *
     * @param array $commands
     *
     * @throws InvalidRoverCommandException
     */
    public function __construct(array $commands)
    {
        $this->commands = $commands;

        $this->validate();
    }

    /**
     * Validate command.
     *
     * @throws InvalidRoverCommandException
     */
    private function validate()
    {
        foreach ($this->commands as $command) {
            if (!in_array($command, self::VALID_COMMANDS)) {
                throw new InvalidRoverCommandException('Invalid command.');
            }
        }
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
