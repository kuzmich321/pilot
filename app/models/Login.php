<?php

class Login extends Model
{
  public $email, $password, $remember_me;

  public function validator()
  {
    $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => 'Email' . __REQUIRED]));
    $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => __PASSWORD . __REQUIRED]));
  }
}
