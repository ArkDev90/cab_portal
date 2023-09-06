<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		USER PROFILE : DELETE
	</div>
	<div id = "delete">
		<div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('Member Name:')
				->setSplit('col-md-4', 'col-md-4')
				->setName('name')
				->setId('name')
				->setValue($lname.', '.$fname.' '.$mname)
				->draw(false);
			?>
		</div>
		<div class = "row font-normal" style = "padding: 0% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('User Level:')
				->setSplit('col-md-4', 'col-md-4')
				->setName('prev_user_type')
				->setId('prev_user_type')
				->setValue($user_type)
				->draw(false);
			?>
		</div>
		<div class = "row font-normal" style = "padding: 0% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('Email:')
				->setSplit('col-md-4', 'col-md-4')
				->setName('email')
				->setId('email')
				->setValue($email)
				->draw(false);
			?>
		</div>
		<div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
			<?php
				echo $ui->formField('dropdown')
				->setLabel('Air Type:')
				->setSplit('col-md-4', 'col-md-4')
				->setName('air_type')
				->setId('air_type')
				->setList($air_type)
				->draw($show_input);
			?>
		</div>
		<div class = "row">
			<div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
				<button id = "change" type = "button" class = "btn btn-sm btn-primary">DELETE</button>
			</div>
		</div>
	</div>
	<div id = "confirm">
		<div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('Member Name:')
				->setSplit('col-md-4', 'col-md-4')
				->setValue($lname.', '.$fname.' '.$mname)
				->draw(false);
			?>
		</div>
		<div class = "row font-normal" style = "padding: 0% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('User Level:')
				->setSplit('col-md-4', 'col-md-4')
				->setValue($user_type)
				->draw(false);
			?>
		</div>
		<div class = "row font-normal" style = "padding: 0% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('Email:')
				->setSplit('col-md-4', 'col-md-4')
				->setValue($email)
				->draw(false);
			?>
		</div>
		<div class = "row">
			<div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
				<button id = "back" type = "button" class = "btn btn-sm btn-default">BACK</button>
				<button type = "submit" class = "btn btn-sm btn-primary">CONFIRM</button>
			</div>
		</div>
	</div>
</div>
</form>
<script>
	$( document ).ready(function() {
		$('#confirm').hide();
		$("#change").click(function() {
			$('#confirm').show();
			$('#delete').hide();
		});
		$("#back").click(function() {
			$('#delete').show();
			$('#confirm').hide();
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
	});
</script>