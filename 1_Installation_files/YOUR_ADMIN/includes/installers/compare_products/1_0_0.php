<?php

// use $configuration_group_id where needed
// For Admin Pages

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

/* If your checking for a field
 * global $sniffer;
 * if (!$sniffer->field_exists(TABLE_SOMETHING, 'column'))  $db->Execute("ALTER TABLE " . TABLE_SOMETHING . " ADD column varchar(32) NOT NULL DEFAULT 'both';");
 */
/*
 * For adding a configuration value
 */
$db->Execute("INSERT IGNORE INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function)
VALUES ('Enable Product Compare', 'COMAPRE_STATUS', 'false', 'If true, the Compare buttons will be shown in the shop at the selected pages (depending on the settings below).', '19', '1', now(), 'zen_cfg_select_option(array(\'true\', \'false\'),'),
       ('Max Products to Compare', 'COMPARE_VALUE_COUNT', '4', 'The number of products to compare at one time.', '19', '2', now(), ''),
       ('Max Products to Compare', 'COMPARE_DESCRIPTION', '150', 'How many characters max to show of the products description.', '19', '3', now(), ''),
       ('Enable Product Compare on Product Listing', 'COMAPRE_STATUS_PRODUCT_LISTING', 'false', 'If true, the Compare buttons will be shown on the Product Listing pages.', '19', '4', now(), 'zen_cfg_select_option(array(\'true\', \'false\'),'),
       ('Product Compare', 'DEFINE_COMPARE_STATUS', '1', 'Enable the Product Compare Link/Text?<br />0= Link ON, Define Text OFF<br />1= Link ON, Define Text ON<br />2= Link OFF, Define Text ON<br />3= Link OFF, Define Text OFF', '25', '84', now(), 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\'),');");
