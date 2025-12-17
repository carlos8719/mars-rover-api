<?php

namespace App\Domain\MarsRover;

class Direction
{
    public const NORTH = 'N';
    public const EAST  = 'E';
    public const SOUTH = 'S';
    public const WEST  = 'W';

    private static array $leftMap = [
        self::NORTH => self::WEST,
        self::WEST  => self::SOUTH,
        self::SOUTH => self::EAST,
        self::EAST  => self::NORTH,
    ];

    private static array $rightMap = [
        self::NORTH => self::EAST,
        self::EAST  => self::SOUTH,
        self::SOUTH => self::WEST,
        self::WEST  => self::NORTH,
    ];

    public static function turnLeft(string $direction): string
    {
        return self::$leftMap[$direction];
    }

    public static function turnRight(string $direction): string
    {
        return self::$rightMap[$direction];
    }
}