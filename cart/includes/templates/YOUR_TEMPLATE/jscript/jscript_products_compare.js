  function compareNew(obj, action) {
    $('#compareProducts').load('ajax_compare.php', {'compare_id': obj, 'action': action});
  }