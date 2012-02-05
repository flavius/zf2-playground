<?php
return array(
    'layout' => 'layout/layout.phtml',
    'di' => array(
        'instance' => array(
            'alias' => array(
                'admin' => 'Administrator\Controller\HomeController',
                //'view' => 'Zend\View\PhpRenderer',
            ),
            /* */
            'Zend\View\TemplatePathStack' => array(
                'parameters' => array(
                    'options' => array(
                        'script_paths' => array('administrator' => __DIR__ . '/../views'),
                    ),
                ),
            ), /* */
        )
    ),
);
