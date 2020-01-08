<?php

/**
 * Compare Products
 *
 * @copyright Portions Copyright 2003-2020 Zen Cart Development Team
 * @copyright Copyright 2020 Zen4All
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version 1.1.0
 */
$db->Execute("INSERT IGNORE INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function)
              VALUES ('Enable Product Compare on Product Featured Listing', 'COMPARE_PRODUCTS_FEATURED_STATUS', 'false', 'If true, the Compare buttons will be shown on the Product Featured Listing pages.', " . $configuration_group_id . ", 5, now(), 'zen_cfg_select_option(array(\'true\', \'false\'),'),
                     ('Enable Product Compare on Product New Listing', 'COMPARE_PRODUCTS_NEW_STATUS', 'false', 'If true, the Compare buttons will be shown on the Product New Listing pages.', " . $configuration_group_id . ", 6, now(), 'zen_cfg_select_option(array(\'true\', \'false\'),'),
                     ('Enable Product Compare on Product All Listing', 'COMPARE_PRODUCTS_ALL_STATUS', 'false', 'If true, the Compare buttons will be shown on the Product All Listing pages.', " . $configuration_group_id . ", 7, now(), 'zen_cfg_select_option(array(\'true\', \'false\'),'),
                     ('Enable Product Compare on Product Details Page', 'COMPARE_PRODUCTS_DETAIL_STATUS', 'false', 'If true, the Compare buttons will be shown on the Product Details Page.', " . $configuration_group_id . ", 8, now(), 'zen_cfg_select_option(array(\'true\', \'false\'),');");
