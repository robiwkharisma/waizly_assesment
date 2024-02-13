<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\APIBaseController as Controller;
use App\Http\Interfaces\Services\TaskServiceInterface;
use App\Libraries\StaticLib;

class TaskController extends Controller
{
	protected $task_service;

	public function __construct(TaskServiceInterface $task_service)
	{
		$this->task_service = $task_service;
	}

	public function get_list(Request $request)
	{
		try {
			$params = $request->all();
			$this->data = $this->task_service->get_list($params);
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}

	public function get_detail(Request $request, $task_id)
	{
		try {
			$this->data = $this->task_service->get_detail($task_id);
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}

	public function create(Request $request)
	{
		try {
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}

	public function update(Request $request)
	{
		try {
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}

	public function delete(Request $request, $task_id)
	{
		try {
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}
}
