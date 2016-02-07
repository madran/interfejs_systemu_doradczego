<?php

class SynonymController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function deleteAction()
    {
      $id = $this->_request->getParam('id');

      $synonymMapper = new Application_Model_SynonymsMapper();
      $synonymMapper->delete($id);

      $this->_redirect('/object/index/' . $this->_request->getParam('object_id'));
    }
}
