<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'home']);

Route::view('/template', 'template');

Route::controller(UserController::class)->group(function() {
    Route::get('/login', 'login')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/login', 'doLogin')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/logout', 'doLogout')->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class]);
});

Route::controller(TodoListController::class)->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class])->group(function () {
    Route::get('/todolist', 'todoList');
    Route::post('/todolist', 'addTodo');
    Route::post('/todolist/{id}/delete', 'removeTodo');
});
