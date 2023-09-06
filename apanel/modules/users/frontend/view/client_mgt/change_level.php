<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		USER PROFILE : CHANGE USER LEVEL
	</div>
	<div id = "update">
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
		<?php if ($user_type == 'Master Admin') { ?>
			<div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
				<?php
					echo $ui->formField('text')
					->setLabel('New User Level:')
					->setSplit('col-md-4', 'col-md-4')
					->setName('user_type')
					->setId('user_type')
					->setValue('Master Admin')
					->SetAttribute(array('readonly' => 'true'))
					->setList($user_types)
					->draw($show_input);
				?>
			</div>
		<?php  } else { ?>
			<div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
				<?php
					echo $ui->formField('dropdown')
					->setLabel('New User Level:')
					->setSplit('col-md-4', 'col-md-4')
					->setName('user_type')
					->setId('user_type')
					->setList($user_types)
					->draw($show_input);
				?>
			</div>
		<?php } ?>
		<!-- <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
			<?php
				echo $ui->formField('dropdown')
				->setLabel('Nature of Operation:')
				->setSplit('col-md-4', 'col-md-4')
				->setName('air_type')
				->setId('air_type')
				->setList($air_type)
				->draw($show_input);
			?>
		</div> -->
		<div class = "row">
			<div class="col-md-6 col-md-offset-3 box-body table-responsive" style = "padding: 2% 0% 0% 0.5%">
				<table id="operation_list" class="table table-sidepad">
					<?php
						echo $ui->loadElement('table')
								->setHeaderClass('info')
								->addHeader('LIST OF NATURE OF OPERATIONS', array('class' => 'col-md-12', 'style' => 'text-align:center'))
								->draw();
					?>
					
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
				<button id = "change" type = "submit" class = "btn btn-sm btn-primary">CHANGE LEVEL</button>
			</div>
		</div>
	</div>
	<!-- <div id = "confirm">
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
		<div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('New User Level:')
                ->setClass('outline')
				->setSplit('col-md-4', 'col-md-4')
				->setName('user_type2')
				->setId('user_type2')
				->draw($show_input);
			?>
		</div>
		<div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('Air Type:')
                ->setClass('outline')
				->setSplit('col-md-4', 'col-md-4')
				->setName('air_type2')
				->setId('air_type2')
				->draw($show_input);
			?>
		</div>
		<div class = "row">
			<div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
				<button id = "back" type = "button" class = "btn btn-sm btn-default">BACK</button>
				<button type = "submit" class = "btn btn-sm btn-primary">CONFIRM</button>
			</div>
		</div>
	</div> -->
</div>
</form>
<script>
	$( document ).ready(function() {
		// $('#confirm').hide();
		// $("#change").click(function() {
		// 	$('#confirm').show();
		// 	$('#update').hide();
		// 	$('#user_type2').val($('#user_type').val());
		// 	$('#air_type2').val($('#air_type').val());
		// 	$('#user_type2').attr('disabled', true);
		// 	$('#air_type2').attr('disabled', true);
		// });
		// $("#back").click(function() {
		// 	$('#update').show();
		// 	$('#confirm').hide();
		// });
		var ajax = {}
		ajax.id = '<?= $id ?>';
		var ajax_call = '';
		function getList() {
			if (ajax_call != '') {
				ajax_call.abort();
			}
			ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_checked_operation_list', ajax, function(data) {
				$('#operation_list tbody').html(data.table);
				if (ajax.page > data.page_limit && data.page_limit > 0) {
					ajax.page = data.page_limit;
					getList();
				}
			});
		}
		getList();

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
<!-- <style>
.outline {
    border : 0;
}

input[type="text"]:disabled , input[type="text"]:disabled:hover{
    background: white;
    cursor : default;
}
</style> -->