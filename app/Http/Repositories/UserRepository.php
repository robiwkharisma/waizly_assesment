<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    function get_many(array $where, array $fields = ['*']) : Collection
	{
		$users = [];

		if (!$fields) {
			$fields = [];
		}

		try {
			$users = User::where($where)->get($fields);
		} catch (Exception $e) {
			$log_data = ['function' => 'get_many', 'where' => $where, 'fields' => $fields];
		}

		return $users;
    }

    function get_first(array $where, array $fields = ['*']) : User
    {
		$user = null;

		try {
			$users = $this->get_many($where, $fields);
			if ($users) {
				$user = $users->first();
			}
		} catch (Exception $e) {
			$log_data = ['function' => 'get_first', 'where' => $where, 'fields' => $fields];
		}

		return $user;
    }

	function update(User $user, array $attributes) : User
	{
		try {
			$user->setAttributeFromJson($attributes);
			$user->save();
		} catch (Exception $e) {
			$message = $e->getMessage();
			$log_data = ['function' => 'update', 'attributes' => $attributes];
			throw new Exception($e);
		}

		return $user;
	}
}
