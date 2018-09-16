<?php

/**
 * ajax_compare.php
 * ajax call to show products selected for comparison
 *
 * @package general
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ajax_compare.php 00001 2011-01-28 5:23:52MT brit (docreativedesign.com) $
 */
class zcAjaxCompare extends base {

  public function updateCompare() {

    global $db;
// get values
    $action = $_POST['action'];
    $selected = $_POST['compare_id'];
    $compare_array = array();
    $comp_images = '';
    $compare_warning = '';

    $comp_value_count = count($_SESSION['compare']);

// add new products selected
    if ($action == 'add') {
      if ($comp_value_count < COMPARE_VALUE_COUNT) {
        $compare_array[] = $selected;
        if (isset($_SESSION['compare'])) {
          foreach ($_SESSION['compare'] as $c) {
            if ($c != $selected) {
              $compare_array[] = $c;
            }
          }
        }
        $_SESSION['compare'] = array_unique($compare_array);
      } else {
        $compare_warning = '<div id="compareWarning">' . COMPARE_WARNING_START . COMPARE_VALUE_COUNT . COMPARE_WARNING_END . '</div>';
      }
    }

// remove products
    if ($action == 'remove') {
      foreach ($_SESSION['compare'] as $rValue) {
        if ($rValue != $selected) {
          $removed_compare_array[] = $rValue;
        }
        $_SESSION['compare'] = array_unique($removed_compare_array);
      }
    }

// return new value for the session
    foreach ($_SESSION['compare'] as $value) {
      if (!empty($value)) {
        $product_comp_image = $db->Execute("SELECT p.products_id, p.master_categories_id, pd.products_name, p.products_image
                                        FROM " . TABLE_PRODUCTS . " p
                                        LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id = p.products_id
                                        WHERE p.products_id = " . (int)$value);
    $comp_images .= '<div class="compareAdded"><a href="' . zen_href_link(zen_get_info_page($product_comp_image->fields['products_id']), 'cPath=' . (zen_get_generated_category_path_rev($product_comp_image->fields['master_categories_id'])) . '&products_id=' . $product_comp_image->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $product_comp_image->fields['products_image'], $product_comp_image->fields['products_name'], '', '35', 'class="listingProductImage"') . '</a><div>' . '<a onclick="compareNew(' . $product_comp_image->fields['products_id'] . ', \'remove\')" title="remove">' . COMPARE_REMOVE . '</a>' . '</div></div>';
  }
}

// return HTML view of found products
if (!empty($comp_images)) {
  echo '<div id="compareMainWrapper"><div class="compareAdded compareButton">' . '<a href="' . zen_href_link('compare') . '" title="compare">' . '<span class="cssButton">' . COMPARE_DEFAULT . '</span></a></div>' . $comp_images . '</div>';
}
echo '<br class="clearBoth" />';

// send back warning if more than allowed is selected
    echo $compare_warning;
  }

}
