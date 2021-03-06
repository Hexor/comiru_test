<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
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
        if ($exception instanceof ApiException) {
            return responseError($exception->getMessage(), $exception->getCode());
        } elseif ($exception instanceof ValidationException) {
            return responseError($this->getErrorsAsString($exception->errors()), Response::HTTP_BAD_REQUEST);
        } elseif ($exception->getCode() >= 400 && $exception->getCode() < 500) {
            return responseError($exception->getMessage(), $exception->getCode());
        }
        return parent::render($request, $exception);
    }

    private function getErrorsAsString(array $errors)
    {
        $result = '';
        foreach ($errors as $error) {
            foreach ($error as $detail) {
                $result .= $detail . " ";
            }
        }
        return $result;
    }
}
