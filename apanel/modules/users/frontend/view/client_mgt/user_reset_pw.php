<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		RESET PASSWORD
	</div>
    <div class = "row">
        <div class = "col-md-12 note" style = "padding: 3% 0% 0% 1%; text-align:center">
            Click confirm to reset password for <?php echo $lname. ', ' .$fname. ' ' .$mname. ' <b>[' .$name. ' - ' .$user_type . ' ]</b>'; ?> <br>
			<br>
			Email will be sent to <b><? echo $email; ?></b>
        </div>
    </div>
    <div class = "row">
        <?php
			echo $ui->formField('hidden')
			->setName('password')
			->setId('password')
            ->setValue('')
			->draw($show_input);
		?>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <button type = "submit" class = "btn btn-sm btn-primary">CONFIRM</button>
			<a href="<?=MODULE_URL?>" class="btn btn-sm btn-default" data-toggle = "back_page">CANCEL</a>
        </div>
    </div>
</div>
</form>
<script>
	ajax.id = '<?= $id ?>';
	$('form').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '<?=$ajax_post?>', function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>