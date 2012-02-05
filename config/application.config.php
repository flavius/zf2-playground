<?php
return array(
    'modules' => array(
        'Application',
//        'Administrator',
    ),
    'module_listener_options' => array(
        'config_cache_enabled' => false,
        'cache_dir' => 'data/cache',
        'module_paths' => array(
            './modules',
            './vendor',//TODO why not work?
        ),
    )
);
