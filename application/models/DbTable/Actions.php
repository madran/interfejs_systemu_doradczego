<?php
class Application_Model_DbTable_Actions extends Zend_Db_Table_Abstract {
  protected $_name = 'actions';
  protected $_primary = 'id';

  // protected $_referenceMap = array(
  //   'References' => array(
  //     'columns' => array('relations_id'),
  //     'refTableClass' => 'relations',
  //     'refColumns' => array('id')
  //   )
  // );

  protected $_dependentTables = array(
    'Application_Model_DbTable_Relations'
  );
}
