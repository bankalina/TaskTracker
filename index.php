<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

if (empty($path)) {
    $path = 'login';
}

Routing::get('', 'DefaultController');
Routing::get('index', 'DefaultController');
Routing::get('addTask', 'TaskController');
Routing::get('taskDetails', 'TaskController');
Routing::get('tasks', 'TaskController');
Routing::get('createAccount', 'SecurityController');
Routing::get('login', 'SecurityController');

Routing::post('login', 'SecurityController');
Routing::post('createAccount', 'SecurityController');
Routing::post('addTask', 'TaskController');
Routing::get('logout', 'SecurityController');

Routing::run($path);