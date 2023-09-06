<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		Welcome to Civil Aeronautics Board of the Philippines [PORTAL]

	</div>

	<div class="panel-body">

		<div class="row">

			<div class="col-md-6">

				<div class="panel panel-primary">

					<div class="panel-heading text-center">

						SUBMITTED REPORTS

					</div>

					<div class="panel-body p-sm">

						<p class="mb-xs">

							<a href="<?php echo MODULE_URL ?>client_users_mgt/users/approved_reports"><b>APPROVED REPORTS</b></a>

						</p>

					</div>

				</div>

			</div>

			<?php //var_dump($pagination->result_count); ?>

			<div class="col-md-6">

				<div class="panel panel-primary">

					<div class="panel-heading text-center">

						<a href="">ADD USERS

					</div>

					<div class="panel-body p-sm">

						<p class="mb-xs">

							<a href="<?php echo MODULE_URL ?>client_users_mgt/users"><b>MANAGE USERS</b></a>

						</p>

						

					</div>

				</div>

			</div>

			<button  data-backdrop="static" data-keyboard="false" id="remindmodalbutton" type="button" style="display:none" class="btn btn-primary" data-toggle="modal" data-target="#remindmodal">
				Modal
			</button>

			<button  data-backdrop="static" data-keyboard="false" id="remindmodalbutton2" type="button" style="display:none" class="btn btn-primary" data-toggle="modal" data-target="#remindmodal2">
				Reminder
			</button>
			<div class="col-md-12">

				<div class="panel panel-primary mb-none">

					<div class="panel-heading text-center">

                    LIST OF PENDING & DISAPPROVED REPORTS

					</div>

					<div class="panel-body p-sm">

						<div class="row">

						<?php foreach($reports as $row){ ?>

							<div class="col-md-6">

									<p>

										<a href="<?php echo MODULE_URL ?>client_users_mgt/users/pending_reports/<?php echo $row->db_table; ?>" class="cab-link text-bold font-xs <?php if($row->count > 0){echo 'text-danger';}?>"> <?php echo '• '.$row->short_title.' - '.$row->title; ?> [ <?php echo $row->count;  ?> ]</a>

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

<!-- Modal -->
<div class="modal fade" id="remindmodal" tabindex="-1" role="dialog" aria-labelledby="remindmodal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-primary" id="exampleModalLabel"><b>Data input required</b></h4>
      </div>
	  <form id="permitdate"  method="post" action="https://cab.gov.ph/portal_api/api/client/client_permitdate_update.php">
      <div class="modal-body">
		<p>Before you may continue on using the portal,You are  required to input the  <span style="color:red">date of issued</span>  and <span style="color:red">validity</span>  of the  permit of your company, <b><?php echo COMPANY_NAME ?> </b>.<br>
		<br>
		<div class="form-group">
			<label for="issuedate">Issuance Date :</label>
			<input type="date" class="form-control" id="issuedate" aria-describedby="issueHelp" placeholder="" name="<?php echo md5("d") ?>" required>
		</div><br>
		<div class="form-group">
			<label for="validdate">Valid Till :</label>
			<input type="date" class="form-control" id="validdate" aria-describedby="validHelp" placeholder="" name="<?php echo md5("v") ?>" required>
		</div><br>

		<div class="form-group">
			<label for="reference" align="center"><i>Permit Sample Reference</i> :</label>
			<img id="reference" src="<?= BASE_URL ?>assets/images/public/permit_af.png" alt="..." class="img-thumbnail">
		</div><br>

		
	


		<input hidden type="number"  name="<?php echo md5("id") ?>" value="<?php echo CLIENT_ID ?>" required/>
      </div>
      <div class="modal-footer">
	 
	  	<input  class="btn btn-primary" type="submit">
	  </div>
	  </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="remindmodal2" tabindex="-1" role="dialog" aria-labelledby="remindmodal2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-primary" id="exampleModalLabel"><b>Reminder</b></h4>
      </div>
      <div class="modal-body">
        <b>Please update your company information, mainly your company email.</b> This is to ensure that Civil Aeronautics Board delivers on-time information and updates to you and your company.
      </div>
      <div class="modal-footer">
		<a id="updatemailremind" href="<?php echo MODULE_URL ?>stakeholder_account_mgt/company_profile" class="btn btn-primary"> Update Company Email</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
	$("document").ready(function() {
		<?php
			if(("0000-00-00" == PERMIT_DATE || "0000-00-00" == PERMIT_VALIDITY) && substr(CODE, 0, 2) == "AF") {
		?>
			setTimeout(function() {
				$("#remindmodalbutton").trigger('click');
			},10);
		<?php
			}
			else
			{
				?>
			setTimeout(function() {
				$("#remindmodalbutton2").trigger('click');
			},10);
		<?php

			}
		?>
		
		
	});

	$("#updatemailremind").bind("click", function() {
		$.cookie("emailupdated", "1");
	});
</script>