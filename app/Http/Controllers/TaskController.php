<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\APIBaseController as Controller;
use App\Libraries\StaticLib;

class TaskController extends Controller
{
	protected $auth_service;

	public function __construct()
	{
	}

	public function get_list(Request $request)
    {
		try {
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
