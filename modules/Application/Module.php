<?php
namespace Application;

use Zend\Module\Consumer\AutoloaderProvider;
use ZFCompat\Module\Configurable;
use Zend\Module\Manager;
use Zend\EventManager\StaticEventManager;
use ZFCompat\View\Listener as ViewListener;
use ZFCompat\Module\Renderable;

class Module implements AutoloaderProvider, Configurable {
    protected $cfg = NULL;
    
    protected $view;
    protected $viewListener;

    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'initializeView'), 100);
    }
    
    public function initializeView($e) {
        $app = $e->getParam('application');
        $config = $e->getParam('config');
        $locator = $app->getLocator();
        
        $listener = $locator->get('Zend\Mvc\View\DefaultRenderingStrategy');
        $app->events()->attachAggregate($listener);
    }
    
    
    public function getConfig() {
        if($this->cfg == NULL) {
            $this->cfg = require __DIR__ . '/config/module.config.php';
        }
        return $this->cfg;
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
    
    public function setConfig($cfg) {
        $this->cfg = $cfg;
        file_put_contents(__DIR__ . '/config/module.config.php', '<?php return ' . var_export($cfg, TRUE));
    }
}
