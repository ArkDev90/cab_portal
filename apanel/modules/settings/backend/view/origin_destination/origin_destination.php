<style>
	table {
		border: 0px white;
	}
</style>

<form action="" method="post" class="form-horizontal">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : ORIGIN / DESTINATION
	</div>
	
    <div class = "row font-normal" style = "padding: 2% 5% 0% 0%">
<?php
			echo $ui->formField('dropdown')
			->setLabel('Type:')
			->setSplit('col-md-4', 'col-md-5')
			->setPlaceholder('All Type')
			->setList(array('1'=>'Domestic', '2'=>'International'))
			->setName('type')
			->setId('type')
			->setValue($type)
			->setValidation('required')
			->draw($show_input);
		?>
	</div>

	<?php if($ajax_task == 'ajax_edit' && $type == 'Domestic') { ?>
		<div class = "row font-normal" id = "dom" style = "padding: 2% 5% 0% 0%">
		<?php
			echo $ui->formField('dropdown')
			->setLabel('Part:')
			->setSplit('col-md-4', 'col-md-5')
			->setPlaceholder('Required for DOMESTIC')
			->setList($domestic_list)
			->setValue($part)
			->setName('domestic')
			->setId('domestic')
			->setValidation('required')
			->draw($show_input);
			
		?>
	</div>


	<?php } ?>

	<?php if($ajax_task == 'ajax_edit' && $type == 'International') { ?>
		<div class = "row font-normal" id = "inter" style = "padding: 2% 5% 0% 0%" >
		<?php
			echo $ui->formField('dropdown')
			->setLabel('Part:')
			->setSplit('col-md-4', 'col-md-5')
			->setPlaceholder('Required for INTERNATIONAL')
			->setList($international_list)
			->setValue($part)
			->setName('international')
			->setId('international')
			->draw($show_input);
		?>
	</div>

	<?php } ?>

	<div class = "row font-normal" id = "dom" style = "padding: 2% 5% 0% 0%" hidden>
		<?php
		
			echo $ui->formField('dropdown')
			->setLabel('Part:')
			->setSplit('col-md-4', 'col-md-5')
			->setPlaceholder('Required for DOMESTIC')
			->setList($domestic_list)
			->setValue($domestic_list)
			->setName('domestic')
			->setId('domestic')
			// ->setValidation('required')
			->draw($show_input);
			
		?>
	</div>



	<div class = "row font-normal" id = "inter" style = "padding: 2% 5% 0% 0%" hidden>
		<?php
			echo $ui->formField('dropdown')
			->setLabel('Part:')
			->setSplit('col-md-4', 'col-md-5')
			->setPlaceholder('Required for INTERNATIONAL')
			->setList($international_list)
			->setValue($international_list)
			->setName('international')
			->setId('international')
			// ->setValidation('required')
			->draw($show_input);
		?>
	</div>
	

    <div class = "row font-normal" style = "padding: 1% 5% 0% 0%">
        <?php
			echo $ui->formField('text')
			->setLabel('Code:')
			->setSplit('col-md-4', 'col-md-3')
			->setName('code')
			->setId('code')
			->setValue($code)
			->setValidation('required')
			->draw($show_input);
		?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 5% 0% 0%">
        <?php
			echo $ui->formField('text')
			->setLabel('Name:')
			->setSplit('col-md-4', 'col-md-5')
			->setName('title')
			->setId('title')
			->setValue($title)
			->setValidation('required')
			->draw($show_input);
		?>
    </div>
<?php 
	if($ajax_task != 'ajax_delete'){ ?>
    <div class = "row font-normal" style = "padding: 1% 5% 0% 0%">
        <div class = "col-md-4"  style = "text-align:right">
            <label>Form:</label>
        </div>
        <div class = "col-md-6">
            <div class="box-body table-responsive no-padding">
                <table border = "1" id="list" class="table table-hover table-sidepad">
                    <tbody>
						<?php 
						if($ajax_task == 'ajax_edit' || $ajax_task == 'ajax_delete'){
						foreach ($origin_list as $row): ?>
							<tr>
							<td><input id = "check" <?php echo ($row->report_form_id) ? 'checked' : '' ?> type="checkbox" name = "check[]" value="<?php echo $row->id ?>"><?php echo $row->title ?></td>
							</tr>
						<?php endforeach; }
						else{
							foreach ($origin_list as $row): ?>
								<tr>
								<td><input id = "check" type="checkbox" name = "check[]" value="<?php echo $row->id ?>"><?php echo $row->title ?></td>
								</tr>
						<?php endforeach; } ?>
					
                    </tbody>
                </table>
            </div>
        </div>
	</div><?php } ?>
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

<?php if($ajax_task == 'ajax_edit' && $type == 'Domestic') { ?>
<script>
$('#domestic').show();
$('#domestic').attr('disabled', false);
$('#international').attr('disabled', true);
</script>

<?php } else if ($ajax_task == 'ajax_edit' && $type == 'International'){?>
<script>
$('#international').show();
$('#international').attr('disabled', false);
$('#domestic').attr('disabled', true);
</script>

<?php } ?>

<script>
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_form_list', ajax, function(data) {
			$('#list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	// getList();

$(document).ready(function(){
	$('#type').on('change', function() {
	if ( this.value == '1')
		{
			$("#dom").show();
			$('#international').attr('disabled', true);
			$('#domestic').attr('disabled', false);
			$('#domestic').attr('name', 'part');
			$("#inter").hide();
			$(this).find('.form-group').find('input, textarea, select').trigger('blur');
			$("#domestic").attr("data-validation", 'required');
		}
	else
		{
			$("#inter").show();
			$('#domestic').attr('disabled', true);
			$('#international').attr('disabled', false);
			$('#international').attr('name', 'part');
			$("#dom").hide();
			$("#international").attr("data-validation", 'required');
		}
});
});
</script>

<?php if ($show_input): ?>
<!-- 
<?php //foreach($checker as $check): ?>
<?php //var_dump($check->report_form_id); ?>
	<script>	

	</script>
<?php //endforeach;?> -->
<script>

$('#list').on('ifToggled', 'input[type="checkbox"]', function() {
		origin = [];
		$('#list tbody input[type="checkbox"]').each(function(index, value) {
			if($(this).is(':checked')) {
				origin.push($(this).closest('tr').find('#check').val());
			}
		});
	});
$('#domestic').on('change', function(){
		$("#domestic").removeAttr("data-validation", 'required');
		$(this).closest('.form-group').removeClass('has-error'); 
});
$('#international').on('change', function(){
		$("#international").removeAttr("data-validation", 'required');
		$(this).closest('.form-group').removeClass('has-error'); 
	});

$('form').submit(function(e) {
	e.preventDefault();
	$(this).find('.form-group').find('input, textarea, select').trigger('blur');

	if ($(this).find('.form-group.has-error').length == 0 && $('#type').val() != 'none') {
		
		$("#international").removeAttr("data-validation", 'required');
		$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>',$(this).serialize() + '<?=$ajax_post?>' + '&origin=' + origin, function(data) {
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
