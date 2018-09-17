<script>
  var compareResultDiv;

  function compare(productId, action) {
      zcJS.ajax({
          url: 'ajax.php?act=ajaxCompareProducts&method=' + action,
          data: {compare_id: productId}
      }).done(function (returnData) {
          console.log(returnData);
          $('#compareProducts').html(returnData['data']);
          $('#buttonCompareSelectProductId_' + productId).replaceWith(returnData['button']);
      });
  }
  compareResultDiv = '';
  compareResultDiv += '<div id="compareResult" class="group">' + "\n";
  compareResultDiv += '  <div class="back compareText"><strong><?php echo COMPARE_DEFAULT; ?></strong> <?php echo COMPARE_COUNT_START . COMPARE_VALUE_COUNT . COMPARE_COUNT_END; ?></div>' + "\n";
  compareResultDiv += '    <div id="compareProducts">' + "\n";
<?php if (isset($_SESSION['compareProducts']) && !empty($_SESSION['compareProducts'])) { ?>
  compareResultDiv += '      <div id="compareMainWrapper">' + "\n";
  compareResultDiv += '        <div class="compareAdded compareButton">' + "\n";
  compareResultDiv += '          <a href="index.php?main_page=compare" title="compare"><span class="cssButton" class="btn btn-primary" role="button"><?php echo COMPARE_DEFAULT; ?></span></a>' + "\n";
  compareResultDiv += '        </div>' + "\n";
  <?php
  foreach ($_SESSION['compare'] as $value) {
    $product_comp_image = $db->Execute("SELECT p.products_id, p.master_categories_id, pd.products_name, p.products_image
                                        FROM " . TABLE_PRODUCTS . " p
                                        LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id = p.products_id
                                        WHERE p.products_id = " . (int)$value);
    ?>
  compareResultDiv += '        <div class="compareAdded">' + "\n";
  compareResultDiv += '          <a href="<?php echo zen_href_link(zen_get_info_page($product_comp_image->fields['products_id']), 'cPath=' . (zen_get_generated_category_path_rev($product_comp_image->fields['master_categories_id'])) . '&products_id=' . $product_comp_image->fields['products_id']); ?>"><?php echo zen_image(DIR_WS_IMAGES . $product_comp_image->fields['products_image'], $product_comp_image->fields['products_name'], '', '35', 'class="listingProductImage"'); ?></a>' + "\n";
  compareResultDiv += '          <div>' + "\n";
  compareResultDiv += '            <button type="button" onclick="compare(\'<?php echo $product_comp_image->fields['products_id']; ?>\', \'removeProduct\')" title="remove" class="btn btn-default btn-xs"><?php echo COMPARE_REMOVE; ?></button>' + "\n";
  compareResultDiv += '          </div>' + "\n";
  compareResultDiv += '        </div>' + "\n";
  <?php } ?>
  compareResultDiv += '      </div>' + "\n";
<?php } ?>
  compareResultDiv += '    </div>' + "\n";
  compareResultDiv += '  </div>' + "\n";
  compareResultDiv += '</div>' + "\n";

$(document).ready(function(){
  $('#filter-wrapper').after(compareResultDiv);
  });
</script>