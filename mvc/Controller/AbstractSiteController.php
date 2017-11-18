<?php

namespace Controller;

use lib\AbstractController;
use lib\Request;
use lib\View;
use Service\ClientScript;
use Service\ServiceProvider;
use Service\Validator;

abstract class AbstractSiteController extends AbstractController
{
    /**
     * AbstractSiteController constructor.
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
        parent::__construct($serviceProvider, $view, $request, $validator, $clientScript, $actionName);

        $this->clientScript->addExternalJsScript('https://code.jquery.com/jquery-3.2.1.min.js');
        $this->clientScript->addExternalJsScript('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
        $this->clientScript->addExternalCssScript('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        $this->clientScript->addExternalJsScript('https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.js');
    }

}