<?php

require __DIR__ . '/bootstrap.php';

try
{
    $data = router();

    if ( !isset($data['data']) ) {
        throw new Exception('O indice data não foi passado.');
    }

    if ( !array_key_exists('view', $data) ) {
        throw new Exception('view not found in return of the method...');
    }

    if ( !file_exists(VIEWS . $data['view']) || !is_file(VIEWS . $data['view']) ) {
        throw new Exception('view not found...');
    }

    $view = $data['view'];
    extract($data['data']);

    require VIEWS . 'master.php';
}
catch(\Exception $exception)
{
    var_dump($exception->getMessage());
}