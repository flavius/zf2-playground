<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController {
    public function indexAction() {
        //var_dump('app controller');
        return array('foo' => 'bar');
    }
}

