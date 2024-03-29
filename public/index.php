<?php
chdir(dirname(__DIR__));
require_once (getenv('ZF2_PATH') ?: 'vendor/ZendFramework/library') . '/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array(
    'namespaces' => array(
        'ZFCompat' => './vendor/ZFCompat'
    )
)));

$appConfig = include 'config/application.config.php';

$listenerOptions  = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
$defaultListeners->getConfigListener()->addConfigGlobPath('config/autoload/*.config.php');

$moduleManager = new Zend\Module\Manager($appConfig['modules']);
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();

// Create application, bootstrap, and run
$conf = $defaultListeners->getConfigListener();
//echo '<pre>'; var_dump($conf->getMergedConfig(false)); echo '</pre>'; 
$bootstrap   = new Zend\Mvc\Bootstrap($conf->getMergedConfig(true));
$application = new Zend\Mvc\Application;
$bootstrap->bootstrap($application);
$application->run()->send();