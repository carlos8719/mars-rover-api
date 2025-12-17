<?php

namespace App\Domain\MarsRover;

class Rover
{
    private bool $obstacleDetected = false;

    public function __construct(
        private Position $position,
        private string $direction,
        private Grid $grid
    ) {}

    public function execute(string $commands): void
    {
        foreach (str_split(strtoupper($commands)) as $command) {
            if ($this->obstacleDetected) {
                break;
            }

            match ($command) {
                'F' => $this->moveForward(),
                'L' => $this->direction = Direction::turnLeft($this->direction),
                'R' => $this->direction = Direction::turnRight($this->direction),
                default => null,
            };
        }
    }

    private function moveForward(): void
    {
        $nextX = $this->position->x;
        $nextY = $this->position->y;

        match ($this->direction) {
            Direction::NORTH => $nextY++,
            Direction::SOUTH => $nextY--,
            Direction::EAST  => $nextX++,
            Direction::WEST  => $nextX--,
        };

        if (
            !$this->grid->isInside($nextX, $nextY) ||
            $this->grid->hasObstacle($nextX, $nextY)
        ) {
            $this->obstacleDetected = true;
            return;
        }

        $this->position->x = $nextX;
        $this->position->y = $nextY;
    }

    public function report(): array
    {
        return [
            'x' => $this->position->x,
            'y' => $this->position->y,
            'direction' => $this->direction,
            'obstacleDetected' => $this->obstacleDetected,
        ];
    }
}