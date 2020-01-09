<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function categories()
    {
        return Category::all();
    }

    public function chapters()
    {
        return Chapter::all();
    }

    public function update(Request $request){
        $course = Course::WhereId($request->course)->first();
        $course->status = $request->status;
        $course->save();
    }
    public function delete($id){
        $course = Course::WhereId($id)->first();
        $course->delete();
    }
}
