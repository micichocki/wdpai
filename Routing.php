<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/ErrorController.php';
require_once 'src/controllers/TutorController.php';


class Router
{

  public static $routes;

  public static function get($url, $view)
  {
    self::$routes[$url] = $view;
  }

  public static function post($url, $view)
  {
    self::$routes[$url] = $view;
  }

  public static function run($url)
  {
    // try {
      $action = explode("/", $url)[0];

      if (!array_key_exists($action, self::$routes)) {
        throw new Exception("404");
      }

      $controller = self::$routes[$action];
      $object = new $controller;
      $action = $action ?: 'index';
      $object->$action();
    // } catch (Exception $e) {
    //   $errorController = new ErrorController();
    //   if ($e->getMessage() === "404") {
    //     $errorController->error404();
    //   } else if ($e->getMessage() === "401") {
    //     $errorController->error401();
    //   } else {
    //     $errorController->error();
    //   }
    // }
  }
}
