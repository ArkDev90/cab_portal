<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		LOGIN INFORMATION
	</div>
    <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Birthday:')
            ->setSplit('col-md-3', 'col-md-4')
            ->setName('birthday')
            ->setId('birthday')
            ->setValue($birthday)
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <!-- <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('dropdown')
            ->setLabel('Security Question:')
            ->setSplit('col-md-3', 'col-md-7')
            ->setName('question_id')
            ->setId('question_id')
            ->setValue($question_id)
            ->setList(array('Who is your favorite pastime?', 'Who was your childhood hero?', 'What was your highschool mascot?' ))
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div> -->
    <!-- <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Your Answer:')
            ->setSplit('col-md-3', 'col-md-7')
            ->setName('answer')
            ->setId('answer')
            ->setValue($answer)
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div> -->
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Username:')
            ->setSplit('col-md-3', 'col-md-4')
            ->setName('username')
            ->setId('username')
            ->setValue($username)
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row note" style = "padding: 0% 3% 3% 0%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-9" >
            Min of 6 characters; A-Z, 0-9, period and underscore are only accepted.
        </div>
    </div>
    <div class = "row" style = "padding: 1% 3% 1% 3%">
        <div class = "col-md-2">
            
        </div>
        <div class = "col-md-8 reminder" style = "padding-top:1%; padding-bottom:1%">
            <center>Input password for your protection.</center>
            <div class = "col-md-3">
            </div>
            <div class = "col-md-6">
                <?php
                    echo $ui->formField('password')
                    ->setName('password')
                    ->setId('password')
                    ->setValidation('required')
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-2">
            </div>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <?php echo $ui->drawSubmit($show_input); ?>
			<a href="<?=MODULE_URL?>account_info/<?php echo $id ?>" class="btn btn-default">Cancel</a>
        </div>
    </div>
</div>
</form>
<?php if ($show_input): ?>
<script>
    var ajax_call = '';
	$('#username').on('input', function() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		var username = $(this).val();
		$('#username').closest('form').find('[type="submit"]').addClass('disabled');
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_check_username', 'username=' + username + '<?=$ajax_post?>', function(data) {
			var error_message = 'Username Already Exists';
			if (data.available) {
				var form_group = $('#username').closest('.form-group');
				if (form_group.find('p.help-block').html() == error_message) {
					form_group.removeClass('has-error').find('p.help-block').html('');
				}
			} else {
				$('#username').closest('.form-group').addClass('has-error').find('p.help-block').html(error_message);
			}
			$('#username').closest('form').find('[type="submit"]').removeClass('disabled');
		});
    });
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