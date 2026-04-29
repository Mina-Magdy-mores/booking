<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Booking\BookingController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Event\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/profile', 'profile');
    });
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
    Route::get('/category/{category}', 'show');
    Route::middleware(['auth:sanctum', 'checkRole:admin'])->group(function () {
        Route::post('/category', 'store');
        Route::put('/category/{category}', 'update');
        Route::delete('/category/{category}', 'destroy');
    });
});


Route::controller(EventController::class)->group(function () {
    Route::get('/event', 'index');
    Route::get('/event/{event}', 'show');
    Route::post('/event', 'store');
    Route::put('/event/{event}', 'update');
    Route::delete('/event/{event}', 'destroy');
});

Route::controller(BookingController::class)->group(function () {
    Route::get('/booking', 'index');
    Route::get('/booking/{booking}', 'show');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/booking', 'store');
        Route::middleware(['checkRole:admin'])->group(function () {
            Route::put('/booking/{booking}', 'update');
            Route::delete('/booking/{booking}', 'destroy');
        });
    });
});
