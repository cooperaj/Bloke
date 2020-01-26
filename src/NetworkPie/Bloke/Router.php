<?php namespace NetworkPie\Bloke;

use NetworkPie\Bloke\Exception\RoutingException;

class Router
{
    private $_request;
    private $_routeParser;

    private $_routes;

    public function __construct(Request $request, RouteParser $routeParser)
    {
        $this->_request = $request;
        $this->_routeParser = $routeParser;

        $this->_routes = [Request::GET_METHOD => [], Request::POST_METHOD => []];
    }

    public function get($url, array $options)
    {
        $this->add($url, $options, [Request::GET_METHOD]);
    }

    public function post($url, array $options)
    {
        $this->add($url, $options, [Request::POST_METHOD]);
    }

    public function any($url, array $options)
    {
        $this->add($url, $options, [Request::GET_METHOD, Request::POST_METHOD]);
    }

    public function add($url, array $options, array $methods)
    {
        $regex = $this->_routeParser->parse($url);

        foreach($methods as $method) {
            $this->_routes[$method][$regex] = $options;
        }
    }

    public function route()
    {
        foreach ($this->getRoutesByMethod($this->_request->_method)
                as $route => $options) {
            $matches = [];
            $found = preg_match($route, $this->_request->_url, $matches);

            if ($found === 1) {
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $this->_request->$key = $value;
                    }
                }

                return $options;
            }
        }

        throw new RoutingException(
            'No route found for url ' . $this->_request->_url,
            404
        );
    }

    protected function getRoutesByMethod($method)
    {
        if ( ! array_key_exists($method, $this->_routes))
            throw new RoutingException(
                'Cannot route to method ' . $method,
                500
            );

        $possibleRoutes = $this->_routes[$this->_request->_method];

        if (count($possibleRoutes) == 0)
            throw new RoutingException(
                'No routes defined for method' . $this->_request->method,
                500
            );

        return $possibleRoutes;
    }
}
