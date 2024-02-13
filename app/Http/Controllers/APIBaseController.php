<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\StaticLib;

class APIBaseController extends Controller
{
	public $status      = StaticLib::SUCCESS_CODE;
	public $data        = null;
	public $message     = '';
	public $httpError   = StaticLib::UNKNOWN_ERROR_CODE;
	public $exception;

	private function buildResponse()
	{
		if ($this->status !== StaticLib::SUCCESS_CODE) {
			$this->responseForError($this->message);
		}

		return [
			'status'    => $this->status,
			'message'   => empty($this->message) ? $this->buildResponseMessage() : $this->message,
			'data'      => $this->data,
		];
	}

	private function buildResponseMessage()
	{
		$this->message = trans('error_api.' . $this->status);

		return $this->message;
	}

	private function buildHttpErrorCode()
	{
		$this->httpError = $this->status;

		return $this->httpError;
	}

	public function response()
	{
		return response()->json(
			$this->buildResponse(),
			$this->buildHttpErrorCode()
		);
	}

	public function responseForError($exception)
	{
		$this->exception = $exception;
		$this->message = $exception->getMessage();

		if (in_array($exception->getCode(), [StaticLib::SUCCESS_CODE, StaticLib::VALIDATION_ERROR_CODE, StaticLib::UNAUTHORIZED_CODE, StaticLib::BAD_REQUEST_CODE, StaticLib::FORBIDDEN_CODE, StaticLib::UNKNOWN_ERROR_CODE])) {
			$this->status = $exception->getCode();
			$this->message = $exception->getMessage();
		}
	}
}
