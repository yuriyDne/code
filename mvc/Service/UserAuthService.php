<?php

namespace mvc\Service;

use mvc\Dto\UserDto;

class UserAuthService
{
    const AUTH_KEY = 'uuid';

    /**
     * @var Session
     */
    private $session;

    /**
     * UserAuthService constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param int $id
     */
    public function authorize(int $id)
    {
        $this->session->add(self::AUTH_KEY, $id);
    }

    public function logout()
    {
        $this->session->remove(self::AUTH_KEY);
    }

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        $uuid = $this->getUuid();
        return (bool) $uuid;
    }

    /**
     * @return null|int
     */
    public function getUuid()
    {
        return $this->session->get(self::AUTH_KEY);
    }

    /**
     * @return UserDto
     */
    public function getDto()
    {
        return new UserDto(
            $this->isAuthorized()
        );
    }


}