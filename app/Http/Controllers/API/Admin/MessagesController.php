<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentsCourse;
use App\Models\User;
use Carbon\Carbon;

use App\Models\Tutor;
use Illuminate\Http\Request;
use App\Notifications\Message;
use Notification;

class MessagesController extends Controller
{

    public function getAdminMessages($id)
    {
        $user = User::whereId($id)->first();
        if ($user->role == 2){
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
    }

    public function getSentMessages($id)
    {
        $user = User::whereRole(1)->get();
        // $user = User::whereId($id)->first();
        // dd($user);
        $updatedNotifications = [];
        $notifications = \App\Models\Notification::all();
        foreach($notifications as $notification){
            $sender = User::whereId($notification->sender)->first();
            if($sender->role == 2){
                array_push($updatedNotifications, $notification);
            }
        }
        // dd($notifications);
        $updatedData = [];
        foreach ($updatedNotifications as $notification) {
            $allData = json_decode($notification->data);
            $sender = User::whereId($allData->sender)->first();
            $data['sender'] = $sender->name;
            $data['subject'] = $allData->subject;
            $data['body'] = $allData->body;
            $data['time'] = $notification->created_at->toFormattedDateString();

            array_push($updatedData, $data);
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

    public function notify(Request $request)
    {

        $this->validate($request, [
            'receiver' => 'required',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);

        // dd($request->all());
        $user = User::whereId($request->sender)->first();

        if($user->role == 2){
            // dd($user);
            if($request->receiver == 1){
                $users = User::whereRole(0)->get();

            }
            if($request->receiver == 2){
                $users = User::whereRole(1)->get();

            }
            $body = $request->body;
            $subject = $request->subject;
            $sender = $user->id;
            Notification::send($users, new Message($body, $subject, $sender));

        }
    }
}
