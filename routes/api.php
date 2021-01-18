<?php

use App\Http\Controllers\Auth\ApiTokenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/oauth/token', [ApiTokenController::class, 'issueToken']);
Route::post('/login', [LoginController::class, 'login'])->name('api.login');



Route::group(['middleware' => 'auth:api'], function (){
    Route::post('/users/add', [UsersController::class, 'store']);
    Route::get('/users', [UsersController::class, 'index']);
    Route::post('/tasks/add', [TasksController::class, 'store']);
    Route::get('/tasks', [TasksController::class, 'index']);

    Route::post('tasks/{task_id}/assign', [TasksController::class, 'assignTaskToUsers']);
});
