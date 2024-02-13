<?php

namespace App\Http\Services;

use App\Http\Interfaces\Repositories\SystemLogRepositoryInterface;
use App\Http\Interfaces\Repositories\UserRepositoryInterface;
use App\Http\Interfaces\Services\AuthServiceInterface;
use App\Libraries\StaticLib;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
	protected $user_repository;
	protected $logs_repo;

	public function __construct(
		UserRepositoryInterface $user_repo,
		SystemLogRepositoryInterface $logs_repo
	)
	{
		$this->user_repository = $user_repo;
		$this->logs_repo = $logs_repo;
	}

	function login(array $credentials) : Array {
		// Get First User
		$query = [
			'email' => $credentials['email'],
		];
		$user = $this->user_repository->get_first($query);

		if (!$user) {
			throw new Exception("MESSAGE.ACCOUNT_NOT_FOUND", StaticLib::BAD_REQUEST_CODE);
		}

		if (!$user->is_active) {
			throw new Exception("MESSAGE.INACTIVE_ACCOUNT", StaticLib::BAD_REQUEST_CODE);
		}

		$authAttempt = Auth::attempt([
			'email' => $credentials['email'],
			'password' => $credentials['password']
		]);

		if (!$authAttempt) {
			throw new Exception("MESSAGE.WRONG_PASSWORD", StaticLib::BAD_REQUEST_CODE);
		}

		$token = $user->createToken('auth_token')->plainTextToken;

		return [
			'user' => $user,
			'token' => $token,
			'token_type' => 'Bearer',
		];
	}

	function change_password(array $params) : bool
	{
		$user = Auth::user();
		if (!Hash::check($params['old_password'], $user->password)) {
			throw new Exception("MESSAGE.INCORRECT_CURRENT_PASSWORD", StaticLib::BAD_REQUEST_CODE);
		}

		$attributes = [
			'password' => $params['new_password'],
		];

		try {
			DB::beginTransaction();
			$user = $this->user_repository->update($user, $attributes);
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			$message = $e->getMessage();
			$log_data = ['function' => 'change_password', 'file' => $e->getFile(), 'line' => $e->getLine(), 'attributes' => $attributes];
			$this->logs_repo->create('auth_service', 'failed', $message, $log_data);
			throw new Exception($message);
		}

		return true;
	}

	function refresh_token() : Array
	{
		$user = Auth::user();
		$token = $user->createToken('auth_token')->plainTextToken;

		return [
			'user' => $user,
			'token' => $token,
			'token_type' => 'Bearer',
		];
	}

	function logout() : bool
	{
		$user = Auth::user()->currentAccessToken()->delete();

		return true;
	}
}
