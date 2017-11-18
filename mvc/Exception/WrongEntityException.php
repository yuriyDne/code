<?php

namespace mvc\Exception;

class WrongEntityException extends \InvalidArgumentException
{

    /**
     * WrongEntityException constructor.
     * @param string $entityName
     * @param int $entityClass
     * @param \Throwable $givenClass
     */
    public function __construct($entityName, $entityClass, $givenClass)
    {
        $message = "$entityName must be $entityClass. $givenClass instead";

        parent::__construct($message);
    }
}