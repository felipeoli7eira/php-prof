<?php

require __DIR__ . '/bootstrap.php';


try
{
    router();
}
catch(\Exception $exception)
{
    var_dump($exception->getMessage());
}