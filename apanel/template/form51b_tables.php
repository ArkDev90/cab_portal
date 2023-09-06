<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="11">DIRECT CARGO (Kilograms)</th>
			</tr>
			<tr class="info">
				<th rowspan="2" class="col-md-1">AIRCRAFT</th>
				<th rowspan="2" class="col-md-1">ROUTE</th>
				<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
				<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
				<th rowspan="2" class="col-md-1">ROUTE</th>
				<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
				<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
			</tr>
			<tr class="info">
				<th>REVENUE</th>
				<th>NON REVENUE</th>
				<th>REVENUE</th>
				<th>NON REVENUE</th>
				<th>REVENUE</th>
				<th>NON REVENUE</th>
				<th>REVENUE</th>
				<th>NON REVENUE</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows				= 0;
				$total_cargoRev			= 0;
				$total_cargoNonRev		= 0;
				$total_mailRev			= 0;
				$total_mailNonRev		= 0;
				$total_cargoRevDep		= 0;
				$total_cargoNonRevDep	= 0;
				$total_mailRevDep		= 0;
				$total_mailNonRevDep	= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($direct) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="11">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr class="no_operation">
						<td class="text-center" colspan="11">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_cargoRev			+= $row->cargoRev;
						$total_cargoNonRev		+= $row->cargoNonRev;
						$total_mailRev			+= $row->mailRev;
						$total_mailNonRev		+= $row->mailNonRev;
						$total_cargoRevDep		+= $row->cargoRevDep;
						$total_cargoNonRevDep	+= $row->cargoNonRevDep;
						$total_mailRevDep		+= $row->mailRevDep;
						$total_mailNonRevDep	+= $row->mailNonRevDep;

						if ($key == 0 || $prev_sector != $row->routeTo || $prev_sector_d != $row->routeFrom) {
							$sub_entries				= 0;
							$subtotal_cargoRev			= 0;
							$subtotal_cargoNonRev		= 0;
							$subtotal_mailRev			= 0;
							$subtotal_mailNonRev		= 0;
							$subtotal_cargoRevDep		= 0;
							$subtotal_cargoNonRevDep	= 0;
							$subtotal_mailRevDep		= 0;
							$subtotal_mailNonRevDep		= 0;
						}

						$prev_sector	= $row->routeTo;
						$prev_sector_d	= $row->routeFrom;

						$sub_entries++;
						$subtotal_cargoRev			+= $row->cargoRev;
						$subtotal_cargoNonRev		+= $row->cargoNonRev;
						$subtotal_mailRev			+= $row->mailRev;
						$subtotal_mailNonRev		+= $row->mailNonRev;
						$subtotal_cargoRevDep		+= $row->cargoRevDep;
						$subtotal_cargoNonRevDep	+= $row->cargoNonRevDep;
						$subtotal_mailRevDep		+= $row->mailRevDep;
						$subtotal_mailNonRevDep		+= $row->mailNonRevDep;
					?>
					<tr>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->routeFrom . ' - ' . $row->routeTo ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoRev, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoNonRev, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailRev, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailNonRev, 2) ?>
						</td>
						<td>
							<?php echo $row->routeTo . ' - ' . $row->routeFrom ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoRevDep, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoNonRevDep, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailRevDep, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailNonRevDep, 2) ?>
						</td>
					</tr>

					<?php if ( ! isset($direct[$key + 1]) || $prev_sector != $direct[$key + 1]->routeTo || $prev_sector_d != $direct[$key + 1]->routeFrom): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoRev, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoNonRev, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailRev, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailNonRev, 2) ?>
							</td>
							<td>

							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoRevDep, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoNonRevDep, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailRevDep, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailNonRevDep, 2) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row">
				<th colspan="2" class="text-right">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoRev, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoNonRev, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailRev, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailNonRev, 2) ?></th>
				<th></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoRevDep, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoNonRevDep, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailRevDep, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailNonRevDep, 2) ?></th>
			</tr>
			<tr class="info">
				<td colspan="8" id="pagination"></td>
				<td colspan="3" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="table-responsive mb-xs">
	<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="11">TRANSIT CARGO (Kilograms)</th>
			</tr>
			<tr class="info">
				<th rowspan="2" class="col-md-1">AIRCRAFT</th>
				<th rowspan="2" class="col-md-1">ROUTE</th>
				<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
				<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
				<th rowspan="2" class="col-md-1">ROUTE</th>
				<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
				<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
			</tr>
			<tr class="info">
				<th>REVENUE</th>
				<th>NON REVENUE</th>
				<th>REVENUE</th>
				<th>NON REVENUE</th>
				<th>REVENUE</th>
				<th>NON REVENUE</th>
				<th>REVENUE</th>
				<th>NON REVENUE</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows				= 0;
				$total_cargoRev			= 0;
				$total_cargoNonRev		= 0;
				$total_mailRev			= 0;
				$total_mailNonRev		= 0;
				$total_cargoRevDep		= 0;
				$total_cargoNonRevDep	= 0;
				$total_mailRevDep		= 0;
				$total_mailNonRevDep	= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($transit) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="11">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($transit as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr class="no_operation">
						<td class="text-center" colspan="11">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_cargoRev			+= $row->cargoRev;
						$total_cargoNonRev		+= $row->cargoNonRev;
						$total_mailRev			+= $row->mailRev;
						$total_mailNonRev		+= $row->mailNonRev;
						$total_cargoRevDep		+= $row->cargoRevDep;
						$total_cargoNonRevDep	+= $row->cargoNonRevDep;
						$total_mailRevDep		+= $row->mailRevDep;
						$total_mailNonRevDep	+= $row->mailNonRevDep;

						if ($key == 0 || $prev_sector != $row->routeTo || $prev_sector_d != $row->routeFrom) {
							$sub_entries				= 0;
							$subtotal_cargoRev			= 0;
							$subtotal_cargoNonRev		= 0;
							$subtotal_mailRev			= 0;
							$subtotal_mailNonRev		= 0;
							$subtotal_cargoRevDep		= 0;
							$subtotal_cargoNonRevDep	= 0;
							$subtotal_mailRevDep		= 0;
							$subtotal_mailNonRevDep		= 0;
						}

						$prev_sector	= $row->routeTo;
						$prev_sector_d	= $row->routeFrom;

						$sub_entries++;
						$subtotal_cargoRev			+= $row->cargoRev;
						$subtotal_cargoNonRev		+= $row->cargoNonRev;
						$subtotal_mailRev			+= $row->mailRev;
						$subtotal_mailNonRev		+= $row->mailNonRev;
						$subtotal_cargoRevDep		+= $row->cargoRevDep;
						$subtotal_cargoNonRevDep	+= $row->cargoNonRevDep;
						$subtotal_mailRevDep		+= $row->mailRevDep;
						$subtotal_mailNonRevDep		+= $row->mailNonRevDep;
					?>
					<tr>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->routeFrom . ' - ' . $row->routeTo ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoRev, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoNonRev, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailRev, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailNonRev, 2) ?>
						</td>
						<td>
							<?php echo $row->routeTo . ' - ' . $row->routeFrom ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoRevDep, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargoNonRevDep, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailRevDep, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->mailNonRevDep, 2) ?>
						</td>
					</tr>

					<?php if ( ! isset($transit[$key + 1]) || $prev_sector != $transit[$key + 1]->routeTo || $prev_sector_d != $transit[$key + 1]->routeFrom): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoRev, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoNonRev, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailRev, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailNonRev, 2) ?>
							</td>
							<td>

							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoRevDep, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargoNonRevDep, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailRevDep, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_mailNonRevDep, 2) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoRev, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoNonRev, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailRev, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailNonRev, 2) ?></th>
				<th></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoRevDep, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargoNonRevDep, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailRevDep, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_mailNonRevDep, 2) ?></th>
			</tr>
			<tr class="info">
				<td colspan="8" id="pagination"></td>
				<td colspan="3" class="text-center blue_text"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>