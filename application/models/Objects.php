<?php
class Application_Model_Objects extends ZendExt_Db_Model {
  private $_id;
  private $_name;

  public function __construct(array $options = null) {
    parent::__construct($options);
  }

  public function setId($id) {
    $this->_id = (integer) $id;
  }

  public function getId() {
    return $this->_id;
  }

  public function setName($name) {
    $this->_name = (string) $name;
  }

  public function getName() {
    return $this->_name;
  }
}
