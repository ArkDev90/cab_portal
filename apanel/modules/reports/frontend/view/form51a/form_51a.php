<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		<?php echo $form_title ?>
	</div>
	<div class="box-body pb-none">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a aria-controls="direct_passenger" role="tab" data-tab="direct_passenger"">DIRECT PASSENGER TRAFFIC</a></li>
			<li role="presentation"><a aria-controls="transit_passenger" data-tab="transit_passenger" role="tab">TRANSIT REVENUE PASSENGER TRAFFIC</a></li>
		</ul>
		<br>
		<div class="form-group">
			<button type="button" id="confirm_proceed" class="btn btn-primary btn-sm mb-xs">Confirm and Proceed</button>
			<button type="button" id="submit_report" class="btn btn-primary btn-sm mb-xs" style="display: none">Submit Report</button>
			<button type="button" id="no_operation" class="btn btn-warning btn-sm mb-xs">No Operation</button>
			<button type="button" id="save_draft" class="btn btn-default btn-sm mb-xs">Save as Draft</button>
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="direct_passenger">
				<form action="" method="post" id="entry_form" class="form-horizontal">
					<div class="row">
						<div class="col-md-6">
							<?php
								echo $ui->formField('text')
										->setLabel('*Report Period:')
										->setSplit('col-md-5', 'col-md-7')
										->setValue($quarter_name . ' ' . $year)
										->draw(false);
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<?php
								echo $ui->formField('text')
										->setLabel('*Aircraft Type:')
										->setSplit('col-md-5', 'col-md-7')
										->setId('aircraft')
										->setName('aircraft')
										->setValidation('required')
										->draw();
								
								echo $ui->formField('radio')
										->setLabel('Direct')
										->setSplit('col-xs-7 force-left', 'col-xs-5 no-padding force-right')
										->setName('extra')
										->setId('direct')
										->setSwitch()
										->setDefault('no')
										->setValue('no')
										->draw();
								
								echo $ui->formField('radio')
										->setLabel('Fifth Freedom')
										->setSplit('col-xs-7 force-left', 'col-xs-5 no-padding force-right')
										->setName('extra')
										->setId('fifth_freedom')
										->setSwitch()
										->setDefault('fifth')
										->draw();
								
								echo $ui->formField('radio')
										->setLabel('Co-Terminal')
										->setSplit('col-xs-7 force-left', 'col-xs-5 no-padding force-right')
										->setName('extra')
										->setId('co_terminal')
										->setSwitch()
										->setDefault('co_te')
										->draw();
							?>
						</div>
						<div class="col-md-6">
							<?php
								echo $ui->formField('text')
										->setLabel('*First Class:')
										->setSplit('col-md-5', 'col-md-7')
										->setId('first')
										->setName('first')
										->setValidation('required integer')
										->draw();

								echo $ui->formField('text')
										->setLabel('*Business Class:')
										->setSplit('col-md-5', 'col-md-7')
										->setId('business')
										->setName('business')
										->setValidation('required integer')
										->draw();

								echo $ui->formField('text')
										->setLabel('*Economy Class:')
										->setSplit('col-md-5', 'col-md-7')
										->setId('economy')
										->setName('economy')
										->setValidation('required integer')
										->draw();

								echo $ui->formField('text')
										->setLabel('Total Seats:')
										->setSplit('col-md-5', 'col-md-7 total_seats')
										->setValue('0')
										->draw(false);
							?>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="control-label col-md-2">*Route:</label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-xs-4">
									<?php
										echo $ui->formField('dropdown')
												->setPlaceholder('Select One')
												->setSplit('', 'col-md-12')
												->setId('destination_from')
												->setName('destination_from')
												->setList($origin_list)
												->setValidation('required')
												->draw();
									?>
								</div>
								<div class="col-xs-4 extra_show" style="display: none">
									<?php
										echo $ui->formField('dropdown')
												->setPlaceholder('Select One')
												->setSplit('', 'col-md-12')
												->setId('extra_dest')
												->setName('extra_dest')
												->setList($destination_list)
												->setValidation('required')
												->draw();
									?>
								</div>
								<div class="col-xs-4">
									<?php
										echo $ui->formField('dropdown')
												->setPlaceholder('Select One')
												->setSplit('', 'col-md-12')
												->setId('destination_to')
												->setName('destination_to')
												->setList($destination_list)
												->setValidation('required')
												->draw();
									?>
								</div>
								<div class="hidden">
									<div id="dropdown_international">
										<option></option>
										<?php foreach ($destination_list as $row): ?>
											<option value="<?php echo $row->ind ?>"><?php echo $row->val ?></option>
										<?php endforeach ?>
									</div>
									<div id="dropdown_mixed">
										<option></option>
										<?php foreach ($mix_list as $row): ?>
											<option value="<?php echo $row->ind ?>"><?php echo $row->val ?></option>
										<?php endforeach ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br>
					<table class="table-style">
						<tr>
							<th class="col-md-2"></th>
							<th colspan="3" class="col-md-5 destination_from">-</th>
							<th rowspan="5" style="background-color: black"></th>
							<th colspan="3" class="col-md-5 destination_to">-</th>
						</tr>
						<tr>
							<th></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
						</tr>
						<tr>
							<th class="text-right">Passenger Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('quarter_month1')
											->setName('quarter_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('quarter_month2')
											->setName('quarter_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('quarter_month3')
											->setName('quarter_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('quarter_month1_d')
											->setName('quarter_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('quarter_month2_d')
											->setName('quarter_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('quarter_month3_d')
											->setName('quarter_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						<tr>
							<th class="text-right">Number of Flights:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('nflight_month1')
											->setName('nflight_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('nflight_month2')
											->setName('nflight_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('nflight_month3')
											->setName('nflight_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('nflight_month1_d')
											->setName('nflight_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('nflight_month2_d')
											->setName('nflight_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('nflight_month3_d')
											->setName('nflight_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						</tr>
						<tr>
							<th class="text-right">FOC Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('foctraffic_month1')
											->setName('foctraffic_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('foctraffic_month2')
											->setName('foctraffic_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('foctraffic_month3')
											->setName('foctraffic_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('foctraffic_month1_d')
											->setName('foctraffic_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('foctraffic_month2_d')
											->setName('foctraffic_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('foctraffic_month3_d')
											->setName('foctraffic_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
					</table>
					<p id="loadFactorError" class="m-none text-center text-danger"></p>
					<br>
					<table class="table-style extra_show" style="display: none">
						<tr>
							<th class="col-md-2"></th>
							<th colspan="3" class="col-md-5 extra_from">-</th>
							<th rowspan="5" style="background-color: black"></th>
							<th colspan="3" class="col-md-5 extra_to">-</th>
						</tr>
						<tr>
							<th></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
						</tr>
						<tr>
							<th class="text-right">Passenger Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_quarter_month1')
											->setName('ex_quarter_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_quarter_month2')
											->setName('ex_quarter_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_quarter_month3')
											->setName('ex_quarter_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_quarter_month1_d')
											->setName('ex_quarter_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_quarter_month2_d')
											->setName('ex_quarter_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_quarter_month3_d')
											->setName('ex_quarter_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						<tr>
							<th class="text-right">Number of Flights:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_nflight_month1')
											->setName('ex_nflight_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_nflight_month2')
											->setName('ex_nflight_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_nflight_month3')
											->setName('ex_nflight_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_nflight_month1_d')
											->setName('ex_nflight_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_nflight_month2_d')
											->setName('ex_nflight_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_nflight_month3_d')
											->setName('ex_nflight_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						</tr>
						<tr>
							<th class="text-right">FOC Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_foctraffic_month1')
											->setName('ex_foctraffic_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_foctraffic_month2')
											->setName('ex_foctraffic_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_foctraffic_month3')
											->setName('ex_foctraffic_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_foctraffic_month1_d')
											->setName('ex_foctraffic_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_foctraffic_month2_d')
											->setName('ex_foctraffic_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_foctraffic_month3_d')
											->setName('ex_foctraffic_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
					</table>
					<p id="ex_loadFactorError" class="m-none text-center text-danger"></p>
					<br>
					<?php
						echo $ui->formField('checkbox')
								->setLabel('Code Shared Flight:')
								->setSplit('col-md-3', 'col-md-7')
								->setId('codeshared_checkbox')
								->setDefault('codeshared')
								->draw();

						echo $ui->formField('text')
								->setLabel('Marketing Airline:')
								->setSplit('col-md-3', 'col-md-4')
								->setId('codeshared')
								->setName('codeshared')
								->draw();
					?>
					<br>
					<table class="table-style codeshared_input">
						<tr>
							<th class="col-md-2"></th>
							<th colspan="3" class="col-md-5 codeshared_from">-</th>
							<th rowspan="5" style="background-color: black"></th>
							<th colspan="3" class="col-md-5 codeshared_to">-</th>
						</tr>
						<tr>
							<th></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
						</tr>
						<tr>
							<th class="text-right">Passenger Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_quarter_month1')
											->setName('cs_quarter_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_quarter_month2')
											->setName('cs_quarter_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_quarter_month3')
											->setName('cs_quarter_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_quarter_month1_d')
											->setName('cs_quarter_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_quarter_month2_d')
											->setName('cs_quarter_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_quarter_month3_d')
											->setName('cs_quarter_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						<tr>
							<th class="text-right">Number of Flights:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_nflight_month1')
											->setName('cs_nflight_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_nflight_month2')
											->setName('cs_nflight_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_nflight_month3')
											->setName('cs_nflight_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_nflight_month1_d')
											->setName('cs_nflight_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_nflight_month2_d')
											->setName('cs_nflight_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_nflight_month3_d')
											->setName('cs_nflight_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						</tr>
						<tr>
							<th class="text-right">FOC Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_foctraffic_month1')
											->setName('cs_foctraffic_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_foctraffic_month2')
											->setName('cs_foctraffic_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_foctraffic_month3')
											->setName('cs_foctraffic_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_foctraffic_month1_d')
											->setName('cs_foctraffic_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_foctraffic_month2_d')
											->setName('cs_foctraffic_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('cs_foctraffic_month3_d')
											->setName('cs_foctraffic_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
					</table>
					<p id="cs_loadFactorError" class="m-none text-center text-danger"></p>
					<br>
					<table class="table-style codeshared_input extra_show" style="display: none">
						<tr>
							<th class="col-md-2"></th>
							<th colspan="3" class="col-md-5 extra_codeshared_from">-</th>
							<th rowspan="5" style="background-color: black"></th>
							<th colspan="3" class="col-md-5 extra_codeshared_to">-</th>
						</tr>
						<tr>
							<th></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
							<th><?php echo $quarter_months[0] ?></th>
							<th><?php echo $quarter_months[1] ?></th>
							<th><?php echo $quarter_months[2] ?></th>
						</tr>
						<tr>
							<th class="text-right">Passenger Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_quarter_month1')
											->setName('ex_cs_quarter_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_quarter_month2')
											->setName('ex_cs_quarter_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_quarter_month3')
											->setName('ex_cs_quarter_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_quarter_month1_d')
											->setName('ex_cs_quarter_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_quarter_month2_d')
											->setName('ex_cs_quarter_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_quarter_month3_d')
											->setName('ex_cs_quarter_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						<tr>
							<th class="text-right">Number of Flights:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_nflight_month1')
											->setName('ex_cs_nflight_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_nflight_month2')
											->setName('ex_cs_nflight_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_nflight_month3')
											->setName('ex_cs_nflight_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_nflight_month1_d')
											->setName('ex_cs_nflight_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_nflight_month2_d')
											->setName('ex_cs_nflight_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_nflight_month3_d')
											->setName('ex_cs_nflight_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
						</tr>
						<tr>
							<th class="text-right">FOC Traffic:</th>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_foctraffic_month1')
											->setName('ex_cs_foctraffic_month1')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_foctraffic_month2')
											->setName('ex_cs_foctraffic_month2')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_foctraffic_month3')
											->setName('ex_cs_foctraffic_month3')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_foctraffic_month1_d')
											->setName('ex_cs_foctraffic_month1_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_foctraffic_month2_d')
											->setName('ex_cs_foctraffic_month2_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
							<td>
								<?php
									echo $ui->formField('text')
											->setSplit('', 'col-md-12')
											->setId('ex_cs_foctraffic_month3_d')
											->setName('ex_cs_foctraffic_month3_d')
											->setValidation('required integer')
											->draw();
								?>
							</td>
						</tr>
					</table>
					<p id="ex_cs_loadFactorError" class="m-none text-center text-danger"></p>
					<div class="text-center">
						<br>
						<button type="submit" id="add_entry" class="btn btn-primary btn-sm">Add Entry</button>
						<button type="button" id="update_entry" class="btn btn-primary btn-sm" style="display: none;">Update Entry</button>
						<button type="button" id="cancel_edit" class="btn btn-default btn-sm" style="display: none;">Cancel Edit</button>
					</div>
				</form>
				<form action="" method="post" id="entries">
					<br>
					<div class="text-right">
						<button type="button" class="btn btn-danger btn-sm mb-xs delete_entry">Delete</button>
					</div>
					<div class="table-responsive mb-xs">
						<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
							<thead>
								<tr class="info">
									<th class="" rowspan="2"><input type="checkbox" class="selectall"></th>
									<th class="col-md-1" rowspan="2">AIRCRAFT</th>
									<th class="col-md-1" rowspan="2">ROUTE</th>
									<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
									<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
									<th class="col-md-1">FOC TRAFFIC</th>
									<th class="col-md-1" rowspan="2">ROUTE</th>
									<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
									<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
									<th class="col-md-1">FOC TRAFFIC</th>
									<th class="col-md-1">TOTAL</th>
									<th class="col-md-1">LF</th>
									<th class="col-md-1" rowspan="2">EDIT</th>
								</tr>
								<tr class="info">
									<th><?php echo strtoupper($quarter_months[0]) ?></th>
									<th><?php echo strtoupper($quarter_months[1]) ?></th>
									<th><?php echo strtoupper($quarter_months[2]) ?></th>
									<th>SUB TOTAL</th>
									<th>SUB TOTAL</th>
									<th><?php echo strtoupper($quarter_months[0]) ?></th>
									<th><?php echo strtoupper($quarter_months[1]) ?></th>
									<th><?php echo strtoupper($quarter_months[2]) ?></th>
									<th>SUB TOTAL</th>
									<th>SUB TOTAL</th>
									<th>REV TRAFFIC</th>
									<th>%</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
								</tr>
							</tbody>
							<tfoot>
								<tr class="info total_row">
									<th colspan="3" class="text-right">TOTAL:</th>
									<th class="total_seats_offered text-right">0</th>
									<th class="total_quarter_month1 text-right">0</th>
									<th class="total_quarter_month2 text-right">0</th>
									<th class="total_quarter_month3 text-right">0</th>
									<th class="total_quarter_total text-right">0</th>
									<th class="total_sub_total text-right">0</th>
									<th></th>
									<th class="total_seats_offered_d text-right">0</th>
									<th class="total_quarter_month1_d text-right">0</th>
									<th class="total_quarter_month2_d text-right">0</th>
									<th class="total_quarter_month3_d text-right">0</th>
									<th class="total_quarter_total_d text-right">0</th>
									<th class="total_sub_total_d text-right">0</th>
									<th class="total_total_rev_traffic text-right">0</th>
									<th class="total_total_percent text-right">0.00%</th>
									<th></th>
								</tr>
								<tr class="info">
									<td colspan="16" id="pagination"></td>
									<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<br>
					<div class="text-center">CODE SHARED</div>
					<br>
					<div class="table-responsive mb-xs">
						<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
							<thead>
								<tr class="info">
									<th class="" rowspan="2"><input type="checkbox" class="selectall"></th>
									<th class="col-md-1" rowspan="2">MARKETING AIRLINE</th>
									<th class="col-md-1" rowspan="2">ROUTE</th>
									<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
									<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
									<th class="col-md-1">FOC TRAFFIC</th>
									<th class="col-md-1" rowspan="2">ROUTE</th>
									<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
									<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
									<th class="col-md-1">FOC TRAFFIC</th>
									<th class="col-md-1">TOTAL</th>
									<th class="col-md-1">LF</th>
									<th class="col-md-1" rowspan="2">EDIT</th>
								</tr>
								<tr class="info">
									<th><?php echo strtoupper($quarter_months[0]) ?></th>
									<th><?php echo strtoupper($quarter_months[1]) ?></th>
									<th><?php echo strtoupper($quarter_months[2]) ?></th>
									<th>SUB TOTAL</th>
									<th>SUB TOTAL</th>
									<th><?php echo strtoupper($quarter_months[0]) ?></th>
									<th><?php echo strtoupper($quarter_months[1]) ?></th>
									<th><?php echo strtoupper($quarter_months[2]) ?></th>
									<th>SUB TOTAL</th>
									<th>SUB TOTAL</th>
									<th>REV TRAFFIC</th>
									<th>%</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
								</tr>
							</tbody>
							<tfoot>
								<tr class="info total_row2">
									<th colspan="3" class="text-right">TOTAL:</th>
									<th class="total_seats_offered text-right">0</th>
									<th class="total_quarter_month1 text-right">0</th>
									<th class="total_quarter_month2 text-right">0</th>
									<th class="total_quarter_month3 text-right">0</th>
									<th class="total_quarter_total text-right">0</th>
									<th class="total_sub_total text-right">0</th>
									<th></th>
									<th class="total_seats_offered_d text-right">0</th>
									<th class="total_quarter_month1_d text-right">0</th>
									<th class="total_quarter_month2_d text-right">0</th>
									<th class="total_quarter_month3_d text-right">0</th>
									<th class="total_quarter_total_d text-right">0</th>
									<th class="total_sub_total_d text-right">0</th>
									<th class="total_total_rev_traffic text-right">0</th>
									<th class="total_total_percent text-right">0.00%</th>
									<th></th>
								</tr>
								<tr class="info">
									<td colspan="16" id="pagination"></td>
									<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count_cs"></span></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="text-right">
						<button type="button" class="btn btn-danger btn-sm delete_entry">Delete</button>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="transit_passenger">
				<form action="" method="post" id="entry_form2" class="form-horizontal">
					<div class="row">
						<label class="control-label col-md-3">*Added Routes:</label>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6">
									<?php
										echo $ui->formField('dropdown')
												->setPlaceholder('Select One')
												->setSplit('', 'col-md-12')
												->setId('addedRoutes')
												->setName('addedRoutes')
												->setValidation('required')
												->draw();
									?>
								</div>
							</div>
						</div>
					</div>
					<br>
					<h4 class="text-center">TRANSIT REVENUE PASSENGER TRAFFIC</h4>
					<br>
					<table class="table-style">
						<thead>
							<tr>
								<th class="col-xs-2">ROUTE</th>
								<th class="col-xs-2"><?php echo strtoupper($quarter_months[0]) ?></th>
								<th class="col-xs-2"><?php echo strtoupper($quarter_months[1]) ?></th>
								<th class="col-xs-2"><?php echo strtoupper($quarter_months[2]) ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="sector_label">FROM/TO</th>
								<td>
									<?php
										echo $ui->formField('text')
												->setSplit('', 'col-md-12')
												->setId('quarter_month1')
												->setName('quarter_month1')
												->setValidation('required integer')
												->draw();
									?>
								</td>
								<td>
									<?php
										echo $ui->formField('text')
												->setSplit('', 'col-md-12')
												->setId('quarter_month2')
												->setName('quarter_month2')
												->setValidation('required integer')
												->draw();
									?>
								</td>
								<td>
									<?php
										echo $ui->formField('text')
												->setSplit('', 'col-md-12')
												->setId('quarter_month3')
												->setName('quarter_month3')
												->setValidation('required integer')
												->draw();
									?>
								</td>
							</tr>
							<tr>
								<th class="sector_d_label">TO/FROM</th>
								<td>
									<?php
										echo $ui->formField('text')
												->setSplit('', 'col-md-12')
												->setId('quarter_month1_d')
												->setName('quarter_month1_d')
												->setValidation('required integer')
												->draw();
									?>
								</td>
								<td>
									<?php
										echo $ui->formField('text')
												->setSplit('', 'col-md-12')
												->setId('quarter_month2_d')
												->setName('quarter_month2_d')
												->setValidation('required integer')
												->draw();
									?>
								</td>
								<td>
									<?php
										echo $ui->formField('text')
												->setSplit('', 'col-md-12')
												->setId('quarter_month3_d')
												->setName('quarter_month3_d')
												->setValidation('required integer')
												->draw();
									?>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="text-center">
						<br>
						<button type="submit" id="add_entry" class="btn btn-primary btn-sm">Add Entry</button>
						<button type="button" id="update_entry" class="btn btn-primary btn-sm" style="display: none;">Update Entry</button>
						<button type="button" id="cancel_edit" class="btn btn-default btn-sm" style="display: none;">Cancel Edit</button>
					</div>
				</form>
				<form action="" method="post" id="entries2">
					<br>
					<div class="text-right">
						<button type="button" class="btn btn-danger btn-sm mb-xs delete_entry">Delete</button>
					</div>
					<div class="table-responsive mb-xs">
						<table id="tableList3" class="table table-hover table-bordered table-sidepad mb-none">
							<thead>
								<tr class="info">
									<th colspan="13">TRANSIT REVENUE</th>
								</tr>
								<tr class="info">
									<th><input type="checkbox" class="selectall"></th>
									<th class="col-md-1">ROUTE</th>
									<th class="col-md-1"><?php echo strtoupper($quarter_months[0]) ?></th>
									<th class="col-md-1"><?php echo strtoupper($quarter_months[1]) ?></th>
									<th class="col-md-1"><?php echo strtoupper($quarter_months[2]) ?></th>
									<th class="col-md-1">SUB-TOTAL</th>
									<th class="col-md-1">ROUTE</th>
									<th class="col-md-1"><?php echo strtoupper($quarter_months[0]) ?></th>
									<th class="col-md-1"><?php echo strtoupper($quarter_months[1]) ?></th>
									<th class="col-md-1"><?php echo strtoupper($quarter_months[2]) ?></th>
									<th class="col-md-1">SUB-TOTAL</th>
									<th class="col-md-1">TOTAL</th>
									<th class="col-md-1">EDIT</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
							<tfoot>
								<tr class="info total_row3">
									<th colspan="2" class="text-right">TOTAL:</th>
									<th class="total_quarter_month1 text-right">0</th>
									<th class="total_quarter_month2 text-right">0</th>
									<th class="total_quarter_month3 text-right">0</th>
									<th class="total_subtotal text-right">0</th>
									<th></th>
									<th class="total_quarter_month1_d text-right">0</th>
									<th class="total_quarter_month2_d text-right">0</th>
									<th class="total_quarter_month3_d text-right">0</th>
									<th class="total_subtotal_d text-right">0</th>
									<th class="total_total text-right">0</th>
									<th></th>
								</tr>
								<tr class="info">
									<td colspan="10" id="pagination"></td>
									<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count_tran"></span></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="text-right">
						<button type="button" class="btn btn-danger btn-sm delete_entry">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	var form_data = [];
	var row_num = 0;
	var report_details = <?php echo json_encode((isset($form_details) && $form_details) ? $form_details : array()) ?>;
	var report_details2 = <?php echo json_encode((isset($form_details2) && $form_details2) ? $form_details2 : array()) ?>;
	// $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	// 	getRoutes();
	// 	checkButtons();
	// 	$('#entry_form #cancel_edit').trigger('click');
	// 	$('#entry_form2 #cancel_edit').trigger('click');
	// });
	$('#confirm_proceed').click(function() {
		$('a[data-tab="direct_passenger"]').closest('li').removeClass('active');
		$('a[data-tab="transit_passenger"]').closest('li').addClass('active');
		$('#direct_passenger').removeClass('in');
		$('#direct_passenger').removeClass('active');
		$('#transit_passenger').addClass('in');
		$('#transit_passenger').addClass('active');
		$('#confirm_proceed').hide();
		$('#submit_report').show();
		getRoutes();
		checkButtons();
	});
	$('#tableList').on('ifChanged', '.selectall', function() {
		var check = ($(this).is(':checked')) ? 'check' : 'uncheck';
		$('#tableList tbody input[type="checkbox"]').iCheck(check);
	});
	$('#tableList2').on('ifChanged', '.selectall', function() {
		var check = ($(this).is(':checked')) ? 'check' : 'uncheck';
		$('#tableList2 tbody input[type="checkbox"]').iCheck(check);
	});
	$('#tableList3').on('ifChanged', '.selectall', function() {
		var check = ($(this).is(':checked')) ? 'check' : 'uncheck';
		$('#tableList3 tbody input[type="checkbox"]').iCheck(check);
	});
	$('#quarter_month1, #quarter_month2, #quarter_month3, #quarter_month1_d, #quarter_month2_d, #quarter_month3_d, #ex_quarter_month1, #ex_quarter_month2, #ex_quarter_month3, #ex_quarter_month1_d, #ex_quarter_month2_d, #ex_quarter_month3_d, #cs_quarter_month1, #cs_quarter_month2, #cs_quarter_month3, #cs_quarter_month1_d, #cs_quarter_month2_d, #cs_quarter_month3_d, #ex_cs_quarter_month1, #ex_cs_quarter_month2, #ex_cs_quarter_month3, #ex_cs_quarter_month1_d, #ex_cs_quarter_month2_d, #ex_cs_quarter_month3_d').change(function() {
		checkLoadFactor();
	});
	$('#nflight_month1, #nflight_month2, #nflight_month3, #nflight_month1_d, #nflight_month2_d, #nflight_month3_d, #ex_nflight_month1, #ex_nflight_month2, #ex_nflight_month3, #ex_nflight_month1_d, #ex_nflight_month2_d, #ex_nflight_month3_d, #cs_nflight_month1, #cs_nflight_month2, #cs_nflight_month3, #cs_nflight_month1_d, #cs_nflight_month2_d, #cs_nflight_month3_d, #ex_cs_nflight_month1, #ex_cs_nflight_month2, #ex_cs_nflight_month3, #ex_cs_nflight_month1_d, #ex_cs_nflight_month2_d, #ex_cs_nflight_month3_d').change(function() {
		checkLoadFactor();
	});
	$('#foctraffic_month1, #foctraffic_month2, #foctraffic_month3, #foctraffic_month1_d, #foctraffic_month2_d, #foctraffic_month3_d, #ex_foctraffic_month1, #ex_foctraffic_month2, #ex_foctraffic_month3, #ex_foctraffic_month1_d, #ex_foctraffic_month2_d, #ex_foctraffic_month3_d, #cs_foctraffic_month1, #cs_foctraffic_month2, #cs_foctraffic_month3, #cs_foctraffic_month1_d, #cs_foctraffic_month2_d, #cs_foctraffic_month3_d, #ex_cs_foctraffic_month1, #ex_cs_foctraffic_month2, #ex_cs_foctraffic_month3, #ex_cs_foctraffic_month1_d, #ex_cs_foctraffic_month2_d, #ex_cs_foctraffic_month3_d').change(function() {
		checkLoadFactor();
	});
	$('#first, #business, #economy').change(function() {
		checkLoadFactor();
	});
	function checkLoadFactor() {
		var error_message = 'PASSENGER TRAFFIC EXCEEDS FROM SEATING CAPACITY';
		var seats_offered = removeComma($('#first').val()) + removeComma($('#business').val()) + removeComma($('#economy').val());

		var quarter_month1 = removeComma($('#quarter_month1').val());
		var quarter_month2 = removeComma($('#quarter_month2').val());
		var quarter_month3 = removeComma($('#quarter_month3').val());
		var quarter_month1_d = removeComma($('#quarter_month1_d').val());
		var quarter_month2_d = removeComma($('#quarter_month2_d').val());
		var quarter_month3_d = removeComma($('#quarter_month3_d').val());
		var r_nflight_month1 = $('#nflight_month1').val();
		var r_nflight_month2 = $('#nflight_month2').val();
		var r_nflight_month3 = $('#nflight_month3').val();
		var r_nflight_month1_d = $('#nflight_month1_d').val();
		var r_nflight_month2_d = $('#nflight_month2_d').val();
		var r_nflight_month3_d = $('#nflight_month3_d').val();
		var nflight_month1 = removeComma(r_nflight_month1);
		var nflight_month2 = removeComma(r_nflight_month2);
		var nflight_month3 = removeComma(r_nflight_month3);
		var nflight_month1_d = removeComma(r_nflight_month1_d);
		var nflight_month2_d = removeComma(r_nflight_month2_d);
		var nflight_month3_d = removeComma(r_nflight_month3_d);
		var foctraffic_month1 = removeComma($('#foctraffic_month1').val());
		var foctraffic_month2 = removeComma($('#foctraffic_month2').val());
		var foctraffic_month3 = removeComma($('#foctraffic_month3').val());
		var foctraffic_month1_d = removeComma($('#foctraffic_month1_d').val());
		var foctraffic_month2_d = removeComma($('#foctraffic_month2_d').val());
		var foctraffic_month3_d = removeComma($('#foctraffic_month3_d').val());

		var exceed = false;
		if ((r_nflight_month1 != '' && (seats_offered * nflight_month1) < (quarter_month1 + foctraffic_month1)) || (r_nflight_month2 != '' && (seats_offered * nflight_month2) < (quarter_month2 + foctraffic_month2)) || (r_nflight_month3 != '' && (seats_offered * nflight_month3) < (quarter_month3 + foctraffic_month3))) {
			exceed = true;
		}
		if ((r_nflight_month1_d != '' && (seats_offered * nflight_month1_d) < (quarter_month1_d + foctraffic_month1_d)) || (r_nflight_month2_d != '' && (seats_offered * nflight_month2_d) < (quarter_month2_d + foctraffic_month2_d)) || (r_nflight_month3_d != '' && (seats_offered * nflight_month3_d) < (quarter_month3_d + foctraffic_month3_d))) {
			exceed = true;
		}
		if (exceed) {
			$('#loadFactorError').html(error_message);
		} else if ($('#loadFactorError').html() == error_message) {
			$('#loadFactorError').html('');
		}

		var ex_quarter_month1 = removeComma($('#ex_quarter_month1').val());
		var ex_quarter_month2 = removeComma($('#ex_quarter_month2').val());
		var ex_quarter_month3 = removeComma($('#ex_quarter_month3').val());
		var ex_quarter_month1_d = removeComma($('#ex_quarter_month1_d').val());
		var ex_quarter_month2_d = removeComma($('#ex_quarter_month2_d').val());
		var ex_quarter_month3_d = removeComma($('#ex_quarter_month3_d').val());
		var ex_nflight_month1 = removeComma($('#ex_nflight_month1').val());
		var ex_nflight_month2 = removeComma($('#ex_nflight_month2').val());
		var ex_nflight_month3 = removeComma($('#ex_nflight_month3').val());
		var ex_nflight_month1_d = removeComma($('#ex_nflight_month1_d').val());
		var ex_nflight_month2_d = removeComma($('#ex_nflight_month2_d').val());
		var ex_nflight_month3_d = removeComma($('#ex_nflight_month3_d').val());
		var ex_foctraffic_month1 = removeComma($('#ex_foctraffic_month1').val());
		var ex_foctraffic_month2 = removeComma($('#ex_foctraffic_month2').val());
		var ex_foctraffic_month3 = removeComma($('#ex_foctraffic_month3').val());
		var ex_foctraffic_month1_d = removeComma($('#ex_foctraffic_month1_d').val());
		var ex_foctraffic_month2_d = removeComma($('#ex_foctraffic_month2_d').val());
		var ex_foctraffic_month3_d = removeComma($('#ex_foctraffic_month3_d').val());

		var ex_exceed = false;
		if ((ex_nflight_month1 && (seats_offered * ex_nflight_month1) < (ex_quarter_month1 + ex_foctraffic_month1)) || (ex_nflight_month2 && (seats_offered * ex_nflight_month2) < (ex_quarter_month2 + ex_foctraffic_month2)) || (ex_nflight_month3 && (seats_offered * ex_nflight_month3) < (ex_quarter_month3 + ex_foctraffic_month3))) {
			ex_exceed = true;
		}
		if ((ex_nflight_month1_d && (seats_offered * ex_nflight_month1_d) < (ex_quarter_month1_d + ex_foctraffic_month1_d)) || (ex_nflight_month2_d && (seats_offered * ex_nflight_month2_d) < (ex_quarter_month2_d + ex_foctraffic_month2_d)) || (ex_nflight_month3_d && (seats_offered * ex_nflight_month3_d) < (ex_quarter_month3_d + ex_foctraffic_month3_d))) {
			ex_exceed = true;
		}
		if (ex_exceed) {
			$('#ex_loadFactorError').html(error_message);
		} else if ($('#ex_loadFactorError').html() == error_message) {
			$('#ex_loadFactorError').html('');
		}

		var cs_quarter_month1 = removeComma($('#cs_quarter_month1').val());
		var cs_quarter_month2 = removeComma($('#cs_quarter_month2').val());
		var cs_quarter_month3 = removeComma($('#cs_quarter_month3').val());
		var cs_quarter_month1_d = removeComma($('#cs_quarter_month1_d').val());
		var cs_quarter_month2_d = removeComma($('#cs_quarter_month2_d').val());
		var cs_quarter_month3_d = removeComma($('#cs_quarter_month3_d').val());
		var cs_nflight_month1 = removeComma($('#cs_nflight_month1').val());
		var cs_nflight_month2 = removeComma($('#cs_nflight_month2').val());
		var cs_nflight_month3 = removeComma($('#cs_nflight_month3').val());
		var cs_nflight_month1_d = removeComma($('#cs_nflight_month1_d').val());
		var cs_nflight_month2_d = removeComma($('#cs_nflight_month2_d').val());
		var cs_nflight_month3_d = removeComma($('#cs_nflight_month3_d').val());
		var cs_foctraffic_month1 = removeComma($('#cs_foctraffic_month1').val());
		var cs_foctraffic_month2 = removeComma($('#cs_foctraffic_month2').val());
		var cs_foctraffic_month3 = removeComma($('#cs_foctraffic_month3').val());
		var cs_foctraffic_month1_d = removeComma($('#cs_foctraffic_month1_d').val());
		var cs_foctraffic_month2_d = removeComma($('#cs_foctraffic_month2_d').val());
		var cs_foctraffic_month3_d = removeComma($('#cs_foctraffic_month3_d').val());

		var cs_exceed = false;
		if ((cs_nflight_month1 && (seats_offered * cs_nflight_month1) < (cs_quarter_month1 + cs_foctraffic_month1)) || (cs_nflight_month2 && (seats_offered * cs_nflight_month2) < (cs_quarter_month2 + cs_foctraffic_month2)) || (cs_nflight_month3 && (seats_offered * cs_nflight_month3) < (cs_quarter_month3 + cs_foctraffic_month3))) {
			cs_exceed = true;
		}
		if ((cs_nflight_month1_d && (seats_offered * cs_nflight_month1_d) < (cs_quarter_month1_d + cs_foctraffic_month1_d)) || (cs_nflight_month2_d && (seats_offered * cs_nflight_month2_d) < (cs_quarter_month2_d + cs_foctraffic_month2_d)) || (cs_nflight_month3_d && (seats_offered * cs_nflight_month3_d) < (cs_quarter_month3_d + cs_foctraffic_month3_d))) {
			cs_exceed = true;
		}
		if (cs_exceed) {
			$('#cs_loadFactorError').html(error_message);
		} else if ($('#cs_loadFactorError').html() == error_message) {
			$('#cs_loadFactorError').html('');
		}

		var ex_cs_quarter_month1 = removeComma($('#ex_cs_quarter_month1').val());
		var ex_cs_quarter_month2 = removeComma($('#ex_cs_quarter_month2').val());
		var ex_cs_quarter_month3 = removeComma($('#ex_cs_quarter_month3').val());
		var ex_cs_quarter_month1_d = removeComma($('#ex_cs_quarter_month1_d').val());
		var ex_cs_quarter_month2_d = removeComma($('#ex_cs_quarter_month2_d').val());
		var ex_cs_quarter_month3_d = removeComma($('#ex_cs_quarter_month3_d').val());
		var ex_cs_nflight_month1 = removeComma($('#ex_cs_nflight_month1').val());
		var ex_cs_nflight_month2 = removeComma($('#ex_cs_nflight_month2').val());
		var ex_cs_nflight_month3 = removeComma($('#ex_cs_nflight_month3').val());
		var ex_cs_nflight_month1_d = removeComma($('#ex_cs_nflight_month1_d').val());
		var ex_cs_nflight_month2_d = removeComma($('#ex_cs_nflight_month2_d').val());
		var ex_cs_nflight_month3_d = removeComma($('#ex_cs_nflight_month3_d').val());
		var ex_cs_foctraffic_month1 = removeComma($('#ex_cs_foctraffic_month1').val());
		var ex_cs_foctraffic_month2 = removeComma($('#ex_cs_foctraffic_month2').val());
		var ex_cs_foctraffic_month3 = removeComma($('#ex_cs_foctraffic_month3').val());
		var ex_cs_foctraffic_month1_d = removeComma($('#ex_cs_foctraffic_month1_d').val());
		var ex_cs_foctraffic_month2_d = removeComma($('#ex_cs_foctraffic_month2_d').val());
		var ex_cs_foctraffic_month3_d = removeComma($('#ex_cs_foctraffic_month3_d').val());

		var ex_cs_exceed = false;
		if ((ex_cs_nflight_month1 && (seats_offered * ex_cs_nflight_month1) < (ex_cs_quarter_month1 + ex_cs_foctraffic_month1)) || (ex_cs_nflight_month2 && (seats_offered * ex_cs_nflight_month2) < (ex_cs_quarter_month2 + ex_cs_foctraffic_month2)) || (ex_cs_nflight_month3 && (seats_offered * ex_cs_nflight_month3) < (ex_cs_quarter_month3 + ex_cs_foctraffic_month3))) {
			ex_cs_exceed = true;
		}
		if ((ex_cs_nflight_month1_d && (seats_offered * ex_cs_nflight_month1_d) < (ex_cs_quarter_month1_d + ex_cs_foctraffic_month1_d)) || (ex_cs_nflight_month2_d && (seats_offered * ex_cs_nflight_month2_d) < (ex_cs_quarter_month2_d + ex_cs_foctraffic_month2_d)) || (ex_cs_nflight_month3_d && (seats_offered * ex_cs_nflight_month3_d) < (ex_cs_quarter_month3_d + ex_cs_foctraffic_month3_d))) {
			ex_cs_exceed = true;
		}
		if (ex_cs_exceed) {
			$('#ex_cs_loadFactorError').html(error_message);
		} else if ($('#ex_cs_loadFactorError').html() == error_message) {
			$('#ex_cs_loadFactorError').html('');
		}
	}
	function computeTotal() {
		var rows = 0;
		var total_seats_offered = 0;
		var total_quarter_month1 = 0;
		var total_quarter_month2 = 0;
		var total_quarter_month3 = 0;
		var total_quarter_total = 0;
		var total_sub_total = 0;
		var total_seats_offered_d = 0;
		var total_quarter_month1_d = 0;
		var total_quarter_month2_d = 0;
		var total_quarter_month3_d = 0;
		var total_quarter_total_d = 0;
		var total_sub_total_d = 0;
		var total_total_rev_traffic = 0;
		$('#tableList tbody tr:visible').each(function() {
			if ($(this).find('.quarter_month1').length || $(this).find('.ex_quarter_month1').length) {
				rows++;
			}
			total_seats_offered += removeComma($(this).find('.seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.quarter_total').html());
			total_sub_total += removeComma($(this).find('.sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.total_rev_traffic').html());

			total_seats_offered += removeComma($(this).find('.ex_seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.ex_quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.ex_quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.ex_quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.ex_quarter_total').html());
			total_sub_total += removeComma($(this).find('.ex_sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.ex_seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.ex_quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.ex_quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.ex_quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.ex_quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.ex_sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.ex_total_rev_traffic').html());
		});
		var total_total_percent = ((total_seats_offered + total_seats_offered_d) > 0) ? (total_total_rev_traffic / (total_seats_offered + total_seats_offered_d)) * 100 : 0;
		$('.total_row .total_seats_offered').html(addComma(total_seats_offered, 0));
		$('.total_row .total_quarter_month1').html(addComma(total_quarter_month1, 0));
		$('.total_row .total_quarter_month2').html(addComma(total_quarter_month2, 0));
		$('.total_row .total_quarter_month3').html(addComma(total_quarter_month3, 0));
		$('.total_row .total_quarter_total').html(addComma(total_quarter_total, 0));
		$('.total_row .total_sub_total').html(addComma(total_sub_total, 0));
		$('.total_row .total_seats_offered_d').html(addComma(total_seats_offered_d, 0));
		$('.total_row .total_quarter_month1_d').html(addComma(total_quarter_month1_d, 0));
		$('.total_row .total_quarter_month2_d').html(addComma(total_quarter_month2_d, 0));
		$('.total_row .total_quarter_month3_d').html(addComma(total_quarter_month3_d, 0));
		$('.total_row .total_quarter_total_d').html(addComma(total_quarter_total_d, 0));
		$('.total_row .total_sub_total_d').html(addComma(total_sub_total_d, 0));
		$('.total_row .total_total_rev_traffic').html(addComma(total_total_rev_traffic, 0));
		$('.total_row .total_total_percent').html(addComma(total_total_percent) + '%');
	}
	function computeTotal2() {
		var rows = 0;
		var total_seats_offered = 0;
		var total_quarter_month1 = 0;
		var total_quarter_month2 = 0;
		var total_quarter_month3 = 0;
		var total_quarter_total = 0;
		var total_sub_total = 0;
		var total_seats_offered_d = 0;
		var total_quarter_month1_d = 0;
		var total_quarter_month2_d = 0;
		var total_quarter_month3_d = 0;
		var total_quarter_total_d = 0;
		var total_sub_total_d = 0;
		var total_total_rev_traffic = 0;
		$('#tableList2 tbody tr:visible').each(function() {
			if ($(this).find('.cs_quarter_month1').length || $(this).find('.ex_cs_quarter_month1').length) {
				rows++;
			}
			total_seats_offered += removeComma($(this).find('.cs_seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.cs_quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.cs_quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.cs_quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.cs_quarter_total').html());
			total_sub_total += removeComma($(this).find('.cs_sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.cs_seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.cs_quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.cs_quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.cs_quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.cs_quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.cs_sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.cs_total_rev_traffic').html());

			total_seats_offered += removeComma($(this).find('.ex_cs_seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.ex_cs_quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.ex_cs_quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.ex_cs_quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.ex_cs_quarter_total').html());
			total_sub_total += removeComma($(this).find('.ex_cs_sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.ex_cs_seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.ex_cs_quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.ex_cs_quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.ex_cs_quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.ex_cs_quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.ex_cs_sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.ex_cs_total_rev_traffic').html());
		});
		var total_total_percent = ((total_seats_offered + total_seats_offered_d) > 0) ? (total_total_rev_traffic / (total_seats_offered + total_seats_offered_d)) * 100 : 0;
		$('.total_row2 .total_seats_offered').html(addComma(total_seats_offered, 0));
		$('.total_row2 .total_quarter_month1').html(addComma(total_quarter_month1, 0));
		$('.total_row2 .total_quarter_month2').html(addComma(total_quarter_month2, 0));
		$('.total_row2 .total_quarter_month3').html(addComma(total_quarter_month3, 0));
		$('.total_row2 .total_quarter_total').html(addComma(total_quarter_total, 0));
		$('.total_row2 .total_sub_total').html(addComma(total_sub_total, 0));
		$('.total_row2 .total_seats_offered_d').html(addComma(total_seats_offered_d, 0));
		$('.total_row2 .total_quarter_month1_d').html(addComma(total_quarter_month1_d, 0));
		$('.total_row2 .total_quarter_month2_d').html(addComma(total_quarter_month2_d, 0));
		$('.total_row2 .total_quarter_month3_d').html(addComma(total_quarter_month3_d, 0));
		$('.total_row2 .total_quarter_total_d').html(addComma(total_quarter_total_d, 0));
		$('.total_row2 .total_sub_total_d').html(addComma(total_sub_total_d, 0));
		$('.total_row2 .total_total_rev_traffic').html(addComma(total_total_rev_traffic, 0));
		$('.total_row2 .total_total_percent').html(addComma(total_total_percent) + '%');
	}
	function computeTotal3() {
		var total_quarter_month1 = 0;
		var total_quarter_month2 = 0;
		var total_quarter_month3 = 0;
		var total_subtotal = 0;
		var total_quarter_month1_d = 0;
		var total_quarter_month2_d = 0;
		var total_quarter_month3_d = 0;
		var total_subtotal_d = 0;
		var total_total = 0;
		$('#tableList3 tbody tr').each(function() {
			total_quarter_month1 += removeComma($(this).find('.quarter_month1').val());
			total_quarter_month2 += removeComma($(this).find('.quarter_month2').val());
			total_quarter_month3 += removeComma($(this).find('.quarter_month3').val());
			total_subtotal += removeComma($(this).find('.subtotal').val());
			total_quarter_month1_d += removeComma($(this).find('.quarter_month1_d').val());
			total_quarter_month2_d += removeComma($(this).find('.quarter_month2_d').val());
			total_quarter_month3_d += removeComma($(this).find('.quarter_month3_d').val());
			total_subtotal_d += removeComma($(this).find('.subtotal_d').val());
			total_total += removeComma($(this).find('.total').val());
		});
		$('.total_row3 .total_quarter_month1').html(addComma(total_quarter_month1, 0));
		$('.total_row3 .total_quarter_month2').html(addComma(total_quarter_month2, 0));
		$('.total_row3 .total_quarter_month3').html(addComma(total_quarter_month3, 0));
		$('.total_row3 .total_subtotal').html(addComma(total_subtotal, 0));
		$('.total_row3 .total_quarter_month1_d').html(addComma(total_quarter_month1_d, 0));
		$('.total_row3 .total_quarter_month2_d').html(addComma(total_quarter_month2_d, 0));
		$('.total_row3 .total_quarter_month3_d').html(addComma(total_quarter_month3_d, 0));
		$('.total_row3 .total_subtotal_d').html(addComma(total_subtotal_d, 0));
		$('.total_row3 .total_total').html(addComma(total_total, 0));
	}
	function displayRoutes() {
		var destination_from = $('#destination_from').val() || 'ROUTE';
		var destination_to = $('#destination_to').val() || 'ROUTE';
		var extra_dest = $('#extra_dest').val() || 'ROUTE';
		
		var destination_from_label = destination_from + ' - ' + destination_to;
		var destination_to_label = destination_to + ' - ' + destination_from;
		var extra_from_label = extra_dest + ' - ' + destination_to;
		var extra_to_label = destination_to + ' - ' + extra_dest;

		$('.destination_from').html(destination_from_label);
		$('.destination_to').html(destination_to_label);
		$('.codeshared_from').html(destination_from_label);
		$('.codeshared_to').html(destination_to_label);
		$('.extra_from').html(extra_from_label);
		$('.extra_to').html(extra_to_label);
		$('.extra_codeshared_from').html(extra_from_label);
		$('.extra_codeshared_to').html(extra_to_label);
	}
	$('#destination_from, #destination_to, #extra_dest').on('change', function() {
		displayRoutes();
	});
	$('#addedRoutes').on('change', function() {
		var temp = $(this).val().split('|');
		var sector = temp[0] || 'FROM';
		var sector_d = temp[1] || 'TO';
		var sector_label = sector + '/' + sector_d;
		var sector_d_label = sector_d + '/' + sector;

		$('.sector_label').html(sector_label);
		$('.sector_d_label').html(sector_d_label);
	});
	var edit_row = '';
	var ex_edit_row = '';
	var cs_edit_row = '';
	var ex_cs_edit_row = '';
	$('#tableList').on('click', '.edit_entry', function(e) {
		e.preventDefault();
		$('#tableList tbody tr, #tableList2 tbody tr').removeClass('warning');
		edit_row = $(this).closest('tr');
		edit_row.addClass('warning');
		ex_edit_row = edit_row.next('tr');
		ex_edit_row.addClass('warning');

		var data_entry = edit_row.attr('data-entry');
		cs_edit_row = $('#tableList2').find('tr[data-entry="' + data_entry + '"]');
		cs_edit_row.addClass('warning');
		ex_cs_edit_row = cs_edit_row.next('tr');
		ex_cs_edit_row.addClass('warning');

		var row_values = JSON.parse(edit_row.find('.data_values').val());

		if (row_values.hasOwnProperty('extra')) {
			var extra = row_values['extra'];
			$('#fifth_freedom').iCheck('uncheck');
			$('#co_terminal').iCheck('uncheck');
			$('#direct').iCheck('uncheck');
			if (extra == 'fifth') {
				$('#fifth_freedom').iCheck('check');
			} else if (extra == 'co_te') {
				$('#co_terminal').iCheck('check');
			} else {
				$('#direct').iCheck('check');
			}
		}

		if (row_values.hasOwnProperty('codeshared')) {
			var codeshared = row_values['codeshared'];
			if (codeshared != '' && codeshared != 0 && codeshared != 'NO OPERATION') {
				$('#codeshared_checkbox').iCheck('check');
			} else {
				$('#codeshared_checkbox').iCheck('uncheck');
			}
		}

		for (var key in row_values) {
			if (row_values.hasOwnProperty(key)) {
				if ($('#entry_form #' + key).length) {
					$('#entry_form #' + key).val(row_values[key]);
					if ($('#entry_form #' + key).is('select')) {
						$('#entry_form #' + key).trigger('change');
					}
				}
			}
		}
		$('#economy').trigger('input');
		checkButtons();
		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');
		$('#entries .delete_entry').attr('disabled', true);
		$('#entry_form #add_entry').hide();
		$('#entry_form #update_entry').show();
		$('#entry_form #cancel_edit').show();
	});
	$('#tableList2').on('click', '.edit_entry', function(e) {
		e.preventDefault();
		var data_entry = $(this).closest('tr').attr('data-entry');
		$('#tableList').find('tr[data-entry="' + data_entry + '"]').find('.edit_entry').trigger('click');
	});
	$('#tableList3').on('click', '.edit_entry', function(e) {
		e.preventDefault();
		$('#tableList3 tbody tr').removeClass('warning');
		edit_row = $(this).closest('tr');
		edit_row.addClass('warning');

		$('#entry_form2 #addedRoutes').val(edit_row.find('.destination_from').val() + '|' + edit_row.find('.destination_to').val()).trigger('change');
		$('#entry_form2 #cargoRev').val(edit_row.find('.cargoRev').val());
		$('#entry_form2 #quarter_month1').val(edit_row.find('.quarter_month1').val());
		$('#entry_form2 #quarter_month2').val(edit_row.find('.quarter_month2').val());
		$('#entry_form2 #quarter_month3').val(edit_row.find('.quarter_month3').val());
		$('#entry_form2 #quarter_month1_d').val(edit_row.find('.quarter_month1_d').val());
		$('#entry_form2 #quarter_month2_d').val(edit_row.find('.quarter_month2_d').val());
		$('#entry_form2 #quarter_month3_d').val(edit_row.find('.quarter_month3_d').val());
		$('#entry_form2').find('.form-group').find('input, textarea, select').trigger('blur');
		$('#entries2 .delete_entry').attr('disabled', true);
		$('#entry_form2 #add_entry').hide();
		$('#entry_form2 #update_entry').show();
		$('#entry_form2 #cancel_edit').show();
	});
	$('#entry_form').on('ifToggled', '#codeshared_checkbox', function() {
		checkButtons();
	});
	$('#codeshared').closest('div').append('<p class="help-block m-none"></p>');
	$('#entry_form #update_entry').click(function() {
		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');
		if ($('#entry_form').find('.form-group.has-error').length == 0) {
			var data = {};
			$('#entry_form').serializeArray().map(function(x) {
				data[x.name] = x.value
			});
			updateRow(data);
			$('#entry_form #cancel_edit').trigger('click');
		} else {
			$('#entry_form').find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
	$('#entry_form2 #update_entry').click(function() {
		$('#entry_form2').find('.form-group').find('input, textarea, select').trigger('blur');
		if ($('#entry_form2').find('.form-group.has-error').length == 0) {
			var data = {};
			$('#entry_form2').serializeArray().map(function(x) {
				data[x.name] = x.value
			});
			updateRow2(data);
			$('#entry_form2 #cancel_edit').trigger('click');
		} else {
			$('#entry_form2').find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
	$('#entry_form #cancel_edit').click(function() {
		edit_row.removeClass('warning');
		edit_row = '';
		ex_edit_row.removeClass('warning');
		ex_edit_row = '';

		cs_edit_row.removeClass('warning');
		cs_edit_row = '';
		ex_cs_edit_row.removeClass('warning');
		ex_cs_edit_row = '';

		$('#entry_form #add_entry').show();
		$('#entry_form #update_entry').hide();
		$('#entry_form #cancel_edit').hide();
		$('#entry_form')[0].reset();
		$('#codeshared_checkbox, #direct, #fifth_freedom, #co_terminal').iCheck('update');
		$('#destination_from, #extra_dest, #destination_to').trigger('change.select2');
		$('#direct').iCheck('check').trigger('ifChecked');
		$('#entries.delete_entry').attr('disabled', false);

		var destination_label = 'ROUTE - ROUTE';
		$('.destination_from').html(destination_label);
		$('.destination_to').html(destination_label);
		$('.extra_from').html(destination_label);
		$('.extra_to').html(destination_label);
		$('.codeshared_from').html(destination_label);
		$('.codeshared_to').html(destination_label);
	});
	$('#entry_form2 #cancel_edit').click(function() {
		edit_row.removeClass('warning');
		edit_row = '';

		$('#entry_form2 #add_entry').show();
		$('#entry_form2 #update_entry').hide();
		$('#entry_form2 #cancel_edit').hide();
		$('#entry_form2')[0].reset();
		$('#entries2 .delete_entry').attr('disabled', false);

		$('.sector_label').html('FROM/TO');
		$('.sector_d_label').html('TO/FROM');
	});
	$('#entries .delete_entry').click(function() {
		$('#tableList tbody input[type="checkbox"]').each(function() {
			if ($(this).is(':checked')) {
				var main_row = $(this).closest('tr');
				var ex_main_row = main_row.next('tr');
				var data_entry = main_row.attr('data-entry');
				var other_row = $('#tableList2').find('tr[data-entry="' + data_entry + '"]');
				var ex_other_row = other_row.next('tr');

				main_row.remove();
				ex_main_row.remove();
				other_row.remove();
				ex_other_row.remove();
			}
		});
		$('#tableList2 tbody input[type="checkbox"]').each(function() {
			if ($(this).is(':checked')) {
				var main_row = $(this).closest('tr');
				var data_entry = main_row.attr('data-entry');
				var other_row = $('#tableList').find('tr[data-entry="' + data_entry + '"]');

				main_row.remove();
				other_row.remove();
			}
		});
		$('.selectall').iCheck('uncheck');
		if ($('#tableList tbody tr').length == 0) {
			addNoEntry();
		}
		if ($('#tableList2 tbody tr').length == 0) {
			addNoEntry2();
		}
		checkCodeSharedEntries();
		computeTotal();
		computeTotal2();
		checkButtons();
	});
	$('#entries2 .delete_entry').click(function() {
		$('#tableList3 tbody input[type="checkbox"]').each(function() {
			if ($(this).is(':checked')) {
				$(this).closest('tr').remove();
			}
		});
		$('.selectall').iCheck('uncheck');
		if ($('#tableList3 tbody tr').length == 0) {
			addNoEntry3();
		}
		computeTotal3();
		checkButtons();
	});
	function addNoEntry() {
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="19" class="text-center">Add Entry or Click No Operation</td></tr>`);
	}
	function addNoEntry2() {
		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="19" class="text-center">No Entries</td></tr>`);
	}
	function addNoEntry3() {
		$('#tableList3 tbody').html(`<tr class="no-entry"><td colspan="13" class="text-center">Add Entry or Click No Operation</td></tr>`);
	}
	addNoEntry();
	addNoEntry2();
	addNoEntry3();
	function checkButtons() {
		var has_entry = !! ($('#tableList tbody .entry').length);
		var has_entry2 = !! ($('#tableList2 tbody .entry').length);
		var has_entry3 = !! ($('#tableList3 tbody .entry').length);
		var no_operation = !! ($('#tableList tbody .no_operation').length);
		var no_operation2 = !! ($('#tableList2 tbody .no_operation').length);
		var no_operation3 = !! ($('#tableList3 tbody .no_operation').length);
		var page_no_operation = false;
		var page_has_entry = false;
		if ($('#direct_passenger.active').length) {
			page_no_operation = no_operation || no_operation2;
			page_has_entry = has_entry || has_entry2;
		} else if ($('#transit_passenger.active').length) {
			page_no_operation = no_operation3;
			page_has_entry = has_entry3;
		}
		$('#confirm_proceed').attr('disabled', ! ((has_entry || no_operation) && (has_entry2 || no_operation2)));
		$('#submit_report').attr('disabled', ! ((has_entry || no_operation) && (has_entry2 || no_operation2) && (has_entry3 || no_operation3)));
		$('#save_draft').attr('disabled', ! ((has_entry || no_operation) || (has_entry2 || no_operation2) && (has_entry3 || no_operation3)));
		$('#no_operation').attr('disabled', page_no_operation);
		$('.delete_entry').attr('disabled', ! page_has_entry);

		$('.entry_count').html($('#tableList tbody .entry').length);
		$('.entry_count_cs').html($('#tableList2 tbody .entry:visible').length);
		$('.entry_count_tran').html($('#tableList3 tbody .entry').length);

		$('#codeshared').attr('readonly', ! $('#codeshared_checkbox').is(':checked')).attr('data-validation', ($('#codeshared_checkbox').is(':checked')) ? 'required' : '');

		var not_extra = ($('#direct:checked').length) ? ':not(.extra_show)' : '';

		$('.codeshared_input' + not_extra + ' input').attr('readonly', ! $('#codeshared_checkbox').is(':checked')).attr('data-validation', ($('#codeshared_checkbox').is(':checked')) ? 'required integer' : 'integer');

		if ( ! $('#codeshared_checkbox').is(':checked')) {
			$('#codeshared').val('');
			$('.codeshared_input' + not_extra + ' input').val('');
		}
	}
	$('#entry_form').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0 && $('#loadFactorError').html() == '' && $('#ex_loadFactorError').html() == '' && $('#cs_loadFactorError').html() == '' && $('#ex_cs_loadFactorError').html() == '') {
			var data = {};
			$(this).serializeArray().map(function(x) {
				data[x.name] = x.value
			});
			$(this)[0].reset();
			$('#codeshared_checkbox, #direct, #fifth_freedom, #co_terminal').iCheck('update');
			$('#destination_from, #extra_dest, #destination_to').trigger('change.select2');
			$('#direct').iCheck('check').trigger('ifChecked');
			addRow(data);
			var destination_label = 'ROUTE - ROUTE';
			$('.destination_from').html(destination_label);
			$('.destination_to').html(destination_label);
			$('.extra_from').html(destination_label);
			$('.extra_to').html(destination_label);
			$('.codeshared_from').html(destination_label);
			$('.codeshared_to').html(destination_label);
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
		checkButtons();
	});
	$('#entry_form2').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			var data = {};
			$(this).serializeArray().map(function(x) {
				data[x.name] = x.value;
				if (x.name == 'addedRoutes') {
					var temp = x.value.split('|');
					data.destination_from = temp[0];
					data.destination_to = temp[1];
					data.aircraft = temp[2];
				}
			});
			$(this)[0].reset();
			addRow2(data);
			$('.sector_label').html('FROM/TO');
			$('.sector_d_label').html('TO/FROM');
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
		checkButtons();
	});
	var submit_type = '';
	$('#entries').submit(function(e) {
		e.preventDefault();
		var has_entry = !! ($('#tableList tbody .entry').length);
		var has_entry2 = !! ($('#tableList2 tbody .entry').length);
		var has_entry3 = !! ($('#tableList3 tbody .entry').length);
		var no_operation = !! ($('#tableList tbody .no_operation').length);
		var no_operation2 = !! ($('#tableList2 tbody .no_operation').length);
		var no_operation3 = !! ($('#tableList3 tbody .no_operation').length);
		var submit_report = (has_entry || no_operation) && (has_entry2 || no_operation2) && (has_entry3 || no_operation3);
		var save_draft = submit_type == 'draft' && ((has_entry || no_operation) || (has_entry2 || no_operation2) && (has_entry3 || no_operation3));
		if (submit_report || save_draft) {
			$('#submit_report').attr('disabled', true);
			$('#save_draft').attr('disabled', true);
			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '&' + $('#entries2').serialize() + '&report_quarter=<?php echo $report_quarter; ?>&year=<?php echo $year; ?>&submit_type=' + submit_type + '<?=$ajax_post?>', function(data) {
				if (data.success) {
					window.location = data.redirect;
				} else {
					checkButtons();
				}
			});
		}
	});
	$('#entry_form').on('ifChecked', '#fifth_freedom, #direct, #co_terminal', function() {
		var id = $(this).attr('id');
		if (id == 'direct') {
			hideExtra();
		} else {
			$('.extra_show').show();
			$('.extra_show input').attr('data-validation', 'required integer');
			$('.extra_show select').attr('data-validation', 'required');
			var options = '';
			if (id == 'fifth_freedom') {
				options = $('#dropdown_international').html();
			} else if (id == 'co_terminal') {
				options = $('#dropdown_mixed').html();
			}
			var prev_value = $('#extra_dest').val();
			$('#extra_dest').html(options);
			if ($('#extra_dest option[value="' + prev_value + '"]').length) {
				$('#extra_dest').val(prev_value);
			}
			displayRoutes();
		}
		$('.extra_show input').each(function() {
			if ($(this).closest('.form-group').find('p.help-block').html() == 'This field is required') {
				$(this).closest('.form-group').removeClass('has-error').find('p.help-block').html('');
			}
		});
		$('.extra_show select').each(function() {
			if ($(this).closest('.form-group').find('p.help-block').html() == 'This field is required') {
				$(this).closest('.form-group').removeClass('has-error').find('p.help-block').html('');
			}
		});
		checkButtons();
	});
	function hideExtra() {
		$('.extra_show').hide();
		$('.extra_show input').attr('data-validation', 'integer').val('');
		$('.extra_show select').attr('data-validation', '').val('').trigger('change');
	}
	hideExtra();
	$('#first, #business, #economy').on('input', function() {
		var total_seats = removeComma($('#first').val()) + removeComma($('#business').val()) + removeComma($('#economy').val());

		$('.total_seats p').html(addComma(total_seats, 0));
	});
	$('#submit_report').click(function() {
		submit_type = 'submit';
		$('#entries').submit();
	});
	$('#save_draft').click(function() {
		submit_type = 'draft';
		$('#entries').submit();
	});
	$('#no_operation').click(function() {
		var data = {};
		data.aircraft = 'NO OPERATION';
		if ($('#direct_passenger.active').length) {
			data.codeshared = 'NO OPERATION';
			$('#tableList2 tbody').html('');
			$('#tableList tbody').html('');
			addRow(data);
		}
		$('#tableList3 tbody').html('');
		addRow2(data);
		checkButtons();
	});
	function addRow(data) {
		data.codeshared = data.codeshared || '';
		var row2 = '';
		if (data.aircraft == 'NO OPERATION') {
			var fields = ['quarter_month1', 'quarter_month2', 'quarter_month3', 'quarter_total', 'foctraffic_month1', 'foctraffic_month2', 'foctraffic_month3', 'nflight_month1', 'nflight_month2', 'nflight_month3', 'seats_offered_d', 'quarter_month1_d', 'quarter_month2_d', 'quarter_month3_d', 'quarter_total_d', 'foctraffic_month1_d', 'foctraffic_month2_d', 'foctraffic_month3_d', 'nflight_month1_d', 'nflight_month2_d', 'nflight_month3_d'];

			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="19">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"><input type="hidden" name="economy[]" class="economy"><input type="hidden" name="business[]" class="business"><input type="hidden" name="first[]" class="first"><input type="hidden" name="destination_from[]" class="destination_from"><input type="hidden" name="destination_to[]" class="destination_to"><input type="hidden" name="seats_offered[]" class="seats_offered"><textarea name="data_values[]" class="data_values hidden">` + JSON.stringify(data) + `</textarea></td>
			`;
			fields.forEach(function(index) {
				row += `
					<input type="hidden" name="quarter_month1[]" class="quarter_month1">
				`;
			});
			row += '</tr>';

			var row2 = `
				<tr class="no_operation">
					<td class="text-center" colspan="19">NO OPERATION<input type="hidden" name="codeshared[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			row_num++;
			var total_seats = removeComma(data.business) + removeComma(data.economy) + removeComma(data.first);

			var quarter_total = removeComma(data.quarter_month1) + removeComma(data.quarter_month2) + removeComma(data.quarter_month3);
			var quarter_total_d = removeComma(data.quarter_month1_d) + removeComma(data.quarter_month2_d) + removeComma(data.quarter_month3_d);
			var total_rev_traffic = quarter_total + quarter_total_d;
			var seats_offered = (removeComma(data.nflight_month1) + removeComma(data.nflight_month2) + removeComma(data.nflight_month3)) * total_seats;
			var seats_offered_d = (removeComma(data.nflight_month1_d) + removeComma(data.nflight_month2_d) + removeComma(data.nflight_month3_d)) * total_seats;
			var total_percent = removeComma(addComma((total_rev_traffic / (seats_offered + seats_offered_d)) * 100));

			var ex_quarter_total = removeComma(data.ex_quarter_month1) + removeComma(data.ex_quarter_month2) + removeComma(data.ex_quarter_month3);
			var ex_quarter_total_d = removeComma(data.ex_quarter_month1_d) + removeComma(data.ex_quarter_month2_d) + removeComma(data.ex_quarter_month3_d);
			var ex_total_rev_traffic = ex_quarter_total + ex_quarter_total_d;
			var ex_seats_offered = (removeComma(data.ex_nflight_month1) + removeComma(data.ex_nflight_month2) + removeComma(data.ex_nflight_month3)) * total_seats;
			var ex_seats_offered_d = (removeComma(data.ex_nflight_month1_d) + removeComma(data.ex_nflight_month2_d) + removeComma(data.ex_nflight_month3_d)) * total_seats;
			var ex_total_percent = removeComma(addComma((ex_total_rev_traffic / (ex_seats_offered + ex_seats_offered_d)) * 100));

			var row = `
				<tr class="entry" data-entry="` + row_num + `">
					<td class="dyna_column"><input type="checkbox"></td>
					<td class="dyna_column"><span class="aircraft">` + data.aircraft + `</span></td>
					<td><span class="destination_from_to">` + data.destination_from + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="seats_offered">` + addComma(seats_offered, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month1">` + addComma(data.quarter_month1, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month2">` + addComma(data.quarter_month2, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month3">` + addComma(data.quarter_month3, 0) + `</span></td>
					<td class="text-right"><span class="quarter_total">` + addComma(quarter_total, 0) + `</span></td>
					<td class="text-right"><span class="sub_total">` + addComma(removeComma(data.foctraffic_month1) + removeComma(data.foctraffic_month2) + removeComma(data.foctraffic_month3), 0) + `</span></td>
					<td><span class="destination_to_from">` + data.destination_to + ' - ' + data.destination_from + `</span></td>
					<td class="text-right"><span class="seats_offered_d">` + addComma(seats_offered_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month1_d">` + addComma(data.quarter_month1_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month2_d">` + addComma(data.quarter_month2_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month3_d">` + addComma(data.quarter_month3_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_total_d">` + addComma(quarter_total_d, 0) + `</span></td>
					<td class="text-right"><span class="sub_total_d">` + addComma(removeComma(data.foctraffic_month1_d) + removeComma(data.foctraffic_month2_d) + removeComma(data.foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="total_rev_traffic">` + addComma(total_rev_traffic, 0) + `</span></td>
					<td class="text-right"><span class="total_percent">` + addComma(total_percent) + `%</span><textarea name="data_values[]" class="data_values hidden">` + JSON.stringify(data) + `</textarea></td>
					<td class="text-center dyna_column"><a href="#edit" class="edit_entry text-info">Edit</a></td>
				</tr>
				<tr>
					<td><span class="ex_destination_from_to">` + data.extra_dest + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="ex_seats_offered">` + addComma(ex_seats_offered, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month1">` + addComma(data.ex_quarter_month1, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month2">` + addComma(data.ex_quarter_month2, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month3">` + addComma(data.ex_quarter_month3, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_total">` + addComma(ex_quarter_total, 0) + `</span></td>
					<td class="text-right"><span class="ex_sub_total">` + addComma(removeComma(data.ex_foctraffic_month1) + removeComma(data.ex_foctraffic_month2) + removeComma(data.ex_foctraffic_month3), 0) + `</span></td>
					<td><span class="ex_destination_to_from">` + data.destination_to + ' - ' + data.extra_dest + `</span></td>
					<td class="text-right"><span class="ex_seats_offered_d">` + addComma(ex_seats_offered_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month1_d">` + addComma(data.ex_quarter_month1_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month2_d">` + addComma(data.ex_quarter_month2_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month3_d">` + addComma(data.ex_quarter_month3_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_total_d">` + addComma(ex_quarter_total_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_sub_total_d">` + addComma(removeComma(data.ex_foctraffic_month1_d) + removeComma(data.ex_foctraffic_month2_d) + removeComma(data.ex_foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="ex_total_rev_traffic">` + addComma(ex_total_rev_traffic, 0) + `</span></td>
					<td class="text-right"><span class="ex_total_percent">` + addComma(ex_total_percent) + `%</span></td>
				</tr>
			`;

			var cs_quarter_total = removeComma(data.cs_quarter_month1) + removeComma(data.cs_quarter_month2) + removeComma(data.cs_quarter_month3);
			var cs_quarter_total_d = removeComma(data.cs_quarter_month1_d) + removeComma(data.cs_quarter_month2_d) + removeComma(data.cs_quarter_month3_d);
			var cs_total_rev_traffic = cs_quarter_total + cs_quarter_total_d;
			var cs_seats_offered = (removeComma(data.cs_nflight_month1) + removeComma(data.cs_nflight_month2) + removeComma(data.cs_nflight_month3)) * total_seats;
			var cs_seats_offered_d = (removeComma(data.cs_nflight_month1_d) + removeComma(data.cs_nflight_month2_d) + removeComma(data.cs_nflight_month3_d)) * total_seats;
			var cs_total_percent = removeComma(addComma((cs_total_rev_traffic / (cs_seats_offered + cs_seats_offered_d)) * 100));

			var ex_cs_quarter_total = removeComma(data.ex_cs_quarter_month1) + removeComma(data.ex_cs_quarter_month2) + removeComma(data.ex_cs_quarter_month3);
			var ex_cs_quarter_total_d = removeComma(data.ex_cs_quarter_month1_d) + removeComma(data.ex_cs_quarter_month2_d) + removeComma(data.ex_cs_quarter_month3_d);
			var ex_cs_total_rev_traffic = ex_cs_quarter_total + ex_cs_quarter_total_d;
			var ex_cs_seats_offered = (removeComma(data.ex_cs_nflight_month1) + removeComma(data.ex_cs_nflight_month2) + removeComma(data.ex_cs_nflight_month3)) * total_seats;
			var ex_cs_seats_offered_d = (removeComma(data.ex_cs_nflight_month1_d) + removeComma(data.ex_cs_nflight_month2_d) + removeComma(data.ex_cs_nflight_month3_d)) * total_seats;
			var ex_cs_total_percent = removeComma(addComma((ex_cs_total_rev_traffic / (ex_cs_seats_offered + ex_cs_seats_offered_d)) * 100));

			var hidden = ! (data.codeshared != '' && data.codeshared != 0 && data.codeshared != 'NO OPERATION');

			var row2 = `
				<tr class="entry" data-entry="` + row_num + `">
					<td class="dyna_column"><input type="checkbox"></td>
					<td class="dyna_column"><span class="codeshared">` + data.codeshared + `</span></td>
					<td><span class="destination_from_to">` + data.destination_from + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="cs_seats_offered">` + addComma(cs_seats_offered, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_month1">` + addComma(data.cs_quarter_month1, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_month2">` + addComma(data.cs_quarter_month2, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_month3">` + addComma(data.cs_quarter_month3, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_total">` + addComma(cs_quarter_total, 0) + `</span></td>
					<td class="text-right"><span class="cs_sub_total">` + addComma(removeComma(data.cs_foctraffic_month1) + removeComma(data.cs_foctraffic_month2) + removeComma(data.cs_foctraffic_month3), 0) + `</span></td>
					<td class="text-right"><span class="destination_to_from">` + data.destination_to + ' - ' + data.destination_from + `</span></td>
					<td class="text-right"><span class="cs_seats_offered_d">` + addComma(cs_seats_offered_d, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_month1_d">` + addComma(data.cs_quarter_month1_d, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_month2_d">` + addComma(data.cs_quarter_month2_d, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_month3_d">` + addComma(data.cs_quarter_month3_d, 0) + `</span></td>
					<td class="text-right"><span class="cs_quarter_total_d">` + addComma(cs_quarter_total_d, 0) + `</span></td>
					<td class="text-right"><span class="cs_sub_total_d">` + addComma(removeComma(data.cs_foctraffic_month1_d) + removeComma(data.cs_foctraffic_month2_d) + removeComma(data.cs_foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="cs_total_rev_traffic">` + addComma(cs_total_rev_traffic, 0) + `</span></td>
					<td class="text-right"><span class="cs_total_percent">` + addComma(cs_total_percent) + `%</span></td>
					<td class="text-center dyna_column"><a href="#edit" class="edit_entry text-info">Edit</a></td>
				</tr>
				<tr>
					<td><span class="destination_from_to">` + data.extra_dest + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="ex_cs_seats_offered">` + ex_cs_seats_offered + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month1">` + data.ex_cs_quarter_month1 + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month2">` + data.ex_cs_quarter_month2 + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month3">` + data.ex_cs_quarter_month3 + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_total">` + cs_quarter_total + `</span></td>
					<td class="text-right"><span class="ex_cs_sub_total">` + addComma(removeComma(data.ex_cs_foctraffic_month1) + removeComma(data.ex_cs_foctraffic_month2) + removeComma(data.ex_cs_foctraffic_month3), 0) + `</span></td>
					<td class="text-right"><span class="destination_to_from">` + data.destination_to + ' - ' + data.extra_dest + `</span></td>
					<td class="text-right"><span class="ex_cs_seats_offered_d">` + ex_cs_seats_offered_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month1_d">` + data.ex_cs_quarter_month1_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month2_d">` + data.ex_cs_quarter_month2_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month3_d">` + data.ex_cs_quarter_month3_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_total_d">` + cs_quarter_total_d + `</span></td>
					<td class="text-right"><span class="ex_cs_sub_total_d">` + addComma(removeComma(data.ex_cs_foctraffic_month1_d) + removeComma(data.ex_cs_foctraffic_month2_d) + removeComma(data.ex_cs_foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="ex_cs_total_rev_traffic">` + ex_cs_total_rev_traffic + `</span></td>
					<td class="text-right"><span class="ex_cs_total_percent">` + addComma(ex_cs_total_percent) + `%</span></td>
				</tr>
			`;
		}
		$('#tableList tbody .no-entry').remove();
		$('#tableList tbody .no_operation').remove();
		$('#tableList tbody').append(row);
		$('#tableList2 tbody .no_operation').remove();
		$('#tableList2 tbody').append(row2);
		checkExtraDisplay(row_num);
		checkCodeSharedEntries();
		if ($('#tableList2 tbody tr').length == 0) {
			addNoEntry2();
		}
		if (typeof drawTemplate === 'function') {
			drawTemplate();
		}
		computeTotal();
		computeTotal2();
	}
	function addRow2(data) {
		if (data.aircraft == 'NO OPERATION' || data.destination_from == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="13">NO OPERATION<input type="hidden" name="t_destination_from[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			data.subtotal = removeComma(data.quarter_month1) + removeComma(data.quarter_month2) + removeComma(data.quarter_month3);
			data.subtotal_d = removeComma(data.quarter_month1_d) + removeComma(data.quarter_month2_d) + removeComma(data.quarter_month3_d);
			data.total = data.subtotal + data.subtotal_d;
			var row = `
				<tr class="entry">
					<td><input type="checkbox"></td>
					<td><span class="firstRoute">` + data.destination_from + ' - ' + data.destination_to + `</span><input type="hidden" name="t_destination_from[]" class="destination_from" value="` + data.destination_from + `"><input type="hidden" name="t_destination_to[]" class="destination_to" value="` + data.destination_to + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month1, 0) + `</span><input type="hidden" name="t_quarter_month1[]" class="quarter_month1" value="` + data.quarter_month1 + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month2, 0) + `</span><input type="hidden" name="t_quarter_month2[]" class="quarter_month2" value="` + data.quarter_month2 + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month3, 0) + `</span><input type="hidden" name="t_quarter_month3[]" class="quarter_month3" value="` + data.quarter_month3 + `"></td>
					<td class="text-right"><span>` + addComma(data.subtotal, 0) + `</span><input type="hidden" name="t_subtotal[]" class="subtotal" value="` + data.subtotal + `"></td>
					<td><span class="lastRoute">` + data.destination_to + ' - ' + data.destination_from + `</span></td>
					<td class="text-right"><span>` + addComma(data.quarter_month1_d, 0) + `</span><input type="hidden" name="t_quarter_month1_d[]" class="quarter_month1_d" value="` + data.quarter_month1_d + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month2_d, 0) + `</span><input type="hidden" name="t_quarter_month2_d[]" class="quarter_month2_d" value="` + data.quarter_month2_d + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month3_d, 0) + `</span><input type="hidden" name="t_quarter_month3_d[]" class="quarter_month3_d" value="` + data.quarter_month3_d + `"></td>
					<td class="text-right"><span>` + addComma(data.subtotal_d, 0) + `</span><input type="hidden" name="t_subtotal_d[]" class="subtotal_d" value="` + data.subtotal_d + `"></td>
					<td class="text-right"><span>` + addComma(data.total, 0) + `</span><input type="hidden" name="t_total[]" class="total" value="` + data.total + `"></td>
					<td class="text-center"><a href="#edit" class="edit_entry text-info">Edit</a></td>
				</tr>
			`;
		}
		$('#tableList3 tbody .no-entry').remove();
		$('#tableList3 tbody .no_operation').remove();
		$('#tableList3 tbody').append(row);
		computeTotal3();
		if (typeof drawTemplate === 'function') {
			drawTemplate();
		}
	}
	function updateRow(data) {
		var total_seats = removeComma(data.business) + removeComma(data.economy) + removeComma(data.first);

		var quarter_total = removeComma(data.quarter_month1) + removeComma(data.quarter_month2) + removeComma(data.quarter_month3);
		var quarter_total_d = removeComma(data.quarter_month1_d) + removeComma(data.quarter_month2_d) + removeComma(data.quarter_month3_d);
		var total_rev_traffic = quarter_total + quarter_total_d;
		var seats_offered = (removeComma(data.nflight_month1) + removeComma(data.nflight_month2) + removeComma(data.nflight_month3)) * total_seats;
		var seats_offered_d = (removeComma(data.nflight_month1_d) + removeComma(data.nflight_month2_d) + removeComma(data.nflight_month3_d)) * total_seats;
		var total_percent = removeComma(addComma((total_rev_traffic / (seats_offered + seats_offered_d)) * 100));

		var ex_quarter_total = removeComma(data.ex_quarter_month1) + removeComma(data.ex_quarter_month2) + removeComma(data.ex_quarter_month3);
		var ex_quarter_total_d = removeComma(data.ex_quarter_month1_d) + removeComma(data.ex_quarter_month2_d) + removeComma(data.ex_quarter_month3_d);
		var ex_total_rev_traffic = ex_quarter_total + ex_quarter_total_d;
		var ex_seats_offered = (removeComma(data.ex_nflight_month1) + removeComma(data.ex_nflight_month2) + removeComma(data.ex_nflight_month3)) * total_seats;
		var ex_seats_offered_d = (removeComma(data.ex_nflight_month1_d) + removeComma(data.ex_nflight_month2_d) + removeComma(data.nflight_month3_d)) * total_seats;
		var ex_total_percent = removeComma(addComma((ex_total_rev_traffic / (ex_seats_offered + ex_seats_offered_d)) * 100));

		edit_row.find('span.aircraft').html(data.aircraft);
		edit_row.find('span.destination_from_to').html(data.destination_from + ' - ' + data.destination_to);
		edit_row.find('span.destination_to_from').html(data.destination_to + ' - ' + data.destination_from);
		edit_row.find('span.seats_offered').html(addComma(seats_offered, 0));
		edit_row.find('span.quarter_month1').html(addComma(data.quarter_month1, 0));
		edit_row.find('span.quarter_month2').html(addComma(data.quarter_month2, 0));
		edit_row.find('span.quarter_month3').html(addComma(data.quarter_month3, 0));
		edit_row.find('span.quarter_total').html(addComma(quarter_total, 0));
		edit_row.find('span.sub_total').html(addComma(removeComma(data.foctraffic_month1) + removeComma(data.foctraffic_month2) + removeComma(data.foctraffic_month3), 0));
		edit_row.find('span.seats_offered_d').html(addComma(seats_offered_d, 0));
		edit_row.find('span.quarter_month1_d').html(addComma(data.quarter_month1_d, 0));
		edit_row.find('span.quarter_month2_d').html(addComma(data.quarter_month2_d, 0));
		edit_row.find('span.quarter_month3_d').html(addComma(data.quarter_month3_d, 0));
		edit_row.find('span.quarter_total_d').html(addComma(quarter_total_d, 0));
		edit_row.find('span.sub_total_d').html(addComma(removeComma(data.foctraffic_month1_d) + removeComma(data.foctraffic_month2_d) + removeComma(data.foctraffic_month3_d), 0));
		edit_row.find('span.total_rev_traffic').html(addComma(total_rev_traffic, 0));
		edit_row.find('span.total_percent').html(addComma(total_percent) + '%');
		edit_row.find('textarea.data_values').html(JSON.stringify(data));

		ex_edit_row.find('span.codeshared').html(data.codeshared);
		ex_edit_row.find('span.ex_destination_from_to').html(data.extra_dest + ' - ' + data.destination_to);
		ex_edit_row.find('span.ex_destination_to_from').html(data.destination_to + ' - ' + data.extra_dest);
		ex_edit_row.find('span.ex_seats_offered').html(addComma(ex_seats_offered, 0));
		ex_edit_row.find('span.ex_quarter_month1').html(addComma(data.ex_quarter_month1, 0));
		ex_edit_row.find('span.ex_quarter_month2').html(addComma(data.ex_quarter_month2, 0));
		ex_edit_row.find('span.ex_quarter_month3').html(addComma(data.ex_quarter_month3, 0));
		ex_edit_row.find('span.ex_quarter_total').html(addComma(ex_quarter_total, 0));
		ex_edit_row.find('span.ex_sub_total').html(addComma(removeComma(data.ex_foctraffic_month1) + removeComma(data.ex_foctraffic_month2) + removeComma(data.ex_foctraffic_month3), 0));
		ex_edit_row.find('span.ex_seats_offered_d').html(addComma(ex_seats_offered_d, 0));
		ex_edit_row.find('span.ex_quarter_month1_d').html(addComma(data.ex_quarter_month1_d, 0));
		ex_edit_row.find('span.ex_quarter_month2_d').html(addComma(data.ex_quarter_month2_d, 0));
		ex_edit_row.find('span.ex_quarter_month3_d').html(addComma(data.ex_quarter_month3_d, 0));
		ex_edit_row.find('span.ex_quarter_total_d').html(addComma(ex_quarter_total_d, 0));
		ex_edit_row.find('span.ex_sub_total_d').html(addComma(removeComma(data.ex_foctraffic_month1_d) + removeComma(data.ex_foctraffic_month2_d) + removeComma(data.ex_foctraffic_month3_d), 0));
		ex_edit_row.find('span.ex_total_rev_traffic').html(addComma(ex_total_rev_traffic, 0));
		ex_edit_row.find('span.ex_total_percent').html(addComma(ex_total_percent) + '%');

		var cs_quarter_total = removeComma(data.cs_quarter_month1) + removeComma(data.cs_quarter_month2) + removeComma(data.cs_quarter_month3);
		var cs_quarter_total_d = removeComma(data.cs_quarter_month1_d) + removeComma(data.cs_quarter_month2_d) + removeComma(data.cs_quarter_month3_d);
		var cs_total_rev_traffic = cs_quarter_total + cs_quarter_total_d;
		var cs_seats_offered = (removeComma(data.cs_nflight_month1) + removeComma(data.cs_nflight_month2) + removeComma(data.cs_nflight_month3)) * total_seats;
		var cs_seats_offered_d = (removeComma(data.cs_nflight_month1_d) + removeComma(data.cs_nflight_month2_d) + removeComma(data.cs_nflight_month3_d)) * total_seats;
		var cs_total_percent = removeComma(addComma((cs_total_rev_traffic / (cs_seats_offered + cs_seats_offered_d)) * 100));

		var ex_cs_quarter_total = removeComma(data.ex_cs_quarter_month1) + removeComma(data.ex_cs_quarter_month2) + removeComma(data.ex_cs_quarter_month3);
		var ex_cs_quarter_total_d = removeComma(data.ex_cs_quarter_month1_d) + removeComma(data.ex_cs_quarter_month2_d) + removeComma(data.ex_cs_quarter_month3_d);
		var ex_cs_total_rev_traffic = ex_cs_quarter_total + ex_cs_quarter_total_d;
		var ex_cs_seats_offered = (removeComma(data.ex_cs_nflight_month1) + removeComma(data.ex_cs_nflight_month2) + removeComma(data.ex_cs_nflight_month3)) * total_seats;
		var ex_cs_seats_offered_d = (removeComma(data.ex_cs_nflight_month1_d) + removeComma(data.ex_cs_nflight_month2_d) + removeComma(data.ex_cs_nflight_month3_d)) * total_seats;
		var ex_cs_total_percent = removeComma(addComma((ex_cs_total_rev_traffic / (ex_cs_seats_offered + ex_cs_seats_offered_d)) * 100));

		cs_edit_row.find('span.codeshared').html(data.codeshared);
		cs_edit_row.find('span.destination_from_to').html(data.destination_from + ' - ' + data.destination_to);
		cs_edit_row.find('span.destination_to_from').html(data.destination_to + ' - ' + data.destination_from);
		cs_edit_row.find('span.cs_seats_offered').html(addComma(cs_seats_offered, 0));
		cs_edit_row.find('span.cs_quarter_month1').html(addComma(data.cs_quarter_month1, 0));
		cs_edit_row.find('span.cs_quarter_month2').html(addComma(data.cs_quarter_month2, 0));
		cs_edit_row.find('span.cs_quarter_month3').html(addComma(data.cs_quarter_month3, 0));
		cs_edit_row.find('span.cs_quarter_total').html(addComma(cs_quarter_total, 0));
		cs_edit_row.find('span.cs_sub_total').html(addComma(removeComma(data.cs_foctraffic_month1) + removeComma(data.cs_foctraffic_month2) + removeComma(data.cs_foctraffic_month3), 0));
		cs_edit_row.find('span.cs_seats_offered_d').html(addComma(cs_seats_offered_d, 0));
		cs_edit_row.find('span.cs_quarter_month1_d').html(addComma(data.cs_quarter_month1_d, 0));
		cs_edit_row.find('span.cs_quarter_month2_d').html(addComma(data.cs_quarter_month2_d, 0));
		cs_edit_row.find('span.cs_quarter_month3_d').html(addComma(data.cs_quarter_month3_d, 0));
		cs_edit_row.find('span.cs_quarter_total_d').html(addComma(cs_quarter_total_d, 0));
		cs_edit_row.find('span.cs_sub_total_d').html(addComma(removeComma(data.cs_foctraffic_month1_d) + removeComma(data.cs_foctraffic_month2_d) + removeComma(data.cs_foctraffic_month3_d), 0));
		cs_edit_row.find('span.cs_total_rev_traffic').html(addComma(cs_total_rev_traffic, 0));
		cs_edit_row.find('span.cs_total_percent').html(addComma(cs_total_percent) + '%');

		ex_cs_edit_row.find('span.codeshared').html(data.codeshared);
		ex_cs_edit_row.find('span.destination_from_to').html(data.extra_dest + ' - ' + data.destination_to);
		ex_cs_edit_row.find('span.destination_to_from').html(data.destination_to + ' - ' + data.extra_dest);
		ex_cs_edit_row.find('span.ex_cs_seats_offered').html(addComma(ex_cs_seats_offered, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_month1').html(addComma(data.ex_cs_quarter_month1, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_month2').html(addComma(data.ex_cs_quarter_month2, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_month3').html(addComma(data.ex_cs_quarter_month3, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_total').html(addComma(ex_cs_quarter_total, 0));
		ex_cs_edit_row.find('span.ex_cs_sub_total').html(addComma(removeComma(data.ex_cs_foctraffic_month1) + removeComma(data.ex_cs_foctraffic_month2) + removeComma(data.ex_cs_foctraffic_month3), 0));
		ex_cs_edit_row.find('span.ex_cs_seats_offered_d').html(addComma(ex_cs_seats_offered_d, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_month1_d').html(addComma(data.ex_cs_quarter_month1_d, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_month2_d').html(addComma(data.ex_cs_quarter_month2_d, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_month3_d').html(addComma(data.ex_cs_quarter_month3_d, 0));
		ex_cs_edit_row.find('span.ex_cs_quarter_total_d').html(addComma(ex_cs_quarter_total_d, 0));
		ex_cs_edit_row.find('span.ex_cs_sub_total_d').html(addComma(removeComma(data.ex_cs_foctraffic_month1_d) + removeComma(data.ex_cs_foctraffic_month2_d) + removeComma(data.ex_cs_foctraffic_month3_d), 0));
		ex_cs_edit_row.find('span.ex_cs_total_rev_traffic').html(addComma(ex_cs_total_rev_traffic, 0));
		ex_cs_edit_row.find('span.ex_cs_total_percent').html(addComma(ex_cs_total_percent) + '%');

		checkExtraDisplay(edit_row.attr('data-entry'));
		checkCodeSharedEntries();
		computeTotal();
		computeTotal2();
	}
	function updateRow2(data) {
		var temp = data.addedRoutes.split('|');
		data.destination_from = temp[0];
		data.destination_to = temp[1];
		data.subtotal = removeComma(data.quarter_month1) + removeComma(data.quarter_month2) + removeComma(data.quarter_month3);
		data.subtotal_d = removeComma(data.quarter_month1_d) + removeComma(data.quarter_month2_d) + removeComma(data.quarter_month3_d);
		data.total = data.subtotal + data.subtotal_d;

		edit_row.find('.destination_from').val(data.destination_from);
		edit_row.find('.destination_to').val(data.destination_to);
		edit_row.find('.quarter_month1').val(data.quarter_month1).closest('td').find('span').html(addComma(data.quarter_month1, 0))
		edit_row.find('.quarter_month2').val(data.quarter_month2).closest('td').find('span').html(addComma(data.quarter_month2, 0))
		edit_row.find('.quarter_month3').val(data.quarter_month3).closest('td').find('span').html(addComma(data.quarter_month3, 0))
		edit_row.find('.subtotal').val(data.subtotal).closest('td').find('span').html(addComma(data.subtotal, 0))
		edit_row.find('.quarter_month1_d').val(data.quarter_month1_d).closest('td').find('span').html(addComma(data.quarter_month1_d, 0))
		edit_row.find('.quarter_month2_d').val(data.quarter_month2_d).closest('td').find('span').html(addComma(data.quarter_month2_d, 0))
		edit_row.find('.quarter_month3_d').val(data.quarter_month3_d).closest('td').find('span').html(addComma(data.quarter_month3_d, 0))
		edit_row.find('.subtotal_d').val(data.subtotal_d).closest('td').find('span').html(addComma(data.subtotal_d, 0))
		edit_row.find('.total').val(data.total).closest('td').find('span').html(addComma(data.total, 0))
		edit_row.find('.firstRoute').html(data.destination_from + ' - ' + data.destination_to);
		edit_row.find('.lastRoute').html(data.destination_to + ' - ' + data.destination_from);

		computeTotal3();
	}
	report_details.forEach(function(data) {
		addRow(data);
	});
	report_details2.forEach(function(data) {
		addRow2(data);
	});
	checkButtons();
	function checkCodeSharedEntries() {
		if ($('#tableList2 tbody tr.entry:visible').length || $('#tableList2 tbody tr.no_operation:visible').length) {
			$('#tableList2 tbody .no-entry').hide();
		} else {
			$('#tableList2 tbody .no-entry').show();
		}
	}
	function checkExtraDisplay(row_num) {
		var main_row = $('#tableList tr[data-entry="' + row_num + '"]');
		var ex_edit_row = $('#tableList tr[data-entry="' + row_num + '"] + tr');
		var cs_row = $('#tableList2 tr[data-entry="' + row_num + '"]');
		var ex_cs_row = $('#tableList2 tr[data-entry="' + row_num + '"] + tr');

		var data_values = JSON.parse(main_row.find('.data_values').val() || '{}');
		var rowspan = ((data_values.extra || 'no') == 'no') ? 1 : 2;
		var visible = ! ((data_values.extra || 'no') == 'no')

		main_row.find('.dyna_column').attr('rowspan', rowspan);
		cs_row.find('.dyna_column').attr('rowspan', rowspan);

		ex_edit_row.toggle(visible);
		ex_cs_row.toggle(visible);

		cs_row.toggle( !! (data_values.codeshared));
		ex_cs_row.toggle( !! (data_values.codeshared) && visible);
	}
	function getRoutes() {
		added_routes = [];
		$('#addedRoutes').html('<option></option>');
		$('#tableList tbody .entry').each(function() {
			var data_values = JSON.parse($(this).find('.data_values').val());
			$('#addedRoutes').append('<option value="' +  data_values.destination_from + '|' + data_values.destination_to + '">' + data_values.destination_from + '-' + data_values.destination_to + '</option>');
		});
	}
</script>