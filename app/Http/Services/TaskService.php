<?php

namespace App\Http\Services;

use App\Http\Interfaces\Repositories\SystemLogRepositoryInterface;
use App\Http\Interfaces\Repositories\TaskRepositoryInterface;
use App\Http\Interfaces\Services\TaskServiceInterface;
use App\Libraries\StaticLib;
use Exception;
use Illuminate\Support\Facades\DB;

class TaskService implements TaskServiceInterface
{
	protected $task_repository;
	protected $logs_repo;

	public function __construct(
		TaskRepositoryInterface $task_repository,
		SystemLogRepositoryInterface $logs_repo
	)
	{
		$this->task_repository = $task_repository;
		$this->logs_repo = $logs_repo;
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

	function update_or_create(array $params) : mixed
	{
		try {
			DB::beginTransaction();
			$task_id = $params['id'] ?? null;
			$existing_task = $task_id ? $this->get_detail($task_id) : null;
			if (!$existing_task) {
				$task = $this->task_repository->create($params);
			} else {
				$task = $this->task_repository->update($existing_task, $params);
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			$message = $e->getMessage();
			$log_data = ['function' => 'update_or_create', 'file' => $e->getFile(), 'line' => $e->getLine(), 'attributes' => $params];
			$this->logs_repo->create('task_service', 'failed', $message, $log_data);
			throw new Exception($message);
		}

		return $task;
	}

	function delete(int $task_id) : bool
	{
		try {
			DB::beginTransaction();
			$is_deleted = $this->task_repository->delete($task_id);
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			$message = $e->getMessage();
			$log_data = ['function' => 'delete', 'file' => $e->getFile(), 'line' => $e->getLine(), 'task_id' => $task_id];
			$this->logs_repo->create('task_service', 'failed', $message, $log_data);
			throw new Exception($message, $e->getCode());
		}
		return $is_deleted;
	}
}
