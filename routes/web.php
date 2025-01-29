<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
     return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resources([
    'users' => UserController::class,
    'roles' => RoleController::class,
    'clients' => ClientController::class,
    'workers' => WorkerController::class,
    'files' => FileController::class,
    'reservations' => ReservationController::class,
    'typesservice' => TypeServiceController::class,
]);
Route::get('/files/{file}/download', [App\Http\Controllers\FileController::class, 'download'])->name('files.download');

Route::get('/reservations/events', [ReservationController::class, 'getEvents'])->name('reservations.events');

