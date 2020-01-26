<?php

$locator->add('response', '\NetworkPie\Bloke\Response', \NetworkPie\Bloke\ServiceLocator::INSTANCE);

$locator->add('request', '\NetworkPie\Bloke\Request', \NetworkPie\Bloke\ServiceLocator::INSTANCE);

$locator->add('routeParser', '\NetworkPie\Bloke\RouteParser');

$locator->add('router', function($locator) {
    return new \NetworkPie\Bloke\Router($locator->request, $locator->routeParser);
}, \NetworkPie\Bloke\ServiceLocator::INSTANCE);

$locator->add('session', '', \NetworkPie\Bloke\ServiceLocator::INSTANCE);

$locator->add('view', function($locator) {
    return new \NetworkPie\Bloke\View(SRC_DIR . 'NetworkPie/Bloke/View');
});
