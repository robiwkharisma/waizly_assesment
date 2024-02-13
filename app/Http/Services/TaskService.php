<?php

namespace App\Http\Services;

use App\Http\Interfaces\Services\TaskServiceInterface;
use App\Models\Task;
use Exception;

class TaskService implements TaskServiceInterface
{
	protected $auth_service;

	public function __construct()
	{
	}

	function get_list(array $params) : mixed
	{
		$attributes = $params;

		$attributes['order_direction'] = isset($attributes['order_direction']) ? filter_var($attributes['order_direction'], FILTER_VALIDATE_BOOLEAN) ? 'DESC' : 'ASC' : 'ASC';
		$attributes['order_model'] = $this->getOrderModel($attributes);
		$attributes['order_name'] = $this->getOrderName($attributes);

		$tasks = Task::select('tasks.*', 'task_statuses.name as status_name')
			->leftJoin('task_statuses', function ($join) {
				$join->on('task_statuses.id', '=', 'tasks.task_statuses_id');
			})
			->orderByRaw($attributes['order_model'] . "." . $attributes['order_name'] . " " . $attributes['order_direction'] . " NULLS LAST")
			->paginate(
				isset($attributes['per_page']) ? $attributes['per_page'] : 10,
				['*'],
				'page',
				isset($attributes['page']) ? $attributes['page'] : 1
			);

		return $tasks;
	}

	public function getOrderModel($attributes)
	{
		if ($attributes['order_column'] == 'status_name' || $attributes['order_column'] == 'status_name') {
			return 'task_statuses';
		}

		return 'tasks';
	}

	public function getOrderName($attributes)
	{
		if (isset($attributes['order_column'])) {
			if ($attributes['order_column'] == 'status_name') {
				return 'name';
			}
			else {
				return $attributes['order_column'];
			}
		}

		return 'created_at';
	}
}
