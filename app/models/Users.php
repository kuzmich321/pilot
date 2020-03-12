<?php

class Users extends Model
{
  protected static $table = 'users', $softDelete = true;
  public $id, $username, $email, $password, $fname, $lname, $deleted;

  public static function findByUsername(string $username)
  {
    return self::findFirst(['conditions' => 'username = ?', 'bind' => [$username]]);
  }
}
