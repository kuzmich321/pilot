<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'helpers.php');

spl_autoload_register(function ($className) {
  if (file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
    require_once(ROOT . DS . 'core' . DS . $className . '.php');
  } elseif (file_exists(ROOT . DS . 'core' . DS . 'Validators' . DS . $className . '.php')) {
    require_once(ROOT . DS . 'core' . DS . 'Validators' . DS . $className . '.php');
  } elseif (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
    require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
  } elseif (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
    require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
  }
});

session_start();

if (isset($_GET['lang']) && !empty($_GET['lang'])) {
  Session::set('lang', $_GET['lang']);

  if (Session::exists('lang') && Session::get('lang') !== $_GET['lang']) {
    echo "<script type='text/javascript'> location.reload(); </script>";
  }
}

if (Session::exists('lang')) {
  require_once 'app' . DS . 'lang' . DS . Session::get('lang') . '.php';
} else {
  require_once 'app' . DS . 'lang' . DS . 'en.php';
}

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

Router::route($url);
