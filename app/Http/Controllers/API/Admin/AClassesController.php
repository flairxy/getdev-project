<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\AClass;
use App\Models\StudentsClass;
use Illuminate\Http\Request;
use Validator;

class AClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = AClass::all();
        $updated = [];
        foreach ($classes as $sClass) {
            $students = StudentsClass::whereClassId($sClass->id)->get();
            $sClass->tStudents = count($students);
            array_push($updated, $sClass);
        }
        return $updated;
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
        $this->authorize('dean');
        Validator::make($request->all(), [
            'name' => 'required',
            'level' => 'required',
        ])->validate();

        $class = new AClass();
        $class->name = $request->name;
        $class->level = $request->level;
        $class->save();
        return 'class created';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AClass  $aClass
     * @return \Illuminate\Http\Response
     */
    public function show(AClass $aClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AClass  $aClass
     * @return \Illuminate\Http\Response
     */
    public function edit(AClass $aClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AClass  $aClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('dean');
        $class = AClass::whereId($id)->first();
        $class->name = $request->name;
        $class->level = $request->level;
        $class->save();
        return 'class updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AClass  $aClass
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('dean');
        $class = AClass::findOrFail($id);
        $class->delete();
        return ([
            'message' => 'Class Deleted',
            'status' => 'success'
        ]);
    }
}
