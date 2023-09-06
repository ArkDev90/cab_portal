<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="col-md-2" rowspan="2">DATE</th>
				<th class="col-md-2" rowspan="2">BASE OF OPERATION</th>
				<th class="col-md-2" colspan="2">AIRCRAFT</th>
				<th class="col-md-2" colspan="2">ROUTES SERVED</th>
				<th class="col-md-1" rowspan="2">DISTANCE TRAVELLED (Kilometers)</th>
				<th class="col-md-1" colspan="2">A/C FLYING TIME</th>
				<th class="col-md-1" rowspan="2">NUMBER OF PASSENGERS CARRIED</th>
				<th class="col-md-1" colspan="2">CARGO CARRIED</th>
				<th class="col-md-1" rowspan="2">REVENUE DERIVED (Philippine Peso)</th>
			</tr>
			<tr class="info">
				<th>TYPE</th>
				<th>NUMBER</th>
				<th>ORIGIN</th>
				<th>DESTINATION</th>
				<th>HOURS</th>
				<th>MINUTES</th>
				<th>QTY</th>
				<th>VALUE</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows				= 0;
				$total_distance			= 0;
				$total_flown_hour		= 0;
				$total_flown_min		= 0;
				$total_passengers_num	= 0;
				$total_cargo_qty		= 0;
				$total_cargo_value		= 0;
				$total_revenue			= 0;
			?>
			<?php if (empty($direct) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="12">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr class="no_operation">
						<td class="text-center" colspan="12">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_distance			+= $row->distance;
						$total_flown_hour		+= $row->flown_hour;
						$total_flown_min		+= $row->flown_min;
						$total_passengers_num	+= $row->passengers_num;
						$total_cargo_qty		+= $row->cargo_qty;
						$total_cargo_value		+= $row->cargo_value;
						$total_revenue			+= $row->revenue;

						$x = $row->flown_min / 60;
						$y = floor($x);
						$dec = $y * 60;
						$row->flown_min = $row->flown_min - $dec;
						$row->flown_hour = $row->flown_hour + $y;
					?>
					<tr>
						<td class="text-center">
							<?php echo $period . ' ' . $row->report_day ?>
						</td>
						<td class="text-center">
							<?php echo $operation ?>
						</td>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->aircraft_num ?>
						</td>
						<td>
							<?php echo $row->origin ?>
						</td>
						<td>
							<?php echo $row->destination ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->distance, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->flown_hour, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->flown_min, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->passengers_num, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargo_qty, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cargo_value, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->revenue, 2) ?>
						</td>
					</tr>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<?php
				$hour_min = $total_flown_min / 60;
				$whole = floor($hour_min);
				$hour_min = $whole * 60;
				$total_flown_min = $total_flown_min - $hour_min;
				$total_flown_hour = $total_flown_hour + $whole;
			?>
			<tr class="info total_row">
				<th colspan="6" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_distance , 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_flown_hour , 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_flown_min , 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_passengers_num , 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargo_qty , 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cargo_value , 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_revenue , 2) ?></th>
			</tr>
			<tr class="info">
				<td colspan="9" id="pagination"></td>
				<td colspan="4" class="text-center blue_text"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>