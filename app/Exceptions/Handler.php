<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        NotFoundHttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        $debugEnabled = config('app.debug');

        if ($e instanceof QueryException) {
            if ($debugEnabled) {
                $message = $e->getMessage();
            } else {
                $message = 'Internal Server Error';
            }
        }

        if ($e instanceof NotFoundHttpException) {
            $message = 'The specified resource could not be found';
        }

        $statusCode = $this->getStatusCode($e);

        if (! isset($message) && ! ($message = $e->getMessage())) {
            $message = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

        $errors = [
            'message' => $message,
            'status_code' => $statusCode,
        ];

        if ($debugEnabled) {
            $errors['exception'] = get_class($e);
            $errors['trace'] = explode("\n", $e->getTraceAsString());
        }

        return response()->json(['errors' => $errors], $statusCode);
    }

    /**
     * Get the status code from the exception.
     *
     * @param \Throwable $exception
     * @return int
     */
    protected function getStatusCode(Throwable $exception)
    {
        return $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
    }
}
