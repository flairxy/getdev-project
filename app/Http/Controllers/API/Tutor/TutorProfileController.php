<?php

namespace App\Http\Controllers\API\Tutor;

use App\Account;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\VerifyEmailQueued;
use Illuminate\Support\Facades\Notification;
use Image;
use Illuminate\Support\Facades\Storage;


class TutorProfileController extends Controller
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
        dd($user);
        // $user->notify(new VerifyEmailQueued);
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $tutor = Tutor::whereUserId($user->id)->first();
        $tutor->country = $request->country ?? $tutor->state;
        $tutor->state = $request->state ?? $tutor->state;
        $tutor->address = $request->address ?? $tutor->address;
        $tutor->zip = $request->zip ?? $tutor->zip;
        $tutor->phone = $request->phone ?? $tutor->phone;

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            public_path('avatars');
            $filename = 'tutor_avatar_' . $tutor->tutor_id . "." . $image->getClientOriginalExtension();
            $avatar_path = $request->file('avatar')->storeAs('avatars', $filename);

            $link =  $filename;
            if (file_exists($link)) {
                unlink($link);
            }
            Image::make($image)->resize(400, 400)->save($avatar_path);

            $tutor->image = $avatar_path ?? $tutor->image;
        }


        if ($request->hasFile('id_card')) {
            $image = $request->file('id_card');
            public_path('identity');
            $filename = 'tutorID_' . $tutor->tutor_id . "." . $image->getClientOriginalExtension();
            $id_path = $request->file('id_card')->storeAs('identity', $filename);

            $link =  $filename;
            if (file_exists($link)) {
                unlink($link);
            }
            Image::make($image)->resize(400, 400)->save($id_path);

            $tutor->identity = $id_path ?? $tutor->identity;
            $tutor->identity_status = 1 ?? $tutor->identity_status;
        }

        $tutor->save();

        return response('profile update successful');
    }

    public function getProfile($id)
    {
        return Tutor::whereUserId($id)->first();
    }
}
