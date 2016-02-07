<?php
class Application_Form_VariantForm extends Zend_Form {
  public function init() {
    $this->setMethod('post');

    $name = $this->createElement('text', 'name');
    $name->setLabel('Odmiana:');
    $name->addFilter('StringTrim');
    $name->addValidator('Alpha');
    $name->addValidator('NotEmpty', true);
    $name->addValidator('StringLength', false, array('max' => 100));
    $name->setRequired(true);

    $objects_id = $this->createElement('hidden', 'objectsId');

    $submit = $this->createElement('submit', 'submit');
    $submit->setIgnore('true');

    //$id = $this->createElement('hidden', 'id');

    $this->addElements(array($name, $submit, $objects_id));
  }
}
