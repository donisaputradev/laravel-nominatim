<?php

use App\Http\Controllers\Api\ReverseController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/search', [SearchController::class, 'index']);
Route::get('/reverse', [ReverseController::class, 'index']);
