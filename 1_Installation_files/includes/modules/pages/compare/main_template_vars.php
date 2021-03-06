<?php

/**
 * Compare Products
 *
 * @copyright Portions Copyright 2003-2020 Zen Cart Development Team
 * @copyright Copyright 2020 Zen4All
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version 1.1.0
 */
if (isset($_SESSION['compareProducts']) && $_SESSION['compareProducts'] != '') {
  $compare_info = array();
  $result = array();
  $compareResult = array();
  $removeProduct = (int)$_GET['removeProduct'];

  if ($removeProduct > 0) {
    $removedCompareArray = array();
    foreach ($_SESSION['compareProducts'] as $compareProductId) {
      if ($compareProductId != $removeProduct) {
        $removedCompareArray[] = $compareProductId;
      }
      $_SESSION['compareProducts'] = $removedCompareArray;
    }
  }

  // loop session for products
  foreach ($_SESSION['compareProducts'] as $value) {
    $productsQuery = "SELECT p.products_id, p.products_quantity, p.products_model, p.products_image, p.products_weight, p.master_categories_id,
                             pd.products_name, pd.products_description,
                             m.manufacturers_name
                      FROM " . TABLE_PRODUCTS . " p
                      LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id
                        AND pd.language_id = " . (int)$_SESSION['languages_id'] . "
                      LEFT JOIN " . TABLE_MANUFACTURERS . " m ON p.manufacturers_id = m.manufacturers_id
                      WHERE p.products_status = 1
                      AND p.products_id = " . (int)$value;

    $products = $db->Execute($productsQuery);

    foreach ($products->fields as $key => $item) {
      $compareResult[$value][$key] = $item;
    }
  }
}

require($template->get_template_dir('tpl_compare_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_compare_default.php');
