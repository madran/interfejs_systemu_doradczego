<?php
class Application_Model_DbTable_Relations extends Zend_Db_Table_Abstract {
  protected $_name = 'relations';
  protected $_primary = 'id';

  protected $_referenceMap = array(
    'Objects' => array(
      'columns' => array('objects_id_left', 'objects_id_right'),
      'refTableClass' => 'Application_Model_DbTable_Objects',
      'refColumns' => array('id', 'id')
    ),
    'Actions' => array(
      'columns' => array('actions_id'),
      'refTableClass' => 'Application_Model_DbTable_Actions',
      'refColumns' => array('id')
    ),
    'States' => array(
      'columns' => array('states_id'),
      'refTableClass' => 'Application_Model_DbTable_States',
      'refColumns' => array('id')
    )
  );
}
