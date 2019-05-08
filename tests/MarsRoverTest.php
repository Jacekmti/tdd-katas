<?php

declare(strict_types = 1);

namespace Test;

use App\MarsRover\InvalidRoverPositionException;
use App\MarsRover\MarsRover;
use App\MarsRover\RoverPosition;
use DomainException;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class MarsRoverTest
 * @package App\MarsRover\test
 */
class MarsRoverTest extends TestCase
{
    private $grid = [
        [0, 0, 1, 0],
        [0, 0, 0, 1],
        [0, 1, 0, 0],
        [0, 0, 0, 0],
    ];

    public function roverProvider()
    {
        return [
          [[0,0], 'e', ['l','b'], false],
          [[-1,-1], 'Ó', ['l','b'], true]
        ];
    }

    /**
     * @dataProvider roverProvider
     * @param $position
     * @param $direction
     * @param $command
     * @param $expectException
     * @throws InvalidRoverPositionException
     */
    public function testRoverPosition($position, $direction, $command, $expectException)
    {
        if (!$expectException) {
            $roverPosition = new RoverPosition($position, $direction);
            $this->assertTrue($roverPosition instanceof RoverPosition);
        } else {
            $this->expectException(InvalidRoverPositionException::class);
            new RoverPosition($position, $direction);
        }
    }
}
