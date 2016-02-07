<?php
class ZendExt_Db_Mapper {
  protected $_dbTable;
  protected $_dbTableModelName;

  public function __construct() {
    if(null != $this->_dbTableModelName) {
      $this->setDbTable($this->_dbTableModelName);
    } else {
      throw new Exception('Invalid table data gateway provided');
    }
  }

  public function setDbTable($dbTable) {
    if(is_string($dbTable)) {
      $dbTable = new $dbTable();
    }

    if(!$dbTable instanceof Zend_Db_Table_Abstract) {
      throw new Exception('Invalid table data gateway provided');
    }

    $this->_dbTable = $dbTable;

    return $this;
  }

  public function getDbTable() {
    if(null === $this->_dbTable) {
      $this->setDbTable($this->dbTableModelName);
    }

    return $this->_dbTable;
  }

  public function delete($id) {

    $dbTable = $this->getDbTable();
    $rowset = $dbTable->find($id);
    echo var_dump($rowset);
    if(count($rowset) == 1):
      $rowset->current()->delete();
    else:
      throw new Zend_Exception('Could not find row to delete!');
    endif;
  }
}
