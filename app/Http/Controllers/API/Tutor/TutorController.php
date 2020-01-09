<?php

namespace App\Http\Controllers\API\Tutor;

use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Models\Course;
use App\Models\Message as ModelsMessage;
use App\Models\Outline;
use App\Models\StudentsCourse;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Image;

class TutorController extends Controller
{
    public function updateProfile(Request $request)
    {

        $user = User::findOrFail($request->user);
        if ($request->hasFile('passport')) {
            $image = $request->file('passport');
            $filename = $user->username . '.' . $image->getClientOriginalExtension();
            $location = 'images/passport/' . $filename;
            $user->passport = $filename;

            $path = './images/passport/';
            $link = $path . $user->passport;
            if (file_exists($link)) {
                unlink($link);
            }
            Image::make($image)->resize(400, 400)->save($location);
        }

        if ($request->hasFile('identity')) {
            $image = $request->file('identity');
            $filename = $user->username . '.' . $image->getClientOriginalExtension();
            $location = 'images/id/' . $filename;
            $user->passport = $filename;

            $path = './id/passport/';
            $link = $path . $user->passport;
            if (file_exists($link)) {
                unlink($link);
            }
            Image::make($image)->resize(400, 400)->save($location);
        }
    }
}
