<?php
class Application_Model_DbTable_Variants extends Zend_Db_Table_Abstract {
  protected $_name = 'variants';
  protected $_primary = 'id';

  protected $_referenceMap = array(
    'Variants' => array(
      'columns' => array('objects_id'),
      'refTableClass' => 'Application_Model_DbTable_Objects',
      'refColumns' => array('id')
    )
  );
}
