<?php

/**
 * Compare Products
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 2011-01-28 5:23:52MT brit (docreativedesign.com) $
 */
if (!empty($_SESSION['compare'])) {
  $compare_info = array();
  $result = array();
  $action = $_GET['remove'];

  if ($action > 0) {
    $removed_compare_array = array();
    foreach ($_SESSION['compare'] as $value) {
      if ($value != $action) {
        $removed_compare_array[] = $value;
      }
      $_SESSION['compare'] = $removed_compare_array;
    }
  }

  // loop session for products
  foreach ($_SESSION['compare'] as $value) {
    if (!empty($value)) {
      $products_compare_query = "SELECT p.products_id, p.products_image, pd.products_name,
                                        p.master_categories_id, pd.products_description, p.products_price,
                                        p.products_model, p.products_weight, p.products_quantity, p.manufacturers_id
                                 FROM " . TABLE_PRODUCTS . " p
                                 LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id
                                 WHERE p.products_status = 1
                                 AND p.products_id = " . (int)$value . "
                                 AND pd.language_id = " . (int)$_SESSION['languages_id'];

      $products_compare = $db->Execute($products_compare_query);
      $products_manufacturer = $db->Execute("SELECT manufacturers_name
                                             FROM " . TABLE_MANUFACTURERS . "
                                             WHERE manufacturers_id = " . (int)$products_compare->fields['manufacturers_id']
      );
      $result[] = [
        'products_id' => $products_compare->fields['products_id'],
        'products_image' => $products_compare->fields['products_image'],
        'products_name' => $products_compare->fields['products_name'],
        'master_categories_id' => $products_compare->fields['master_categories_id'],
        'products_description' => $products_compare->fields['products_description'],
        'products_price' => $products_compare->fields['products_price'],
        'products_model' => $products_compare->fields['products_model'],
        'products_weight' => $products_compare->fields['products_weight'],
        'products_quantity' => $products_compare->fields['products_quantity'],
        'manufacturers_id' => $products_manufacturer->fields['manufacturers_id'],
        'manufacturers_name' => $products_manufacturer->fields['manufacturers_name']
      ];
    }
  }
}

require($template->get_template_dir('tpl_compare_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_compare_default.php');
