<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        // \DB::table('task_statuses')->truncate();

		$statuses = [
			[
				'name'    => 'open',
			],
			[
				'name'    => 'todo',
			],
			[
				'name'    => 'in progress',
			],
			[
				'name'    => 'in review',
			],
			[
				'name'    => 'ready for test',
			],
			[
				'name'    => 'done',
			],
		];

		foreach ($statuses as $key => $data) {
			$status = TaskStatus::where('name', $data['name'])->first();
			if (!$status) {
				$status = new TaskStatus;
			}
			$status->setAttributeFromJson($data);
			$status->save();
		}
	}
}
