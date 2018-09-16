<script>
  function compareNew(productId, action) {
    zcJS.ajax({
      url: 'ajax.php?act=ajaxCompareProducts&method=' + action,
      data: {compare_id: productId}
    }).done(function (returnData) {
      console.log(returnData);
      $('#compareProducts').html(returnData['data']);
    });
  }
</script>