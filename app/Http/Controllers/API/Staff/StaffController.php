<?php

namespace App\Http\Controllers\API\Staff;

use App\Http\Controllers\Controller;
use App\Models\AClass;
use App\Models\Staff;
use App\Models\StaffsClass;
use App\Models\Student;
use App\Models\StudentsClass;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
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
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Staff::whereUserId($id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::whereUserId($id)->first();
        $staff->country = $request->country;
        $staff->state = $request->state;
        $staff->phone = $request->phone;
        $staff->address = $request->address;
        $staff->save();
        return "update successful";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }

    public function enrollInClass(Request $request)
    {
        $classes = AClass::whereIn('id', $request->ids)->get();
        // $staff = Staff::whereUserId($request->staff)->first();
        $staff = Staff::whereId($request->staff)->first();
        $check = StaffsClass::whereStaffId($staff->id)->get();
        if (count($check) >= 3) {

            return [
                'info' => "Enrollment Unsuccessful!",
                'message' => 'Maximum number of courses reached',
                'status' => 'error'
            ];
        }

        foreach ($classes as $myClass) {

            StaffsClass::firstOrCreate([
                'staff_id' => $staff->id,
                'class_id' => $myClass->id
            ]);
        }

        return [
            'info' => "Enrolled Successfully!",
            'message' => 'Successfully enrolled in classes',
            'status' => 'success'
        ];
    }

    public function getStaffClasses($id)
    {
        $staff = Staff::whereUserId($id)->first();
        $classes = StaffsClass::whereStaffId($staff->id)->pluck('class_id');
        $updatedClasses = AClass::whereIn('id', $classes)->get();
        $x = [];
        foreach ($updatedClasses as $sclass) {
            $students = StudentsClass::whereClassId($sclass->id)->get();
            $sclass->tStudents = count($students);
            array_push($x, $sclass);
        }
        return $x;
    }

    public function getStaffRole($id)
    {
        $user = User::whereId($id)->first();
        $roles = $user->roles;
        foreach ($roles as $role) {
            return $role->slug;
        }
    }

    public function getTeacherStudents($id)
    {
        $updatedUsers = [];
        $staff = Staff::whereUserId($id)->first();
        $staff_classes = StaffsClass::whereStaffId($staff->id)->pluck('class_id');
        $student_classes = StudentsClass::whereIn('class_id', $staff_classes)->pluck('student_id');
        $students = Student::whereIn('id', $student_classes)->pluck('user_id');
        $users = User::whereIn('id', $students)->whereBan(0)->get();
        // $users->makeHidden(['id']);
        foreach ($users as $user) {
            $student = Student::whereUserId($user->id)->first();
            $user->level = $student->level;
            $user->student_id = $student->student_id;
            array_push($updatedUsers, $user);
        }
        return $updatedUsers;
    }
}
