<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentsCourse;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\Message;
use Illuminate\Notifications\Notifiable;
use Notification;

class NotificationsController extends Controller
{
    public function notify(Request $request)
    {
        $this->validate($request, [
            'receiver' => 'required',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);

        // dd($request->all());
        $user = User::whereId($request->sender)->first();
        // dd($user);
        $tutor = Tutor::whereUserId($user->id)->first();
        $courses = Course::whereTutorId($tutor->id)->pluck('id');
        $studentUsers = StudentsCourse::whereIn('course_id', $courses)->pluck('user_id');
        $users = User::whereIn('id', $studentUsers)->get();
        // dd($users);

        $body = $request->body;
        $subject = $request->subject;
        $sender = $user->id;
        Notification::send($users, new Message($body, $subject, $sender));
    }
}
