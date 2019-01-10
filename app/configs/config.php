<?php

return
    $settings = array(
        'database' => array(
            'driver' => 'app\core\MySQLDriver',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'dbname' => 'message',
            'type' => 'mysql'
        ),
        'router' => array(
            'defaultController' => 'message',
            'defaultAction' => 'index',
            'defaultErrorAction' => 'error',
        ),
        'session' => array(
            'user_id' => 'id'
        ),
        'pagination' => array(
            'per_page' => 10
        ),
        'image' => array(
            'path' => 'uploads/',
            'width' => 320,
            'height' => 240
        ),
        'base_path' => 'http://message.loc/'
);

