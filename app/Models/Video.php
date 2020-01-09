<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = ['outline_id', 'url'];

    public function outline()
    {
        return $this->belongsTo(Outline::class);;
    }

    // $video = App\Model\Video::find(1);

    // echo $video->course->title
}
