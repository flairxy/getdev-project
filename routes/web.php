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

use App\Models\Plan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/subscribe', function () {
    $plans = Plan::all();
    return view('checkoutPage', ['plans' => $plans]);
})->middleware('auth');
Route::post('subscribe', 'API\Student\CourseController@subscribe')->name('subscribe');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tutor/register', 'UserController@tutor')->name('tutorSignup');
Route::post('register-tutor', 'UserController@registerTutor')->name('tutorRegistration');

// 'middleware' => ['auth', 'admin', 'ban']
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('_dmgt/{any}', 'ManagementController@index')->where('any', '.*');
});

Route::group(['middleware' => ['auth', 'student']], function () {
    Route::get('_ds/{any}', 'StudentController@index')->where('any', '.*');
});

Route::group(['middleware' => ['auth', 'tutor']], function () {
    Route::get('_dt/{any}', 'TutorController@index')->where('any', '.*');
});
