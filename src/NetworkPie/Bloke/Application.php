<?php namespace NetworkPie\Bloke;


class Application
{

    private $_locator;

    public function __construct(ServiceLocator $locator)
    {
        $this->_locator = $locator;

        //set_error_handler([$this, 'errorHandler']);
        //set_exception_handler([$this, 'exceptionHandler']);
    }

    public function make($class, array $args = [])
    {
        return $this->_locator->make($class, $args);
    }

    public function dispatch()
    {
        $router = $this->_locator->router;
        $callable_options = $router->route();

        list($action, $controller) = explode('@', $callable_options['calls']);
        $controller = $this->make(
            "\\NetworkPie\\Bloke\\Controller\\" . $controller
        );
        
        // TODO pass url parameters as function parameters.
        $content = $controller->$action();

        if ($content instanceof View)
            $content = $content->render();
        
        $response = $this->_locator->response;
        $response->setBody($content);
        
        $response->send();
    }

    public function errorHandler($errNo, $errStr, $errFile, $errLine)
    {
        $view = $this->_locator->view;

        echo $view->render('error', ['errNo' => $errNo, 'errStr' => $errStr]);
    }

    public function exceptionHandler($exception)
    {
        $view = $this->_locator->view;

        echo $view->render(
            'error',
            [
                'errNo' => $exception->getCode(),
                'errStr' => $exception->getMessage()
            ]
        );
    }
}
