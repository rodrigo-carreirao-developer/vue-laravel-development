<?php

use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', 'Admin\User\UserController', ['parameters' => ['user' => 'user'], 'as' => 'admin.users.resource']);
Route::post('/users/validate', [UserController::class, 'validate'])->name('admin.users.validate');