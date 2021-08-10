<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [];

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
        if ($request->ajax() || $request->wantsJson()) {
            return $this->prepareJsonResponse($request, $exception);
        }

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

        if ($this->shouldntReport($e)) {
            return;
        }

        if ($e instanceof QueryException) {
            $message = 'Internal Server Error';
            $statusCode = 500;
        }

        if (
            $e instanceof NotFoundHttpException ||
            $e instanceof ModelNotFoundException
        ) {
            $message = 'The specified resource could not be found';
            $statusCode = 404;
        }

        $errors = [
            'message' => $debugEnabled ? $e->getMessage() : $message,
            'status_code' => $debugEnabled ? $this->getStatusCode($e) : $statusCode,
        ];

        if (empty($errors['message'])) {
            $errors['message'] = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

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
        return $exception instanceof HttpExceptionInterface 
            ? $exception->getStatusCode() 
            : 500;
    }
}
