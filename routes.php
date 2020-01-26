<?php

$router->get('/', ['as' => 'home', 'calls' => 'index@IndexController']);

//$router->get('/login', ['as' => 'login', 'calls' => 'index@AuthController']);

//$router->get('/{user}/{repo}', ['as' => 'repo', 'calls' => 'index@RepoController']);
