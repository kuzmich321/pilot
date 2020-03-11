<?php

class View
{
  protected $siteTitle = SITE_TITLE, $layout = DEFAULT_LAYOUT, $content = [], $currentBuffer;

  public function render($viewName)
  {
    $viewArray = explode('/', $viewName);
    $viewString = implode(DS, $viewArray);
    if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
      include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
      include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->layout . '.php');
    } else {
      die("The view {$viewName} does not exist");
    }
  }

  public function content($type)
  {
    return array_key_exists($type, $this->content) ? $this->content[$type] : false;
  }

  public function start($type)
  {
    if (empty($type)) die('You must define a type');
    $this->currentBuffer = $type;
    ob_start();
  }

  public function end()
  {
    if (empty($this->currentBuffer)) die('You must first start the start method');
    $this->content[$this->currentBuffer] = ob_get_clean();
    $this->currentBuffer = null;
  }

  public function getSiteTitle()
  {
    return $this->siteTitle;
  }

  public function setSiteTitle($title)
  {
    $this->siteTitle = $title;
  }

  public function setLayout($path)
  {
    $this->layout = $path;
  }
}
