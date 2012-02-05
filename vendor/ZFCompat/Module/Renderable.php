<?php
namespace ZFCompat\Module;

use Zend\EventManager\StaticEventManager;
use ZFCompat\View\Listener as ViewListener;

class Renderable  {    
    protected $view;
    protected $viewListener;
    
    
    public function initializeView($e) {
        $app = $e->getParam('application');
        $config = $e->getParam('config');
        $locator = $app->getLocator();
        
        $listener = $locator->get('Zend\Mvc\View\DefaultRenderingStrategy');
        $app->events()->attachAggregate($listener);
    }
    
    public function initializeView2($e)
    {
        $app          = $e->getParam('application');
        $locator      = $app->getLocator();
        $config       = $e->getParam('config');
        $view         = $this->getView($app);
        $viewListener = $this->getViewListener($view, $config);
        $app->events()->attachAggregate($viewListener);
        $events       = StaticEventManager::getInstance();
        $viewListener->registerStaticListeners($events, $locator);
    }

    protected function getViewListener($view, $config)
    {
        if ($this->viewListener instanceof ViewListener) {
            return $this->viewListener;
        }

        $viewListener       = new ViewListener($view, $config->layout);
        $viewListener->setDisplayExceptionsFlag($config->display_exceptions);

        $this->viewListener = $viewListener;
        return $viewListener;
    }

    protected function getView($app)
    {
        if ($this->view) {
            return $this->view;
        }

        $locator = $app->getLocator();
        $view    = $locator->get('view');

        // Set up view helpers        
        $view->plugin('url')->setRouter($app->getRouter());
        $view->doctype()->setDoctype('HTML5');

        $basePath = $app->getRequest()->getBaseUrl();
        $view->plugin('basePath')->setBasePath($basePath);

        $this->view = $view;
        return $view;
    }
}
