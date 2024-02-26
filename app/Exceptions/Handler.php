<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            if (request()->wantsJson()) {
                return \RestApi::error('Unauthorized!', 401);
            }else{
                // return response()->view('errors.401',[],401);
                return \RestApi::error('Unauthorized!', 401);
            }
        }else if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
            if (request()->wantsJson()) {
                return \RestApi::error('Token Blacklisted!', 401);
            }else{
                // return response()->view('errors.401',[],404);
                return \RestApi::error('Token Blacklisted!', 401);
            }
        }else if($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            if (request()->wantsJson()) {
                return \RestApi::error('Not Found!', 404);
            }else{
                return response()->view('errors.404',[],404);
            }
        }else if($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return \RestApi::error('Method not allowed!', 405);
        }else if($exception instanceof \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException) {
            if (request()->wantsJson()) {
                $title = explode('|',json_decode(file_get_contents(storage_path('framework/down')), true)['message']);
                if(!isset($title[1])) {
                    return \RestApi::error(['title' => 'Maintenance', "description" => 'System Update'], 503);
                }
                return \RestApi::error(['title' => $title[0], "description" => strip_tags(str_replace('<br/>', ' ', $title[1]))], 503);
            }
        }
        return parent::render($request, $exception);
    }
}
