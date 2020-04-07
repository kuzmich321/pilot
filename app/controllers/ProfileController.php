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
      $this->view->user = Users::findByUsername(Session::get('username'));
      $this->view->render('profile/index');
    } else {
      Router::redirect('');
    }
  }

  public function addFile()
  {
    if ($this->request->isPost()) {
      $this->request->csrfCheck();
      $name = $_FILES['file']['name'];
      $targetDir = 'upload';
      $targetFile = $targetDir . DS .basename($_FILES['file']['name']);
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
      $extensions = ['jpg', 'jpeg', 'png', 'gif'];
      if (in_array($imageFileType, $extensions)) {
        if (currentUser()->file && Filesystem::exists($targetDir . DS . currentUser()->file)) {
          unlink(ROOT . DS . 'upload' . DS . currentUser()->file);
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $targetDir . DS .$name);
        currentUser()->update(['file' => $name]);
      } else {
        throw new Exception("Choose another file's type");
      }
    }
    Router::redirect('profile');
  }
}
