<?php
class Application_Model_ActionsMapper extends ZendExt_Db_Mapper {
  protected $_dbTableModelName = 'Application_Model_DbTable_Actions';

  public function __construct() {
    parent::__construct();
  }

  public function save(Application_Model_Actions $action) {
    $dbTable = $this->getDbTable();
    $id = $action->getId();

    if(ctype_digit($id) && $id > 0) {
      $row = $dbTable->find($id)->current();

      if(!$row) {
        $row = $dbTable->createRow();
      }

      $row->id = $action->getId();
      $row->name = $action->getName();
    } else {
      $row = $dbTable->createRow();
      $row->name = $action->getName();
    }

    if($row->save()) {
      if(null == $id) {
        $id = $dbTable->getAdapter()->lastInsertId();
        $action->setId($id);
      }
    } else {
      throw new Zend_Exception('Could not save action data!');
    }
  }

  public function find($id, Application_Model_Actions $action) {
    $dbTable = $this->getDbTable();
    $rowSet = $dbTable->find($id);

    if(count($rowSet) == 1) {
      $row = $rowSet->current();

      $action->setId($row->id);
      $action->setName($row->name);
    } else {
      throw new Zend_Exception('Could not find action data!');
    }
  }

  public function fetchAll() {
    $dbTable = $this->getDbTable();
    $entries = array();

    $rowSet = $dbTable->fetchAll();

    if($rowSet) {
      foreach ($rowSet as $row) {
        $action = new Application_Model_Actions();
        $action->setId($row->id);
        $action->setName($row->name);

        $entries[] = $action;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }
}
