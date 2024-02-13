<?php

namespace App\Http\Interfaces\Repositories;

interface TaskRepositoryInterface
{
    function get_list_paginated(array $attributes): mixed;
}
