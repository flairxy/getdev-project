<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = [
        'identity', 'tutor_id', 'image', 'name'
    ];
}
