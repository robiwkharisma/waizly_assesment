<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->is('api/*')) {
            abort(response()
                ->json([
                    'status'    => false,
                    'message' => 'Unauthenticated',
                    'data'    => null,
                ], 401));
        }else{
            abort(401);
        }
    }
}
