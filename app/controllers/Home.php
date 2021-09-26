<?php

namespace app\controllers;

class Home
{
    public function index($params)
    {
        $users = fetchAll('user');

        return [
            'view' => 'home.php',
            'data' => ['title' => 'Home', 'users' => $users]
        ];
    }
}