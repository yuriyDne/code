<?php
namespace lib;

use config\Constants;
use Controller\ControllerBase;
use Service\ServiceProvider;

class Route
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $moduleNames = [];


    /**
     * Route constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->initModuleNames();
    }

    /**
     * @return AbstractController
     */
    public function getController()
    {
        $route = $this->request->get('route');
        if (empty($route)) {
            $route = Constants::DEFAULT_ROUTE;
        }
        $route = trim($route, '/\\');
        $parts = explode('/', $route);
        $currentPartId = 0;
        $controllerClassName = '';
        $moduleOrControllerName = $parts[$currentPartId];

        $viewPath = MVC_PATH.'Views'.DS;
        if ($this->isModule($moduleOrControllerName)) {
            $controllerClassName = "$moduleOrControllerName\\";
            $currentPartId ++;
            $moduleOrControllerName = isset($parts[$currentPartId]) ? $parts[$currentPartId] : 'index';
            $viewPath = SITE_ROOT.'Module'.DS.$controllerClassName.DS.'Views';
        }

        $controllerClassName .= "Controller\\".ucfirst($moduleOrControllerName).'Controller';
        $currentPartId ++;
        $actionName = isset($parts[$currentPartId]) ? $parts[$currentPartId] : 'index';

        $serviceProvider = new ServiceProvider();
        $clientScript = $serviceProvider->getClientScript();
        $userDto = $serviceProvider->getUserAuthService()->getDto();

        return new $controllerClassName(
            $serviceProvider,
            new View($clientScript, $viewPath, $userDto),
            $this->request,
            $serviceProvider->getValidator(),
            $clientScript,
            $actionName
        );
    }

    private function initModuleNames()
    {
        $modulePath = MVC_PATH.'Module'.DS;
        if (is_dir($modulePath)) {
            $fileHelper = new DirectoryHelper();
            $this->moduleNames = $fileHelper->getList($modulePath);
        }
    }

    /**
     * @param string $moduleName
     * @return bool
     */
    private function isModule(string $moduleName)
    {
        return array_key_exists($moduleName, $this->moduleNames);
    }

}