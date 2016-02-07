<?php

class ActionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $actionMapper = new Application_Model_ActionsMapper();
        $actions = $actionMapper->fetchAll();
        $this->view->actions = $actions;

        $actionForm = new Application_Form_ActionForm();
        $this->view->actionForm = $actionForm;

        $request = $this->getRequest();

        if($this->getRequest()->isPost()):
          if($actionForm->isValid($request->getPost())):
            $action = new Application_Model_Actions($request->getPost());
            $actionMapper = new Application_Model_ActionsMapper();
            $actionMapper->save($action);
          endif;
          $this->_redirect('/action');
        endif;
    }

    public function deleteAction() {
      $id = $this->_request->getParam('id');

      $actionMapper = new Application_Model_ActionsMapper();
      $actionMapper->delete($id);

      $this->_redirect('/action');
    }
}
