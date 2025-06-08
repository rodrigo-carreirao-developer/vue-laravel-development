<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user', function () {
    return view('vue/user');
});

Route::get('/user/listing', function () {
    return view('vue/welcome');
});

Route::get('/user/registry', function () {
    return view('vue/registry');
});

Route::get('/user/preview', function () {
    return view('vue/preview');
});
