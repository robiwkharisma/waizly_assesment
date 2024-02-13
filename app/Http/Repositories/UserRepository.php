<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\Repositories\UserRepositoryInterface;
use App\Libraries\StaticLib;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    function get_many(array $where, array $fields = ['*']) : Collection
	{
		$users = [];

		try {
			$users = User::where($where)->get($fields);
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $users;
    }

    function get_first(array $where, array $fields = ['*']) : mixed
    {
		$user = null;

		try {
			$users = $this->get_many($where, $fields);
			if ($users) {
				$user = $users->first();
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $user;
    }

	function update(User $user, array $attributes) : User
	{
		try {
			$user->setAttributeFromJson($attributes);
			$user->save();
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), StaticLib::UNKNOWN_ERROR_CODE);
		}

		return $user;
	}
}
