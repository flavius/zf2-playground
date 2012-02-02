<?php
chdir(dirname(__DIR__));
require_once getenv('ZF2_PATH').'/Zend/Loader/AutoloaderFactory.php';
\Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array()));

$appConfig = include 'config/application.config.php';
$listenerOptions = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
//$defaultListeners->getConfigListener()->addConfigGlobPath('config/autoload/*.config.php');

$moduleManager = new Zend\Module\Manager($appConfig['modules']);
unset($appConfig);
$moduleManager->events()->attachAggregate($defaultListeners);
//--------------------------------------------------
$cb_loadmodules_pre = function($e) {
    echo "loadModules.pre\n";
};
$cb_loadmodules_post = function($e) {
    echo "loadModules.post\n";
};
$cb_loadmodule_resolve = function($e) {
    echo "loadModule.resolve\n";
};
$cb_loadmodule= function($e) {
    echo "loadModule\n";
};
$moduleManager->events()->attach('loadModules.pre', $cb_loadmodules_pre);
$moduleManager->events()->attach('loadModules.post', $cb_loadmodules_post);
$moduleManager->events()->attach('loadModule.resolve', $cb_loadmodule_resolve);
$moduleManager->events()->attach('loadModule', $cb_loadmodule);
echo '<pre>';
//--------------------------------------------------
$moduleManager->loadModules();
$c = $defaultListeners->getConfigListener()
        ->getMergedConfig();
$bootstrap = new Zend\Mvc\Bootstrap($c);
$application = new Zend\Mvc\Application;

//--------------------------------------------------
$cb_route = function($e) {
    echo "route\n";
};
$cb_dispatch = function($e) {
    echo "dispatch\n";
};
$cb_bootstrap = function($e) {
    $app = $e->getParam('application');
    $locator = $app->getLocator();
    //begin: set up view di
    $params = array(
        'resolver' => 'Zend\View\TemplatePathStack',
        'options' => array(
            'script_paths' => array(
                'application' => __DIR__ . '/../modules/Application/views',
            ),
        ),
    );
    $im = $locator->instanceManager();
    //$im->addAlias('view', 'Zend\View\PhpRenderer', $params);
    //$im->setParameters('Zend\View\PhpRenderer', );
    //end: set up view di
    $config = $e->getParam('config');
    $view = $locator->get('view');
    $url = $view->plugin('url');
    $url->setRouter($app->getRouter());
    //TODO more preparation for default layout
    $viewListener = new Application\View\Listener($view, 'layout/layout.phtml');
    $app->events()->attachAggregate($viewListener);
    $events = Zend\EventManager\StaticEventManager::getInstance();
    $viewListener->registerStaticListeners($events, $locator);

    echo "bootstrap\n";
    //var_dump($locator);
};
$cb_dispatch_error = function($e) {
    echo "dispatch.error\n";
    //var_dump($e);
    //$e->stopPropagation();
};
$cb_finish = function($e) {
    echo "finish\n";
    var_dump($e->getParam('__RESULT__'));
};

$events = $application->events();
$events->attach('route', $cb_route);
$events->attach('dispatch', $cb_dispatch);
$events->attach('dispatch.error', $cb_dispatch_error);
$events->attach('finish', $cb_finish);
$bootstrap->events()->attach('bootstrap', $cb_bootstrap);

$bootstrap->bootstrap($application);
$r = $application->run();
echo '</pre>';
//--------------------------------------------------
//$r->send();
