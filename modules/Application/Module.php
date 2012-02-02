<?php
namespace Application;

use Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider {
    public function getConfig() {
        $foo = 'bar';
        return array(
            'layout' => 'layout/layout.phtml',
            'di' => array(
                'instance' => array(
                    'alias' => array(
                        'index' => 'Application\Controller\IndexController',
                        'view' => 'Zend\View\PhpRenderer',
                    ),
                    /* */
                    'Zend\View\PhpRenderer' => array(
                        'parameters' => array(
                            'resolver' => 'Zend\View\TemplatePathStack',
                            'options' => array(
                                'script_paths' => array('application' => __DIR__ . '/views'),
                            ),
                        )
                    ),
                    /* */
                )
            ),
            'routes' => array(
                'home' => array(
                    'type' => 'Zend\Mvc\Router\Http\Literal',
                    'options' => array(
                        'route' => '/',
                        'defaults' => array(
                            'controller' => 'index',
                            'action' => 'index'
                        )
                    )
                )
            )
        );
    }
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
}
