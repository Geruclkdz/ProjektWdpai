<?php

require_once 'src/controller/DefaultController.php';
require_once 'src/controller/SecurityController.php';
require_once 'src/controller/VideoController.php';
require_once 'src/controller/CategoryController.php';
require_once 'src/controller/ProfileController.php';
require_once 'src/controller/ReportController.php';




class Router {

    public static $routes;

    public static function get($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function run ($url) {

        $urlParts = explode("/", $url);
        $action = $urlParts[0];
        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $videoId = $urlParts[1] ?? '';
        $CategoryId = $urlParts[2] ?? '';

        $object->$action($videoId, $CategoryId);
    }
}