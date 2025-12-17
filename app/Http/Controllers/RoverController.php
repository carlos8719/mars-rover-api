<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\MarsRover\{
    Rover,
    Grid,
    Position,
    Direction
};

class RoverController extends Controller
{
    public function move(Request $request)
    {
        $validated = $request->validate([
            'position.x' => 'required|integer|min:0|max:199',
            'position.y' => 'required|integer|min:0|max:199',
            'direction'  => 'required|in:N,E,S,W',
            'commands'   => 'required|string',
            'obstacles'  => 'array',
            'obstacles.*.x' => 'required|integer|min:0|max:199',
            'obstacles.*.y' => 'required|integer|min:0|max:199',
        ]);

        $obstacles = collect($validated['obstacles'] ?? [])
            ->map(fn ($o) => [$o['x'], $o['y']])
            ->toArray();

        $grid = new Grid(200, 200, $obstacles);

        $rover = new Rover(
            new Position(
                $validated['position']['x'],
                $validated['position']['y']
            ),
            $validated['direction'],
            $grid
        );

        $rover->execute($validated['commands']);

        return response()->json($rover->report());
    }
}