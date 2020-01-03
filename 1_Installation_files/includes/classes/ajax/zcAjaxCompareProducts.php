<?php

/**
 * zcAjaxCompareProducts.php
 * ajax call to show products selected for comparison
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: zAjaxCompareProducts.php 00001 2018-09-16  Zen4All (https://zen4all.nl)
 */
class zcAjaxCompareProducts extends base {

  var $selected;
  var $compare_array;
  var $comp_images;
  var $compare_warning;
  var $comp_value_count;

// add new products selected
  public function addProduct() {
    $compareProductsArray = (isset($_SESSION['compareProducts']) ? $_SESSION['compareProducts'] : '');
    $selected = (int)$_POST['compare_id'];
    $compare_array = array();
    $compare_warning = '';
    $comp_value_count = ($compareProductsArray != '' ? count($compareProductsArray) : 0);

    include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/compare.php');

    if ($comp_value_count < COMPARE_PRODUCTS_VALUE_COUNT) {
      $compare_array[] = $selected;
      if ($compareProductsArray != '') {
        foreach ($compareProductsArray as $compareProduct) {
          if ($compareProduct != $selected) {
            $compare_array[] = $compareProduct;
          }
        }
      }
      $_SESSION['compareProducts'] = array_unique($compare_array);
    } else {
      $compare_warning = '<div id="compareWarning">' . COMPARE_WARNING_START . COMPARE_PRODUCTS_VALUE_COUNT . COMPARE_WARNING_END . '</div>';
    }
    $result = $this->getProducts($_SESSION['compareProducts']);

    $button = '<button type="button" id="buttonCompareSelectProductId_' . $selected . '" onclick="compare(\'' . $selected . '\',\'removeProduct\')"><i class="fa fa-minus"></i> ' . COMPARE_DEFAULT . '</button>';

    return([
      'data' => $result,
      'button' => $button
    ]);
  }

// remove products
  public function removeProduct() {
    $selected = (int)$_POST['compare_id'];
    $newCompareArray = [];
    if (isset($_SESSION['compareProducts']) && $_SESSION['compareProducts'] != '') {
      foreach ($_SESSION['compareProducts'] as $value) {
        if ($value != $selected) {
          $newCompareArray[] = $value;
        }
      }
    }
    if (!empty($newCompareArray)) {
      $_SESSION['compareProducts'] = $newCompareArray;
    } else {
      $_SESSION['compareProducts'] = '';
    }

    $button = '<button type="button" id="buttonCompareSelectProductId_' . $selected . '" onclick="compare(\'' . $selected . '\',\'addProduct\')"><i class="fa fa-plus"></i> ' . COMPARE_DEFAULT . '</button>';

    $result = $this->getProducts($_SESSION['compareProducts']);
    return([
      'data' => $result,
      'button' => $button
    ]);
  }

  private function getProducts($compareList) {
    global $db;
    $comp_images = '';
// return new value for the session
    if (!empty($compareList)) {
      foreach ($compareList as $value) {
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
