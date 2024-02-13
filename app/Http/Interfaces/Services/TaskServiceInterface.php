<?php

namespace App\Http\Interfaces\Services;

interface TaskServiceInterface
{
	function get_list(array $params) : mixed;
}
