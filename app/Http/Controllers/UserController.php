<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Notification;
use App\Notifications\Message;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function staff()
    {
        return view('auth.tutor_register');
    }
    public function adminLogin()
    {
        return view('auth.admin_login');
    }

    public function registerStaff(Request $request)
    {

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $data = $request->all();
        $user = new User();
        $user->username = $data['username'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = 1;
        $user->password = Hash::make($data['password']);
        $user->save();



        $staff = new Staff();
        $staff->user_id = $user->id;
        // $hasFile = $data['identity'];

        // if ($hasFile) {
        //     $image = $hasFile;
        //     $name = $image->getClientOriginalName();
        //     $image->move(public_path() . '/gallery/', $name);
        //     $tutor->identity = $name;
        // }
        $staff->tutor_id = 'DA' . uniqid();
        $staff->save();
        return redirect('/login')->with('status', 'Registration Successful. Account Pending Verification');
    }
}
