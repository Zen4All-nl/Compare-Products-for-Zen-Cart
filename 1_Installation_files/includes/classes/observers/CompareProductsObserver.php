<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CompareProductsObserver extends base {

  public function __construct()
  {
    if ((defined('COMPARE_PRODUCTS_STATUS') && COMPARE_PRODUCTS_STATUS == 'true') && (defined('COMPARE_PRODUCTS_LIST_STATUS') && COMPARE_PRODUCTS_LIST_STATUS == 'true')) {
      $this->attach($this, array('NOTIFY_PRODUCT_LISTING_END'));
    }
  }

  public function update(&$class, $eventID, $p1, &$list_box_contents, &$p3, &$p4, &$p5, &$p6, &$p7)
  {
    switch ($eventID) {
      case 'NOTIFY_PRODUCT_LISTING_END':
        global $listing;
        $rows = 0;
        foreach ($listing as $item) {
          $rows++;
          $lc_align = '';
          $lc_text = '<div id="compareSelectProductId_' . $item['products_id'] . '" class="compareSelect list-compare"><button type="button" id="buttonCompareSelectProductId_' . $item['products_id'] . '" onclick="compare(\'' . $item['products_id'] . '\',\'addProduct\')"><i class="fa fa-plus"></i> ' . COMPARE_DEFAULT . '</button></div>';
          $list_box_contents[$rows][] = array('align' => $lc_align,
            'params' => 'class="productListing-data"',
            'text' => $lc_text);
        }
        break;

      default:
        break;
    }
  }

}
