<?php
return array(
    'layout' => 'layout/layout.phtml',
    'di' => array(
        
        'definition' => array(
            'class' => array(
                // We want to add a renderer to Zend\View\View, so we create a 
                // definition for the addRenderer() method.
                /* */
                'Zend\View\View' => array(
                    'addRenderer' => array(
                        'renderer' => array('type' => 'Zend\View\Renderer', 'required' => true)
                    )
                ),
                /* *
                'Zend\View\HelperBroker' => array(
                    'setView' => array(
                        'view' => array('type' => 'Zend\View\View', 'required' => true),
                    )
                ),/* */
            )
        ),
        
        'instance' => array(
            'alias' => array(
                'index' => 'Application\Controller\IndexController',
                //'view' => 'Zend\View\PhpRenderer',
            ),
            // Inject the plugin broker for controller plugins into
            // the action controller for use by all controllers that
            // extend it.
            /* */
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker'       => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),/* */
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),/* */

            // Set up the view layer.
            // Set the RenderingStrategy to use a Zend\View\View for its view
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'view' => 'Zend\View\View',
                )
            ),            
            // We want to inject a PhpRenderer to our view via addRenderer() that
            // we definied above
            'Zend\View\View' => array( 
                'injections' => array(
                    'Zend\View\PhpRenderer',
                )
            ),
            // Set the PhpRenderer to resolve using a TemplatePathStack and
            /// also inject the HelperBroker
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\TemplatePathStack',
                    'broker'   => 'Zend\View\HelperBroker',
               ),
            ),

            // Add our view scripts directory to the TemplatePathStack
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'application' => __DIR__ . '/../views/',
                        ),
                    ),
                ),
            ),
        ),
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
