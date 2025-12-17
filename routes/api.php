<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoverController;

Route::post('/rover/move', [RoverController::class, 'move']);