<?php
/**
 * Created by PhpStorm.
 * User: yuriy
 * Date: 11/14/17
 * Time: 4:59 PM
 */

namespace Controller;

class IndexController extends AbstractSiteController
{
    public function index()
    {
        $this->request->redirect('/task/list');
    }
}