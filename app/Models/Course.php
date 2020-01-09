<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{

    use HasSlug, Uuids, SoftDeletes;
    public $incrementing = false;

    protected $fillable = ['slug', 'title', 'cover_image', 'price', 'promo_price', 'total_chapters', 'tutor_id', 'price'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }

    public function video()
    {
        return $this->hasMany(Video::class);
    }

    public function student()
    {
        return $this->belongsToMany(Student::class, 'students_courses');;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // $videos = App\Models\Course::find(1)->videos;

    // foreach ($videos as $video) {
    //     //
    // }
}
