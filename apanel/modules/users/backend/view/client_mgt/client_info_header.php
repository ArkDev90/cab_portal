
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
	</div>
	<div class = "row navhead">
		<ul style = "list-style-type: none">
			<li><a href = "<?php echo BASE_URL ?>client_mgt/">[ Back to Main ]</a></li>
			<li><a href = "<?php echo BASE_URL ?>client_mgt/client_info/<?php echo $client_id ?>">[ Client Info ]</a></li>  
			<li><a href = "<?php echo BASE_URL ?>client_mgt/users/listing/<?php echo $client_id ?>">[ Users ]</a></li> 
			<li><a href = "<?php echo BASE_URL ?>client_mgt/add_operation/<?php echo $client_id ?>">[ Add Nature of Operation ]</a></li> 
			<li><a href = "<?php echo BASE_URL ?>client_mgt/change_status/<?php echo $client_id ?>">[ Change Status ]</a></li>
			<li><a href = "<?php echo BASE_URL ?>client_mgt/reports/<?php echo $client_id ?>">[ View All Reports ]</a></li> 
			<li><a href = "<?php echo BASE_URL ?>client_mgt/history/<?php echo $client_id ?>">[ View History Listing ]</a></li>
		</ul>
	</div>