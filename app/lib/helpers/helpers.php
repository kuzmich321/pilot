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
