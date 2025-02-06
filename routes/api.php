<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group([

    'middleware' => 'api',

], function ($router) {
    //user
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('jwt.verify')->group(function () {
    //rutas de tareas
    Route::get('tasks', [TaskController::class, 'index'])->name('task.index');
    Route::post('tasks', [TaskController::class, 'store'])->name('task.store');
    Route::put('tasks/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('tasks/{id}', [TaskController::class, 'delete'])->name('task.delete');
});



