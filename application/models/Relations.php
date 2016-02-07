<?php
class Application_Model_Relations extends ZendExt_Db_Model {
  private $_id;
  private $_objects_id_left;
  private $_objects_id_right;
  private $_action;
  private $_state;

  public function __construct(array $options = null) {
    parent::__construct($options);
  }

  public function setId($id) {
    $this->_id = (integer) $id;
  }

  public function getId() {
    return $this->_id;
  }

  public function setObjectsIdLeft($objects_id_left) {
    $this->_objects_id_left = (string) $objects_id_left;
  }

  public function getObjectsIdLeft() {
    return $this->_objects_id_left;
  }

  public function setObjectsIdRight($objects_id_right) {
    $this->_objects_id_right = (string) $objects_id_right;
  }

  public function getObjectsIdRight() {
    return $this->_objects_id_right;
  }

  public function setActionsId($action) {
    $this->_action = (string) $action;
  }

  public function getActionsId() {
    return $this->_action;
  }

  public function setStatesId($state) {
    $this->_state = (string) $state;
  }

  public function getStatesId() {
    return $this->_state;
  }
}
