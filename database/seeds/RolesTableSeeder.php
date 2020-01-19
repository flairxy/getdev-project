<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student_perms = [
            'enroll-in-school',
            'enroll-in-classes',
        ];

        $teacher_perms = [
            'enroll-in-school',
            'enroll-in-classes',
            'students-in-class',
        ];

        $dean_perms = [
            'add-students',
            'hire-staff',
            'view',
            'add-classes',
            'students-in-class',
            'student-in-school',
        ];

        $contractor_finance = [
            'view',
            'staff-in-school',
        ];

        $management_perm = [
            'view-records',
            'view',
            'students-in-class',
            'staff-in-school',
            'student-in-school',
        ];

        $admin = Permission::all();
        $dean = Permission::whereIn('slug', $dean_perms)->get();
        $student = Permission::whereIn('slug', $student_perms)->get();
        $teacher = Permission::whereIn('slug', $teacher_perms)->get();
        $finance_contractor = Permission::whereIn('slug', $contractor_finance)->get();
        $management = Permission::whereIn('slug', $management_perm)->get();
        $general = Permission::where('slug', 'view')->first();

        $admin_role = new Role();
        $admin_role->slug = 'admin';
        $admin_role->description = 'Admin Role';
        $admin_role->save();
        $admin_role->permissions()->attach($admin);

        $dean_role = new Role();
        $dean_role->slug = 'dean';
        $dean_role->description = 'Dean Role';
        $dean_role->save();
        $dean_role->permissions()->attach($dean);

        $student_role = new Role();
        $student_role->slug = 'student';
        $student_role->description = 'Student Role';
        $student_role->save();
        $student_role->permissions()->attach($student);

        $teacher_role = new Role();
        $teacher_role->slug = 'teacher';
        $teacher_role->description = 'teacher Role';
        $teacher_role->save();
        $teacher_role->permissions()->attach($teacher);

        $finance_role = new Role();
        $finance_role->slug = 'finance';
        $finance_role->description = 'Finance Staff ';
        $finance_role->save();
        $finance_role->permissions()->attach($finance_contractor);

        $contractor_role = new Role();
        $contractor_role->slug = 'contractor';
        $contractor_role->description = 'Contractor Staff ';
        $contractor_role->save();
        $contractor_role->permissions()->attach($finance_contractor);

        $management_role = new Role();
        $management_role->slug = 'management';
        $management_role->description = 'Management Staff';
        $management_role->save();
        $management_role->permissions()->attach($management);

        $general_role = new Role();
        $general_role->slug = 'general';
        $general_role->description = 'General Staff';
        $general_role->save();
        $general_role->permissions()->attach($general);
    }
}
