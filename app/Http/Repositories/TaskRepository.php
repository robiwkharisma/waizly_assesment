<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\TaskRepositoryInterface;
use App\Libraries\StaticLib;
use App\Models\Task;
use Exception;

class TaskRepository implements TaskRepositoryInterface
{
	function get_list_paginated(array $attributes): mixed
	{
		$tasks = [];
		try {
			$orderModel = $attributes['order_model'] ?? 'tasks';
			$orderName = $attributes['order_name'] ?? 'created_at';
			$orderDirection = $attributes['order_direction'] ?? 'DESC';

			$tasks = Task::select('tasks.*', 'task_statuses.name as status_name')
				->leftJoin('task_statuses', function ($join) {
					$join->on('task_statuses.id', '=', 'tasks.task_statuses_id');
				})
				->orderByRaw($orderModel . "." . $orderName . " " . $orderDirection . " NULLS LAST")
				->paginate(
					isset($attributes['per_page']) ? $attributes['per_page'] : 10,
					['*'],
					'page',
					isset($attributes['page']) ? $attributes['page'] : 1
				);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $tasks;
	}
}
