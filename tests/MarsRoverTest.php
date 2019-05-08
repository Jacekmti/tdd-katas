<?php

declare(strict_types = 1);

namespace Test;

use App\MarsRover\Exception\InvalidRoverCommandException;
use App\MarsRover\Exception\InvalidRoverPositionException;
use App\MarsRover\RoverCommand;
use App\MarsRover\RoverPosition;
use PHPUnit\Framework\TestCase;

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

    public function positionProvider()
    {
        return [
          [0, 0, 'e', true],
          [-1, -1, "Ó", false]
        ];
    }

    public function commandProvider()
    {
        return [
          [['f','l','r','b'], true],
          [['3', 'T'], false]
        ];
    }

    /**
     * @dataProvider positionProvider
     *
     * @param $x
     * @param $y
     * @param $direction
     * @param $shouldPass
     *
     * @throws InvalidRoverPositionException
     */
    public function testRoverPosition($x, $y, $direction, $shouldPass)
    {
        if ($shouldPass) {
            $roverPosition = new RoverPosition($x, $y, $direction);
            $this->assertTrue($roverPosition instanceof RoverPosition);
        } else {
            $this->expectException(InvalidRoverPositionException::class);
            new RoverPosition($x, $y, $direction);
        }
    }
    //TODO: typeError

    /**
     * @dataProvider commandProvider
     *
     * @param $command
     * @param $shouldPass
     *
     * @throws InvalidRoverCommandException
     */
    public function testRoverCommand($command, $shouldPass)
    {
        if ($shouldPass) {
            $command = new RoverCommand($command);
            $this->assertTrue($command instanceof RoverCommand);
        } else {
            $this->expectException(InvalidRoverCommandException::class);
            new RoverCommand($command);
        }
    }

    //TODO: typeError
}
