<?php

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// ----
// Initialize the plugin's observer ...
// 
$autoLoadConfig[200][] = array(
    'autoType' => 'class',
    'loadFile' => 'observers/CompareProductsObserver.php'
);
$autoLoadConfig[200][] = array(
    'autoType' => 'classInstantiate',
    'className' => 'CompareProductsObserver',
    'objectName' => 'compareProductsObserver'
);
