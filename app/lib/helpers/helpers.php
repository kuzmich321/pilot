<?php

function dd($data)
{
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
  die();
}

function sanitize($dirty)
{
  return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}

function currentUser()
{
  return Users::currentUser();
}

function generateToken()
{
  $token = base64_encode(openssl_random_pseudo_bytes(32));
  Session::set('csrf_token', $token);
  return $token;
}

function checkToken($token)
{
  return Session::exists('csrf_token' && Session::get('csrf_token') === $token);
}

function csrfInput()
{
  return '<input type="hidden" name="csrf_token" id="csrf_token" value="' . generateToken() . '" />';
}

function displayErrors($errors)
{
  $hasErrors = !empty($errors) ? 'has-errors' : '';
  $html = '<div class="form-errors"><ul class="' . $hasErrors . '">';
  foreach ($errors as $field => $error) {
    $html .= '<li class="red-text">' . $error . '</li>';
  }
  $html .= '</ul></div>';
  return $html;
}
