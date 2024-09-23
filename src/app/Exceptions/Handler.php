<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if($this->isHttpRequest($request)) {
            if($e instanceof ValidationException) {
                $e = (new ValidationFailedException())->withErrors($e->errors());
            }

            if($e instanceof Exception) {
                if (config('app.debug')) {
                    $response = [
                        'message' => $e->getMessage(),
                        'errors' => $e->getErrors(),
                        'exception' => static::class,
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->gettrace()
                    ];
                } else {
                    $response = [
                        'message' => $e->getMessage(),
                        'errors' => $e->getErrors()
                    ];
                }
                return response()->json($response, $e->getCode());
            }
        }

        return parent::render($request, $e);
    }

    protected function isHttpRequest($request)
    {
        return $request instanceof \Illuminate\Http\Request;
    }
}
