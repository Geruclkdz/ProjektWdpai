<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('videos', 'VideoController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('addVideo', 'VideoController');
Router::post('search', 'VideoController');
Router::post('addCategory', 'CategoryController');
Router::get('logout', 'SecurityController');
Router::get('profile', 'ProfileController');
Router::post('edit_profile', 'ProfileController');
Router::get('addCategoryToVideo', 'VideoController');
Router::get('removeCategoryFromVideo', 'VideoController');
Router::post('search', 'VideoController');
Router::post('sendForm', 'ReportController');
Router::get('viewForm', 'ReportController');

Router::run($path);