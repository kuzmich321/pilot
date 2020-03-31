<?php

class Input
{
  public function isPost()
  {
    return $this->getRequestMethod() === 'POST';
  }

  public function isPut()
  {
    return $this->getRequestMethod() === 'PUT';
  }

  public function isGet()
  {
    return $this->getRequestMethod() === 'GET';
  }

  public function getRequestMethod()
  {
    return strtoupper($_SERVER['REQUEST_METHOD']);
  }

  public function get($input = false)
  {
    if (!$input) {
      $data = [];

      foreach ($_REQUEST as $field => $value) {
        $data[$field] = trim(sanitize($value));
      }

      return false;
    }

    return array_key_exists($input, $_REQUEST) ? trim(sanitize($_REQUEST[$input])) : '';
  }
}
