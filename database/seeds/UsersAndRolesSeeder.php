<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'Super Admin Cong',
            'email' => 'congnguyentan_super_admin@codeandmore.com',
            'password' => '123456',
            'super_admin' => 1
        ]);

        $adminUser = User::create([
            'name' => 'Admin Cong',
            'email' => 'congnguyentan_admin@codeandmore.com',
            'password' => '123456'
        ]);
        $adminUser->assignRole('admin');

        $modUser = User::create([
            'name' => 'Mod Cong',
            'email' => 'congnguyentan_mod@codeandmore.com',
            'password' => '123456'
        ]);
        $modUser->assignRole('mod');

        $registerUser = User::create([
            'name' => 'User Cong',
            'email' => 'congnguyentan_user@codeandmore.com',
            'password' => '123456'
        ]);
        $registerUser->assignRole('user');
    }
}
