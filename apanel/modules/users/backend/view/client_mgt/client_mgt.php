<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CLIENTS LIST
	</div>
	<div class="box-header pb-none">
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<a href="<?= MODULE_URL ?>create" class="btn btn-sm btn-primary">CREATE NEW CLIENT</a>
				</div>
			</div>
			<div class="col-md-9">
				<form class="form-horizontal">
					<?php
						echo $ui->formField('dropdown')
							->setLabel('Filter Nature of Operation')
							->setSplit('col-md-6', 'col-md-6')
							->setName('operation')
							->setId('operation')
							->setList($nature_list)
							->setNone('- Select All -')
							->draw();
					?>
				</form>
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<?php
							echo $ui->formField('text')
									->setName('search')
									->setId('search')
									->setButtonAddon('search')
									->draw();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="box-body table-responsive">
	<div class="row" style="text-align:center;">
		<div class="col-md-12">
			<?php $alphabet = array('ALL','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
				foreach($alphabet as $clientVal){		
						echo "<span style='padding-right:28px'><a style='font-family: arial;cursor:pointer; font-size: 15px; line-height: 20px'><b class='abc'>" . $clientVal . "</b></a></span>";			
					}
			?>
		</div>
		
	</div>
		<table id="tableList" class="table table-hover table-bordered table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('#', array('class' => 'col-md-1'))
						->addHeader('Client Code', array('class' => 'col-md-2'))
						->addHeader('Client Name', array('class' => 'col-md-6'))
						->addHeader('Country', array('class' => 'col-md-2'))
						->addHeader('Status', array('class' => 'col-md-1'))
						->draw();
			?>
			
			<tbody>
				<tr>
					<td class="text-center" colspan="5">Loading List...</td>
				</tr>
			</tbody>
			<tfoot>
				<tr class="info">
					<td colspan="3" id="pagination"></td>
					<td colspan="2" class="text-center"><b>Result: </b> <span class="result"></span></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script>
	var ajax = {}
	ajax.limit = 20;
	var ajax_call = '';
	$('#operation').on('change', function() {
		ajax.nature = $(this).val();
		getList();
	});
	$('#search').on('input', function() {
		ajax.search = $(this).val();
		getList();
	});
	$('#search_button').click(function() {
		$('#search').trigger('input');
	});
	$('.abc').click(function() {
		ajax.abc = $(this).html();
		getList();
	});
	$('#pagination').on('click', 'a', function(e) {
		e.preventDefault();
		ajax.page = $(this).attr('data-page');
		getList();
	});
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_list', ajax, function(data) {
			$('#tableList tbody').html(data.table);
			$('#pagination').html(data.pagination);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
			$('#tableList tfoot .result').html('None');
			if (data.result_count > 0) {
				var min = (ajax.limit * (data.page - 1) + data.page);
				var max = ((ajax.limit * data.page) > data.result_count) ? data.result_count : ajax.limit * data.page;
				$('#tableList tfoot .result').html(min + ' - ' + max + ' of ' + data.result_count);
			}
		});
	}
	getList();
</script>