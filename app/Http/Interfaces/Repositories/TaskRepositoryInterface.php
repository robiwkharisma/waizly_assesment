<?php

namespace App\Http\Interfaces\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    function get_list_paginated(array $attributes): mixed;
    function get_many(array $where, array $fields = ['*']) : Collection;
    function get_first(array $where, array $fields = ['*']) : mixed;
    function create(array $attributes) : Task;
    function update(Task $task, array $attributes) : Task;
}
