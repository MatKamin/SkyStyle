<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    // Other methods...

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
                ? response()->json(['error' => 'Unauthorized'], 401)
                : redirect()->guest(route('login'));
    }

}
