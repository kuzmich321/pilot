<?php

class Filesystem
{
  public static function exists($path)
  {
    return file_exists($path);
  }

  public static function get($path)
  {
    return static::isFile($path) ? file_get_contents($path) : false;
  }

  public static function put($path, $contents)
  {
    return file_put_contents($path, $contents);
  }

  public static function isFile($file)
  {
    return is_file($file);
  }
}

