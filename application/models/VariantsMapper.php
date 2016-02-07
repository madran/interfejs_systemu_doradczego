<?php
class Application_Model_VariantsMapper extends ZendExt_Db_Mapper {
  protected $_dbTableModelName = 'Application_Model_DbTable_Variants';

  public function __construct() {
    parent::__construct();
  }

  public function save(Application_Model_Variants $variant) {
    $dbTable = $this->getDbTable();
    $id = $variant->getId();

    if(ctype_digit($id) && $id > 0) {
      $row = $dbTable->find($id)->current();

      if(!$row) {
        $row = $dbTable->createRow();
      }

      $row->id = $variant->getId();
      $row->name = $variant->getName();
      $row->objects_id = $variant->getObjectsId();
    } else {
      $row = $dbTable->createRow();

      $row->id = $variant->getId();
      $row->name = $variant->getName();
      $row->objects_id = $variant->getObjectsId();
    }

    if($row->save()) {
      if(null == $id) {
        $id = $dbTable->getAdapter()->lastInsertId();
        $variant->setId($id);
      }
    } else {
      throw new Zend_Exception('Could not save variant data!');
    }
  }

  public function find($id, Application_Model_Variants $variant) {
    $dbTable = $this->getDbTable();
    $rowSet = $variant->find($id);

    if(count($rowSet) == 1) {
      $row = $rowSet->current();

      $variant->setId($row->id);
      $variant->setName($row->name);
      $variant->setRelationsId($row->objects_id);
    } else {
      throw new Zend_Exception('Could not find variant data!');
    }
  }

  public function fetchAll() {
    $dbTable = $this->getDbTable();
    $entries = array();

    $rowSet = $dbTable->fetchAll();

    if($rowSet) {
      foreach ($rowSet as $row) {
        $variant = new Application_Model_Variants();
        $variant->setId($row->id);
        $variant->setName($row->name);
        $variant->setRelationsId($row->objects_id);

        $entries[] = $variant;
      }

      return $entries;
    } else {
      throw new Zend_Exception('Could not get actions list!');
    }
  }
}
