<?php

class Users extends Model
{
  protected static $table = 'users', $softDelete = true;
  public static $currentLoggedInUser = null;
  public $id, $username, $email, $password, $fname, $lname, $deleted = 0, $confirm, $file, $created_at;

  public function validator()
  {
    $this->runValidation(new RequiredValidator($this, ['field' => 'fname', 'msg' => __FNAME . __REQUIRED]));
    $this->runValidation(new RequiredValidator($this, ['field' => 'lname', 'msg' => __LNAME . __REQUIRED]));
    $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => 'Email' . __REQUIRED]));
    $this->runValidation(new EmailValidator($this, ['field' => 'email', 'msg' => __VALID_EMAIL]));
    $this->runValidation(new MaxValidator($this, ['field' => 'email', 'rule' => 150, 'msg' => 'Email' . __MAX . '150 ' . __CHARS]));
    $this->runValidation(new MinValidator($this, ['field' => 'username', 'rule' => 6, 'msg' => __USERNAME . __MIN . '6 ' . __CHARS]));
    $this->runValidation(new MaxValidator($this, ['field' => 'username', 'rule' => 150, 'msg' => __USERNAME . __MIN . '150 ' . __CHARS]));
    $this->runValidation(new UniqueValidator($this, ['field' => ['username', 'deleted'], 'msg' => __UNIQUE_USERNAME]));
    $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => __PASSWORD . __REQUIRED]));
    $this->runValidation(new MinValidator($this, ['field' => 'password', 'rule' => 6, 'msg' => __PASSWORD . __MIN . '6 ' . __CHARS]));
    if ($this->isNew()) {
      $this->runValidation(new MatchesValidator($this, ['field' => 'password', 'rule' => $this->confirm, 'msg' => __PASSWORD_MATCH]));
    }
  }

  public function beforeSave()
  {
    if ($this->isNew()) {
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
  }

  public static function currentUser()
  {
    if (!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
      self::$currentLoggedInUser = self::findById((int)Session::get(CURRENT_USER_SESSION_NAME));
    }
    return self::$currentLoggedInUser;
  }

  public static function findByUsername(string $username)
  {
    return self::findFirst(['conditions' => 'username = ?', 'bind' => [$username]]);
  }

  public static function findByEmail(string $email)
  {
    return self::findFirst(['conditions' => 'email = ?', 'bind' => [$email]]);
  }

  public function login()
  {
    Session::set(CURRENT_USER_SESSION_NAME, $this->id);
  }

  public function logout()
  {
    Session::delete(CURRENT_USER_SESSION_NAME);
    self::$currentLoggedInUser = null;
    return true;
  }
}
