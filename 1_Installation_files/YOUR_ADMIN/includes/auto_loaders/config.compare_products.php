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

$autoLoadConfig[999][] = array(
  'autoType' => 'init_script',
  'loadFile' => 'init_compare_products.php'
);
