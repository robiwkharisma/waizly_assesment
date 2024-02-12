<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        // \DB::table('roles')->delete();
        // \DB::table('roles')->truncate();

		$roles = [
			[
				'name' => 'Super Admin',
				'slug' => 'super-admin',
			],
			[
				'name' => 'Staff',
				'slug' => 'staff',
			],
		];

		foreach ($roles as $key => $role) {
			$data = Role::where('slug', $role['slug'])->first();
			if (!$data) {
				$data = new Role;
			}
			$data->setAttributeFromJson($role);
			$data->save();
		}
	}
}
