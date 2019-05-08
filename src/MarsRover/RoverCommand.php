<?php

namespace App\MarsRover;

use App\MarsRover\Exception\InvalidRoverCommandException;

/**
 * Class RoverCommand
 *
 * @package App\MarsRover
 */
class RoverCommand
{
    /**
     * @var array
     */
    const VALID_COMMANDS = [
        'l', 'r', 'f', 'b'
    ];

    /**
     * @var array
     */
    private $commands;

    /**
     * RoverCommand constructor.
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
}