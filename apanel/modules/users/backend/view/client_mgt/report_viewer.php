<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		REPORT VIEWER
	</div>
	<div class="hidden-print">
		<?php $this->load('client_mgt/client_info_header', $data, false) ?>
	</div>
	<div class="visible-print">
		<br>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Client's Name:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $name . ' [' . $code . ']' ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Telephone Number:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $telno ?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Address:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $address ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Fax Number:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $faxno ?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Country:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $country ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Contact Person:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $cperson ?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">TIN Number:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $tin_no ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Contact Details:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $cp_contact ?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Email Address:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $email ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Contact Designation:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $cp_designation ?></div>
				</div>
			</div>
		</div>
	</div>
	<div class="report_name">
		<?php echo $report_name ?> (<?php echo $period . ' ' . $year; ?>)
	</div>
	<div class="visible-print">
		<br>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Report Period:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $period ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Report Year:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $year ?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Submitted Date:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $this->date->dateFormat($submitteddate) ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Approved Date:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $this->date->dateFormat($approveddate) ?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Submitted By:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $submittedby ?></div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-5 text-right">
					<b><div class="form-control-static">Approved By:</div></b>
				</div>
				<div class="col-xs-7 text-left">
					<div class="form-control-static"><?php echo $approvedby ?></div>
				</div>
			</div>
		</div>
	</div>
	<div class="nav_link hidden-print">
		<a href="<?php echo $listing_url ?>" id="back_page">Back to <?php echo $report_name ?> List </a>
	</div>
	<div class="dl_button hidden-print">
		<a href="<?php echo MODULE_URL ?>report_download/<?php echo $client_id.'/' . $db_table . '/'. $report_id . (($template_name == 'serial_number_tables') ? '/serial' : '') ?>" class="btn btn-info btn-md" target="_blank">DOWNLOAD REPORT</a>

		<?php if (in_array($db_table, array('form71a', 'form71b')) && $template_name != 'serial_number_tables'): ?>
			<a href="<?php echo MODULE_URL ?>report_viewer/<?php echo $client_id.'/' . $db_table . '/'. $report_id . '/serial' ?>" class="btn btn-info btn-md" target="_blank">SERIAL NUMBER</a>
		<?php endif ?>
	</div>
	<div class="panel-body">
		<?php $this->loadTemplate($template_name, $data) ?>
	</div>
</div>
<script>
$('#back_page').hide();
if (window.history.length > 1) {
	$('#back_page').show();
}
$('#back_page').click(function(e) {
	e.preventDefault();
	window.history.back();
});
</script>