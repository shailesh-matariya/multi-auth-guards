<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\App2\HomeController as App2HomeController;
use App\Http\Controllers\App3\HomeController as App3HomeController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// route for app1 -> app1 uses Laravel auth with the database
Route::group(['as' => 'app1.', 'prefix' => 'app1'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);

        Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

        Route::get('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.forgot');
        Route::post('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']);

        Route::get('reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset']);
    });

    Route::group(['middleware' => 'auth'], function () {
        //logout
        Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

        Route::get('home', [HomeController::class, 'index'])->name('home');
    });
});


// Routes for app2 -> uses API and App2User Model -> you can set authentication mechanism in the model method: authenticateFromApi()
Route::group(['as' => 'app2.', 'prefix' => 'app2'], function () {
    Route::group(['middleware' => 'guest:app2'], function () {
        Route::get('login', [\App\Http\Controllers\App2\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\App2\LoginController::class, 'login']);
    });

    Route::group(['middleware' => 'auth:app2'], function () {
        //logout
        Route::post('logout', [\App\Http\Controllers\App2\LoginController::class, 'logout'])->name('logout');

        Route::get('home', [App2HomeController::class, 'index'])->name('home');
    });
});



// Routes for app3 -> uses API and App3User Model -> you can set authentication mechanism in the model method: authenticateFromApi()
Route::group(['as' => 'app3.', 'prefix' => 'app3'], function () {
    Route::group(['middleware' => 'guest:app3'], function () {
        Route::get('login', [\App\Http\Controllers\App3\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\App3\LoginController::class, 'login']);
    });

    Route::group(['middleware' => 'auth:app3'], function () {
        //logout
        Route::post('logout', [\App\Http\Controllers\App3\LoginController::class, 'logout'])->name('logout');

        Route::get('home', [App3HomeController::class, 'index'])->name('home');
    });
});


