<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Uuids;
    public $incrementing = false;
    protected $fillable = ['receiver', 'sender', 'header', 'message', 'time'];
}
