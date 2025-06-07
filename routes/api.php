<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('users', 'Admin\User\UserController', ['parameters' => ['user' => 'user'], 'as' => 'admin.rental_united.handler_urls']);
