<?php

namespace App\Http\Services;

use App\Http\Interfaces\Repositories\TaskRepositoryInterface;
use App\Http\Interfaces\Services\TaskServiceInterface;

class TaskService implements TaskServiceInterface
{
	protected $task_repository;

	public function __construct(TaskRepositoryInterface $task_repository)
	{
		$this->task_repository = $task_repository;
	}

	function get_list(array $params) : mixed
	{
		$attributes = $params;

		$attributes['order_direction'] = isset($attributes['order_direction']) ? filter_var($attributes['order_direction'], FILTER_VALIDATE_BOOLEAN) ? 'DESC' : 'ASC' : 'ASC';
		$attributes['order_model'] = $this->getOrderModel($attributes);
		$attributes['order_name'] = $this->getOrderName($attributes);

		return $this->task_repository->get_list_paginated($attributes);
	}

	private function getOrderModel($attributes)
	{
		if ($attributes['order_column'] == 'status_name' || $attributes['order_column'] == 'status_name') {
			return 'task_statuses';
		}

		return 'tasks';
	}

	private function getOrderName($attributes)
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

	function get_detail(int $task_id) : mixed
	{
		$query = [
			'id' => $task_id,
		];
		return $this->task_repository->get_first($query);
	}
}
