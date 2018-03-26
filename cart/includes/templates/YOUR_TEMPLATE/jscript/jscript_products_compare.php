<script type="text/javascript">
  function compareNew(obj, action) {
    $('#compareProducts').load('ajax_compare.php', {'compare_id': obj, 'action': action, 'securityToken': '<?php echo $_SESSION['securityToken']; ?>'});
  }
</script>