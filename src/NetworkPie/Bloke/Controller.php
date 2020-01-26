<?php namespace NetworkPie\Bloke;


abstract class Controller
{
    protected $locator;

    protected $request;
    protected $response;
    protected $view;

    public function __construct(ServiceLocator $locator)
    {
        $this->locator = $locator;

        $this->request = $this->locator->request;
        $this->response = $this->locator->response;
        $this->view = $this->locator->view;
    }

}
