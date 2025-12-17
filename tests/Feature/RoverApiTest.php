<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoverApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_rover_stops_when_obstacle_is_detected()
    {
        $response = $this->postJson('/api/rover/move', [
            'position' => ['x' => 0, 'y' => 0],
            'direction' => 'N',
            'commands' => 'FFFF',
            'obstacles' => [
                ['x' => 0, 'y' => 2]
            ]
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'x' => 0,
                'y' => 1,
                'obstacleDetected' => true
            ]);
    }
}