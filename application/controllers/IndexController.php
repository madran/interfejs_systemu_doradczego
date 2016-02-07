<?php

class IndexController extends Zend_Controller_Action
{

  public function init()
  {
    /* Initialize action controller here */
  }

  public function indexAction()
  {
    $form = new Application_Form_IndexForm();
    // $form->setAction('/index/test');
    $form->setAction($this->view->serverUrl() . $this->view->url(array(),'test',true));
    $this->view->form = $form;
  }

  public function testAction()
  {
    $objectMapper = new Application_Model_ObjectsMapper();
    $actionMapper = new Application_Model_ActionsMapper();
    $relationMapper = new Application_Model_RelationsMapper();

    $request = $this->getRequest();
    $sentence = $request->getParam('sentence');

    $objects = $objectMapper->fetchAll();
    $actions = $actionMapper->fetchAll();

    $_object_l['name'] = '';
    $_object_l['best_match'] = new Application_Model_Objects();
    $_object_l['match_value'] = 0;
    $_action['name'] = '';
    $_action['found'] = false;
    $_object_r['name'] = '';
    $_object_r['best_match'] = new Application_Model_Objects();
    $_object_r['match_value'] = 0;
    $_state = '';

    $sentence = explode(' ', $sentence);

    foreach($sentence as $word) {
      foreach($actions as $action) {
        if($word == $action->getName()) {
          $_action['name'] = $action;
          $_action['found'] = true;
        }
      }
      foreach($objects as $object) {
        $m = strlen($this->get_longest_common_subsequence($word, $object->getName()));
        $match_value = similar_text($word, $object->getName(), $percent);
        echo $match_value. ':' . round($percent) . ' - ' . $word . ' - ' . $object->getName() . '<br />';
        if($match_value > 1) {
          if($_action['found']) {
            // echo 'R - ' . $_object_r['match_value'] . '=' . $percent . '<br />';
            if($_object_r['match_value'] < $percent) {
              $_object_r['best_match'] = $object;
              $_object_r['match_value'] = $percent;
              $_object_r['name'] = $word;
            }
          } else {
            // echo 'L - ' . $_object_l['match_value'] . '=' . $percent . '<br />';
            if($_object_l['match_value'] < $percent) {
              $_object_l['best_match'] = $object;
              $_object_l['match_value'] = $percent;
              $_object_l['name'] = $word;
            }
          }
        } else {
          $synonyms = $objectMapper->getSynonyms($object->getId());
          if($synonyms) {
            for($i = 0; $i < count($synonyms); $i++) {
              if($word == $synonyms[$i]->getName()) {
                if($_action['found']) {
                  $_object_r['best_match'] = $object;
                  $_object_r['match_value'] = 100;
                  $_object_r['name'] = $word;
                } else {
                  $_object_l['best_match'] = $object;
                  $_object_l['match_value'] = 100;
                  $_object_l['name'] = $word;
                }
              }
            }
          }
        }
      }
      echo 'L - ' . $_object_l['best_match']->getName() . ' -- R - ' . $_object_r['best_match']->getName() . '<br />';
    }

    if($_object_l['match_value'] < 100 && null !== $_object_l['best_match']->getId()) {
      $variants = $objectMapper->getVariants($_object_l['best_match']->getId());
      $synonyms = $objectMapper->getSynonyms($_object_l['best_match']->getId());
      $is_variant = false;
      $is_synonym = false;
      if($variants) {
        foreach($variants as $variant) {
          if($_object_l['name'] == $variant->getName()) {
            echo 'is_variant<br />';
            $is_variant = true;
          }
        }
      }
      if($synonyms) {
        foreach($synonyms as $synonym) {
          if($_object_l['name'] == $synonym->getName()) {
            echo 'is_synonym<br />';
            $is_synonym = true;
          }
        }
      }
      if(!$is_variant && !$is_synonym) {
        $_object_l['name'] = '';
        $_object_l['best_match'] = new Application_Model_Objects();
        $_object_l['match_value'] = 0;
      }
    }
    if($_object_r['match_value'] < 100 && null !== $_object_r['best_match']->getId()) {
      $variants = $objectMapper->getVariants($_object_r['best_match']->getId());
      $synonyms = $objectMapper->getSynonyms($_object_r['best_match']->getId());
      $is_variant = false;
      $is_synonym = false;
      if($variants) {
        foreach($variants as $variant) {
          if($_object_r['name'] == $variant->getName()) {
            $is_variant = true;
          }
        }
      }
      if($synonyms) {
        foreach($synonyms as $synonym) {
          if($_object_r['name'] == $synonym->getName()) {
            echo 'is_synonym<br />';
            $is_synonym = true;
          }
        }
      }
      if(!$is_variant && !$is_synonym) {
        $_object_r['name'] = '';
        $_object_r['best_match'] = new Application_Model_Objects();
        $_object_r['match_value'] = 0;
      }
    }

    $state_exsists = false;
    if(null !== $_object_r['best_match']->getId()) {
      $states = $objectMapper->getStates($_object_r['best_match']->getId());

      if($states) {
        foreach($sentence as $word) {
          foreach($states as $state) {
            $match_value = similar_text($word, $state->getName(), $percent);
            if($percent == 100) {
              $_state = $state;
              $state_exsists = true;
            }
          }
        }
      }

      if(!$state_exsists){
        $_state = new Application_Model_States();
        $_state->setId(0);
        $_state->setName('brak');
      }
    }
    // echo $_state->getName() . '<br />';
    // echo var_dump($states);
    //
    // echo var_dump($sentence) . '<br /><br />';
    //
    // echo var_dump($_object_l) . '<br /><br />';
    // echo var_dump($_action) . '<br /><br />';
    // echo var_dump($_object_r) . '<br /><br />';
    // echo var_dump($state);
    echo '<br /><br />';
    if($_object_l['name'] == '' && $_object_r['name'] == '') {
      echo 'obrak dopasowań obiektów';
    }


    if($_object_l['name'] != '') {
      $opration = false;
      $relations = $relationMapper->findByLeft($_object_l['best_match']);
      if(is_object($_action['name']) && is_object($_object_l['best_match'])) {
        foreach($relations as $relation) {
          if($relation->getActionsId() == $_action['name']->getId() && $relation->getObjectsIdLeft() == $_object_l['best_match']->getId()) {
            echo 'lewa strona się zgadza<br />';
            $opration = true;
          }
        }
      }

      if(!$opration) {
        echo 'lewa strona się nie zgadza';
      }

      if($_object_r['name'] == '') {
        foreach($relations as $relation) {
          $obj = new Application_Model_Objects();
          $act = new Application_Model_Actions();
          $objectMapper->find($relation->getObjectsIdRight(), $obj);
          $actionMapper->find($relation->getActionsId(), $act);
          $accepted['objects'][] = $obj;
          $accepted['actions'][] = $act;
        }
        echo '<br /><br />Nie odnaleziono obiektu po prawej stronie.<br />';
        if(isset($accepted)) {
          echo 'Dozwolone obiekty:<br />';
          for($i = 0; $i < count($accepted['objects']); $i++) {
            echo $accepted['actions'][$i]->getName() . ' - ' . $accepted['objects'][$i]->getName() . '<br />';
          }
        } else {
          echo 'brak relacji z obiektem ' . $_object_l['name'];
        }
      }
    }

    $ss = false;
    if($_object_r['name'] != '') {
      $opration = false;
      $relations = $relationMapper->findByRight($_object_r['best_match']);
      if(is_object($_action['name']) && is_object($_state) && is_object($_object_r['best_match'])) {
        foreach($relations as $relation) {
          if($relation->getActionsId() == $_action['name']->getId() && $relation->getStatesId() == $_state->getId() &&
          $relation->getObjectsIdRight() == $_object_r['best_match']->getId()) {
            echo 'prawa strona się zgadza<br />';
            $opration = true;
            $ss = true;
          }
        }
      }

      if(!$opration) {
        echo 'prawa strona się nie zgadza';
      }

      if($_object_l['name'] == '') {
        foreach($relations as $relation) {
          $obj = new Application_Model_Objects();
          $act = new Application_Model_Actions();
          $objectMapper->find($relation->getObjectsIdLeft(), $obj);
          $actionMapper->find($relation->getActionsId(), $act);
          $accepted['objects'][] = $obj;
          $accepted['actions'][] = $act;
        }
        echo '<br /><br />Nie odnaleziono obiektu po lewej stronie.<br />';
        if(isset($accepted)) {
          echo 'Dozwolone obiekty:<br />';
          for($i = 0; $i < count($accepted['objects']); $i++) {
            echo $accepted['objects'][$i]->getName() . ' - ' . $accepted['actions'][$i]->getName() . '<br />';
          }
        } else {
          echo 'brak relacji z obiektem ' . $_object_r['name'];
        }
      }
    }
    if($_object_r['best_match']->getId() !== null) {
      if($_state == '' || !$ss) {
        echo '<br />Prawy obiekt nie jest w odpowiednim stanie.<br />';
        echo 'Poprawny stany to:<br />';

        $states = $objectMapper->getStates($_object_r['best_match']->getId());
        $relations = $relationMapper->findByRight($_object_r['best_match']);

        foreach($relations as $relation) {
          foreach($states as $state) {
            if($relation->getStatesId() == $state->getId()) {
              echo $state->getName();
            }
          }
        }
      }
    }


  }

  private function get_longest_common_subsequence($string_1, $string_2)
  {
    $string_1_length = strlen($string_1);
    $string_2_length = strlen($string_2);
    $return          = '';

    if ($string_1_length === 0 || $string_2_length === 0)
    {
      // No similarities
      return $return;
    }

    $longest_common_subsequence = array();

    // Initialize the CSL array to assume there are no similarities
    $longest_common_subsequence = array_fill(0, $string_1_length, array_fill(0, $string_2_length, 0));

    $largest_size = 0;

    for ($i = 0; $i < $string_1_length; $i++)
    {
      for ($j = 0; $j < $string_2_length; $j++)
      {
        // Check every combination of characters
        if ($string_1[$i] === $string_2[$j])
        {
          // These are the same in both strings
          if ($i === 0 || $j === 0)
          {
            // It's the first character, so it's clearly only 1 character long
            $longest_common_subsequence[$i][$j] = 1;
          }
          else
          {
            // It's one character longer than the string from the previous character
            $longest_common_subsequence[$i][$j] = $longest_common_subsequence[$i - 1][$j - 1] + 1;
          }

          if ($longest_common_subsequence[$i][$j] > $largest_size)
          {
            // Remember this as the largest
            $largest_size = $longest_common_subsequence[$i][$j];
            // Wipe any previous results
            $return       = '';
            // And then fall through to remember this new value
          }

          if ($longest_common_subsequence[$i][$j] === $largest_size)
          {
            // Remember the largest string(s)
            $return = substr($string_1, $i - $largest_size + 1, $largest_size);
          }
        }
        // Else, $CSL should be set to 0, which it was already initialized to
      }
    }

    // Return the list of matches
    return $return;
  }
}
