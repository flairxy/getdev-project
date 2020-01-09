<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentsCourse;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function getApprovedCourses()
    {
        $courses =  Course::whereStatus(1)->get();
        $updatedCourses = [];
        $sumStudent = 0;
        foreach ($courses as $course) {
            $course->makeHidden(['total_earned', 'status', 'id',]);
            $tutor = Tutor::whereId($course->tutor_id)->first();
            $user = User::whereId($tutor->user_id)->first();
            // $course_students = StudentsCourse::whereCourseId($course->id)->get();
            // $total_students = count($course_students);
            // $sumStudent += $total_students;
            if ($tutor->user_id == $user->id) {

                $course->tutor = $user->name;
                // $course->total_student = strval($sumStudent);
                $course->total_outlines = strval($course->total_outlines);
                array_push($updatedCourses, $course);
            }
        }
        return response($updatedCourses);
    }

    public function users()
    {
        $students = Student::all();
        $student_count = count($students);

        $tutors = Tutor::all();
        $tutor_count = count($tutors);

        return response([
            'total_students' => $student_count,
            'total_tutors' => $tutor_count
        ]);
    }

    public function courses()
    {
        $approved_courses = Course::whereStatus(1)->get();
        $total_approved = count($approved_courses);

        $pending_courses = Course::whereStatus(0)->get();
        $total_pending = count($pending_courses);

        return response([
            'pending_courses' => $pending_courses,
            'approved_courses' => $approved_courses,
            'total_approved' => $total_approved,
            'total_pending' => $total_pending,
        ]);
    }

    public function totalRevenue()
    {
        $tutor_balance = Tutor::sum('total_earned');
        return response([
            'revenues' => $tutor_balance
        ]);
    }
}
