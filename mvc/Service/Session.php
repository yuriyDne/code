<?php

namespace mvc\Service;

/**
 * Class Session
 * @package mvc\Service
 */
class Session
{
    /**
     * @param string $key
     * @param $value
     */
    public function add(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param null $defaultValue
     * @return null
     */
    public function get(string $key, $defaultValue = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
    }

    /**
     * @param string $key
     */
    public function remove(string $key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}