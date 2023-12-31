<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::post('login', 'SecurityController');
Router::get('register', 'DefaultController');
Router::get('dashboard', 'DefaultController');
Router::get('profile', 'DefaultController');

Router::run($path);
