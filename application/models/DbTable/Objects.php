<?php
class Application_Model_DbTable_Objects extends Zend_Db_Table_Abstract {
  protected $_name = 'objects';
  protected $_primary = 'id';

  protected $_dependentTables = array(
    'Application_Model_DbTable_States',
    'Application_Model_DbTable_Variants',
    'Application_Model_DbTable_Synonyms',
    'Application_Model_DbTable_Relations'
  );
}
