<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $tutor = Tutor::whereUserId($user->id)->first();
        return view('tutor.tutor', ['tutor' => $tutor]);
    }
}
