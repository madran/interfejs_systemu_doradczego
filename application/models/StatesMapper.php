<?php
class Application_Model_StatesMapper extends ZendExt_Db_Mapper {
  protected $_dbTableModelName = 'Application_Model_DbTable_States';

  public function __construct() {
    parent::__construct();
  }

  public function save(Application_Model_States $state) {
    $dbTable = $this->getDbTable();
    $id = $state->getId();

    if(ctype_digit($id) && $id > 0) {
      $row = $dbTable->find($id)->current();

      if(!$row) {
        $row = $dbTable->createRow();
      }

      $row->id = $state->getId();
      $row->name = $state->getName();
      $row->objects_id = $state->getObjectsId();
    } else {
      $row = $dbTable->createRow();

      $row->id = $state->getId();
      $row->name = $state->getName();
      $row->objects_id = $state->getObjectsId();
    }

    if($row->save()) {
      if(null == $id) {
        $id = $dbTable->getAdapter()->lastInsertId();
        $state->setId($id);
      }
    } else {
      throw new Zend_Exception('Could not save state data!');
    }
  }

  public function find($id, Application_Model_States $state) {
    $dbTable = $this->getDbTable();
    $rowSet = $dbTable->find($id);

    if(count($rowSet) == 1) {
      $row = $rowSet->current();

      $state->setId($row->id);
      $state->setName($row->name);
      $state->setRelationsId($row->objects_id);
    } else {
      throw new Zend_Exception('Could not find state data!');
    }
  }

  public function fetchAll() {
    $dbTable = $this->getDbTable();
    $entries = array();

    $rowSet = $dbTable->fetchAll();

    if($rowSet) {
      foreach ($rowSet as $row) {
        $state = new Application_Model_States();
        $state->setId($row->id);
        $state->setName($row->name);
        $state->setRelationsId($row->objects_id);

        $entries[] = $state;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }

  public function getObjectState($object) {
    $objectMapper = new Application_Model_ObjectsMapper();
    $objectDbTable = $objectMapper->getDbTable();
    $rowset = $objectDbTable->find($object->getId());
    $result = $rowset->current();

    $rowSet = $result->findDependentRowset('Application_Model_DbTable_States');

    if($rowSet) {
      $entries = null;
      foreach ($rowSet as $row) {
        $state = new Application_Model_States();
        $state->setId($row->id);
        $state->setName($row->name);

        $entries[] = $state;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }
}
