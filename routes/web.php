<?php

use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
