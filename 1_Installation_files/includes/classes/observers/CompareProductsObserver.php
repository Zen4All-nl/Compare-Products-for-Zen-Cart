<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CompareProductsObserver extends base {

  public function __construct()
  {
    if (defined('COMPARE_PRODUCTS_STATUS') && COMPARE_PRODUCTS_STATUS == 'true') {
      if (defined('COMPARE_PRODUCTS_LIST_STATUS') && COMPARE_PRODUCTS_LIST_STATUS == 'true') {
        $this->attach($this, array('NOTIFY_PRODUCT_LISTING_END'));
      }
      if (defined('COMPARE_PRODUCTS_FEATURED_STATUS') && COMPARE_PRODUCTS_FEATURED_STATUS == 'true') {
        $this->attach($this, array('NOTIFY_PRODUCTS_FEATURED_COMPARE'));
      }
      if (defined('COMPARE_PRODUCTS_NEW_STATUS') && COMPARE_PRODUCTS_NEW_STATUS == 'true') {
        $this->attach($this, array('NOTIFY_PRODUCTS_NEW_COMPARE'));
      }
      if (defined('COMPARE_PRODUCTS_ALL_STATUS') && COMPARE_PRODUCTS_ALL_STATUS == 'true') {
        $this->attach($this, array('NOTIFY_PRODUCTS_ALL_COMPARE'));
      }
      if (defined('COMPARE_PRODUCTS_DETAIL_STATUS') && COMPARE_PRODUCTS_DETAIL_STATUS == 'true') {
        $this->attach($this, array('NOTIFY_PRODUCTS_DETAIL_COMPARE'));
      }
    }
  }

  public function update(&$class, $eventID, $p1, &$p2, &$p3, &$p4, &$p5, &$p6, &$p7)
  {
    switch ($eventID) {
      case 'NOTIFY_PRODUCT_LISTING_END':
        global $listing;
        $rows = 0;
        foreach ($listing as $item) {
          $rows++;
          $lc_align = '';
          $lc_text = '<div id="compareSelectProductId_' . $item['products_id'] . '" class="compareSelect list-compare"><button type="button" id="buttonCompareSelectProductId_' . $item['products_id'] . '" onclick="compare(\'' . $item['products_id'] . '\',\'addProduct\');"><i class="fa fa-plus"></i> ' . COMPARE_DEFAULT . '</button></div>';
          $p2[$rows][] = array('align' => $lc_align,
            'params' => 'class="productListing-data"',
            'text' => $lc_text);
        }
        break;
      case 'NOTIFY_PRODUCTS_FEATURED_COMPARE':
      case 'NOTIFY_PRODUCTS_NEW_COMPARE':
      case 'NOTIFY_PRODUCTS_ALL_COMPARE':
        echo '<div id="compareSelectProductId_' . $p1->fields['products_id'] . '" class="compareSelect list-compare">';
        echo '<button type="button" id="buttonCompareSelectProductId_' . $p1->fields['products_id'] . '" onclick="compare(\'' . $p1->fields['products_id'] . '\', \'addProduct\');"><i class="fa fa-plus"></i> ' . COMPARE_DEFAULT . '</button>';
        echo '</div>';
        break;
      case 'NOTIFY_PRODUCTS_DETAIL_COMPARE':
        echo '<div id="compareSelectProductId_' . $p1 . '" class="compareSelect list-compare">';
        echo '<button type="button" id="buttonCompareSelectProductId_' . $p1 . '" onclick="compare(\'' . $p1 . '\', \'addProduct\');"><i class="fa fa-plus"></i> ' . COMPARE_DEFAULT . '</button>';
        echo '</div>';
        break;
      default:
        break;
    }
  }

}
