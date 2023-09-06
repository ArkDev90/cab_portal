<div class="panel panel-primary br-xs">
  <div class="panel-heading bb-colored text-center">
    RESET PASSWORD
  </div>
  <div class="panel-body text-center">
    <p>Click confirm to reset password for <?php echo $uname ?> <b> [ Cab User ] </b></p>
    <a href="<?php echo MODULE_URL ?>" class="btn btn-sm btn-default">CANCEL</a>
    <button type="button" id="confirm" class="btn btn-sm btn-primary">CONFIRM</button>
  </div>
</div>
<script>
  $('#confirm').click(function() {
    $.post('<?php echo MODULE_URL . "ajax/$ajax_task" ?>', { username: '<?php echo $uname ?>' }, function() {
      window.location = '<?php echo MODULE_URL ?>';
    });
  });
</script>