<?php
return array(
    'layout' => 'layout/layout.phtml',
    'di' => array(
        'instance' => array(
            'alias' => array(
                'index' => 'Application\Controller\IndexController',
                //'view' => 'Zend\View\PhpRenderer',
            ),
            /* */
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    //   'options' => array(
                    //       'script_paths' => array('application' => __DIR__ . '/../views'),
                    //   ),
                ),
            ),
            /* */
            'Zend\View\TemplatePathStack' => array(
                'parameters' => array(
                    'options' => array(
                        'script_paths' => array('application' => __DIR__ . '/../views'),
                    ),
                ),
            ), /* */
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
        ),
        'default' => array(
            'type' => 'Zend\Mvc\Router\Http\Segment',
            'options' => array(
                'route' => '/[:controller[/:action]]',
                'defaults' => array(
                    'controller' => 'index',
                    'action' => 'index'
                ),
                'constraints' => array(
                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]',
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]',
                ),
            )
        ),
    )
);
