<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\TaskRepositoryInterface;
use App\Libraries\StaticLib;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\Collection;

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

    function get_many(array $where, array $fields = ['*']) : Collection
	{
		$tasks = [];

		try {
			$tasks = Task::where($where)->get($fields);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $tasks;
    }

    function get_first(array $where, array $fields = ['*']) : mixed
    {
		$user = null;

		try {
			$tasks = $this->get_many($where, $fields);
			if ($tasks) {
				$user = $tasks->first();
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $user;
    }

	function create(array $attributes) : Task
	{
		try {
			$task = new Task();
			$task->setAttributeFromJson($attributes);
			$task->save();
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $task;
	}

	function update(Task $task, array $attributes) : Task
	{
		try {
			$task->setAttributeFromJson($attributes);
			$task->save();
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $task;
	}
}
