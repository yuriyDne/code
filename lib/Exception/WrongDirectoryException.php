<?php

namespace lib\Exception;

class WrongDirectoryException extends \InvalidArgumentException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "Wrong directory path $message";
        parent::__construct($message, $code, $previous);
    }

}