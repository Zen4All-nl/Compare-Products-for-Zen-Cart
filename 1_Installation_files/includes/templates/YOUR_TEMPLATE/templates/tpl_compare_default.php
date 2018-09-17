<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_compare_default.php 2011-01-28 5:23:52MT brit (docreativedesign.com) $
 */
?>
<div class="centerColumn" id="compare">
  <h1 id="compareDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

  <div id="compareDefaultMainContent" class="content">

    <?php
    if (!empty($_SESSION['compareProducts'])) {
      // create our table rows of data
      foreach ($compareResult as $item) {

        $compName .= '<td><h1 class="productGeneral"><a href="' . zen_href_link(zen_get_info_page($item['products_id']), 'cPath=' . (zen_get_generated_category_path_rev($item['master_categories_id'])) . '&products_id=' . $item['products_id']) . '">' . $item['products_name'] . '</a></h1></td>';
        $compImage .= '<td><div class="compareImage">' . '<a href="' . zen_href_link(zen_get_info_page($item['products_id']), 'cPath=' . (zen_get_generated_category_path_rev($item['master_categories_id'])) . '&products_id=' . $item['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $item['products_image'], $item['products_name'], IMAGE_PRODUCT_LISTING_WIDTH, IMAGE_PRODUCT_LISTING_HEIGHT, 'class="listingProductImage"') . '</a>' . '</div></td>';
        $compDescription .= '<td>' . zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($item['products_id'], $_SESSION['languages_id']))), COMPARE_DESCRIPTION) . '</td>';
        $compModel .= '<td>' . $item['products_model'] . '</td>';
        $compWeight .= '<td>' . $item['products_weight'] . '</td>';
        $compQuantity .= '<td>' . $item['products_quantity'] . '</td>';
        $compPrice .= '<td>' . ((zen_has_product_attributes_values($item['products_id']) && $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price($item['products_id']) . '</td>';
        $compManufacturer .= '<td>' . $item['manufacturers_name'] . '</td>';
        $compRemove .= '<td><a href="' . zen_href_link('compare', 'removeProduct=' . $item['products_id']) . '" alt="remove">' . COMPARE_REMOVE . '</a></td>';
      }
      ?>
      <table>
        <!-- // create the display -->
        <tr><th>&nbsp;</th><?php echo $compName; ?></tr>
        <tr><th>&nbsp;</th><?php echo $compImage; ?></tr>
        <tr class="rowOdd"><th><?php echo COMPARE_PRICE; ?></th><?php echo $compPrice; ?></tr>
        <tr class="rowEven"><th><?php echo COMPARE_QUANTITY; ?></th><?php echo $compQuantity; ?></tr>
        <tr class="rowOdd"><th><?php echo COMPARE_MODEL; ?></th><?php echo $compModel; ?></tr>
        <tr class="rowEven"><th><?php echo COMPARE_WEIGHT; ?></th><?php echo $compWeight; ?></tr>
        <tr class="rowOdd"><th><?php echo COMPARE_MANUFACTURER; ?></th><?php echo $compManufacturer; ?></tr>
        <tr class="rowEven"><th><?php echo COMPARE_DESC; ?></th><?php echo $compDescription; ?></tr>
        <tr class="rowOdd"><th>&nbsp;</th><?php echo $compRemove; ?></tr>
      </table>
      <?php
    } else {
      // nothing to compare
      echo NOTHING_TO_COMPARE;
    }
    ?>
  </div>
  <?php if (DEFINE_COMPARE_STATUS >= '1' && DEFINE_COMPARE_STATUS <= '2') { ?>
<div id="productCompareNoticeContent" class="content">
<?php
/**
 * require html_define for the compare page
 */
  require($define_page);
?>
</div>
<?php } ?>
</div>