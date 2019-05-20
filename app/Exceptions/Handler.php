<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use InvalidArgumentException;
use Illuminate\Auth\Access\AuthorizationException;

use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(["error" => "Method Not Allowed"], 405);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(["error" => "Not Found"], 404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json(["error" => "Not Found"], 404);
        }

        if ($exception instanceof TokenBlacklistedException) {
            return response()->json(["error" => "Token Blacklisted"], 400);
        }

        if ($exception instanceof TokenExpiredException) {
            return response()->json(["error" => "Token Expired"], 400);
        }

        if ($exception instanceof TokenInvalidException) {
            return response()->json(["error" => "Token Invalid"], 400);
        }

        if ($exception instanceof JWTException) {
            return response()->json(["error" => "Token Absent"], 404);
        }

        if ($exception instanceof HttpException) {
            return response()->json(["error" => $exception->getMessage()], $exception->getStatusCode());
        }

        if( $exception instanceof InvalidArgumentException ){
            return response()->json(['message'=>'Validation rule unique requires at least 1 parameters.'],400);
        }

        if( $exception instanceof AuthorizationException ){
            return response()->json(['message'=>'This action is unauthorized.'],403);
        }

        return parent::render($request, $exception);
    }
}
