<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CHANGE STATUS
    </div>
    <?php $this->load('client_mgt/client_info_header', $data, false) ?>
    <div class = "row font-normal">
        <div class="col-md-12" style ="padding: 2% 0%; color:red; font-family:verdana; font-size:12px; text-align:center" id="error_message"></div>
        <?php
            echo $ui->formField('dropdown')
            ->setLabel('Status:')
            ->setSplit('col-md-4', 'col-md-4')
            ->setName('status')
            ->setId('status')
            ->setValue($status)
            ->setList(array('Pending' => 'Pending', 'Active' => 'Active', 'Suspended' => 'Suspended', 'Terminated' => 'Terminated' ))
            ->draw($show_input);
        ?>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <?php echo $ui->drawSubmit($show_input); ?>
			<a href="<?=MODULE_URL?>edit/<?php echo $id ?>" class="btn btn-default">Back</a>
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
                    $('#error_message').html(data.message);
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>
<?php endif ?>
