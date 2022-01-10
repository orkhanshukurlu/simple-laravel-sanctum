<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    protected $dontReport = [];

    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request)
        {
            if ($request->is('api/*'))
            {
                return $this->responseMessage('Error', 'Not found', 404);
            }
        });

        $this->renderable(function (RouteNotFoundException $e, $request)
        {
            if ($request->is('api/*'))
            {
                return $this->responseMessage('Error', 'Token not found', 500);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request)
        {
            if ($request->is('api/*'))
            {
                return $this->responseMessage('Error', $e->getMessage(), 405);
            }
        });

        $this->renderable(function (ValidationException $e, $request)
        {
            if ($request->is('api/*'))
            {
                return $this->responseMessage('Error', $e->errors());
            }
        });

        $this->renderable(function (AuthorizationException $e, $request)
        {
            if ($request->is('api/*'))
            {
                return $this->responseMessage('Error', $e->getMessage(), 403);
            }
        });
    }
}