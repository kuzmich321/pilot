<?php

class RegisterController extends Controller
{
  public function onConstruct()
  {
    $this->view->setLayout('default');
  }

  public function login()
  {
    $loginModel = new Login();
    if ($this->request->isPost()) {
      // form validation
      $this->request->csrfCheck();
      $loginModel->assign($_POST);
      $loginModel->validator();
      if ($loginModel->validationPassed()) {
        $user = Users::findByEmail($_POST['email']);
        if ($user && password_verify($this->request->get('password'), $user->password)) {
          $user->login();
          $_SESSION['username'] = $user->username;
          Router::redirect('profile');
        } else {
          $loginModel->addErrorMessage('email', 'There is an error with your email or password');
        }
      }
    }
    $this->view->login = $loginModel;
    $this->view->displayErrors = $loginModel->getErrorMessages();
    $this->view->render('login/index');
  }

  public function logout()
  {
    if (currentUser()) currentUser()->logout();
    Router::redirect('register/login');
  }

  public function register()
  {
    $newUser = new Users();
    if($this->request->isPost()) {
      $this->request->csrfCheck();
      $newUser->assign($_POST);
      $newUser->confirm =$this->request->get('confirm');
      if($newUser->save()){
        Router::redirect('register/login');
      }
    }
    $this->view->newUser = $newUser;
    $this->view->displayErrors = $newUser->getErrorMessages();
    $this->view->render('register/index');
  }
}
