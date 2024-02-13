<?php

namespace App\Http\Interfaces\Services;

interface AuthServiceInterface
{
	function login(array $credentials) : Array;
	function change_password(array $params) : bool;
	function refresh_token() : Array;
}
