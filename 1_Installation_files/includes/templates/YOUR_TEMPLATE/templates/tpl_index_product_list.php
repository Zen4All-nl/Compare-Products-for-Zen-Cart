<?php
/**
 * Page Template
 *
 * Loaded by main_page=index<br />
 * Displays product-listing when a particular category/subcategory is selected for browsing
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: picaflor-azul Wed Jan 13 18:44:28 2016 -0500 New in v1.5.5 $
 * @modification: added in the initial compare view 2011-01-28 5:23:52MT brit (docreativedesign.com) $
 */
?>
<div class="centerColumn" id="indexProductList">

<div id="cat-top" class="group">
<div id="cat-left" class="back">
<h1 id="productListHeading"><?php echo $current_categories_name; ?></h1>

<?php
if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS == 'true') {
// categories_image
  if ($categories_image = zen_get_categories_image($current_category_id)) {
?>
<div id="categoryImgListing" class="categoryImg"><?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT); ?></div>
<?php
  }
} // categories_image
?>
</div>

<?php
// categories_description
    if ($current_categories_description != '') {
?>
<div id="indexProductListCatDescription" class="content"><?php echo $current_categories_description;  ?></div>
<?php } // categories_description ?>
</div>

<?php if ($listing->RecordCount()) { ?>
<div id="filter-wrapper" class="group">
<?php } ?>

<?php
  $check_for_alpha = $listing_sql;
  $check_for_alpha = $db->Execute($check_for_alpha);

  if ($do_filter_list || isset($_GET['alpha_filter_id']) || ($check_for_alpha->RecordCount() > 0 && PRODUCT_LIST_ALPHA_SORTER == 'true')) {
  $form = zen_draw_form('filter', zen_href_link(FILENAME_DEFAULT), 'get') . '<label class="inputLabel">' .TEXT_SHOW . '</label>';
?>

<?php
  echo $form;
  echo zen_draw_hidden_field('main_page', FILENAME_DEFAULT);
?>
<?php
  // draw cPath if known
  if (!$getoption_set) {
    echo zen_draw_hidden_field('cPath', $cPath);
  } else {
    // draw manufacturers_id
    echo zen_draw_hidden_field($get_option_variable, $_GET[$get_option_variable]);
  }

  // draw music_genre_id
  if (isset($_GET['music_genre_id']) && $_GET['music_genre_id'] != '') echo zen_draw_hidden_field('music_genre_id', $_GET['music_genre_id']);

  // draw record_company_id
  if (isset($_GET['record_company_id']) && $_GET['record_company_id'] != '') echo zen_draw_hidden_field('record_company_id', $_GET['record_company_id']);

  // draw typefilter
  if (isset($_GET['typefilter']) && $_GET['typefilter'] != '') echo zen_draw_hidden_field('typefilter', $_GET['typefilter']);

  // draw manufacturers_id if not already done earlier
  if ($get_option_variable != 'manufacturers_id' && isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0) {
    echo zen_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);
  }

  // draw sort
  echo zen_draw_hidden_field('sort', $_GET['sort']);

  // draw filter_id (ie: category/mfg depending on $options)
  if ($do_filter_list) {
    echo zen_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'onchange="this.form.submit()"');
  }




  // draw alpha sorter
require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING_ALPHA_SORTER));
?>
</form>
<?php
  }
?>

<?php // end wrapper ?>
<?php if ($listing->RecordCount()) { ?>
</div>
<?php } ?>
<?php /* BOF Zen4All Compare Products 1 of 1 */ ?>
<div id="compareResult">
  <div class="back compareText"><strong><?php echo COMPARE_DEFAULT; ?></strong>&nbsp;<?php echo COMPARE_COUNT_START . COMPARE_VALUE_COUNT . COMPARE_COUNT_END; ?></div>
  <div id="compareProducts">
      <?php
      if (!empty($_SESSION['compare'])) {
        ?>
      <div id="compareMainWrapper">
        <div class="compareAdded compareButton">
          <a href="index.php?main_page=compare" title="compare"><span class="cssButton" class="btn btn-primary" role="button"><?php echo COMPARE_DEFAULT; ?></span></a>
        </div>
        <?php
        foreach ($_SESSION['compare'] as $value) {
          $product_comp_image = $db->Execute("SELECT p.products_id, p.master_categories_id, pd.products_name, p.products_image
                                              FROM " . TABLE_PRODUCTS . " p
                                              LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id = p.products_id
                                              WHERE p.products_id = " . (int)$value);
          ?>
          <div class="compareAdded">
            <a href="<?php echo zen_href_link(zen_get_info_page($product_comp_image->fields['products_id']), 'cPath=' . (zen_get_generated_category_path_rev($product_comp_image->fields['master_categories_id'])) . '&products_id=' . $product_comp_image->fields['products_id']); ?>"><?php echo zen_image(DIR_WS_IMAGES . $product_comp_image->fields['products_image'], $product_comp_image->fields['products_name'], '', '35', 'class="listingProductImage"'); ?></a>
            <div>
              <button type="button" onclick="compareNew('<?php echo $product_comp_image->fields['products_id']; ?>', 'removeProduct')" title="remove" class="btn btn-default btn-xs"><?php echo COMPARE_REMOVE; ?></button>
            </div>
          </div>
          <?php
        }
        ?>
      </div>
      <br class="clearBoth" />
      <?php
    }
    ?>
  </div>
</div>
<?php /* EOF Zen4All Compare Products 1 of 1 */ ?>

<?php
/**
 * require the code for listing products
 */
 require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
?>


<?php
//// bof: categories error
if ($error_categories==true) {
  // verify lost category and reset category
  $check_category = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where categories_id='" . $cPath . "'");
  if ($check_category->RecordCount() == 0) {
    $new_products_category_id = '0';
    $cPath= '';
  }
?>

<?php
$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_MISSING);

while (!$show_display_category->EOF) {
?>

<?php
  if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_FEATURED_PRODUCTS') { ?>
<?php
/**
 * display the Featured Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
  if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_SPECIALS_PRODUCTS') { ?>
<?php
/**
 * display the Special Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
  if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_NEW_PRODUCTS') { ?>
<?php
/**
 * display the New Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
  if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_UPCOMING') {
    include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
  }
?>
<?php
  $show_display_category->MoveNext();
} // !EOF
?>
<?php } //// eof: categories error ?>

<?php
//// bof: categories
$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_LISTING_BELOW);
if ($error_categories == false and $show_display_category->RecordCount() > 0) {
?>

<?php
  $show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_LISTING_BELOW);
  while (!$show_display_category->EOF) {
?>

<?php
    if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_FEATURED_PRODUCTS') { ?>
<?php
/**
 * display the Featured Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
    if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_SPECIALS_PRODUCTS') { ?>
<?php
/**
 * display the Special Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
    if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_NEW_PRODUCTS') { ?>
<?php
/**
 * display the New Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
    if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_UPCOMING') {
      include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
    }
?>
<?php
  $show_display_category->MoveNext();
  } // !EOF
?>

<?php
} //// eof: categories
?>

</div>
