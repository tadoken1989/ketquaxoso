<?php

namespace Core\Foundation\Exceptions;

use Exception;
use Illuminate\Mail\Message;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\ExceptionHandler as SymfonyDisplayer;
use Mail;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        if ($e instanceof FormInvalidException) {
            $this->log->error($e->getMessage(), $e->errors()->toArray());
        } else {
            $this->log->error($e);
        }

        // notify by email
        if (env('ERROR_REPORT_EMAIL')) {
            Mail::queue('email.500', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], function (Message $message) {
                $message->to(env('ERROR_REPORT_EMAIL'))->subject('Error from phimnhanh.com');
            });
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($request->isXmlHttpRequest() || $request->is(config('api.path'))) {
            if ($e instanceof FormInvalidException) {
                return $this->responseJson($e->getMessage(), $e->getStatusCode(), $e->errors());
            }

            if ($e instanceof NotFoundHttpException && ! $e->getMessage()) {
                return $this->responseJson('404 Not Found', $e->getStatusCode());
            }

            if ($e instanceof HttpException) {
                return $this->responseJson($e->getMessage(), $e->getStatusCode());
            }

            return $this->responseJson($e->getMessage(), 500);
        }

        return parent::render($request, $e);
    }

    protected function responseJson($message, $code, $data = [])
    {
        $send = ['message' => $message];
        if ($data) {
            $send['data'] = $data;
        }
        return response()->json($send, $code);
    }
    
    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();
        $prefix = '';
        if (is_admin()) {
            $prefix = 'admin::';
        }

        if (! view()->exists("{$prefix}errors.{$status}")) {
            return $this->convertExceptionToResponse($e);
        }

        return response()->view("{$prefix}errors.{$status}", [
            'exception' => $e,
            'exceptionHtml' => config('app.debug') ?
                (new SymfonyDisplayer())->getContent(FlattenException::create($e)) : ''
        ], $status);
    }
}

