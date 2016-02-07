<?php
class Application_Form_IndexForm extends Zend_Form {
  public function init() {
    $this->setMethod('post');

    $name = $this->createElement('text', 'sentence');
    $name->addFilter('StringTrim');
    $name->addValidator('NotEmpty', true);
    $name->setAttrib('size', '100');
    $name->setRequired(true);

    $submit = $this->createElement('submit', 'submit');
    $submit->setIgnore('true');

    $this->addElements(array($name, $submit));
  }
}
