<?php

namespace App\Domain\MarsRover;

class Grid
{
    public function __construct(
        private int $width = 200,
        private int $height = 200,
        private array $obstacles = []
    ) {}

    public function hasObstacle(int $x, int $y): bool
    {
        return in_array([$x, $y], $this->obstacles, true);
    }

    public function isInside(int $x, int $y): bool
    {
        return $x >= 0 && $x < $this->width && $y >= 0 && $y < $this->height;
    }
}