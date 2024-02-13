<?php

namespace App\Libraries;

class StaticLib
{
    // http response code
	const SUCCESS_CODE    = 200;    // Success
	const VALIDATION_ERROR_CODE = 422; // Validation error
	const UNAUTHORIZED_CODE = 401; // Unauthorized
	const BAD_REQUEST_CODE = 400; // Bad Request
	const FORBIDDEN_CODE = 403; // Forbidden
	const UNKNOWN_ERROR_CODE = 500; // unknown error
}
