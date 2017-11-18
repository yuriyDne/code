<?php

namespace lib;

use Service\ClientScript;
use Service\ServiceProvider;
use Service\Validator;

abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var string
     */
    protected $actionName;
    /**
     * @var ServiceProvider
     */
    protected $serviceProvider;
    /**
     * @var View
     */
    protected $view;

    /**
     * @var Validator
     */
    protected $validator;
    /**
     * @var ClientScript
     */
    protected $clientScript;

    /**
     * ControllerBase constructor.
     * @param ServiceProvider $serviceProvider
     * @param View $view
     * @param Request $request
     * @param Validator $validator
     * @param ClientScript $clientScript
     * @param string $actionName
     */
    public function __construct(
        ServiceProvider $serviceProvider,
        View $view,
        Request $request,
        Validator $validator,
        ClientScript $clientScript,
        string $actionName
    ) {
        $this->request = $request;
        $this->actionName = $actionName;
        $this->serviceProvider = $serviceProvider;
        $this->view = $view;
        $this->validator = $validator;
        $this->clientScript = $clientScript;
    }

    public function runAction()
    {
        $method = new \ReflectionMethod($this, $this->actionName);
        $params = $method->getParameters();
        $paramValues = [];
        foreach ($params as $param) {
            $paramValues[] = $this->request->postOrGet($param->getName());
        }

        $method->invoke($this, ...$paramValues);
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->serviceProvider->getRequest();
    }
}