<?php

function connect(): \PDO {

    return new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
}
