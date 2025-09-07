<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

if (empty($path)) {
    $path = 'login';
}

Routing::get('', 'DefaultController');
Routing::get('index', 'DefaultController');
Routing::get('addTask', 'DefaultController');
Routing::get('taskDetails', 'DefaultController');
Routing::get('tasks', 'DefaultController');
Routing::post('createAccount', 'DefaultController');

Routing::post('login', 'SecurityController');
Routing::post('createAccount', 'SecurityController');
Routing::post('addTask', 'TaskController');

Routing::run($path);