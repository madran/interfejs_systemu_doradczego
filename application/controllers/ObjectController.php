<?php

class ObjectController extends Zend_Controller_Action
{

  public function init()
  {
    /* Initialize action controller here */
  }

  public function indexAction()
  {
    $objectMapper = new Application_Model_ObjectsMapper();
    $objects = $objectMapper->fetchAll();
    $this->view->objects = $objects;

    $objectForm = new Application_Form_ObjectForm();
    $this->view->objectForm = $objectForm;

    $request = $this->getRequest();
    $id = $request->getParam('id');
    $this->view->id = $id;

    if($id)
    {
      $what = $request->getParam('what');

      foreach($objects as $object) {
        if($object->getId() == $id) {
          $this->view->objectName = $object->getName();
        }
      }

      $synonymForm = new Application_Form_SynonymForm();
      //$synonymForm->setAction('/object/index/'.$id.'/synonym');
      $synonymForm->setAction($this->view->serverUrl() . $this->view->url(array('id' => $id, 'what' => 'synonym'),'object_add_sub',true));
      $variantForm = new Application_Form_VariantForm();
      // $variantForm->setAction('/object/index/'.$id.'/variant');
      $variantForm->setAction($this->view->serverUrl() . $this->view->url(array('id' => $id, 'what' => 'variant'),'object_add_sub',true));
      $stateForm = new Application_Form_StateForm();
      // $stateForm->setAction('/object/index/'.$id.'/state');
      $stateForm->setAction($this->view->serverUrl() . $this->view->url(array('id' => $id, 'what' => 'state'),'object_add_sub',true));

      $synonymForm->getElement('objectsId')->setValue($id);
      $variantForm->getElement('objectsId')->setValue($id);
      $stateForm->getElement('objectsId')->setValue($id);

      $this->view->synonymForm = $synonymForm;
      $this->view->variantForm = $variantForm;
      $this->view->stateForm = $stateForm;

      if($this->getRequest()->isPost() && $what == 'synonym'):
        if($synonymForm->isValid($request->getPost())):
          $synonym = new Application_Model_Synonyms($request->getPost());
          $synonymsMapper = new Application_Model_SynonymsMapper();
          $synonymsMapper->save($synonym);
        endif;
      endif;
      if($this->getRequest()->isPost() && $what == 'variant'):
        if($synonymForm->isValid($request->getPost())):
          $synonym = new Application_Model_Variants($request->getPost());
          $synonymsMapper = new Application_Model_VariantsMapper();
          $synonymsMapper->save($synonym);
        endif;
      endif;
      if($this->getRequest()->isPost() && $what == 'state'):
        if($synonymForm->isValid($request->getPost())):
          $synonym = new Application_Model_States($request->getPost());
          $synonymsMapper = new Application_Model_StatesMapper();
          $synonymsMapper->save($synonym);
        endif;
      endif;

      $this->view->synonyms = $objectMapper->getSynonyms($id);
      $this->view->variants = $objectMapper->getVariants($id);
      $this->view->states = $objectMapper->getStates($id);
    }

    $form = new Application_Form_ObjectForm();
    // $form->setAction('/object');
    $form->setAction($this->view->serverUrl() . $this->view->url(array(),'object',true));
    $this->view->form = $form;

    if($this->getRequest()->isPost() && !$id):
      if($form->isValid($request->getPost())):
        $object = new Application_Model_Objects($request->getPost());
        $objectMapper = new Application_Model_ObjectsMapper();
        $objectMapper->save($object);
      endif;
      $id = $objectMapper->getDbTable()->getAdapter()->lastInsertId();
      $this->_redirect('/object/index/' . $id);
    endif;
  }

  public function deleteAction() {
    $id = $this->_request->getParam('id');

    $objectMapper = new Application_Model_ObjectsMapper();
    $objectMapper->delete($id);

    $this->_redirect('/object/index');
  }
}
