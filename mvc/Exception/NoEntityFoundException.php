<?php

namespace mvc\Exception;

use Throwable;

class NoEntityFoundException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "No entity found: ".$message;
        parent::__construct($message, $code, $previous);
    }

}