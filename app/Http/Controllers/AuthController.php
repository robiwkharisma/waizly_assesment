<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\APIBaseController as Controller;
use App\Http\Interfaces\Services\AuthServiceInterface;
use App\Libraries\StaticLib;
use Auth;

class AuthController extends Controller
{
	protected $auth_service;

	public function __construct(AuthServiceInterface $auth_service)
	{
		$this->auth_service = $auth_service;
	}

	public function login(Request $request)
	{
		try {
			$params = $request->all();

			$rules = array(
				'email' => 'required',
				'password' => 'required|min:8'
			);
			$messages = [
				'email.required'	=> 'MESSAGE.ERROR_REQUIRED',
				'password.required'	=> 'MESSAGE.ERROR_REQUIRED',
				'password.min'		=> 'MESSAGE.PASSWORD_MIN_8',
			];

			$validate = Validator::make($params, $rules, $messages);
			if ($validate->fails()) {
				$this->data = $validate->messages();
				throw new \Exception("MESSAGE.ERROR_VALIDATION", StaticLib::VALIDATION_ERROR_CODE);
			}

			$credentials = $request->only(['email', 'password']);

			$this->data = $this->auth_service->login($credentials);
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}

	public function refresh_token(Request $request)
	{
		try {
			$this->data = $this->auth_service->refresh_token();
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}

	public function logout(Request $request)
	{
		try {
			$this->auth_service->logout();
			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message 		= $e;
			$this->status    	= self::CODE_9999;
		}

		return $this->response();
	}

	public function change_password(Request $request)
	{
		try {
			$params = $request->all();

			$rules = array(
				'old_password' => 'required',
				'new_password' => 'required|min:8|required_with:password_confirmation|same:password_confirmation',
				'password_confirmation' => 'min:8'
			);

			$messages = [
				'old_password.required'	=> 'MESSAGE.ERROR_REQUIRED',
				'new_password.required'	=> 'MESSAGE.ERROR_REQUIRED',
				'new_password.same' => 'MESSAGE.REPEAT_PASSWORD.NOT_SAME',
			];
			$validate = Validator::make($params, $rules, $messages);

			if ($validate->fails()) {
				$this->data = $validate->messages();
				throw new \Exception("MESSAGE.ERROR_VALIDATION", StaticLib::VALIDATION_ERROR_CODE);
			}

			$this->auth_service->change_password($params);

			$this->message = 'MESSAGE.SUCCESS';
		} catch (\Exception $e) {
			$this->message = $e;
			$this->status = StaticLib::UNKNOWN_ERROR_CODE;
		}

		return $this->response();
	}
}
