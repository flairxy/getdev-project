<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsCourse extends Model
{
    // protected $table = 'student_courses';
    protected $fillable = ['course_id', 'student_id', 'user_id'];
}
