<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentsCourse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getStudents()
    {
        $users = User::whereRole(0)->get();
        $updatedUser = [];
        foreach ($users as $user) {
            $user_courses = StudentsCourse::whereUserId($user->id)->pluck('course_id');
            $courses = Course::whereIn('id', $user_courses)->get();
            $total_course = count($user_courses);
            $user->courses = $courses;
            $date = $user->created_at;
            $user->joined = $date->toDayDateTimeString();
            $user->total_course = $total_course;
            array_push($updatedUser, $user);
        }
        return [
            'students' => $updatedUser
        ];
    }
}
