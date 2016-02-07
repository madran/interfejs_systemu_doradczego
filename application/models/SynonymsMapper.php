<?php
class Application_Model_SynonymsMapper extends ZendExt_Db_Mapper {
  protected $_dbTableModelName = 'Application_Model_DbTable_Synonyms';

  public function __construct() {
    parent::__construct();
  }

  public function save(Application_Model_Synonyms $synonym) {
    $dbTable = $this->getDbTable();
    $id = $synonym->getId();
    
    if(ctype_digit($id) && $id > 0) {
      $row = $dbTable->find($id)->current();

      if(!$row) {
        $row = $dbTable->createRow();
      }

      $row->id = $synonym->getId();
      $row->name = $synonym->getName();
      $row->objects_id = $synonym->getObjectsId();
    } else {
      $row = $dbTable->createRow();

      $row->name = $synonym->getName();
      $row->objects_id = $synonym->getObjectsId();
    }

    if($row->save()) {
      if(null == $id) {
        $id = $dbTable->getAdapter()->lastInsertId();
        $synonym->setId($id);
      }
    } else {
      throw new Zend_Exception('Could not save synonym data!');
    }
  }

  public function find($id, Application_Model_Synonyms $synonym) {
    $dbTable = $this->getDbTable();
    $rowSet = $dbTable->find($id);

    if(count($rowSet) == 1) {
      $row = $rowSet->current();

      $synonym->setId($row->id);
      $synonym->setName($row->name);
      $synonym->setObjectsId($row->objects_id);
    } else {
      throw new Zend_Exception('Could not find synonym data!');
    }
  }

  public function fetchAll() {
    $dbTable = $this->getDbTable();
    $entries = array();

    $rowSet = $dbTable->fetchAll();

    if($rowSet) {
      foreach ($rowSet as $row) {
        $synonym = new Application_Model_Synonyms();
        $synonym->setId($row->id);
        $synonym->setName($row->name);
        $synonym->setObjectsId($row->objects_id);

        $entries[] = $synonym;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }
}
