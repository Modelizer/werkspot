<?php

namespace Werkspot\CompressUrl\Exceptions;

use Exception;
use Throwable;

class UrlNotFoundException extends Exception
{
    public function __construct($message = "The given url doesn't exist", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
