<?php
class Application_Model_DbTable_Synonyms extends Zend_Db_Table_Abstract {
  protected $_name = 'synonyms';
  protected $_primary = 'id';

  protected $_referenceMap = array(
    'Synonyms' => array(
      'columns' => array('objects_id'),
      'refTableClass' => 'Application_Model_DbTable_Objects',
      'refColumns' => array('id')
    )
  );
}
