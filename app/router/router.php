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

function params($currentURI, $matchedURI): array
{
    if (!empty($matchedURI)) {
        $mathedToGetparams = current(array_keys($matchedURI));

        return array_diff(
            $currentURI,
            explode('/', ltrim($mathedToGetparams))
        );
    }

    return [];
}

function paramsFormat($currentURI, array $params): array
{
    $paramsData = [];

    foreach($params as $index => $param) {

        $paramsData[ $currentURI [ $index - 1 ] ] = $param;
    }

    return $paramsData;
}

function router()
{
    $currentURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $routes = routes();

    $uri = findExactUriInArrayRoutes($currentURI, $routes);

    $params = [];

    if (empty($uri)) {
        $uri = dynamicRoutesWithRegularExp($currentURI, $routes);

        $explodeCurrentURI = explode('/', ltrim($currentURI));
        $params = params($explodeCurrentURI, $uri);
        $params = paramsFormat($explodeCurrentURI, $params);
    }

    if (!empty($uri)) {
        controller($uri, $params);
        return;
    }

    throw new Exception('Erro inesperado nas rotas...');
}