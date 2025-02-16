<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\PlantsPayController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceRecordController;
use App\Http\Controllers\StatementController;
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
    // 'reservations' => ReservationController::class,
    'typesservice' => TypeServiceController::class,
    'statements' => StatementController::class,
    'service_records' => ServiceRecordController::class,
    'plant_pay' => PlantsPayController::class,
    'pays' => PayController::class
]);
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
Route::put('/reservations/{id}', [ReservationController::class, 'update']);
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::get('/files/{file}/download', [App\Http\Controllers\FileController::class, 'download'])->name('files.download');

Route::get('statements/{id}/pdf', [StatementController::class, 'GenerarPDF'])->name('statement.pdf');
