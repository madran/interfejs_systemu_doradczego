<?php

class RelationController extends Zend_Controller_Action
{

  public function init()
  {
    /* Initialize action controller here */
  }

  public function indexAction()
  {
    $relationMapper = new Application_Model_RelationsMapper();
    $relations = $relationMapper->fetchAll2();

    $this->view->relations = $relations;

    $objectMapper = new Application_Model_ObjectsMapper();
    $objects = $objectMapper->fetchAll();

    $actionMapper = new Application_Model_ActionsMapper();
    $actions = $actionMapper->fetchAll();

    $form = new Application_Form_RelationForm();
    // $form->setAction('/relation/state');
    $form->setAction($this->view->serverUrl() . $this->view->url(array(),'relation_state',true));
    $this->view->form = $form;

    $object_one = $form->getElement('objectsIdLeft');
    $object_two = $form->getElement('objectsIdRight');
    $action_e = $form->getElement('actionsId');
    $state_e = $form->getElement('statesId');

    $state_e->setAttrib('disabled', 'true');

    foreach($objects as $object) {
      $object_one->addMultiOption($object->getId(), $object->getName());
    }

    foreach($objects as $object) {
      $object_two->addMultiOption($object->getId(), $object->getName());
    }

    foreach($actions as $action) {
      $action_e->addMultiOption($action->getId(), $action->getName());
    }
  }

  public function stateAction()
  {
    $request = $this->getRequest();

    $_object_one = new Application_Model_Objects();
    $_object_two = new Application_Model_Objects();
    $_action = new Application_Model_Actions();

    $objectMapper = new Application_Model_ObjectsMapper();
    $objectMapper->find($request->getParam('objectsIdLeft'), $_object_one);
    $objectMapper->find($request->getParam('objectsIdRight'), $_object_two);

    $actionMapper = new Application_Model_ActionsMapper();
    $actionMapper->find($request->getParam('actionsId'), $_action);

    $form = new Application_Form_RelationForm();
    // $form->setAction('/relation/add');
    $form->setAction($this->view->serverUrl() . $this->view->url(array(),'relation_add',true));
    $this->view->form = $form;

    $object_one = $form->getElement('objectsIdLeft');
    $object_two = $form->getElement('objectsIdRight');
    $action_e = $form->getElement('actionsId');
    $state_e = $form->getElement('statesId');

    $object_one->addMultiOption($_object_one->getId(), $_object_one->getName());

    $object_two->addMultiOption($_object_two->getId(), $_object_two->getName());

    $action_e->addMultiOption($_action->getId(), $_action->getName());

    $stateMapper = new Application_Model_StatesMapper();
    $states = $stateMapper->getObjectState($_object_two);

    //$state_e->addMultiOption(0, 'Domyślny');
    $state_e->addMultiOption(0, 'brak');
    if(isset($states)) {
      foreach($states as $state) {
        $state_e->addMultiOption($state->getId(), $state->getName());
      }
    }
  }

  public function addAction() {
    $request = $this->getRequest();

    $form = new Application_Form_RelationForm();

    if($request->isPost()):
      $relation = new Application_Model_Relations($request->getPost());
      echo var_dump($relation);
      $relationMapper = new Application_Model_RelationsMapper();
      $relationMapper->save($relation);
      $this->_redirect('/relation');
    endif;
  }

  public function deleteAction() {
    $id = $this->_request->getParam('id');

    $relationMapper = new Application_Model_RelationsMapper();
    $relationMapper->delete($id);

    $this->_redirect('/relation');
  }
}
