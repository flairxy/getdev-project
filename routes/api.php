<?php

use App\Http\Controllers\API\CoursesController;
use Illuminate\Http\Request;

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


Route::group(['as' => 'api.', 'namespace' => 'API'], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Admin Routes
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:api', 'prefix' => 'admin'], function () {
        Route::resources([
            'staffs' => 'StaffController',
            'students' => 'StudentController',
            'roles' => 'RoleController',
            'classes' => 'AClassesController',
        ]);

        Route::post('students/ban', ['uses' => 'StudentController@banStudent']);
        Route::post('staffs/ban', ['uses' => 'StaffController@banStaff']);
        Route::post('students/activate', ['uses' => 'StudentController@activateStudent']);
        Route::post('staffs/activate', ['uses' => 'StaffController@activateStaff']);
        Route::post('student/class', ['uses' => 'StudentController@removeFromClass']);
        Route::post('staff/class', ['uses' => 'StaffController@removeFromClass']);
        Route::get('student/class/{id}', ['uses' => 'StudentController@getStudentClasses']);
        Route::get('staff/class/{id}', ['uses' => 'StaffController@getStaffClasses']);
    });

    // Staff Routes
    Route::group(['namespace' => 'Staff', 'prefix' => 'staff', 'middleware' => 'auth:api'], function () {

        Route::resources([
            'staffs' => 'StaffController',
        ]);
        Route::get('staffs/class/{id}', ['uses' => 'StaffController@getStaffClasses']);
        Route::get('staffs/{id}/students', ['uses' => 'StaffController@getTeacherStudents']);
        Route::get('{id}/role', ['uses' => 'StaffController@getStaffRole']);
        Route::post('staffs/enroll', ['uses' => 'StaffController@enrollInClass']);
    });

    //Student Routes
    Route::group(['namespace' => 'Student', 'prefix' => 'student', 'middleware' => 'auth:api'], function () {
        Route::resources([
            'students' => 'StudentController',
        ]);
        Route::get('students/{id}/class', ['uses' => 'StudentController@getClassByLevel']);
        Route::post('students/enroll', ['uses' => 'StudentController@enrollInClass']);
        Route::get('students/class/{id}', ['uses' => 'StudentController@getStudentClasses']);
    });
});
