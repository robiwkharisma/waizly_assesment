<?php

namespace Tests\Unit\Http\Services;

use App\Http\Repositories\SystemLogRepository;
use App\Http\Repositories\TaskRepository;
use App\Http\Services\TaskService;
use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
	protected $task_repository;
	protected $logs_repository;

	/**
	 * should be result array of data
	 */
	public function test_get_list()
	{
		$this->setup_task_repository();
		$this->setup_logs_repository();

		$expected_return = [
			[
				"id" => 3,
				"title" => "SUSA",
				"description" => "semoga saja",
				"due_date" => null,
				"time_estimate" => null,
				"task_statuses_id" => null,
				"assigned_to" => null,
				"created_at" => "2024-02-13T18:48:53.000000Z",
				"updated_at" => "2024-02-13T18:48:53.000000Z",
				"deleted_at" => null,
				"status_name" => null,
			],
		];
		$this->task_repository->method('get_list_paginated')
			->willReturn($expected_return);

		$task_service = new TaskService($this->task_repository, $this->logs_repository);

		$params = [
			"order_direction" => "true",
			"order_column" => "id",
			"per_page" => "10",
			"page" => "1",
		];
		$result = $task_service->get_list($params);

		$this->assertEquals($expected_return, $result);
	}

	/**
	 * should be result string model name
	 */
	public function test_get_order_model()
	{
		$this->setup_task_repository();
		$this->setup_logs_repository();

		$task_service = new TaskService($this->task_repository, $this->logs_repository);

		// with this param, it should be return "tasks" as result
		$params = [
			"order_column" => "id",
		];
		$result = $task_service->get_order_model($params);

		$this->assertEquals('tasks', $result);

		// with this param, it should be return "task_statuses" as result
		$params = [
			"order_column" => "status_name",
		];
		$result = $task_service->get_order_model($params);

		$this->assertEquals('task_statuses', $result);
	}

	/**
	 * should be result string column name
	 */
	public function test_get_order_name()
	{
		$this->setup_task_repository();
		$this->setup_logs_repository();

		$task_service = new TaskService($this->task_repository, $this->logs_repository);

		// with this param, it should be return tha same as its params
		$params = [
			"order_column" => "status",
		];
		$result = $task_service->get_order_name($params);

		$this->assertEquals('status', $result);

		// with this param, it should be return "created_at" as result
		$params = [];
		$result = $task_service->get_order_name($params);

		$this->assertEquals('created_at', $result);
	}

	/**
	 * should be result object of data
	 */
	public function test_get_detail()
	{
		$this->setup_task_repository();
		$this->setup_logs_repository();

		$expected_return = (object) [
			"id" => 1,
			"title" => "SUSA",
			"description" => "semoga saja",
			"due_date" => null,
			"time_estimate" => null,
			"task_statuses_id" => null,
			"assigned_to" => null,
			"created_at" => "2024-02-13T18:48:53.000000Z",
			"updated_at" => "2024-02-13T18:48:53.000000Z",
			"deleted_at" => null,
			"status_name" => null,
		];
		$this->task_repository->method('get_first')
			->willReturn($expected_return);

		$task_service = new TaskService($this->task_repository, $this->logs_repository);

		$task_id = 1;
		$result = $task_service->get_detail($task_id);

		$this->assertEquals($expected_return, $result);
	}

	public function setup_task_repository()
	{
		$this->task_repository = $this->createMock(TaskRepository::class);
	}

	public function setup_logs_repository()
	{
		$this->logs_repository = $this->createMock(SystemLogRepository::class);
	}
}
