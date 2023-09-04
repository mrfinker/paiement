<?php

/**
 * 
 */
class Bootstrap
{
  private $_url = null;
  private $controller = null;

  private $_controllerPath = 'controllers/';
  private $_modelPath      = 'models/';
  private $_errorFile      = 'My_error.php';
  private $_defaultFile    = 'login.php';

  function __construct()
  {
    # code...
  }

  public function int()
  {
    # code...
    $this->_getUrl();
    if (empty($this->_url[0])) {
      # code...
      $this->_loadDefaultController();
      return false;
    }
    $this->_loadExistingController();
    $this->_callControllerMethod();
  }

  private function _getUrl()
  {
    # code...
    $url = isset($_GET['url']) ? $_GET['url'] : null;

    $url = rtrim(!is_null($url) ? $url : '', '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $this->_url = explode('/', $url);
  }

  public function setControllerPath($path)
  {
    # code...
    $this->_controllerPath = trim($path, '/') . '/';
  }

  public function setModelPath($path)
  {
    # code...
    $this->_modelPath = trim($path, '/') . '/';
  }

  public function setErrorFile($path)
  {
    # code...
    $this->_errorFile = trim($path, '/') . '/';
  }

  public function setDefaultFile($path)
  {
    # code...
    $this->_defaultFile = trim($path, '/');
  }

  private function _loadDefaultController()
  {
    # code...
    require  $this->_controllerPath . $this->_defaultFile;
    $this->controller = new Login();
    $this->controller->index();
  }

  private function _loadExistingController()
  {

    $file = $this->_controllerPath . $this->_url[0] . '.php';

    if (file_exists($file)) {
      require $file;
      $this->controller = new $this->_url[0];
      $this->controller->loadModel($this->_url[0], $this->_modelPath);
    } else {
      $this->_error();
      return false;
      echo $_GET['url'];
    }
  }
  
  private function _callControllerMethod()
  {
    # code...
    $length = count($this->_url);
    if ($length > 1) {
      # code...
      if (!method_exists($this->controller, $this->_url[1])) {
        // $this->controller->{$this->_url[1]}();
        $this->_error();
      }
    }
    switch ($length) {
      case 5:
        $this->controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
        break;

      case 4:
        $this->controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
        break;

      case 3:
        $this->controller->{$this->_url[1]}($this->_url[2]);
        break;
      case 2:
        //  print_r($this->_url); 
        $this->controller->{$this->_url[1]}();

        break;
      default:
        //  print_r($this->_url);
        $this->controller->index();
        break;
    }
  }

  private function _error()
  {

    require $this->_controllerPath . $this->_errorFile;
    $this->controller = new My_error();
    $this->controller->index();
    exit;
  }
}
