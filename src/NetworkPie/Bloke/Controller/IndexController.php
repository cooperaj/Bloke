<?php namespace NetworkPie\Bloke\Controller;

use NetworkPie\Bloke\Controller;

class IndexController extends Controller
{

    public function index()
    {
        return $this->locator->view->render('Index/index');
    }

}
