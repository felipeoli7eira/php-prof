<?php

function controller($mathedURI, $params)
{
    $objectAndMethodOfRoute = current($mathedURI);
    [ $object, $method ] = explode('@', $objectAndMethodOfRoute);

    $controllerWithNamespaceConcat = CONTROLLERS_PATH . $object;

    if (!class_exists($controllerWithNamespaceConcat)) {
        throw new Exception('Controller not found');
    }

    if (!method_exists($controllerWithNamespaceConcat, $method)) {
        throw new Exception("Method not found in {$controllerWithNamespaceConcat} object");
    }

    $controller = new $controllerWithNamespaceConcat;
    return $controller->$method($params);
}