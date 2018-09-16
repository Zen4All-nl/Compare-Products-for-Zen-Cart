<?php

/**
 * zcAjaxCompareProducts.php
 * ajax call to show products selected for comparison
 *
 * @package general
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ajax_compare.php 00001 2011-01-28 5:23:52MT brit (docreativedesign.com) $
 */
class zcAjaxCompareProducts extends base {

  var $selected;
  var $compare_array;
  var $comp_images;
  var $compare_warning;
  var $comp_value_count;

// add new products selected
  public function addProduct() {
    $returndata['toApi'] = $_POST;
    $selected = $_POST['compare_id'];
    $compare_array = array();
    $compare_warning = '';
    $comp_value_count = count($_SESSION['compare']);

    include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_DEFINE_COMPARE_LANGUAGE);

    if ($comp_value_count < COMPARE_VALUE_COUNT) {
      $compare_array[] = $selected;
      foreach ($_SESSION['compare'] as $c) {
        if ($c != $selected) {
          $compare_array[] = $c;
        }
      }
      $_SESSION['compare'] = array_unique($compare_array);
    } else {
      $compare_warning = '<div id="compareWarning">' . COMPARE_WARNING_START . COMPARE_VALUE_COUNT . COMPARE_WARNING_END . '</div>';
    }
    $result = $this->getProducts($_SESSION['compare']);
    return([
      'data' => $result,
      'toApi' => $returndata['toApi']
    ]);
  }

// remove products
  public function removeProduct() {
    $returndata['toApi'] = $_POST;
    $selected = $_POST['compare_id'];
    foreach ($_SESSION['compare'] as $rValue) {
      if ($rValue != $selected) {
        $removed_compare_array[] = $rValue;
      }
      $_SESSION['compare'] = array_unique($removed_compare_array);
    }

    $result = $this->getProducts($_SESSION['compare']);
    return([
      'data' => $result,
      'toApi' => $returndata['toApi']
    ]);
  }

  private function getProducts($compareList) {
    global $db;
    $comp_images = '';
// return new value for the session
    foreach ($compareList as $value) {
      if (!empty($value)) {
        $product_comp_image = $db->Execute("SELECT p.products_id, p.master_categories_id, pd.products_name, p.products_image
                                        FROM " . TABLE_PRODUCTS . " p
                                        LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id = p.products_id
                                        WHERE p.products_id = " . (int)$value);
        $comp_images .= '<div class="compareAdded">';
        $comp_images .= '<a href="' . zen_href_link(zen_get_info_page($product_comp_image->fields['products_id']), 'cPath=' . (zen_get_generated_category_path_rev($product_comp_image->fields['master_categories_id'])) . '&products_id=' . $product_comp_image->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $product_comp_image->fields['products_image'], $product_comp_image->fields['products_name'], '', '35', 'class="listingProductImage"') . '</a>';
        $comp_images .= '<div>';
        $comp_images .= '<button type="button" onclick="compare(\'' . $product_comp_image->fields['products_id'] . '\', \'removeProduct\')" title="remove" class="btn btn-default btn-xs">' . COMPARE_REMOVE . '</button>';
        $comp_images .= '</div>';
        $comp_images .= '</div>';
      }
    }

// return HTML view of found products
    if (!empty($comp_images)) {
      $data = '<div id="compareMainWrapper"><div class="compareAdded compareButton">' . '<a href="' . zen_href_link('compare') . '" title="compare">' . '<span class="cssButton">' . COMPARE_DEFAULT . '</span></a></div>' . $comp_images . '</div>';
    }
    return $data;
  }

}
