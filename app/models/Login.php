<?php

class Login extends Model
{
  public $email, $password;

  public function validator()
  {
    $this->runValidation(new RequiredValidator($this, ['field' => 'email', 'msg' => 'Email is required']));
    $this->runValidation(new RequiredValidator($this, ['field' => 'password', 'msg' => 'Password is required']));
  }
}
