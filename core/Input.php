<?php

class Input
{
  public static function sanitize($dirty)
  {
    return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
  }

  public static function get($input)
  {
    return isset($_POST[$input]) ? self::sanitize($_POST[$input]) : self::sanitize($_GET[$input]);
  }
}
