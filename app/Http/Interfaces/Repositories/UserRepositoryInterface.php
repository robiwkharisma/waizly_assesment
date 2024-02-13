<?php

namespace App\Http\Interfaces\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
	function get_many(array $where, array $fields = ['*']) : Collection;
	function get_first(array $where, array $fields = ['*']) : User;
	function update(User $user, array $attributes) : User;
}
