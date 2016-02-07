<?php
class Application_Form_RelationForm extends Zend_Form {
  public function init() {
    $this->setMethod('post');

    $object_one = $this->createElement('select', 'objectsIdLeft');
    $object_one->setLabel('Obiekt1:');
    $object_one->setRequired(true);

    $action = $this->createElement('select', 'actionsId');
    $action->setLabel('Akcja:');
    $action->setRequired(true);

    $object_two = $this->createElement('select', 'objectsIdRight');
    $object_two->setLabel('Obiekt2:');
    $object_two->setRequired(true);

    $state = $this->createElement('select', 'statesId');
    $state->setLabel('stan');
    $state->setRequired(false);

    $submit = $this->createElement('submit', 'submit');
    $submit->setIgnore('true');

    $this->addElements(array($object_one, $action, $object_two, $state, $submit));
  }
}
