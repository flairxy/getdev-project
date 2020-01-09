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

    // General Course controller
    Route::get('courses/other-courses', ['as' => '.getApprovedCourses', 'uses' => 'CoursesController@getApprovedCourses']);
    Route::post('notify', ['as' => '.notify', 'uses' => 'NotificationsController@notify']);



    // admin general routes
    Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function () {
        Route::get('revenues', ['as' => '.revenues', 'uses' => 'CoursesController@totalRevenue']);
        Route::get('mix-courses', ['as' => '.mix-courses', 'uses' => 'CoursesController@courses']);
        Route::get('mix-users', ['as' => '.mix-users', 'uses' => 'CoursesController@users']);
        Route::post('notify', ['as' => '.adminNotify', 'uses' => 'MessageController@notify']);

    });

    // Admin Routes
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:api'], function () {

        Route::post('admin/notify', ['as' => '.adminNotify', 'uses' => 'MessagesController@notify']);
        Route::get('admin/{admin_id}/messages/sent', ['as' => '.getAdminSentMessages', 'uses' => 'MessagesController@getSentMessages']);
        // categories route
        Route::get('categories', ['as' => '.categories', 'uses' => 'CourseController@categories']);
        // returns all categories
        Route::get('chapters', ['as' => '.chapters', 'uses' => 'CourseController@chapters']);

        Route::group(['as' => '.students', 'prefix' => 'admin/students'], function () {
            Route::get('/', ['as' => '.getStudents', 'uses' => 'StudentController@getStudents']);
        });

        Route::group(['as' => '.tutors', 'prefix' => 'admin/tutors'], function () {
            Route::get('/', ['as' => '.getTutors', 'uses' => 'TutorController@getTutors']);
        });

        //updateCourse
        Route::post('course/update', ['as' => '.updateCourse', 'uses' => 'CourseController@update']);
        Route::post('course/{id}/delete', ['as' => '.deleteCourse', 'uses' => 'CourseController@delete']);
    });

    // Tutor Routes
    Route::group(['namespace' => 'Tutor', 'middleware' => 'auth:api'], function () {
        Route::group(['as' => '.tutor', 'prefix' => 'tutor'], function () {
            // get courses by tutor
            Route::get('{user_id}/summary', ['as' => '.accountSummary', 'uses' => 'CourseController@getAccountSummary']);
            Route::get('{tutor_id}/courses', ['as' => '.getCoursesByTutor', 'uses' => 'CourseController@getCoursesByTutor']);
            Route::get('{tutor_id}/messages', ['as' => '.getTutorMessages', 'uses' => 'MessagesController@getTutorMessages']);
            Route::get('{tutor_id}/messages/sent', ['as' => '.getTutorSentMessages', 'uses' => 'MessagesController@getSentMessages']);
            Route::post('message/update', ['as' => '.updateMessage', 'uses' => 'MessagesController@updateMessage']);
            Route::post('messages', ['as' => '.updateMessages', 'uses' => 'MessagesController@updateMessages']);
            Route::post('messages/delete', ['as' => '.deleteMessages', 'uses' => 'MessagesController@deleteMessages']);

            Route::group(['as' => '.course', 'prefix' => 'course'], function () {

                // get the outlines with specific course id
                Route::get('{id}', ['as' => '.courseOutlines', 'uses' => 'CourseController@getCourseOutlines']);
                Route::get('{id}/edit', ['as' => '.getCourseById', 'uses' => 'CourseController@getCourseById']);
                Route::post('update', ['as' => '.updateCourse', 'uses' => 'CourseController@update']);
                Route::post('{id}/delete', ['as' => '.deleteCourse', 'uses' => 'CourseController@deleteCourse']);
                Route::post('outline/{id}/delete', ['as' => '.deleteOutline', 'uses' => 'CourseController@deleteOutline']);

                // get the outlines with specific course id and chapter
                Route::get('{course_id}/{chapter}', ['as' => '.courseChapterOutlines', 'uses' => 'CourseController@getOutlinesByChapter']);

                // create a course
                Route::post('create', ['as' => '.create', 'uses' => 'CourseController@create']);

                // upload videos
                Route::post('video-uploads', ['as' => '.videoUpload', 'uses' => 'CourseController@courseVideos']);

                //get videos by outline
                Route::post('videos', ['as' => '.tutorVideos', 'uses' => 'CourseController@getVideosByOutlines']);
            });

            Route::group(['as' => '.profile',  'prefix' => 'profile'], function () {
                Route::get('{id}', ['as' => '.getTutor', 'uses' => 'TutorProfileController@getProfile']);
                Route::post('{id}/update', ['as' => '.update', 'uses' => 'TutorProfileController@update']);
                Route::post('update-password', ['uses' => 'TutorProfileController@updatePassword']);
                Route::post('verify-email', ['uses' => 'TutorProfileController@sendEmailVerification']);
            });

            Route::post('funds/withdraw', ['as' => '.withdraw', 'uses' => 'WithdrawalController@withdraw']);
            Route::get('{id}/withdrawals', ['as' => '.withdrawHistory', 'uses' => 'WithdrawalController@withdrawHistory']);
        });
    });

    //Student Routes
    Route::group(['namespace' => 'Student', 'prefix' => 'student', 'middleware' => 'auth:api'], function () {
        Route::get('{id}/courses', ['as' => '.studentCourses', 'uses' => 'CourseController@getCourses']);
        Route::get('course/{id}', ['as' => '.studentCourse', 'uses' => 'CourseController@getCourse']);
        Route::get('course/{course}/{user}/review', ['as' => '.getReview', 'uses' => 'CourseController@getReview']);
        Route::get('course/{id}/reviews', ['as' => '.courseReviews', 'uses' => 'CourseController@getCourseReviews']);
        Route::post('course/review', ['as' => '.createReview', 'uses' => 'CourseController@createReview']);
        Route::post('course/buy', ['as' => '.buy', 'uses' => 'CourseController@buyCourse']);
        Route::post('course/enroll', ['as' => '.pay', 'uses' => 'CourseController@enroll']);
        Route::post('course/subscribe', ['as' => '.subscribe', 'uses' => 'CourseController@subscribe']);
        Route::get('subscribers/{id}', ['as' => '.subscribers', 'uses' => 'CourseController@isSubscribed']);

        Route::group(['as' => '.profile',  'prefix' => 'profile'], function () {

            Route::post('{id}/update', ['as' => '.update', 'uses' => 'StudentProfileController@update']);
            Route::post('update-password', ['uses' => 'StudentProfileController@updatePassword']);
            Route::post('{id}/notifications', ['uses' => 'StudentProfileController@getNotifications']);
            Route::post('verify-email', ['uses' => 'StudentProfileController@sendEmailVerification']);
        });
    });
});
