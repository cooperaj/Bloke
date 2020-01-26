<?php namespace NetworkPie\Bloke;


class RouteParser
{
    public function parse($route) {
        $parsedRoute = '';

        // start by spliting on the slashes
        $tokens = explode('/', trim($route, '/'));

        // parse remaining tokens for parameters
        $parameters = [];
        foreach($tokens as $token) {

            // parse out named tokens
            $token_matches = [];
            preg_match('/{(.*)}/', $token, $token_matches);
            if (count($token_matches) == 2) {
                $parsedRoute .= '/' . "(?P<${token_matches[1]}>\\w+)";
            } else {
                $parsedRoute .= '/' . $token;
            }

        }

        return "#^${parsedRoute}$#i";
    }
}
