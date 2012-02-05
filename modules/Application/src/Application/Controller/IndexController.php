<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController;
use Zend\View\Model\ViewModel;

class IndexController extends ActionController {
    public function indexAction() {
        $result = new ViewModel;
        $result->setOptions(array(
           'template' => 'index/index',
            'use_layout' => true,
        ));
        $result->setVariables(array('foo' => 'bar'));
        return $result;
    }
}

