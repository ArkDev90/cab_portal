<style>.header {cursor: pointer;}</style>
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		LIST OF REPORTS
		<br>
		<?php 
			if ($db_table == 'form51a') {
				echo 'FORM 51-A: Traffic Flow - Quarterly Report On Scheduled International Services';
			} else if ($db_table == 'form51b') {
				echo 'FORM 51-B: Monthly International Cargo Traffic Flow';
			} else if ($db_table == 'form61a') {echo 'FORM 61-A: Monthly Statement of Traffic and Operating Statistics (Agricultural Aviation)';}
			else if ($db_table == 'form61b') {
				echo 'FORM 61-B: Monthly Statement of Traffic and Operating Statistics';
			} else if ($db_table == 'form71a') {
				echo 'FORM 71-A: International Airfreight Forwarder Cargo Production Report';
			} else if ($db_table == 'form71b') {
				echo 'FORM 71-B: Domestic Airfreight Forwarder Cargo Production Report';
			} else if ($db_table == 'form71c') {
				echo 'FORM 71-C: Cargo Sales Agency Report';
			} else if ($db_table == 'formt1a') {
				echo 'FORM T1-A: Domestic Sector Load Report';
			}
		?>
	</div>
	<div class="panel-body">
		<div class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-md-5">Client Name :</label>
				<div class="col-md-7">
					<p class="form-control-static"><b><?php echo $name ?></b> [ <?php echo $code ?> ]</p>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5">Address :</label>
				<div class="col-md-7">
					<p class="form-control-static"><?php echo $address ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-5">Email Address :</label>
				<div class="col-md-7">
					<p class="form-control-static"><?php echo $email ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 col-md-offset-8">
				<?php
				if ($db_table == 'form51a') {
					echo $ui->formField('dropdown')
							->setList(array('1' => '1st Quarter', '2' => '2nd Quarter', '3' => '3rd Quarter', '4' => '4th Quarter'))
							->setNone('All Quarter')
							->setName('month')
							->setId('month')
							->draw(true);
				} else {
					echo $ui->formField('dropdown')
							->setList(array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', 
											'6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', 
											'11' => 'November', '12' => 'December'))
							->setNone('All Months')
							->setName('month')
							->setId('month')
							->draw(true);
				}
				?>
			</div>
			<div class="col-md-2">
				<?php
					echo $ui->formField('dropdown')
							->setList(array('2010' => '2010', '2011' => '2011', '2012' => '2012', '2013' => '2013', '2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018'))
							->setNone('All Years')
							->setName('year')
							->setId('year')
							->draw(true);
				?>
			</div>
		</div>
		<div class="box-body table-responsive no-padding">
			<table id="list" class="table table-hover table-sidepad">
				<?php
					echo $ui->loadElement('table')
							->setHeaderClass('info')
							->addHeader('Report Date', array('class' => 'col-md-2 header'),'sort','year, timespan')
							->addHeader('Submitted By', array('class' => 'col-md-2'))
							->addHeader('Submitted Date', array('class' => 'col-md-2'))
							->addHeader('Approved By', array('class' => 'col-md-2'))
							->addHeader('Approved Date', array('class' => 'col-md-2 header'),'sort','approveddate')
							->addHeader('Status', array('class' => 'col-md-2'))
							->draw();
				?>
				<tbody>

				</tbody>
				<tfoot>
					<th colspan="6"><div id="pagination"></div></th>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<script>
$('#pagination').on('click', 'a', function(e) {
	e.preventDefault();
	ajax.page = $(this).attr('data-page');
	getList();
});
var ajax = {}
	ajax.limit = 20;
	ajax.id = '<?php echo $id ?>';
	ajax.client_id = '<?php echo $client_id ?>';
	ajax.db_table = '<?php echo $db_table ?>';
var ajax_call = '';

$("#month").on('change', function() {
	ajax.page = 1;
	ajax.month = $("#month").val();
	getList();
});

$("#year").on('change', function() {
	ajax.page = 1;
	ajax.year = $("#year").val();
	getList();
});

function getList() {
	if (ajax_call != '') {
		ajax_call.abort();
	}
	ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_view_approved_reports', ajax, function(data) {
		$('#list tbody').html(data.table);
		$('#pagination').html(data.pagination);
		if (ajax.page > data.page_limit && data.page_limit > 0) {
			ajax.page = data.page_limit;
			getList();
		}
	});
}
getList();
tableSort('#list', function(value) {
		ajax.sort = value;
		ajax.page = 1;
		getList();
	});
</script>


