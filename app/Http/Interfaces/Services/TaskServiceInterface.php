<?php

namespace App\Http\Interfaces\Services;

interface TaskServiceInterface
{
	function get_list(array $params) : mixed;
	function get_detail(int $task_id) : mixed;
	function update_or_create(array $params) : mixed;
	function delete(int $task_id) : bool;
}
