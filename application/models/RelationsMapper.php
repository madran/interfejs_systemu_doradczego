<?php
class Application_Model_RelationsMapper extends ZendExt_Db_Mapper {
  protected $_dbTableModelName = 'Application_Model_DbTable_Relations';

  public function __construct() {
    parent::__construct();
  }

  public function save(Application_Model_Relations $relation) {
    $dbTable = $this->getDbTable();
    $id = $relation->getId();

    if(ctype_digit($id) && $id > 0) {
      $row = $dbTable->find($id)->current();

      if(!$row) {
        $row = $dbTable->createRow();
      }

      $row->id = $relation->getId();
      $row->objects_id_left = $relation->getObjectsIdLeft();
      $row->objects_id_right = $relation->getObjectsIdRight();
      $row->actions_id = $relation->getActionssId();
      $row->states_id = $relation->getStatesId();
    } else {
      $row = $dbTable->createRow();

      $row->id = $relation->getId();
      $row->objects_id_left = $relation->getObjectsIdLeft();
      $row->objects_id_right = $relation->getObjectsIdRight();
      $row->actions_id = $relation->getActionsId();
      $row->states_id = $relation->getStatesId();
    }

    if($row->save()) {
      if(null == $id) {
        $id = $dbTable->getAdapter()->lastInsertId();
        $relation->setId($id);
      }
    } else {
      throw new Zend_Exception('Could not save relation data!');
    }
  }

  public function find($id, Application_Model_Relations $relation) {
    $dbTable = $this->getDbTable();
    $rowSet = $relation->find($id);

    if(count($rowSet) == 1) {
      $row = $rowSet->current();

      $relation->setId($row->id);
      $relation->setObjectsIdLeft($row->objects_id_left);
      $relation->setObjectsIdRight($row->objects_id_right);
      $relation->setActionsId($row->actions_id);
      $relation->setStatesId($row->states_id);
    } else {
      throw new Zend_Exception('Could not find relation data!');
    }
  }

  public function fetchAll() {
    $dbTable = $this->getDbTable();
    $entries = array();

    $rowSet = $dbTable->fetchAll();

    if($rowSet) {
      foreach ($rowSet as $row) {
        $relation = new Application_Model_Relations();
        $relation->setId($row->id);
        $relation->setObjectsIdLeft($row->objects_id_left);
        $relation->setObjectsIdRight($row->objects_id_right);
        $relation->setActionsId($row->actions_id);
        $relation->setStatesId($row->states_id);

        $entries[] = $relation;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }

  public function fetchAll2() {
    $dbTable = $this->getDbTable();

    $sql = 'SELECT a.id, o1.name AS objects_id_l, actions.name AS action, o2.name AS objects_id_r, states.name AS state FROM (objects AS o1, objects AS o2) JOIN relations AS a ON o1.id = a.objects_id_left AND o2.id = a.objects_id_right JOIN actions ON actions.id = a.actions_id LEFT JOIN states ON states.id = a.states_id';
    $db = Zend_Db_Table::getDefaultAdapter();
    return $db->fetchAll($sql);
  }

  public function findByLeft($object) {
    $dbTable = $this->getDbTable();
    $entries = array();
    $rowSet = $dbTable->fetchAll($dbTable->select()->where('objects_id_left = ?', $object->getId()));


    if($rowSet) {
      foreach ($rowSet as $row) {
        $relation = new Application_Model_Relations();
        $relation->setId($row->id);
        $relation->setObjectsIdLeft($row->objects_id_left);
        $relation->setObjectsIdRight($row->objects_id_right);
        $relation->setActionsId($row->actions_id);
        $relation->setStatesId($row->states_id);

        $entries[] = $relation;
      }
// echo var_dump($entries);
      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }

  public function findByRight($object) {
    $dbTable = $this->getDbTable();
    $entries = array();
    $rowSet = $dbTable->fetchAll($dbTable->select()->where('objects_id_right = ?', $object->getId()));


    if($rowSet) {
      foreach ($rowSet as $row) {
        $relation = new Application_Model_Relations();
        $relation->setId($row->id);
        $relation->setObjectsIdLeft($row->objects_id_left);
        $relation->setObjectsIdRight($row->objects_id_right);
        $relation->setActionsId($row->actions_id);
        $relation->setStatesId($row->states_id);

        $entries[] = $relation;
      }
// echo var_dump($entries);
      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }
}
