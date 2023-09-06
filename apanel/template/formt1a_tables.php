<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="col-md-3">SECTOR</th>
				<th class="col-md-2">DISTANCE(Kilometers)</th>
				<th class="col-md-1">AVAILABLE SEAT-KMS OFFERED</th>
				<th class="col-md-1">AVAILABLE SEATS</th>
				<th class="col-md-1">REVENUE PASSENGERS</th>
				<th class="col-md-1">NON-REVENUE PASSENGERS</th>
				<th class="col-md-1">PASSENGER LOAD FACTOR</th>
				<th class="col-md-1">CARGO(Kilograms)</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows = 0;
				$total_distance = 0;
				$total_sk_offered = 0;
				$total_seats_offered = 0;
				$total_rev_pass = 0;
				$total_nonrev_pass = 0;
				$total_load_factor = 0;
				$total_cargo = 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($direct) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="8">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $key => $row): ?>
				<?php if ($row->sector == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="8">NO OPERATION</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;

						$sk_offered = $row->distance * $row->seats_offered;
						$load_factor = ($row->seats_offered > 0) ? ($row->rev_pass / $row->seats_offered) * 100 : 0;
						$sk_offered_d = $row->distance_d * $row->seats_offered_d;
						$load_factor_d = ($row->seats_offered_d > 0) ? ($row->rev_pass_d / $row->seats_offered_d) * 100 : 0;

						$total_distance			+= $row->distance;
						$total_distance			+= $row->distance_d;
						$total_sk_offered		+= $sk_offered;
						$total_sk_offered		+= $sk_offered_d;
						$total_seats_offered	+= $row->seats_offered;
						$total_seats_offered	+= $row->seats_offered_d;
						$total_rev_pass			+= $row->rev_pass;
						$total_rev_pass			+= $row->rev_pass_d;
						$total_nonrev_pass		+= $row->nonrev_pass;
						$total_nonrev_pass		+= $row->nonrev_pass_d;
						$total_cargo			+= $row->cargo;
						$total_cargo			+= $row->cargo_d;

						if ($key == 0 || $prev_sector != $row->sector || $prev_sector_d != $row->sector_d) {
							$sub_entries				= 0;
							$subtotal_distance			= 0;
							$subtotal_sk_offered		= 0;
							$subtotal_seats_offered		= 0;
							$subtotal_rev_pass			= 0;
							$subtotal_nonrev_pass		= 0;
							$subtotal_load_factor		= 0;
							$subtotal_cargo				= 0;
						}

						$prev_sector	= $row->sector;
						$prev_sector_d	= $row->sector_d;

						$sub_entries++;
						$subtotal_distance			+= $row->distance;
						$subtotal_distance			+= $row->distance_d;
						$subtotal_sk_offered		+= $sk_offered;
						$subtotal_sk_offered		+= $sk_offered_d;
						$subtotal_seats_offered		+= $row->seats_offered;
						$subtotal_seats_offered		+= $row->seats_offered_d;
						$subtotal_rev_pass			+= $row->rev_pass;
						$subtotal_rev_pass			+= $row->rev_pass_d;
						$subtotal_nonrev_pass		+= $row->nonrev_pass;
						$subtotal_nonrev_pass		+= $row->nonrev_pass_d;
						$subtotal_cargo				+= $row->cargo;
						$subtotal_cargo				+= $row->cargo_d;
					?>
					<tr>
						<td class="text-center">
							<?php echo $row->sector . '/' . $row->sector_d ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->distance, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sk_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->rev_pass, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->nonrev_pass, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($load_factor, 2) ?>%
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargo, 0) ?>
						</td>
					</tr>
					<tr>
						<td class="text-center">
							<?php echo $row->sector_d. '/' . $row->sector ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->distance_d, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sk_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->rev_pass_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->nonrev_pass_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($load_factor_d, 2) ?>%
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargo_d, 0) ?>
						</td>
					</tr>

					<?php if ( ! isset($direct[$key + 1]) || $prev_sector != $direct[$key + 1]->sector || $prev_sector_d != $direct[$key + 1]->sector_d): ?>
						<tr class="info">
							<td class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_distance, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sk_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_rev_pass, 0) ?></td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_nonrev_pass, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format((($subtotal_seats_offered) ? ($subtotal_rev_pass / $subtotal_seats_offered) * 100 : 0), 2) ?>%
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargo, 0) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_distance, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_sk_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_seats_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_rev_pass, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_nonrev_pass, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format((($total_seats_offered) ? ($total_rev_pass / $total_seats_offered) * 100 : 0), 2) ?>%</th>
				<th class="text-right blue_text"><?php echo number_format($total_cargo, 0) ?></th>
			</tr>
			<tr class="info">
				<td colspan="6" id="pagination"></td>
				<td colspan="2" class="text-center blue_text"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="table-responsive mb-xs">
	<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="9">CODE SHARED</th>
			</tr>
			<tr class="info">
				<th class="col-md-2">MARKETING AIRLINE</th>
				<th class="col-md-2">SECTOR</th>
				<th class="col-md-1">DISTANCE(Kilometers)</th>
				<th class="col-md-1">AVAILABLE SEAT-KMS OFFERED</th>
				<th class="col-md-1">AVAILABLE SEATS</th>
				<th class="col-md-1">REVENUE PASSENGERS</th>
				<th class="col-md-1">NON-REVENUE PASSENGERS</th>
				<th class="col-md-1">PASSENGER LOAD FACTOR</th>
				<th class="col-md-1">CARGO(Kilograms)</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows = 0;
				$total_distance = 0;
				$total_sk_offered = 0;
				$total_seats_offered = 0;
				$total_rev_pass = 0;
				$total_nonrev_pass = 0;
				$total_load_factor = 0;
				$total_cargo = 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($direct_cs) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="9">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct_cs as $key => $row): ?>
				<?php if ($row->sector == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="9">NO OPERATION</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;

						$sk_offered = $row->distance * $row->seats_offered;
						$load_factor = ($row->seats_offered > 0) ? ($row->rev_pass / $row->seats_offered) * 100 : 0;
						$sk_offered_d = $row->distance_d * $row->seats_offered_d;
						$load_factor_d = ($row->seats_offered_d > 0) ? ($row->rev_pass_d / $row->seats_offered_d) * 100 : 0;

						$total_distance			+= $row->distance;
						$total_distance			+= $row->distance_d;
						$total_sk_offered		+= $sk_offered;
						$total_sk_offered		+= $sk_offered_d;
						$total_seats_offered	+= $row->seats_offered;
						$total_seats_offered	+= $row->seats_offered_d;
						$total_rev_pass			+= $row->rev_pass;
						$total_rev_pass			+= $row->rev_pass_d;
						$total_nonrev_pass		+= $row->nonrev_pass;
						$total_nonrev_pass		+= $row->nonrev_pass_d;
						$total_cargo			+= $row->cargo;
						$total_cargo			+= $row->cargo_d;

						if ($key == 0 || $prev_sector != $row->sector || $prev_sector_d != $row->sector_d) {
							$sub_entries				= 0;
							$subtotal_distance			= 0;
							$subtotal_sk_offered		= 0;
							$subtotal_seats_offered		= 0;
							$subtotal_rev_pass			= 0;
							$subtotal_nonrev_pass		= 0;
							$subtotal_load_factor		= 0;
							$subtotal_cargo				= 0;
						}

						$prev_sector	= $row->sector;
						$prev_sector_d	= $row->sector_d;

						$sub_entries++;
						$subtotal_distance			+= $row->distance;
						$subtotal_distance			+= $row->distance_d;
						$subtotal_sk_offered		+= $sk_offered;
						$subtotal_sk_offered		+= $sk_offered_d;
						$subtotal_seats_offered		+= $row->seats_offered;
						$subtotal_seats_offered		+= $row->seats_offered_d;
						$subtotal_rev_pass			+= $row->rev_pass;
						$subtotal_rev_pass			+= $row->rev_pass_d;
						$subtotal_nonrev_pass		+= $row->nonrev_pass;
						$subtotal_nonrev_pass		+= $row->nonrev_pass_d;
						$subtotal_cargo				+= $row->cargo;
						$subtotal_cargo				+= $row->cargo_d;
					?>
					<tr>
						<td rowspan="2" class="text-center">
							<?php echo $row->codeshared ?>
						</td>
						<td class="text-center">
							<?php echo $row->sector . '/' . $row->sector_d ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->distance, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sk_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->rev_pass, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->nonrev_pass, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($load_factor, 2) ?>%
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargo, 0) ?>
						</td>
					</tr>
					<tr>
						<td class="text-center">
							<?php echo $row->sector_d. '/' . $row->sector ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->distance_d, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sk_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->rev_pass_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->nonrev_pass_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($load_factor_d, 2) ?>%
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargo_d, 0) ?>
						</td>
					</tr>
					
					<?php if ( ! isset($direct[$key + 1]) || $prev_sector != $direct[$key + 1]->sector || $prev_sector_d != $direct[$key + 1]->sector_d): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_distance, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sk_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_rev_pass, 0) ?></td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_nonrev_pass, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format((($subtotal_seats_offered) ? ($subtotal_rev_pass / $subtotal_seats_offered) * 100 : 0), 2) ?>%
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cargo, 0) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_distance, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_sk_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_seats_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_rev_pass, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_nonrev_pass, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format((($total_seats_offered) ? ($total_rev_pass / $total_seats_offered) * 100 : 0), 2) ?>%</th>
				<th class="text-right blue_text"><?php echo number_format($total_cargo, 0) ?></th>
			</tr>
			<tr class="info">
				<td colspan="7" id="pagination"></td>
				<td colspan="2" class="text-center blue_text"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>