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
        $role = \App\Models\Role::where('slug', 'super-admin')->first();
        $user = new \App\Models\User();
        $user->username = 'super-admin';
        $user->name = 'super-admin';
        $user->email = 'superadmin@localhost';
        $user->role = 2;
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role);
    }
}
