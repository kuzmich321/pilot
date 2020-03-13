<?php

class Controller extends Application
{
  public $view, $request;
  protected $controller, $action;

  public function __construct($controller, $action)
  {
    parent::__construct();
    $this->controller = $controller;
    $this->action = $action;
    $this->request = new Input();
    $this->view = new View();
  }

  public function onConstruct()
  {
    //
  }
}

