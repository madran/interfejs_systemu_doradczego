<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initDoctype() {
    $doctypeHelper = new Zend_View_Helper_Doctype();
    $doctypeHelper->doctype('XHTML5');
  }

  public function _initConfig() {
    $this->bootstrap('frontcontroller');
    $controller = $this->getResource('frontcontroller');

    $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');

    $router = $controller->getRouter();
    $router->addConfig($config, 'routes');
  }
}
