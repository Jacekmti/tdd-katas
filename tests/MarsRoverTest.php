<?php

declare(strict_types=1);

namespace Test;

use App\MarsRover\Exception\InvalidRoverCommandException;
use App\MarsRover\Exception\InvalidRoverPositionException;
use App\MarsRover\MarsRover;
use App\MarsRover\RoverCommandList;
use App\MarsRover\RoverPosition;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class MarsRoverTest
 *
 * @package App\MarsRover\test
 */
class MarsRoverTest extends TestCase
{
    /**
     * @var array
     */
    private $grid;

    public function positionProvider()
    {
        return [
            [0, 0, 'e'],
            [-1, -1, "Ó", InvalidRoverPositionException::class],
            [-1, "-1", "Ó", TypeError::class]
        ];
    }

    public function commandProvider()
    {
        return [
            [['f', 'l', 'r', 'b']],
            [['3', 'T'], InvalidRoverCommandException::class],
            ['f', TypeError::class]
        ];
    }

    public function basicNavigateProvider()
    {
        return [
            [0, 0, 'n', ['r', 'f', 'r', 'f'], 1, 1, 's'],
            [0, 0, 'n', ['l', 'l'], 0, 0, 's'],
            [1, 0, 'w', ['f', 'b', 'l', 'r'], 1, 0, 'w']
        ];
    }

    public function collisionNavigateProvider()
    {
        return [
            [0, 0, 'n', ['r', 'f'], 0, 1, 'e', false],
            [0, 0, 'n', ['r', 'f', 'f'], 0, 1, 'e', true],
            [0, 0, 'n', ['r', 'f', 'f', 'f', 'r', 'f'], 0, 1, 'e', true]
        ];
    }

    public function wrapNavigateProvider()
    {
        return [
            [0, 0, 'n', ['f'], 3, 0, 'n'],
            [0, 0, 'n', ['r', 'b'], 0, 3, 'e'],
            [0, 0, 'n', ['r', 'r', 'f', 'f', 'r', 'f'], 2, 3, 'w'],
            [0, 0, 'n', ['r', 'r', 'f', 'f', 'f', 'f', 'f'], 1, 0, 's'],
        ];
    }

    protected function setUp()
    {
        $this->grid = [
            [0, 0, 1, 0],
            [0, 0, 0, 1],
            [0, 1, 0, 0],
            [0, 0, 0, 0],
        ];
    }

    /**
     * @dataProvider positionProvider
     *
     * @param $x
     * @param $y
     * @param $direction
     * @param $exception
     *
     * @throws InvalidRoverPositionException
     */
    public function testRoverPosition($x, $y, $direction, $exception = '')
    {
        if ($exception) {
            $this->expectException($exception);
            new RoverPosition($x, $y, $direction);
        } else {
            $roverPosition = new RoverPosition($x, $y, $direction);
            $this->assertTrue($roverPosition instanceof RoverPosition);
        }
    }

    /**
     * @dataProvider commandProvider
     *
     * @param $command
     * @param $exception
     *
     * @throws InvalidRoverCommandException
     */
    public function testRoverCommand($command, $exception = '')
    {
        if ($exception) {
            $this->expectException($exception);
            new RoverCommandList($command);
        } else {
            $command = new RoverCommandList($command);
            $this->assertTrue($command instanceof RoverCommandList);
        }
    }

    /**
     * @dataProvider basicNavigateProvider
     * @dataProvider wrapNavigateProvider
     *
     * @param $startX
     * @param $startY
     * @param $startDirection
     * @param $command
     * @param $targetX
     * @param $targetY
     * @param $targetDirection
     *
     * @throws InvalidRoverCommandException
     * @throws InvalidRoverPositionException
     */
    public function testRoverBasicNavigate(
        $startX,
        $startY,
        $startDirection,
        $command,
        $targetX,
        $targetY,
        $targetDirection
    ) {
        $rover = new MarsRover($this->grid, new RoverPosition($startX, $startY, $startDirection));
        $rover->navigate(new RoverCommandList($command));
        $targetPosition = new RoverPosition($targetX, $targetY, $targetDirection);

        $this->assertEquals($rover->getPosition(), $targetPosition);
    }

    /**
     * @dataProvider collisionNavigateProvider
     *
     * @param $startX
     * @param $startY
     * @param $startDirection
     * @param $command
     * @param $targetX
     * @param $targetY
     * @param $targetDirection
     *
     * @param $collisionExpected
     *
     * @throws InvalidRoverCommandException
     * @throws InvalidRoverPositionException
     */
    public function testRoverCollision(
        $startX,
        $startY,
        $startDirection,
        $command,
        $targetX,
        $targetY,
        $targetDirection,
        $collisionExpected
    ) {
        $rover = new MarsRover($this->grid, new RoverPosition($startX, $startY, $startDirection));
        $rover->navigate(new RoverCommandList($command));
        $targetPosition = new RoverPosition($targetX, $targetY, $targetDirection);
        $this->assertEquals($rover->getPosition(), $targetPosition);

        if ($collisionExpected) {
            $this->assertEquals('Collision detected!', $rover->getStatus());
        }
    }
}
