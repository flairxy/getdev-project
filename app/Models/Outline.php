<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Outline extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = ['title', 'course_id', 'chapter'];

    public function course()
    {
        return $this->belongsTo(Course::class);;
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }

    // $video = App\Model\Video::find(1);

    // echo $video->course->title
}
