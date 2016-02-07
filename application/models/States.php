<?php
class Application_Model_States extends ZendExt_Db_Model {
  protected $_id;
  protected $_name;
  protected $_objects_id;

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

  public function setObjectsId($objectsId) {
    $this->_objects_id = $objectsId;
  }

  public function getObjectsId() {
    return $this->_objects_id;
  }
}
