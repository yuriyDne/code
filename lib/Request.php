<?php
/**
 * Created by PhpStorm.
 * User: yuriy
 * Date: 11/14/17
 * Time: 3:57 PM
 */

namespace lib;


use config\Constants;

class Request
{
    /**
     * @return string
     */
    public function getRequestUri()
    {
        return Constants::SITE_SCHEMA. "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    public function getRequestUriWithoutParams(array $paramNames)
    {
        return $this->getUrlWithoutParams($this->getRequestUri(), $paramNames);
    }

    public function getUrlWithoutParams($url, array $paramNames)
    {
        $result = parse_url($url);
        $params = [];
        if (!empty($result['query'])) {
            parse_str($result['query'], $params);
        }
        foreach ($paramNames as $paramName) {
            if (isset($params[$paramName])) {
                unset($params[$paramName]);
            }
        }

        $queryParams = http_build_query($params);
        if (!empty($queryParams)) {
            $queryParams = '?'.$queryParams;
        }

        return $result['scheme'].'://'.$result['host'].$result['path'].$queryParams;
    }

    /**
     * @param string $variableName
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function get(string $variableName, $defaultValue = null)
    {
        return $this->getFromArray($_GET, $variableName, $defaultValue);
    }

    /**
     * @param string $variableName
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function post(string $variableName, $defaultValue = null)
    {
        return $this->getFromArray($_POST, $variableName, $defaultValue);
    }


    /**
     * @param string $variableName
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function files(string $variableName, $defaultValue = null)
    {
        return $this->getFromArray($_FILES, $variableName, $defaultValue);
    }

    public function redirect(
        string $url,
        int $statusCode = 303
    ) {
        header('Location: '.$url, true, $statusCode);
        die();
    }

    /**
     * @param string $variableName
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function postOrGet(string $variableName, $defaultValue = null)
    {
        $defaultValue = $this->get($variableName, $defaultValue);
        return $this->post($variableName, $defaultValue);
    }

    /**
     * @return bool
     */
    public function isPostRequest()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST');
    }

    /**
     * @param array $array
     * @param string $variableName
     * @param mixed $defaultValue
     * @return mixed
     */
    private function getFromArray(array $array, string $variableName, $defaultValue)
    {
        if (!is_string($variableName)) {
            throw new \InvalidArgumentException('variableName must be string');
        }

        if (!isset($array[$variableName])) {
            return $defaultValue;
        }

        return $array[$variableName];
    }
}