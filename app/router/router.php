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

function params(string $currentURI, $matchedURI): array
{
    if (!empty($matchedURI)) {
        $mathedToGetparams = current(array_keys($matchedURI));

        return array_diff(
            explode('/', ltrim($currentURI)),
            explode('/', ltrim($mathedToGetparams))
        );
    }

    return [];
}

function paramsFormat(string $currentURI, array $params): array
{
    $explodedURI = explode('/', ltrim($currentURI));

    $paramsData = [];

    foreach($params as $index => $param) {

        $paramsData[ $explodedURI [ $index - 1 ] ] = $param;
    }

    return $paramsData;
}

function router()
{
    $currentURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routes = routes();

    $uri = findExactUriInArrayRoutes($currentURI, $routes);

    if (empty($uri)) {
        $uri = dynamicRoutesWithRegularExp($currentURI, $routes);

        $params = params($currentURI, $uri);
        $params = paramsFormat($currentURI, $params);
    }

    return $uri;
}