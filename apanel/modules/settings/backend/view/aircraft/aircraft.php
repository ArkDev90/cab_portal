<form action="" method="post" class="form-horizontal">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : AIRCRAFTS
	</div>
	<div class = "row font-normal" style = "padding: 2% 5% 0% 0%">
		<?php
			echo $ui->formField('text')
			->setLabel('Name:')
			->setSplit('col-md-4', 'col-md-5')
			->setName('title')
			->setId('title')
			->setValue($title)
			->draw($show_input);
		?>
	</div>
	<div class = "row">
		<div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
		<?php 
					if (isset($task_delete)) {
						echo '<a href="#" class="btn btn-danger delete_button">Delete</a>';
					} else {
						echo $ui->drawSubmit($show_input); 
					}
				?>
			<a href="<?=MODULE_URL?>" class="btn btn-default">Cancel</a>
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
<?php else: ?>
<script>
	$('.delete_button').click(function(e) {
		e.preventDefault();
		$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', {id: <?php echo $delete_id ?>}, function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
</script>
<?php endif ?>
