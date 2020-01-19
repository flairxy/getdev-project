<?php

namespace App\Http\Controllers\API\Student;

use App\Http\Controllers\Controller;
use App\Models\AClass;
use App\Models\Student;
use App\Models\StudentsClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Student::whereUserId($id)->first();
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
        $student = Student::whereUserId($id)->first();
        $student->country = $request->country;
        $student->state = $request->state;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->save();
        return "update successful";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getClassByLevel($id){
        $student = Student::whereUserId($id)->first();
        $classes = AClass::whereLevel($student->level)->get();
        return $classes;
    }

    public function enrollInClass(Request $request){
        $classes = AClass::whereIn('id', $request->ids)->get();
        $student = Student::whereUserId($request->student)->first();
        $check = StudentsClass::whereStudentId($student->id)->get();
        if(count($check) >= 6){

            return [
                'info' => "Enrollment Unsuccessful!",
                'message' => 'Maximum number of courses reached',
                'status' => 'error'
            ];
        }

        foreach ($classes as $myClass) {

            StudentsClass::firstOrCreate([
                'student_id' => $student->id,
                'class_id' => $myClass->id
            ]);
        }

        return [
            'info' => "Enrolled Successfully!",
            'message' => 'Successfully enrolled in classes',
            'status' => 'success'
        ];


    }

    public function getStudentClasses($id){
        $student = Student::whereUserId($id)->first();
        $classes = StudentsClass::whereStudentId($student->id)->pluck('class_id');
        $updatedClasses = AClass::whereIn('id', $classes)->get();
        return $updatedClasses;
    }
}
