<?php

class Router
{
  public static function route($url)
  {
    $controller = isset($url[0]) && $url[0] !== '' ? ucwords($url[0]) . 'Controller' : DEFAULT_CONTROLLER;
    $controllerName = $controller;
    array_shift($url);

    $action = isset($url[0]) && $url[0] !== '' ? $url[0] : 'index';
    array_shift($url);

    $queryParams = $url;

    $dispatch = new $controller($controllerName, $action);

    if (method_exists($controller, $action)) {
      call_user_func_array([$dispatch, $action], $queryParams);
    } else {
      die("That method doesn't exist in the controller {$controllerName}");
    }
  }

  public static function redirect($location)
  {
    if (!headers_sent()) {
      header('Location: ' . PROOT . $location);
      exit();
    } else {
      echo '<script type="text/javascript">';
      echo 'window.location.href="' .PROOT . $location .'";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-equiv="refresh" content="0;url=' . $location .'" />';
      echo '</noscript>';
      exit;
    }
  }
}
