<?php
class Application_Model_ObjectsMapper extends ZendExt_Db_Mapper {
  protected $_dbTableModelName = 'Application_Model_DbTable_Objects';

  public function __construct() {
    parent::__construct();
  }

  public function save(Application_Model_Objects $object) {
    $dbTable = $this->getDbTable();
    $id = $object->getId();

    if(ctype_digit($id) && $id > 0) {
      $row = $dbTable->find($id)->current();

      if(!$row) {
        $row = $dbTable->createRow();
      }

      $row->id = $object->getId();
      $row->name = $object->getName();
    } else {
      $row = $dbTable->createRow();
      $row->name = $object->getName();
    }

    if($row->save()) {
      if(null == $id) {
        $id = $dbTable->getAdapter()->lastInsertId();
        $object->setId($id);
      }
    } else {
      throw new Zend_Exception('Could not save object data!');
    }
  }

  public function find($id, Application_Model_Objects $object) {
    $dbTable = $this->getDbTable();
    $rowSet = $dbTable->find($id);

    if(count($rowSet) == 1) {
      $row = $rowSet->current();

      $object->setId($row->id);
      $object->setName($row->name);
    } else {
      throw new Zend_Exception('Could not find object data!');
    }
  }

  public function fetchAll() {
    $dbTable = $this->getDbTable();
    $entries = array();

    $rowSet = $dbTable->fetchAll();

    if($rowSet) {
      foreach ($rowSet as $row) {
        $object = new Application_Model_Objects();
        $object->setId($row->id);
        $object->setName($row->name);

        $entries[] = $object;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get objects list!');
    }
  }

  public function getSynonyms($id) {
    $synonymsMapper = new Application_Model_SynonymsMapper();
    $dbTable = $synonymsMapper->getDbTable();
    $rowSet = $dbTable->fetchAll(
    $dbTable->select()->where('objects_id = ?', $id));

    if($rowSet) {
      $entries = null;
      foreach ($rowSet as $row) {
        $synonym = new Application_Model_Synonyms();
        $synonym->setId($row->id);
        $synonym->setName($row->name);

        $entries[] = $synonym;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }

  public function getVariants($id) {
    $variantsMapper = new Application_Model_VariantsMapper();
    $dbTable = $variantsMapper->getDbTable();
    $rowSet = $dbTable->fetchAll(
    $dbTable->select()->where('objects_id = ?', $id));

    if($rowSet) {
      $entries = null;
      foreach ($rowSet as $row) {
        $variant = new Application_Model_Variants();
        $variant->setId($row->id);
        $variant->setName($row->name);

        $entries[] = $variant;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }

  public function getStates($id) {
    $statesMapper = new Application_Model_StatesMapper();
    $dbTable = $statesMapper->getDbTable();
    $rowSet = $dbTable->fetchAll(
    $dbTable->select()->where('objects_id = ?', $id));

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
