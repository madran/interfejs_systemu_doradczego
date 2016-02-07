<?php
class Application_Model_DbTable_States extends Zend_Db_Table_Abstract {
  protected $_name = 'states';
  protected $_primary = 'id';

  protected $_dependentTables = array(
    'Application_Model_DbTable_Relations'
  );

  protected $_referenceMap = array(
    'States' => array(
      'columns' => array('objects_id'),
      'refTableClass' => 'Application_Model_DbTable_Objects',
      'refColumns' => array('id')
    )
  );
}
