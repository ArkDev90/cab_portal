<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		Welcome to Civil Aeronautics Board of the Philippines [PORTAL]
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">
						RECENTLY SUBMITTED REPORTS
					</div>
					<div class="panel-body p-sm">
						<p class="mb-xs">
							No. of Late Submitted Reports : <b><?php echo $late. ' records'; ?></b>
						</p>
						<p class="font-sm">
							<a href="<?php echo BASE_URL?>client_mgt/late_submitted_report" class="cab-link">View reports »»</a>
						</p>
						<p class="mb-xs">
							No. of Suspended Clients : <b><?php echo $suspended. ' records'; ?></b>
						</p>
						<p class="font-sm">
							<a href="<?php echo BASE_URL?>client_mgt/suspended_clients" class="cab-link">View Suspended Clients »»</a>
						</p>
						<p class="mb-xs">
							No. of Terminated Clients : <b><?php echo $terminated. ' records'; ?></b>
						</p>
						<p class="font-sm mb-none">
							<a href="<?php echo BASE_URL?>client_mgt/terminated_clients" class="cab-link">View Terminated Clients »»</a>
						</p>
					</div>
				</div>
			</div>
			<?php //var_dump($pagination->result_count); ?>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">
						SETTINGS
					</div>
					<div class="panel-body p-sm">
						<p class="mb-xs">
							<b>Nature of Operation Report Settings</b>
						</p>
						<p class="font-sm">
							<a href="<?php echo BASE_URL?>report_ctrl/" class="cab-link">Click here to continue »»</a>
						</p>
						<p class="mb-xs">
							<b>No of Days Expiration for Each Report</b>
						</p>
						<p class="font-sm">
							<a href="<?php echo BASE_URL?>report_form/report_expiration" class="cab-link">Click here to continue »»</a>
						</p>
						<p class="mb-xs">
							<b>Start Date of Report</b>
						</p>
						<p class="font-sm mb-none">
							<a href="<?php echo BASE_URL?>report_form/report_start_date" class="cab-link">Click here to continue »»</a>
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="panel panel-primary mb-none">
					<div class="panel-heading text-center">
						LIST OF REPORTS
					</div>
					<div class="panel-body p-sm">
						<div class="row">
						<?php foreach($reports as $row){ ?>
							<div class="col-md-6">
							
								<p>
									<a href="<?php echo BASE_URL?>client_mgt/approved_reports/<?php echo $row->db_table; ?>" class="cab-link text-bold font-xs <?php if($row->count == 0){echo 'text-danger';}?>"> <?php echo '• '.$row->short_title.' - '.$row->title; ?> [ <?php echo $row->count;  ?> ]</a>
								</p>
							
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>