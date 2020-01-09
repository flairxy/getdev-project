<?php

namespace App\Http\Controllers\API\Student;

use App\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\VerifyEmailQueued;
use Illuminate\Support\Facades\Notification;


class StudentProfileController extends Controller
{
    public function updatePassword(Request $request)
    {
        Validator::make($request->all(), [
            'old_password' => 'required|max:255',
            'password' => 'required|min:6|confirmed|max:255'
        ])->validate();

        $hashedPassword = Auth::user()->password;

        if (Hash::check($request->old_password, $hashedPassword) && !Hash::check($request->password, $hashedPassword)) {
            $user = User::findOrFail($request->user);
            $user->password = Hash::make($request->password);
            $user->save();
            return response([
                'status' => 'success',
                'message' => 'Password update successful'
            ]);
        }
        return response([
            'status' => 'error',
            'message' => 'Failed to update password. Check provided information'
        ]);
    }


    public function sendEmailVerification(Request $request)
    {
        $user = User::findOrFail($request->user);
        // $user->notify(new VerifyEmailQueued);
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $student = Student::whereUserId($user->id)->first();
        $student->country = $request->country;
        $student->state = $request->state;
        $student->address = $request->address;
        $student->zip = $request->zip;
        $student->save();

        return response('profile update successful');
    }

    public function getNotifications($id){

        $user = User::whereId($id)->first();
        $updatedData = [];
        foreach ($user->notifications as $notification) {

            $data = $notification->data;
            $sender = User::whereId($notification->sender)->first();
            $data['sender'] = $sender->name;
            $data['date'] = $notification->created_at->toFormattedDateString();

            array_push($updatedData, $data);
        }
        return $updatedData;
    }
}
