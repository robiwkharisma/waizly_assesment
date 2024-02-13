<?php

namespace App\Http\Interfaces\Repositories;

use App\Models\SystemLogs;

interface SystemLogRepositoryInterface
{
	function create(string $type, string $status, string $message, array $data = []) : bool;
}
