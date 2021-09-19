<?php

function routes(): array
{
    return require __DIR__ . '/routes.php';
}

function findExactUriInArrayRoutes(string $currentURI, array $routes): array
{
    if (array_key_exists($currentURI, $routes)) {
        return [ $currentURI => $routes[ $currentURI ] ];
    }

    return [];
}

function dynamicRoutesWithRegularExp(string $currentURI, array $routes): array
{
    $arrayFilterCallback = function (string $route) use ($currentURI) {
        $pattern = str_replace('/', '\/', ltrim($route, '/'));

        return preg_match("/^{$pattern}$/", ltrim($currentURI, '/'));
    };

    return array_filter($routes, $arrayFilterCallback, ARRAY_FILTER_USE_KEY);
}

function router()
{
    $currentURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routes = routes();

    $exactUri = findExactUriInArrayRoutes($currentURI, $routes);

    if (!empty($exactUri)) {
        return $exactUri;
    }

    return dynamicRoutesWithRegularExp($currentURI, $routes);

}