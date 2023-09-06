<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		RESET USERNAME
	</div>
    <div class = "row">
        <div class = "col-md-9 col-md-offset-3 note" style = "padding: 3% 0% 0% 1%">
            Click confirm to reset password for <?php echo $lname. ', ' .$fname. ' ' .$mname. ' <b>[' .$name. ' - ' .$user_type . ' ]</b>'; ?> <br>
        </div>
    </div>
   <div class = "row font-normal" style = "padding: 2% 5% 0% 0%">
        <?php
			echo $ui->formField('text')
			->setLabel('New Username:')
			->setSplit('col-md-4', 'col-md-6')
			->setName('username')
			->setId('username')
			->draw($show_input);
			
			echo $ui->formField('hidden')
                ->setName('client_id')
                ->setValue($client_id)
                ->draw();
		?>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <?php echo $ui->drawSubmit($show_input); ?>
			<a href="<?=MODULE_URL?>" class="btn btn-default" data-toggle = "back_page">Cancel</a>
        </div>
    </div>
</div>
</form>
<?php if ($show_input): ?>
<script>
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
<?php endif ?>