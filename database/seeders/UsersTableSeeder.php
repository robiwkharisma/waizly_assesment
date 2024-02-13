<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'nik'    => '1234567890',
                'email'    => 'super-admin@hr.com',
                'password' => 'password',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'gender' => 'L',
                'role_slug' => 'super-admin',
            ],
            [
                'nik'    => '0987654321',
                'email'    => 'staff@office.com',
                'password' => 'password',
                'first_name' => 'Staff',
                'last_name' => 'Member',
                'gender' => 'L',
                'role_slug' => 'staff',
            ],
        ];

        foreach ($users as $key => $data) {
            $role = Role::where('slug', $data['role_slug'])->first();
            if (!$role) {
                echo "Role is not found";
            } else {
                $user = User::where('email', $data['email'])->first();
                if (!$user) {
                    $user = new User;
                }
                $data['role_id'] = $role->id;
                $user->setAttributeFromJson($data);
                $user->save();
            }
        }
    }
}
