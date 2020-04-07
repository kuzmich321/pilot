<?php

class Users extends Model
{
  protected static $table = 'users', $softDelete = true;
  public static $currentLoggedInUser = null;
  public $id, $username, $email, $password, $fname, $lname, $deleted = 0, $confirm, $file, $created_at;

  public function validator()
  {
    $this->runValidation(new RequiredValidator($this,['field'=>'fname','msg'=>'First Name is required.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'lname','msg'=>'Last Name is required.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'email','msg'=>'Email is required.']));
    $this->runValidation(new EmailValidator($this, ['field'=>'email','msg'=>'You must provide a valid email address']));
    $this->runValidation(new MaxValidator($this,['field'=>'email','rule'=>150,'msg'=>'Email must be less than 150 characters.']));
    $this->runValidation(new MinValidator($this,['field'=>'username','rule'=>6,'msg'=>'Username must be at least 6 characters.']));
    $this->runValidation(new MaxValidator($this,['field'=>'username','rule'=>150,'msg'=>'Username must be less than 150 characters.']));
    $this->runValidation(new UniqueValidator($this,['field'=>['username','deleted'],'msg'=>'That username already exists. Please choose a new one.']));
    $this->runValidation(new RequiredValidator($this,['field'=>'password','msg'=>'Password is required.']));
    $this->runValidation(new MinValidator($this,['field'=>'password','rule'=>6,'msg'=>'Password must be a minimum of 6 characters.']));
    if($this->isNew()){
      $this->runValidation(new MatchesValidator($this,['field'=>'password','rule'=>$this->confirm,'msg'=>"Your passwords do not match."]));
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
