<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\AClass;
use App\Models\Role;
use App\Models\Staff;
use App\Models\StaffsClass;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
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

        $lUser = Auth::user();
        $staffs = Staff::where('user_id', '!=', $lUser->id)->get();
        $updatedStaffs = [];

        foreach ($staffs as $staff) {
            $user = User::whereId($staff->user_id)->first();
            $staff->name = $user->name;
            $staff->email = $user->email;
            $staff->status = $user->ban;
            $staff->role = $user->roles;

            array_push($updatedStaffs, $staff);
        }

        return $updatedStaffs;
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
            'role' => 'required',
            'email' => 'required|unique:users',
        ])->validate();


        try {
            $role = Role::where('slug', $request->role)->first();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = 'GD/ST/' . $this->generateRandomString(5);
            $user->password = bcrypt('secret');
            $user->role = 1;
            if ($request->role == 'admin' || $request->role == 'management') {
                $user->role = 2;
            }
            $user->save();
            $user->roles()->attach($role);

            $staff = new Staff();
            $staff->user_id = $user->id;
            $staff->staff_id = $user->username;
            $staff->save();

            if (!$user || !$staff) {
                throw new Exception;
            }


            return 'staff created successfully';
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
        $staff = Staff::findOrFail($id);
        $role = Role::where('slug', $request->role)->first();
        // dd($role);
        $user = User::findOrFail($staff->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->roles()->sync($role);
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
        $staff = Staff::findOrFail($id);
        $user = User::findOrFail($staff->user_id);
        $user->delete();
        return ([
            'status' => 'success',
            'message' => 'staff deleted'
        ]);
    }


    public function removeFromClass(Request $request)
    {

        $this->authorize('dean');
        $sc = StaffsClass::whereStaffId($request->staff)->whereClassId($request->class)->first();
        $sc->delete();

        return ([
            'status' => 'success',
            'message' => 'Staff removed from class'
        ]);
    }

    public function getStaffClasses($id)
    {

        $class_ids = StaffsClass::whereStaffId($id)->pluck('class_id');
        $classes = AClass::whereIn('id', $class_ids)->get();
        return [
            'staff' => $id,
            'classes' => $classes
        ];
    }

    public function banStaff(Request $request)
    {
        $staffs = Staff::whereIn('id', $request->ids)->get();
        foreach ($staffs as $staff) {
            $user = User::whereId($staff->user_id)->first();
            $user->ban = 1;
            $user->save();
        }
        return 'success';
    }
    public function activateStaff(Request $request)
    {
        $staffs = Staff::whereIn('id', $request->ids)->get();
        foreach ($staffs as $staff) {
            $user = User::whereId($staff->user_id)->first();
            $user->ban = 0;
            $user->save();
        }
        return 'success';
    }
}
