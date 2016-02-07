<?php
class Application_Model_Actions extends ZendExt_Db_Model {
  protected $_id;
  protected $_name;
  protected $_relations_id;

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

  public function setRelationsId($relations_id) {
    $this->_relations_id = (integer) $relations_id;
  }

  public function getRelationsId() {
    return $this->_relations_id;
  }
}
