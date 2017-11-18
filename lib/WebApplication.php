<?php
/**
 * Created by PhpStorm.
 * User: yuriy
 * Date: 11/14/17
 * Time: 3:34 PM
 */

namespace lib;


use config\Constants;

class WebApplication
{
    public function run()
    {
        try {
            $request = new Request();
            $route = new Route($request);
            $controller = $route->getController();
            $controller->runAction();
        } catch (\Throwable $e) {
            if (Constants::DEBUG_MODE) {
                throw $e;
            } else {

            }
        }
    }
}