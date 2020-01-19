<?php

use App\BusinessRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $permissions = [
            'add-classes',
            'add-students',
            'hire-staff',
            'view-records',
            'students-in-class',
            'staff-in-school',
            'student-in-school',
            'enroll-in-school',
            'enroll-in-classes',
            'view'

        ];

        foreach ($permissions as $permission) {
            $word = explode('-', $permission);
            \App\Models\Permission::firstOrCreate([
                'slug' => $permission,
                'description' => implode($word)
            ]);
        }
    }
}
