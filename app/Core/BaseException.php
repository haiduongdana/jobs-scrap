<?php

namespace App\Core;

use Exception;
use Illuminate\Http\Response;

abstract class BaseException extends Exception
{
    protected $errors = [];

    /**
     * @var int
     */
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
