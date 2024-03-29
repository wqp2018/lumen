<?php

namespace App\Exceptions;

use App\Http\Tool\Result;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if (env('APP_ENV') === 'local'){
            return parent::render($request, $exception);
        }

        if ($exception instanceof NotFoundHttpException){
            return response()->json(Result::fail('请确认API请求路径或者方式是否正确'));
        }

        if ($exception instanceof HttpException){
            return response('', $exception->getStatusCode());
        }

        if ($exception instanceof \ErrorException) {
            return response()->json(Result::fail($exception->getMessage()));
        }

        if ($exception instanceof TooManyRequestsHttpException){
            return response()->json(Result::fail('操作次数过于频繁，请稍后重试'));
        }

        if ($exception instanceof ValidationException){
            $errors = $exception->errors();
            $v = array_shift($errors);
            $response = Result::fail($v[0]);
        }else if ($exception instanceof ModelNotFoundException) {
            $response = Result::fail('请求数据不存在');
        }else{
            $response = Result::fail('系统繁忙，请稍后重试');
        }

        return response()->json($response);
    }
}
