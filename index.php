<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::post('login', 'SecurityController');
Router::get('register', 'SecurityController');
Router::get('logout', 'SecurityController');
Router::get('user_credentials', 'SecurityController');
Router::get('dashboard', 'TutorController');
Router::get('profile', 'TutorController');
Router::get('tutoring', 'TutorController');
Router::get('add_participation', 'TutorController');
Router::get('delete_participation', 'TutorController');
Router::get('admin_panel', 'AdminController');


Router::run($path);
