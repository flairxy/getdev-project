<?php

namespace App\Http\Controllers\API\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{

    public function getTutorMessages($id)
    {
        $user = User::whereId($id)->first();
        $updatedData = [];
        foreach ($user->notifications as $notification) {

            $data = $notification->data;
            $sender = User::whereId($notification->sender)->first();
            $data['sender'] = $sender->name;
            $data['read_at'] = $notification->read_at;
            $data['id'] = $notification->id;
            $data['date'] = $notification->created_at->toFormattedDateString();

            array_push($updatedData, $data);
        }
        return $updatedData;
    }

    public function getMessages()
    {
        $username = Auth::user()->username;
        $messages = Message::whereReceiver($username)->get();
        $updatedMessage = [];
        foreach ($messages as $message) {
            $message->time = $message->created_at->toFormattedDateString();
            array_push($updatedMessage, $message);
        }
        return view('layouts.tutor_sidebar', ['messages' => $updatedMessage]);
    }

    public function getSentMessages($id)
    {
        $user = User::whereId($id)->first();
        // dd($user);
        $notifications = Notification::whereSender($user->id)->get();
        // dd($notifications);
        $updatedData = [];
        foreach ($notifications as $notification) {
            $notifications->makeHidden(['sender', 'notifiable_id']);
            $notification->time = $notification->created_at->toFormattedDateString();
            $notification->data = json_decode($notification->data);

            array_push($updatedData, $notification);
        }
        return $updatedData;
    }

    public function updateMessage(Request $request)
    {
        $notification = Notification::whereId($request->id)->first();
        $notification->read_at = Carbon::now();
        $notification->save();
        return response('Message read');
    }

    public function updateMessages(Request $request)
    {
        $messages = Notification::whereId($request->id)->first();
        foreach ($messages as $message) {

            $message->status = 1;
            $message->save();
        }
        return response('Messages read');
    }

    public function deleteMessages(Request $request)
    {
        $messages = Notification::whereIn('id', $request->id)->get();
        foreach ($messages as $message) {

            $message->delete();
        }
        return response('Messages deleted');
    }
}
