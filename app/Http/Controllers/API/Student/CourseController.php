<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Outline;
use App\Models\Plan;
use App\Models\Quiz;
use App\Models\Review;
use App\Models\Student;
use App\Models\StudentsCourse;
use App\Models\Subscription;
use App\Models\Tutor;
use App\Models\User;
use App\Models\UsersQuiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class CourseController extends Controller
{
    public function getCourses($id)
    {
        $student_courses = StudentsCourse::whereUserId($id)->pluck('course_id');
        $courses =  Course::whereIn('id', $student_courses)->get();
        $updatedCourses = [];
        $sumStudent = 0;
        foreach ($courses as $course) {
            $course->makeHidden(['total_earned', 'status']);
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
        return response([
            'courses' => $updatedCourses
        ]);
    }

    public function getCourse($id)
    {

        $course = Course::whereId($id)->first() ?? Course::whereSlug($id)->first();
        $tutor = Tutor::whereId($course->tutor_id)->first();
        $user = User::whereId($tutor->user_id)->first();
        $category = Category::whereId($course->category_id)->first();
        $course_students = StudentsCourse::whereCourseId($id)->get();
        $total_students = count($course_students);
        $sumStudent = 0;
        $course_students = StudentsCourse::whereCourseId($course->id)->get();
        // $total_students = count($course_students);
        $sumStudent += $total_students;
        $updatedOutlines = [];
        if ($tutor->user_id == $user->id) {

            $course->tutor = $user->name;
            $course->makeHidden(['total_earned', 'status', 'id']);
            // $course->total_student = strval($sumStudent);
            $course->total_outlines = strval($course->total_outlines);
            $course->category = $category->name;
        }
        $outlines = Outline::whereCourseId($course->id)->get();
        foreach ($outlines as $outline) {
            $outline->makeHidden(['course_id']);
            array_push($updatedOutlines, $outline);
        }
        return [
            'course' => $course,
            'outlines' => $updatedOutlines
        ];
    }

    public function enroll(Request $request)
    {

        // dd($request->all());
        // each time a student pays for a course increase the course total student by +1

        $user = User::whereId($request->user)->first();
        $student = Student::whereUserId($user->id)->first();

        $course = Course::whereId($request->course)->first();
        if ($request->enroll) {
            $course = Course::whereSlug($request->course)->first();
        }


        $new_student_course = new StudentsCourse();
        $new_student_course->user_id = $user->id;
        $new_student_course->course_id = $course->id;
        $new_student_course->amount =  0;
        $new_student_course->student_id = $student->id;
        $new_student_course->status = 1;
        $new_student_course->save();

        // Get the tutor of the course

        $tutor = Tutor::whereId($course->tutor_id)->first();

        if ($new_student_course) {

            $tutor->balance += $course->price;
            $tutor->total_earned += $course->price;
            $tutor->students += 1;
            $tutor->save();

            $course->total_student += 1;
            $course->total_earned += $course->price;
            $course->save();
        }
        return response('Course enrollment successful');
    }

    public function getCourseReviews($slug)
    {
        $course = Course::whereSlug($slug)->first();
        $reviews = Review::whereCourseId($course->id)->get();
        $updatedReviews = [];
        foreach ($reviews as $review) {
            $review->makeHidden(['user_id', 'course_id', 'id']);
            $user = user::whereId($review->user_id)->first();
            $review->user = $user->name;
            array_push($updatedReviews, $review);
        }
        return $updatedReviews;
    }

    public function createReview(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|string',
            'rating' => 'required|integer|min:1',
        ]);

        // dd($request->all());
        // check if review exists and update
        $old_review = Review::whereCourseId($request->course)->whereUserId($request->user)->first();
        if ($old_review) {
            $old_review->body = $request->body;
            $old_review->user_id = $request->user;
            $old_review->course_id = $request->course ?? $old_review->course_id;
            $old_review->rating = $request->rating;
            $old_review->save();

            if ($old_review) {
                // update course rating
                $course = Course::whereId($request->course)->first();
                $average_rating = Review::whereCourseId($request->course)->average('rating');
                $course->rating = round($average_rating);
                $course->save();
            }
            return response([
                'status' => "success",
                'message' => "Review Successful"
            ]);
        } else {
            // check if user is taking the course
            $check = StudentsCourse::whereCourseId($request->course)->whereUserId($request->user)->whereStatus(1)->first();
            if ($check) {
                $review = new Review();
                $review->body = $request->body;
                $review->user_id = $request->user;
                $review->course_id = $request->course;
                $review->rating = $request->rating;
                $review->save();

                if ($review) {
                    // update course rating
                    $course = Course::whereId($request->course)->first();
                    $average_rating = Review::whereCourseId($request->course)->average('rating');
                    // $total = count($all_reviews);
                    // $sum = $course->rating + $review->rating;
                    // $average_rating = $sum / $total;
                    $course->rating = round($average_rating);
                    $course->save();
                }
                return response([
                    'status' => "success",
                    'message' => "Review Successful"
                ]);
            }
            return response([
                'message' => 'You must be enrolled to this course to review it',
                'status' => 'error'
            ]);
        }
    }

    public function getReview($course, $user)
    {
        return Review::whereUserId($user)->whereCourseId($course)->first();
    }

    public function subscribe(Request $request)
    {

        $user = Auth::user();
        $plan = Plan::whereAmount($request->amount)->first();

        if ($plan->amount !== $request->amount) {
            return response([
                'status' => 'error',
                'message' => 'Subscription Unsuccessful. Please try again'
            ]);
        }

        $now = Carbon::now();
        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->plan_id = $plan->id;
        $subscription->expires_at = $now->addMonths($plan->duration);
        $subscription->save();

        if ($subscription) {
            $client = new Client(); //GuzzleHttp\Client
            $promise = $client->request(
                'POST',
                'http://45.77.201.82/api',
                [
                    'form_params' => [
                        'publickey' => config('services.bpay.public'),
                        'secretkey' => config('services.bpay.secret'),
                        'businessemail' => config('services.bpay.email'),
                        'businessid' => config('services.bpay.id'),
                        'currency' => 'BTC',
                        'username' => $user->username,
                        'email' => $user->email,
                        'amount' => $request->amount
                    ]
                ]
            );

            $response = json_decode($promise->getBody()->getContents());
            return response([
                'status' => 'success',
                'message' => 'Subscription Successful.'
            ]);

            dd($response->address);
            // return redirect
        }
        return response([
            'status' => 'error',
            'message' => 'Subscription Unsuccessful. Please try again'
        ]);
    }
    public function buyCourse(Request $request)
    {
        $user = User::findOrFail($request->user);
        $amount = $request->amount;
        $client = new Client(); //GuzzleHttp\Client
        $promise = $client->request(
            'POST',
            'http://45.77.201.82/api',
            [
                'form_params' => [
                    'publickey' => config('services.bpay.public'),
                    'secretkey' => config('services.bpay.secret'),
                    'businessemail' => config('services.bpay.email'),
                    'businessid' => config('services.bpay.id'),
                    'currency' => 'BTC',
                    'username' => $user->username,
                    'email' => $user->email,
                    'amount' => $amount
                ]
            ]
        );
        $response = json_decode($promise->getBody()->getContents());

        return response($response->address);
    }

    public function isSubscribed($id)
    {

        // check for active subscription
        $check = Subscription::whereUserId($id)->whereStatus(1)->first();
        if ($check) {
            return 1;
        }
        return 0;
    }

    public function getQuiz($course, $chapter)
    {
        return Quiz::whereCourseId($course)->whereChapter($chapter)->get();
    }

    public function answerQuiz(Request $request)
    {
        $quiz = Quiz::whereId($request->quiz)->first();
        $quiz_answer = $quiz->answer;
        if ($quiz_answer != $request->answer) {

            $userQ = UsersQuiz::whereChapter($quiz->chapter)->whereQuizId($quiz->id)->get();
            if ($userQ) {
            }
            $newUserQ = new UsersQuiz();
            $newUserQ->user_id = $request->user;
            $newUserQ->quiz_id = $quiz->id;
            $newUserQ->chapter = $request->chapter;
            $newUserQ->last_answered = $quiz->id;
            return response([
                'status' => 'error',
                'message' => 'Incorrect. The right answer is ' + $quiz_answer
                // 'message' => 'Incorrect. The right answer is ' + $quiz_answer
            ]);
        }
        return response([
            'status' => 'success',
            'message' => 'Correct'
        ]);
    }
}
