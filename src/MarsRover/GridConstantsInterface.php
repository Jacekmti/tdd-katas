<?php

namespace App\MarsRover;

interface GridConstantsInterface
{
    const COMMAND_TURN_LEFT = 'l';
    const COMMAND_TURN_RIGHT = 'r';
    const COMMAND_MOVE_FORWARD = 'f';
    const COMMAND_MOVE_BACKWARD = 'b';

    const NORTH = 'n';
    const EAST = 'e';
    const SOUTH = 's';
    const WEST = 'w';

    const DIRECTIONS = [
        self::NORTH,
        self::EAST,
        self::SOUTH,
        self::WEST
    ];

    const GRID_OBSTACLE = 1;
}
