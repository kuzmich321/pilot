<?php

class ProfileController extends Controller
{
  public function onConstruct()
  {
    $this->view->setLayout('default');
  }

  public function index()
  {
    if (currentUser()) {
      $this->view->user = Users::findByUsername($_SESSION['username']);
      $this->view->render('profile/index');
    } else {
      Router::redirect('');
    }
  }
}
