<?php

namespace lib\Exception;

use Throwable;

class FileNotFoundException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "File $message not found";
        parent::__construct($message, $code, $previous);
    }
}