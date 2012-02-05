<?php

namespace Administrator\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController {
    public function indexAction() {
        //var_dump('admin controller');
        return array('purpose' => 'home');
    }
}
