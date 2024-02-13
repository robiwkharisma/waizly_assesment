<?php

namespace App\Http\Interfaces\Services;

interface AuthServiceInterface
{
	function login(array $credentials) : Array;
}
