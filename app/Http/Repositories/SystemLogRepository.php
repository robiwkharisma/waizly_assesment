<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\SystemLogRepositoryInterface;
use App\Models\SystemLogs;
use Exception;
use Illuminate\Support\Facades\DB;

class SystemLogRepository implements SystemLogRepositoryInterface
{
	function create(string $type, string $status, string $message, array $data = []) : bool
	{
		$attributes = [
			'type' => $type,
			'status' => $status,
			'message' => $message,
			'data' => $data
		];

		$log = new SystemLogs;
		$log->setAttributeFromJson($attributes);
		$log->save();

		return true;
	}
}
