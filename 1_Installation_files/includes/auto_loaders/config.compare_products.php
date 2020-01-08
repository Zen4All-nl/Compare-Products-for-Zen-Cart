<?php

/**
 * Compare Products
 *
 * @copyright Portions Copyright 2003-2020 Zen Cart Development Team
 * @copyright Copyright 2020 Zen4All
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version 1.1.0
 */
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
