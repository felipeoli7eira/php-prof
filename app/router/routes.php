<?php

return [

    /** home */
    '/' => 'Home@index',

    /** create user */
    '/user/create' => 'User@create',

    /***/
    '/user/[a-z0-9]+' => 'User@index',

    /***/
    '/user/[0-9]+/' => 'User@show'

];