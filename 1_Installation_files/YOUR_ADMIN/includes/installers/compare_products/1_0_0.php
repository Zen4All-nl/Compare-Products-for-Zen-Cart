<?php

/**
 * Compare Products
 *
 * @copyright Portions Copyright 2003-2020 Zen Cart Development Team
 * @copyright Copyright 2020 Zen4All
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version 1.1.0
 */
$admin_page = 'configCompareProducts';
// delete configuration menu
$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
// add configuration menu
if (!zen_page_key_exists($admin_page)) {
  if ((int)$configuration_group_id > 0) {
    zen_register_admin_page($admin_page,
            'BOX_CONFIGURATION_COMPARE_PRODUCTS',
            'FILENAME_CONFIGURATION',
            'gID=' . $configuration_group_id,
            'configuration',
            'Y',
            $configuration_group_id);

    $messageStack->add('Enabled MODULE Configuration Menu.', 'success');
  }
}


global $sniffer;
if (!$sniffer->field_exists(TABLE_CONFIGURATION, 'COMPARE_VALUE_COUNT')) {
  $db->Execute("UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_key = 'COMPARE_PRODUCTS_VALUE_COUNT',
                    configuration_group_id = " . $configuration_group_id . ",
                    sort_order = 2
                WHERE configuration_key = 'COMPARE_VALUE_COUNT'");
}
if (!$sniffer->field_exists(TABLE_CONFIGURATION, 'COMPARE_DESCRIPTION')) {
  $db->Execute("UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_key = 'COMPARE_PRODUCTS_DESCRIPTION',
                    configuration_group_id = " . $configuration_group_id . ",
                    sort_order = 3
                WHERE configuration_key = 'COMPARE_DESCRIPTION'");
}

$db->Execute("INSERT IGNORE INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function)
              VALUES ('Enable Product Compare', 'COMAPRE_STATUS', 'false', 'If true, the Compare buttons will be shown in the shop at the selected pages (depending on the settings below).', " . $configuration_group_id . ", 1, now(), 'zen_cfg_select_option(array(\'true\', \'false\'),'),
                     ('Max Products to Compare', 'COMPARE_PRODUCTS_VALUE_COUNT', '4', 'The number of products to compare at one time.', " . $configuration_group_id . ", 2, now(), ''),
                     ('Display Product Description', 'COMPARE_PRODUCTS_DESCRIPTION', '150', 'Do you want to display the Product Description?<br /><br />0= OFF<br />150= Suggested Length, or enter the maximum number of characters to display', " . $configuration_group_id . ", 3, now(), ''),
                     ('Enable Product Compare on Product Listing', 'COMAPRE_STATUS_PRODUCT_LISTING', 'false', 'If true, the Compare buttons will be shown on the Product Listing pages.', " . $configuration_group_id . ", 4, now(), 'zen_cfg_select_option(array(\'true\', \'false\'),'),
                     ('Product Compare', 'DEFINE_COMPARE_STATUS', '1', 'Enable the Product Compare Link/Text?<br />0= Link ON, Define Text OFF<br />1= Link ON, Define Text ON<br />2= Link OFF, Define Text ON<br />3= Link OFF, Define Text OFF', '25', '84', now(), 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\'),');");
