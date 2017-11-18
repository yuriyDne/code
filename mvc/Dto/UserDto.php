<?php

namespace mvc\Dto;

class UserDto
{
    /**
     * @var bool
     */
    private $isAuthorized;

    /**
     * UserDto constructor.
     * @param bool $isAuthorized
     */
    public function __construct(
        bool $isAuthorized
    ) {
        $this->isAuthorized = $isAuthorized;
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        return $this->isAuthorized;
    }

}