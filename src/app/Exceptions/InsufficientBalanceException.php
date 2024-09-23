<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InsufficientBalanceException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
    protected $message = 'Insufficient balance.';
}
