<?php

class LoginController extends Controller
{
  public function index()
  {
    $this->view->render('login/index');
  }
}
