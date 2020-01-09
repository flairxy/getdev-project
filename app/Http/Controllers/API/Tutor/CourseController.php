<?php

namespace App\Http\Controllers\API\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Outline;
use App\Models\Quiz;
use App\Models\StudentsCourse;
use App\Models\Tutor;
use App\Models\User;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function getCourseOutlines($id)
    {
        return Outline::whereCourseId($id)->get();
    }

    public function getOutlinesByChapter($course_id, $chapter)
    {
        return Outline::whereCourseId($course_id)->whereChapter($chapter)->get();
    }

    public function getCourseById($id)
    {
        $course = Course::whereId($id)->first();
        $outlines = Outline::whereCourseId($id)->get();
        // $sumStudent = 0;
        // $course_students = StudentsCourse::whereCourseId($course->id)->get();
        // $total_students = count($course_students);
        // $sumStudent += $total_students;
        // $course->total_student = $sumStudent;
        return response([
            'course' => $course,
            'outlines' => $outlines
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|integer|min:1',
            'total_chapters' => 'required',
            'price' => 'required|integer|min:0',
        ]);

        // DB::beginTransaction();
        try {

            $user = User::findOrFail($request->user);
            $tutor = Tutor::whereUserId($request->user)->first();
            $course = new Course();
            $course->title = $request->title;
            $course->category_id = $request->category_id;
            // dd(count(json_decode($request->total_chapters)));
            $total_chapters = count(json_decode($request->total_chapters));
            $course->total_chapters = $total_chapters;
            $course->price = $request->price;
            $course->type = $request->type;
            $course->tutor_id = $tutor->id;

            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $cover_path = $request->file('file')->store('images/cover');
                // $filename = 'cover_' . $tutor->tutor_id . $course->slug . '.' . $image->getClientOriginalExtension();
                // $location = 'images/cover/' . $filename;
                $course->cover_image = $cover_path;

                $link = $course->cover_image;
                if (file_exists($link)) {
                    unlink($link);
                }
                Image::make($image)->resize(400, 400)->save($cover_path);
            }
            $course->total_outlines = count(json_decode($request->outlines));
            $course->save();

            if ($course) {
                $tutor->courses += 1;
                $tutor->save();
            }

            $outlines = json_decode($request->outlines);


            foreach ($outlines as $outline) {
                $newOutline = new Outline();
                $newOutline->title = $outline->title;
                $newOutline->course_id = $course->id;
                $newOutline->chapter = $outline->chapter;
                $newOutline->save();

                if (!$newOutline) {
                    throw new Exception;
                }
            }
            return $course;
        } catch (\Exception $e) {
            // DB::rollback();
            return $e->getMessage();
        }
    }


    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'title' => 'required|string',
        //     'file' => 'required',
        //     'file.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        //     'category_id' => 'required|integer|min:1',
        //     'total_chapters' => 'required',
        // ]);

        // DB::beginTransaction();
        try {
            $course = course::whereId($request->course_id)->first();
            $course->title = $request->title ?? $course->title;
            $course->category_id = $request->category_id ?? $course->category_id;
            // dd(count(json_decode($request->total_chapters)));
            $total_chapters = count(json_decode($request->total_chapters));
            $course->total_chapters = $total_chapters ?? $course->total_chapters;
            $course->price = $request->price ?? $course->price;
            $course->type = $request->type ?? $course->type;

            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $cover_path = $request->file('file')->store('images/cover');
                // $filename = 'cover_' . $tutor->tutor_id . $course->slug . '.' . $image->getClientOriginalExtension();
                // $location = 'images/cover/' . $filename;
                $course->cover_image = $cover_path ?? $course->cover_image;

                $link = $course->cover_image;
                if (file_exists($link)) {
                    unlink($link);
                }
                Image::make($image)->resize(400, 400)->save($cover_path);
            }
            $course->total_outlines = count(json_decode($request->outlines));
            $course->save();

            $outlines = json_decode($request->outlines);


            foreach ($outlines as $outline) {
                $existing_outline = Outline::whereId($outline->id)->first();
                if ($existing_outline) {
                    $existing_outline->title = $outline->title;
                    $existing_outline->course_id = $course->id;
                    $existing_outline->chapter = $outline->chapter;
                    $existing_outline->save();

                    if (!$existing_outline) {
                        throw new Exception;
                    }
                } else {
                    $newOutline = new Outline();
                    $newOutline->title = $outline->title;
                    $newOutline->course_id = $course->id;
                    $newOutline->chapter = $outline->chapter;
                    $newOutline->save();

                    if (!$newOutline) {
                        throw new Exception;
                    }
                }
            }
            return $course;
        } catch (\Exception $e) {
            // DB::rollback();
            return $e->getMessage();
        }
    }

    public function courseVideos(Request $request)
    {
        // dd($request->all());

        $videoExists = Video::whereOutlineId($request->outline_id)->first();
        if ($videoExists) {
            if ($request->hasFile('filename')) {
                $path = $request->file('filename')->store('videos/outline');
                $videoExists->url = $path;
                $videoExists->save();
            }
        } else {
            $outlineVideo = new Video();
            if ($request->hasFile('filename')) {
                $path = $request->file('filename')->store('videos/outline');
                $outlineVideo->outline_id = $request->outline_id;
                $outlineVideo->url = $path;
            }
            $outlineVideo->save();
        }
    }

    public function getVideosByOutlines(Request $request)
    {
        return Video::whereIn('outline_id', $request->outlines)->get();
    }

    public function totalCourses()
    {
        $user = Auth::user();
        $course = Course::whereUserId($user->id)->get();
        return count($course);
    }

    public function getCoursesByTutor($id)
    {
        // $user = User::findOrFail($request->user);
        $tutor = Tutor::whereUserId($id)->first();
        // get courses by the tutor
        $courses = Course::whereTutorId($tutor->id)->pluck('id');
        if (count($courses) > 0) {
            $outlines = Outline::whereIn('course_id', $courses)->get();
            $tutor_courses = Course::whereTutorId($tutor->id)->get();
            // $t_courses = [];
            // $sumStudent = 0;
            // foreach ($tutor_courses as $tutor_course) {
            //     $course_students = StudentsCourse::whereCourseId($tutor_course->id)->get();
            //     $total_students = count($course_students);
            //     $sumStudent += $total_students;
            //     $tutor_course->total_student = $sumStudent;
            //     array_push($t_courses, $tutor_course);
            // }
            return [
                'courses' => $tutor_courses,
                'outlines' => $outlines
            ];
        }
        return response('You have no courses yet');
    }

    public function deleteCourse($id)
    {
        $course = Course::whereId($id)->first();
        $course->delete();

        $tutor = Tutor::whereId($course->tutor_id)->first();
        $tutor->courses -= 1;
        $tutor->save();

        return response([
            'status' => 'success',
            'message' => 'Course deleted'
        ]);
    }

    public function deleteOutline($id)
    {
        $outline = Outline::whereId($id)->first();
        $outline->delete();
        return response([
            'status' => 'success',
            'message' => 'Outline deleted'
        ]);
    }

    public function createQuiz(Request $request)
    {

        $course = Course::whereId($request->course)->first();
        // $user = User::whereId($request->user)->first();

        $quiz = new Quiz();
        $quiz->course_id = $course->id;
        $quiz->chapter = $request->chapter;
        $quiz->question = $request->question;
        $quiz->answer = $request->answer;
        $quiz->options = $request->options;
        $quiz->save();
        return ('Quiz created');
    }

    public function updateQuiz(Request $request)
    {
    }

    public function deleteQuiz($id)
    {
    }


    public function getAccountSummary($id)
    {
        $tutor = Tutor::whereUserId($id)->first();
        $courses = Course::whereTutorId($tutor->id)->whereType(1)->pluck('id');
        $student_courses = StudentsCourse::whereIn('course_id', $courses)->get();
        $updatedC = [];
        foreach ($student_courses as $sc) {
            $sc->makeHidden(['status', 'student_id']);
            $course = Course::whereId($sc->course_id)->first();
            $sc->course = $course->title;
            $sc->time = $sc->created_at->toFormattedDateString();
            array_push($updatedC, $sc);
        }

        return $updatedC;
    }
}
