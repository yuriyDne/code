<?php

namespace lib;

use lib\Exception\FileNotFoundException;
use mvc\Dto\UserDto;
use Service\ClientScript;

class View
{
    /**
     * @var string
     */
    private $layout = 'default';
    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $viewPath;
    /**
     * @var ClientScript
     */
    private $clientScript;
    /**
     * @var UserDto
     */
    private $userDto;

    /**
     * View constructor.
     * @param ClientScript $clientScript
     * @param string $viewPath
     * @param UserDto $userDto
     */
    public function __construct(
        ClientScript $clientScript,
        string $viewPath,
        UserDto $userDto
    ) {
        $this->viewPath = $viewPath;
        $this->clientScript = $clientScript;
        $this->userDto = $userDto;
    }

    /**
     * @param string $layout
     * @return $this
     */
    public function withLayout(string $layout)
    {
        $this->layout = $layout;
        return $this;
    }


    /**
     * @param string $paramName
     * @param $paramValue
     * @return $this
     */
    public function withParam(string $paramName, $paramValue)
    {
        $this->params[$paramName] = $paramValue;
        return $this;
    }

    public function render(string $viewName)
    {
        $viewContent = $this->getContent($viewName, $this->params);

        $layoutPath = 'layout'.DS.$this->layout;
        $this->withParam('viewContent', $viewContent)
            ->withParam('jsScripts', $this->clientScript->getJsScripts())
            ->withParam('cssScripts', $this->clientScript->getCssScripts())
            ->renderPartial($layoutPath, $this->params);
    }


    public function renderPartial(string $viewName, array $params = []) {
        $viewPath = $this->viewPath. $viewName. '.php';

        if (!file_exists($viewPath)) {
            throw new FileNotFoundException($viewPath);
        }

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        include $viewPath;
    }

    /**
     * @param $data
     */
    public function renderJson($data) {
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($data);
    }

    /**
     * @param string $viewName
     * @param array $params
     * @return string
     */
    public function getContent(string $viewName, array $params)
    {
        ob_start();
        ob_implicit_flush(false);
        $this->renderPartial($viewName, $params);
        return ob_get_clean();
    }

    /**
     * @return UserDto
     */
    public function getUserDto(): UserDto
    {
        return $this->userDto;
    }
}