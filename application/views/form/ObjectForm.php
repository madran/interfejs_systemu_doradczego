<?php
class Application_Form_ObjectForm extends Zend_Form {
  public function init() {
    $this->setMethod('post');

    $object = $this->createElement('text', 'object');
    $object->setLabel('Obiekt:');
    $object->addFilter('StringTrim');
    $object->addValidator('Alpha');
    $object->addValidator('NotEmpty', true)
    $object->addValidator('StringLength', false, array('max' => 100));
    $object->setRequired(true);

    $submit = $this->createElement('submit', 'submit');
    $submit->setIgnore('true');

    $id = $this->createElement('hidden', 'id');

    $this->addElements(array($object, $submit, $id));
  }
}
