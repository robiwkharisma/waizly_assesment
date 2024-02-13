<?php

namespace App\Http\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    function get_list_paginated(array $attributes): mixed;
    function get_many(array $where, array $fields = ['*']) : Collection;
    function get_first(array $where, array $fields = ['*']) : mixed;
}
