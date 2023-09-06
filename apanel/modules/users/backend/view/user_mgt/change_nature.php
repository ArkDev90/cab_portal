<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		USER PROFILE : CHANGE NATURE OF OPERATION
	</div>
	<div id = "update">
		<div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
			<?php
				echo $ui->formField('text')
				->setLabel('Member Name:')
				->setSplit('col-md-4', 'col-md-4')
				->setName('name')
				->setId('name')
				->setValue($lastname.', '.$firstname.' '.$middlename)
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
				<button id = "change" type = "submit" class = "btn btn-sm btn-primary">CHANGE NATURE</button>
			</div>
		</div>
	</div>
</div>
</form>
<script>
	$( document ).ready(function() {
		var ajax = {}
		ajax.username = '<?= $user_name ?>';
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