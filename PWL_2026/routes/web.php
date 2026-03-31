<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PageController;
use Cron\DayOfMonthField;
use Illuminate\Support\Facades\Route;

Route::get('/hello', [WelcomeController::class, 'hello']);

Route::get('/', [HomeController::class, 'index']);

// Route::get('/', [PageController::class,'index']);

Route::get('/about', [AboutController::class,'about']);

Route::get('/articles/{id}', [ArticleController::class,'articles']);

// Route::get('/about', function () {
//     return ('NIM: 244107020061 <br> Nama: Muhammad Daniel Assaqovi');
// });

// Route::get('/user/{name?}', function ($name='john') {
//     return 'Muhammad Daniel Assaqovi '.$name;
// });

// Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
//     return 'post ke-'.$postId.' komentar ke-'.$commentId;
// });

Route::resource('photos', PhotoController::class)-> only([
    'index', 'show'
]);

// route::resource('pages', PageController::class)-> except([
//     'create', 'store', 'update', 'destroy'
// ]);

route::get('/greeting', [WelcomeController::class, 'greeting']);