<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \App\Models\Role::where('slug', 'dean')->first();
        $user = new \App\Models\User();
        $user->username = 'dean';
        $user->name = 'Dean A';
        $user->email = 'superadmin@localhost';
        $user->role = 2;
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role);
    }
}
