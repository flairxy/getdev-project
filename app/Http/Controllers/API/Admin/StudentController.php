<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\AClass;
use App\Models\Student;
use App\Models\StudentsClass;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class StudentController extends Controller
{
    function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::all();

        $updatedStudents = [];

        foreach ($student as $student) {
            $sc = StudentsClass::whereStudentId($student->id)->pluck('class_id');
            $user = User::whereId($student->user_id)->first();
            $student->name = $user->name;
            $student->email = $user->email;
            $student->classes = AClass::whereIn('id', $sc)->get();
            $student->status = $user->ban;

            array_push($updatedStudents, $student);
        }

        return $updatedStudents;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('dean');
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
        ])->validate();

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = 'GD/STU/' . $this->generateRandomString(5);
            $user->password = bcrypt('secret');
            $user->role = 0;
            $user->save();

            $student = new Student();
            $student->user_id = $user->id;
            $student->student_id = $user->username;
            $student->level = $request->level;
            $student->save();

            if (!$user || !$student) {
                throw new Exception;
            }


            return 'student created successfully';
        } catch (\Exception $e) {
            // DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('dean');
        $student = Student::findOrFail($id);
        // dd($role);
        $user = User::findOrFail($student->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $student = Student::whereUserId($id)->first();
        $student->level = $request->level;
        $student->save();

        return ('update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('dean');
        $student = Student::findOrFail($id);
        $user = User::findOrFail($student->user_id);
        $user->delete();
        return ([
            'status' => 'success',
            'message' => 'student deleted'
        ]);
    }

    public function removeFromClass(Request $request)
    {
        $this->authorize('dean');
        $sc = StudentsClass::whereStudentId($request->student)->whereClassId($request->class)->first();
        $sc->delete();

        return ([
            'status' => 'success',
            'message' => 'Student removed from class'
        ]);
    }

    public function getStudentClasses($id)
    {

        $class_ids = StudentsClass::whereStudentId($id)->pluck('class_id');
        $classes = AClass::whereIn('id', $class_ids)->get();
        return [
            'student' => $id,
            'classes' => $classes
        ];
    }

    public function banStudent(Request $request){
        $students = Student::whereIn('id', $request->ids)->get();
        foreach($students as $student){
            $user = User::whereId($student->user_id)->first();
            $user->ban = 1;
            $user->save();
        }
        return 'success';
    }
    public function activateStudent(Request $request){
        $students = Student::whereIn('id', $request->ids)->get();
        foreach($students as $student){
            $user = User::whereId($student->user_id)->first();
            $user->ban = 0;
            $user->save();
        }
        return 'success';
    }
}
