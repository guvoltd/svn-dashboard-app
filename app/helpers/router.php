<?php

function dispatch($route)
{
    list($controllerName, $methodName) = explode('/', $route) + [1 => 'index'];

    $controllerClass = ucfirst($controllerName) . 'Controller';

    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        if (method_exists($controller, $methodName)) {
            $controller->$methodName();
            return;
        }
    }

    http_response_code(404);
    echo "404 Not Found - Controller or Method does not exist.";
}
