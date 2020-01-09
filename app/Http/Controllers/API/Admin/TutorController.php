<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;

class TutorController extends Controller
{

    public function getTutors()
    {
        $users = User::whereRole(1)->get();
        $updatedUser = [];
        foreach ($users as $user) {
            $tutor = Tutor::whereUserId($user->id)->first();
            $admin_courses = Course::whereTutorId($tutor->id)->get();
            // $courses = Course::whereIn('id', $user_courses)->get();
            $total_course = $tutor->courses;
            $user->courses = $admin_courses;
            $user->balance = $tutor->balance;
            $user->total_earned = $tutor->total_earned;
            $user->joined = $user->created_at->toDayDateTimeString();
            $user->total_course = $total_course;
            array_push($updatedUser, $user);
        }
        return [
            'tutors' => $updatedUser
        ];
    }
}
