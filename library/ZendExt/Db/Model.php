<?php
class ZendExt_Db_Model {
  public function __construct(array $options = null) {
    if(is_array($options)) {
      $this->setOptions($options);
    }
  }

  public function __set($name, $value) {
    $method = 'set' . $name;

    if(('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception('Invalid model property');
    }

    $this->$method($value);
  }

  public function __get($name) {
    $method = 'get' . $name;

    if(('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception('Invalid model property');
    }

    return $this->$method();
  }

  public function setOptions(array $options) {
    $methods = get_class_methods($this);
    // echo var_dump($options);
    foreach($options as $key => $value) {
      $method = 'set' . ucfirst($key);
      if(in_array($method, $methods)) {
        $this->$method($value);
      }
    }

    return $this;
  }
}
