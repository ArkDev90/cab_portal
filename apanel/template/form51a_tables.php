
<div class="table-responsive mb-xs">
	<table class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="text-center" colspan="17">DIRECT</th>
			</tr>
			<tr class="info">
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
			<?php
				$num_rows					= 0;
				$total_seats_offered		= 0;
				$total_quarter_month1		= 0;
				$total_quarter_month2		= 0;
				$total_quarter_month3		= 0;
				$total_quarter_total		= 0;
				$total_sub_total			= 0;
				$total_seats_offered_d		= 0;
				$total_quarter_month1_d		= 0;
				$total_quarter_month2_d		= 0;
				$total_quarter_month3_d		= 0;
				$total_quarter_total_d		= 0;
				$total_sub_total_d			= 0;
				$total_total_rev_traffic	= 0;
				$total_total_percent		= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($direct)): ?>
				<tr>
					<td class="text-center" colspan="17">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="17">NO OPERATION</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_seats		= $row->business + $row->economy + $row->first;
						$quarter_total		= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
						$quarter_total_d	= $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
						$total_rev_traffic	= $quarter_total + $quarter_total_d;
						$seats_offered		= ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3) * $total_seats;
						$seats_offered_d	= ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d) * $total_seats;
						$total_percent		= (($seats_offered + $seats_offered_d) > 0) ? ($total_rev_traffic / ($seats_offered + $seats_offered_d)) * 100 : 0;
						$sub_total			= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
						$sub_total_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;

						$total_seats_offered		+= $seats_offered;
						$total_quarter_month1		+= $row->quarter_month1;
						$total_quarter_month2		+= $row->quarter_month2;
						$total_quarter_month3		+= $row->quarter_month3;
						$total_quarter_total		+= $quarter_total;
						$total_sub_total			+= $sub_total;
						$total_seats_offered_d		+= $seats_offered_d;
						$total_quarter_month1_d		+= $row->quarter_month1_d;
						$total_quarter_month2_d		+= $row->quarter_month2_d;
						$total_quarter_month3_d		+= $row->quarter_month3_d;
						$total_quarter_total_d		+= $quarter_total_d;
						$total_sub_total_d			+= $sub_total_d;
						$total_total_rev_traffic	+= $total_rev_traffic;
						$total_total_percent		+= $total_percent;

						if ($key == 0 || $prev_sector != $row->destination_to || $prev_sector_d != $row->destination_from) {
							$sub_entries					= 0;
							$subtotal_seats_offered			= 0;
							$subtotal_quarter_month1		= 0;
							$subtotal_quarter_month2		= 0;
							$subtotal_quarter_month3		= 0;
							$subtotal_quarter_total			= 0;
							$subtotal_sub_total				= 0;
							$subtotal_seats_offered_d		= 0;
							$subtotal_quarter_month1_d		= 0;
							$subtotal_quarter_month2_d		= 0;
							$subtotal_quarter_month3_d		= 0;
							$subtotal_quarter_total_d		= 0;
							$subtotal_sub_total_d			= 0;
							$subtotal_total_rev_traffic		= 0;
							$subtotal_total_percent			= 0;
						}

						$prev_sector	= $row->destination_to;
						$prev_sector_d	= $row->destination_from;

						$sub_entries++;
						$subtotal_seats_offered			+= $seats_offered;
						$subtotal_quarter_month1		+= $row->quarter_month1;
						$subtotal_quarter_month2		+= $row->quarter_month2;
						$subtotal_quarter_month3		+= $row->quarter_month3;
						$subtotal_quarter_total			+= $quarter_total;
						$subtotal_sub_total				+= $sub_total;
						$subtotal_seats_offered_d		+= $seats_offered_d;
						$subtotal_quarter_month1_d		+= $row->quarter_month1_d;
						$subtotal_quarter_month2_d		+= $row->quarter_month2_d;
						$subtotal_quarter_month3_d		+= $row->quarter_month3_d;
						$subtotal_quarter_total_d		+= $quarter_total_d;
						$subtotal_sub_total_d			+= $sub_total_d;
						$subtotal_total_rev_traffic		+= $total_rev_traffic;
						$subtotal_total_percent			+= $total_percent;
					?>
					<tr>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->destination_from . ' - ' . $row->destination_to ?>
						</td>
						<td class="text-right">
							<?php echo number_format($seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month1, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month2, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month3, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($quarter_total, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sub_total, 0) ?>
						</td>
						<td>
							<?php echo $row->destination_to . ' - ' . $row->destination_from ?>
						</td>
						<td class="text-right">
							<?php echo number_format($seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month1_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month2_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month3_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($quarter_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sub_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_rev_traffic, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_percent, 2) ?>%
						</td>
					</tr>

					<?php if ( ! isset($direct[$key + 1]) || $prev_sector != $direct[$key + 1]->destination_to || $prev_sector_d != $direct[$key + 1]->destination_from): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month1, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month2, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month3, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_total, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sub_total, 0) ?>
							</td>
							<td>

							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month1_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month2_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month3_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sub_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_total_rev_traffic, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format(((($subtotal_seats_offered + $subtotal_seats_offered_d) > 0) ? ($subtotal_total_rev_traffic / ($subtotal_seats_offered + $subtotal_seats_offered_d)) * 100 : 0), 2).'%' ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_seats_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month1, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month2, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month3, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_total, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_sub_total, 0) ?></th>
				<th></th>
				<th class="text-right blue_text"><?php echo number_format($total_seats_offered_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month1_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month2_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month3_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_sub_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_total_rev_traffic, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format(((($total_seats_offered + $total_seats_offered_d) > 0) ? ($total_total_rev_traffic / ($total_seats_offered + $total_seats_offered_d)) * 100 : 0), 2) ?>%</th>
			</tr>
			<tr class="info">
				<td colspan="14"></td>
				<td colspan="3" class="text-center"><b>Entries: </b> <?php echo number_format($num_rows, 0) ?></td>
			</tr>
		</tfoot>
	</table>
</div>

<div class="table-responsive mb-xs">
	<table class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="text-center" colspan="17">FIFTH FREEDOM / CO-TERMINAL</th>
			</tr>
			<tr class="info">
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
			<?php
				$num_rows					= 0;
				$total_seats_offered		= 0;
				$total_quarter_month1		= 0;
				$total_quarter_month2		= 0;
				$total_quarter_month3		= 0;
				$total_quarter_total		= 0;
				$total_sub_total			= 0;
				$total_seats_offered_d		= 0;
				$total_quarter_month1_d		= 0;
				$total_quarter_month2_d		= 0;
				$total_quarter_month3_d		= 0;
				$total_quarter_total_d		= 0;
				$total_sub_total_d			= 0;
				$total_total_rev_traffic	= 0;
				$total_total_percent		= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($free_flight)): ?>
				<tr>
					<td class="text-center" colspan="17">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($free_flight as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="17">NO OPERATION</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_seats		= $row->business + $row->economy + $row->first;
						$quarter_total		= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
						$quarter_total_d	= $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
						$total_rev_traffic	= $quarter_total + $quarter_total_d;
						$seats_offered		= ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3) * $total_seats;
						$seats_offered_d	= ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d) * $total_seats;
						$total_percent		= (($seats_offered + $seats_offered_d) > 0) ? ($total_rev_traffic / ($seats_offered + $seats_offered_d)) * 100 : 0;
						$sub_total			= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
						$sub_total_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;

						$total_seats_offered		+= $seats_offered;
						$total_quarter_month1		+= $row->quarter_month1;
						$total_quarter_month2		+= $row->quarter_month2;
						$total_quarter_month3		+= $row->quarter_month3;
						$total_quarter_total		+= $quarter_total;
						$total_sub_total			+= $sub_total;
						$total_seats_offered_d		+= $seats_offered_d;
						$total_quarter_month1_d		+= $row->quarter_month1_d;
						$total_quarter_month2_d		+= $row->quarter_month2_d;
						$total_quarter_month3_d		+= $row->quarter_month3_d;
						$total_quarter_total_d		+= $quarter_total_d;
						$total_sub_total_d			+= $sub_total_d;
						$total_total_rev_traffic	+= $total_rev_traffic;
						$total_total_percent		+= $total_percent;

						$ex_quarter_total		= $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3;
						$ex_quarter_total_d		= $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d;
						$total_ex_rev_traffic		= $ex_quarter_total + $ex_quarter_total_d;
						$ex_seats_offered		= ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3) * $total_seats;
						$ex_seats_offered_d		= ($row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d) * $total_seats;
						$total_ex_percent			= (($ex_seats_offered + $ex_seats_offered_d) > 0) ? ($total_ex_rev_traffic / ($ex_seats_offered + $ex_seats_offered_d)) * 100 : 0;
						$ex_sub_total			= $row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3;
						$ex_sub_total_d			= $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;

						$total_seats_offered		+= $ex_seats_offered;
						$total_quarter_month1		+= $row->ex_quarter_month1;
						$total_quarter_month2		+= $row->ex_quarter_month2;
						$total_quarter_month3		+= $row->ex_quarter_month3;
						$total_quarter_total		+= $ex_quarter_total;
						$total_sub_total			+= $ex_sub_total;
						$total_seats_offered_d		+= $ex_seats_offered_d;
						$total_quarter_month1_d		+= $row->ex_quarter_month1_d;
						$total_quarter_month2_d		+= $row->ex_quarter_month2_d;
						$total_quarter_month3_d		+= $row->ex_quarter_month3_d;
						$total_quarter_total_d		+= $ex_quarter_total_d;
						$total_sub_total_d			+= $ex_sub_total_d;
						$total_total_rev_traffic	+= $total_ex_rev_traffic;
						$total_total_percent		+= $total_ex_percent;

						if ($key == 0 || $prev_sector != $row->destination_to || $prev_sector_d != $row->destination_from) {
							$sub_entries					= 0;
							$subtotal_seats_offered			= 0;
							$subtotal_quarter_month1		= 0;
							$subtotal_quarter_month2		= 0;
							$subtotal_quarter_month3		= 0;
							$subtotal_quarter_total			= 0;
							$subtotal_sub_total				= 0;
							$subtotal_seats_offered_d		= 0;
							$subtotal_quarter_month1_d		= 0;
							$subtotal_quarter_month2_d		= 0;
							$subtotal_quarter_month3_d		= 0;
							$subtotal_quarter_total_d		= 0;
							$subtotal_sub_total_d			= 0;
							$subtotal_total_rev_traffic		= 0;
							$subtotal_total_percent			= 0;
						}

						$prev_sector	= $row->destination_to;
						$prev_sector_d	= $row->destination_from;

						$sub_entries++;
						$subtotal_seats_offered			+= $seats_offered;
						$subtotal_quarter_month1		+= $row->quarter_month1;
						$subtotal_quarter_month2		+= $row->quarter_month2;
						$subtotal_quarter_month3		+= $row->quarter_month3;
						$subtotal_quarter_total			+= $quarter_total;
						$subtotal_sub_total				+= $sub_total;
						$subtotal_seats_offered_d		+= $seats_offered_d;
						$subtotal_quarter_month1_d		+= $row->quarter_month1;
						$subtotal_quarter_month2_d		+= $row->quarter_month2;
						$subtotal_quarter_month3_d		+= $row->quarter_month3;
						$subtotal_quarter_total_d		+= $quarter_total_d;
						$subtotal_sub_total_d			+= $sub_total_d;
						$subtotal_total_rev_traffic		+= $total_rev_traffic;
						$subtotal_total_percent			+= $total_percent;

						$subtotal_seats_offered			+= $ex_seats_offered;
						$subtotal_quarter_month1		+= $row->ex_quarter_month1;
						$subtotal_quarter_month2		+= $row->ex_quarter_month2;
						$subtotal_quarter_month3		+= $row->ex_quarter_month3;
						$subtotal_quarter_total			+= $ex_quarter_total;
						$subtotal_sub_total				+= $ex_sub_total;
						$subtotal_seats_offered_d		+= $ex_seats_offered_d;
						$subtotal_quarter_month1_d		+= $row->ex_quarter_month1;
						$subtotal_quarter_month2_d		+= $row->ex_quarter_month2;
						$subtotal_quarter_month3_d		+= $row->ex_quarter_month3;
						$subtotal_quarter_total_d		+= $ex_quarter_total_d;
						$subtotal_sub_total_d			+= $ex_sub_total_d;
						$subtotal_total_rev_traffic		+= $total_ex_rev_traffic;
						$subtotal_total_percent			+= $total_ex_percent;
					?>
					<tr>
						<td rowspan="2">
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->destination_from . ' - ' . $row->destination_to ?>
						</td>
						<td class="text-right">
							<?php echo number_format($seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month1, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month2, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month3, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($quarter_total, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sub_total, 0) ?>
						</td>
						<td>
							<?php echo $row->destination_to . ' - ' . $row->destination_from ?>
						</td>
						<td class="text-right">
							<?php echo number_format($seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month1_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month2_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->quarter_month3_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($quarter_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($sub_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_rev_traffic, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_percent, 2) ?>%
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $row->extra_dest . ' - ' . $row->destination_to ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_quarter_month1, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_quarter_month2, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_quarter_month3, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_quarter_total, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_sub_total, 0) ?>
						</td>
						<td>
							<?php echo $row->destination_to . ' - ' . $row->extra_dest ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_quarter_month1_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_quarter_month2_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_quarter_month3_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_quarter_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_sub_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_ex_rev_traffic, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_ex_percent, 2) ?>%
						</td>
					</tr>
					<?php if ( ! isset($free_flight[$key + 1]) || $prev_sector != $free_flight[$key + 1]->destination_to || $prev_sector_d != $free_flight[$key + 1]->destination_from): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month1, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month2, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month3, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_total, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sub_total, 0) ?>
							</td>
							<td>

							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month1_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month2_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month3_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sub_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_total_rev_traffic, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format(((($subtotal_seats_offered + $subtotal_seats_offered_d) > 0) ? ($subtotal_total_rev_traffic / ($subtotal_seats_offered + $subtotal_seats_offered_d)) * 100 : 0), 2) ?>%
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_seats_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month1, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month2, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month3, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_total, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_sub_total, 0) ?></th>
				<th></th>
				<th class="text-right blue_text"><?php echo number_format($total_seats_offered_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month1_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month2_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month3_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_sub_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_total_rev_traffic, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format(((($total_seats_offered + $total_seats_offered_d) > 0) ? ($total_total_rev_traffic / ($total_seats_offered + $total_seats_offered_d)) * 100 : 0), 2) ?>%</th>
			</tr>
			<tr class="info">
				<td colspan="14"></td>
				<td colspan="3" class="text-center"><b>Entries: </b> <?php echo number_format($num_rows, 0) ?></td>
			</tr>
		</tfoot>
	</table>
</div>

<div class="table-responsive mb-xs">
	<table class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="text-center" colspan="17">CODE SHARED FLIGHT: DIRECT</th>
			</tr>
			<tr class="info">
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
			<?php
				$num_rows						= 0;
				$total_cs_seats_offered			= 0;
				$total_cs_quarter_month1		= 0;
				$total_cs_quarter_month2		= 0;
				$total_cs_quarter_month3		= 0;
				$total_cs_quarter_total			= 0;
				$total_cs_sub_total				= 0;
				$total_cs_seats_offered_d		= 0;
				$total_cs_quarter_month1_d		= 0;
				$total_cs_quarter_month2_d		= 0;
				$total_cs_quarter_month3_d		= 0;
				$total_cs_quarter_total_d		= 0;
				$total_cs_sub_total_d			= 0;
				$total_cs_total_rev_traffic		= 0;
				$total_cs_total_percent			= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($direct_cs)): ?>
				<tr>
					<td class="text-center" colspan="17">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct_cs as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="17">NO OPERATION</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_cs_seats		= $row->business + $row->economy + $row->first;
						$cs_quarter_total		= $row->cs_quarter_month1 + $row->cs_quarter_month2 + $row->cs_quarter_month3;
						$cs_quarter_total_d	= $row->cs_quarter_month1_d + $row->cs_quarter_month2_d + $row->cs_quarter_month3_d;
						$total_cs_rev_traffic	= $cs_quarter_total + $cs_quarter_total_d;
						$cs_seats_offered		= ($row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3) * $total_cs_seats;
						$cs_seats_offered_d	= ($row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d) * $total_cs_seats;
						$total_cs_percent		= (($cs_seats_offered + $cs_seats_offered_d) > 0) ? ($total_cs_rev_traffic / ($cs_seats_offered + $cs_seats_offered_d)) * 100 : 0;
						$cs_sub_total			= $row->cs_foctraffic_month1 + $row->cs_foctraffic_month2 + $row->cs_foctraffic_month3;
						$cs_sub_total_d		= $row->cs_foctraffic_month1_d + $row->cs_foctraffic_month2_d + $row->cs_foctraffic_month3_d;

						$total_cs_seats_offered		+= $cs_seats_offered;
						$total_cs_quarter_month1	+= $row->cs_quarter_month1;
						$total_cs_quarter_month2	+= $row->cs_quarter_month2;
						$total_cs_quarter_month3	+= $row->cs_quarter_month3;
						$total_cs_quarter_total		+= $cs_quarter_total;
						$total_cs_sub_total			+= $cs_sub_total;
						$total_cs_seats_offered_d	+= $cs_seats_offered_d;
						$total_cs_quarter_month1_d	+= $row->cs_quarter_month1_d;
						$total_cs_quarter_month2_d	+= $row->cs_quarter_month2_d;
						$total_cs_quarter_month3_d	+= $row->cs_quarter_month3_d;
						$total_cs_quarter_total_d	+= $cs_quarter_total_d;
						$total_cs_sub_total_d		+= $cs_sub_total_d;
						$total_cs_total_rev_traffic	+= $total_cs_rev_traffic;
						$total_cs_total_percent		+= $total_cs_percent;

						if ($key == 0 || $prev_sector != $row->destination_to || $prev_sector_d != $row->destination_from) {
							$sub_entries						= 0;
							$subtotal_cs_seats_offered			= 0;
							$subtotal_cs_quarter_month1			= 0;
							$subtotal_cs_quarter_month2			= 0;
							$subtotal_cs_quarter_month3			= 0;
							$subtotal_cs_quarter_total			= 0;
							$subtotal_cs_sub_total				= 0;
							$subtotal_cs_seats_offered_d		= 0;
							$subtotal_cs_quarter_month1_d		= 0;
							$subtotal_cs_quarter_month2_d		= 0;
							$subtotal_cs_quarter_month3_d		= 0;
							$subtotal_cs_quarter_total_d		= 0;
							$subtotal_cs_sub_total_d			= 0;
							$subtotal_cs_total_rev_traffic		= 0;
							$subtotal_cs_total_percent			= 0;
						}

						$prev_sector	= $row->destination_to;
						$prev_sector_d	= $row->destination_from;

						$sub_entries++;
						$subtotal_cs_seats_offered			+= $cs_seats_offered;
						$subtotal_cs_quarter_month1			+= $row->cs_quarter_month1;
						$subtotal_cs_quarter_month2			+= $row->cs_quarter_month2;
						$subtotal_cs_quarter_month3			+= $row->cs_quarter_month3;
						$subtotal_cs_quarter_total			+= $cs_quarter_total;
						$subtotal_cs_sub_total				+= $cs_sub_total;
						$subtotal_cs_seats_offered_d		+= $cs_seats_offered_d;
						$subtotal_cs_quarter_month1_d		+= $row->cs_quarter_month1_d;
						$subtotal_cs_quarter_month2_d		+= $row->cs_quarter_month2_d;
						$subtotal_cs_quarter_month3_d		+= $row->cs_quarter_month3_d;
						$subtotal_cs_quarter_total_d		+= $cs_quarter_total_d;
						$subtotal_cs_sub_total_d			+= $cs_sub_total_d;
						$subtotal_cs_total_rev_traffic		+= $total_cs_rev_traffic;
						$subtotal_cs_total_percent			+= $total_cs_percent;
					?>
					<tr>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->destination_from . ' - ' . $row->destination_to ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month1, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month2, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month3, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_quarter_total, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_sub_total, 0) ?>
						</td>
						<td>
							<?php echo $row->destination_to . ' - ' . $row->destination_from ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month1_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month2_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month3_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_quarter_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_sub_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_cs_rev_traffic, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_cs_percent, 2) ?>%
						</td>
					</tr>
					<?php if ( ! isset($direct_cs[$key + 1]) || $prev_sector != $direct_cs[$key + 1]->destination_to || $prev_sector_d != $direct_cs[$key + 1]->destination_from): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_seats_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_month1, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_month2, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_month3, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_total, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_sub_total, 0) ?>
							</td>
							<td>

							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_seats_offered_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_month1_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_month2_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_month3_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_quarter_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_sub_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_cs_total_rev_traffic, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format(((($subtotal_cs_seats_offered + $subtotal_cs_seats_offered_d) > 0) ? ($subtotal_cs_total_rev_traffic / ($subtotal_cs_seats_offered + $subtotal_cs_seats_offered_d)) * 100 : 0), 2).'%' ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_seats_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month1, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month2, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month3, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_total, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_sub_total, 0) ?></th>
				<th></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_seats_offered_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month1_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month2_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month3_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_sub_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_total_rev_traffic, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format(((($total_cs_seats_offered + $total_cs_seats_offered_d) > 0) ? ($total_cs_total_rev_traffic / ($total_cs_seats_offered + $total_cs_seats_offered_d)) * 100 : 0), 2) ?>%</th>
			</tr>
			<tr class="info">
				<td colspan="14"></td>
				<td colspan="3" class="text-center"><b>Entries: </b> <?php echo number_format($num_rows, 0) ?></td>
			</tr>
		</tfoot>
	</table>
</div>

<div class="table-responsive mb-xs">
	<table class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="text-center" colspan="17">CODE SHARED FLIGHT: FIFTH FREEDOM / CO-TERMINAL</th>
			</tr>
			<tr class="info">
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
			<?php
				$num_rows						= 0;
				$total_cs_seats_offered			= 0;
				$total_cs_quarter_month1		= 0;
				$total_cs_quarter_month2		= 0;
				$total_cs_quarter_month3		= 0;
				$total_cs_quarter_total			= 0;
				$total_cs_sub_total				= 0;
				$total_cs_seats_offered_d		= 0;
				$total_cs_quarter_month1_d		= 0;
				$total_cs_quarter_month2_d		= 0;
				$total_cs_quarter_month3_d		= 0;
				$total_cs_quarter_total_d		= 0;
				$total_cs_sub_total_d			= 0;
				$total_cs_total_rev_traffic		= 0;
				$total_cs_total_percent			= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($free_flight_cs)): ?>
				<tr>
					<td class="text-center" colspan="17">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($free_flight_cs as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="17">NO OPERATION</td>
					</tr>
					<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_cs_seats		= $row->business + $row->economy + $row->first;
						$cs_quarter_total		= $row->cs_quarter_month1 + $row->cs_quarter_month2 + $row->cs_quarter_month3;
						$cs_quarter_total_d	= $row->cs_quarter_month1_d + $row->cs_quarter_month2_d + $row->cs_quarter_month3_d;
						$total_cs_rev_traffic	= $cs_quarter_total + $cs_quarter_total_d;
						$cs_seats_offered		= ($row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3) * $total_cs_seats;
						$cs_seats_offered_d	= ($row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d) * $total_cs_seats;
						$total_cs_percent		= (($cs_seats_offered + $cs_seats_offered_d) > 0) ? ($total_cs_rev_traffic / ($cs_seats_offered + $cs_seats_offered_d)) * 100 : 0;
						$cs_sub_total			= $row->cs_foctraffic_month1 + $row->cs_foctraffic_month2 + $row->cs_foctraffic_month3;
						$cs_sub_total_d		= $row->cs_foctraffic_month1_d + $row->cs_foctraffic_month2_d + $row->cs_foctraffic_month3_d;

						$total_cs_seats_offered		+= $cs_seats_offered;
						$total_cs_quarter_month1	+= $row->cs_quarter_month1;
						$total_cs_quarter_month2	+= $row->cs_quarter_month2;
						$total_cs_quarter_month3	+= $row->cs_quarter_month3;
						$total_cs_quarter_total		+= $cs_quarter_total;
						$total_cs_sub_total			+= $cs_sub_total;
						$total_cs_seats_offered_d	+= $cs_seats_offered_d;
						$total_cs_quarter_month1_d	+= $row->cs_quarter_month1_d;
						$total_cs_quarter_month2_d	+= $row->cs_quarter_month2_d;
						$total_cs_quarter_month3_d	+= $row->cs_quarter_month3_d;
						$total_cs_quarter_total_d	+= $cs_quarter_total_d;
						$total_cs_sub_total_d		+= $cs_sub_total_d;
						$total_cs_total_rev_traffic	+= $total_cs_rev_traffic;
						$total_cs_total_percent		+= $total_cs_percent;

						$ex_cs_quarter_total		= $row->ex_cs_quarter_month1 + $row->ex_cs_quarter_month2 + $row->ex_cs_quarter_month3;
						$ex_cs_quarter_total_d	= $row->ex_cs_quarter_month1_d + $row->ex_cs_quarter_month2_d + $row->ex_cs_quarter_month3_d;
						$total_ex_cs_rev_traffic	= $ex_cs_quarter_total + $ex_cs_quarter_total_d;
						$ex_cs_seats_offered		= ($row->ex_cs_nflight_month1 + $row->ex_cs_nflight_month2 + $row->ex_cs_nflight_month3) * $total_cs_seats;
						$ex_cs_seats_offered_d	= ($row->ex_cs_nflight_month1_d + $row->ex_cs_nflight_month2_d + $row->ex_cs_nflight_month3_d) * $total_cs_seats;
						$total_ex_cs_percent		= (($ex_cs_seats_offered + $ex_cs_seats_offered_d) > 0) ? ($total_ex_cs_rev_traffic / ($ex_cs_seats_offered + $ex_cs_seats_offered_d)) * 100 : 0;
						$ex_cs_sub_total			= $row->ex_cs_foctraffic_month1 + $row->ex_cs_foctraffic_month2 + $row->ex_cs_foctraffic_month3;
						$ex_cs_sub_total_d		= $row->ex_cs_foctraffic_month1_d + $row->ex_cs_foctraffic_month2_d + $row->ex_cs_foctraffic_month3_d;

						$total_cs_seats_offered		+= $ex_cs_seats_offered;
						$total_cs_quarter_month1	+= $row->ex_cs_quarter_month1;
						$total_cs_quarter_month2	+= $row->ex_cs_quarter_month2;
						$total_cs_quarter_month3	+= $row->ex_cs_quarter_month3;
						$total_cs_quarter_total		+= $ex_cs_quarter_total;
						$total_cs_sub_total			+= $ex_cs_sub_total;
						$total_cs_seats_offered_d	+= $ex_cs_seats_offered_d;
						$total_cs_quarter_month1_d	+= $row->ex_cs_quarter_month1_d;
						$total_cs_quarter_month2_d	+= $row->ex_cs_quarter_month2_d;
						$total_cs_quarter_month3_d	+= $row->ex_cs_quarter_month3_d;
						$total_cs_quarter_total_d	+= $ex_cs_quarter_total_d;
						$total_cs_sub_total_d		+= $ex_cs_sub_total_d;
						$total_cs_total_rev_traffic	+= $total_ex_cs_rev_traffic;
						$total_cs_total_percent		+= $total_ex_cs_percent;

						if ($key == 0 || $prev_sector != $row->destination_to || $prev_sector_d != $row->destination_from) {
							$sub_entries					= 0;
							$subtotal_seats_offered			= 0;
							$subtotal_quarter_month1		= 0;
							$subtotal_quarter_month2		= 0;
							$subtotal_quarter_month3		= 0;
							$subtotal_quarter_total			= 0;
							$subtotal_sub_total				= 0;
							$subtotal_seats_offered_d		= 0;
							$subtotal_quarter_month1_d		= 0;
							$subtotal_quarter_month2_d		= 0;
							$subtotal_quarter_month3_d		= 0;
							$subtotal_quarter_total_d		= 0;
							$subtotal_sub_total_d			= 0;
							$subtotal_total_rev_traffic		= 0;
							$subtotal_total_percent			= 0;
						}

						$prev_sector	= $row->destination_to;
						$prev_sector_d	= $row->destination_from;

						$sub_entries++;
						$subtotal_seats_offered			+= $cs_seats_offered;
						$subtotal_quarter_month1		+= $row->cs_quarter_month1;
						$subtotal_quarter_month2		+= $row->cs_quarter_month2;
						$subtotal_quarter_month3		+= $row->cs_quarter_month3;
						$subtotal_quarter_total			+= $cs_quarter_total;
						$subtotal_sub_total				+= $cs_sub_total;
						$subtotal_seats_offered_d		+= $cs_seats_offered_d;
						$subtotal_quarter_month1_d		+= $row->cs_quarter_month1_d;
						$subtotal_quarter_month2_d		+= $row->cs_quarter_month2_d;
						$subtotal_quarter_month3_d		+= $row->cs_quarter_month3_d;
						$subtotal_quarter_total_d		+= $cs_quarter_total_d;
						$subtotal_sub_total_d			+= $cs_sub_total_d;
						$subtotal_total_rev_traffic		+= $total_cs_rev_traffic;
						$subtotal_total_percent			+= $total_cs_percent;

						$subtotal_seats_offered			+= $ex_cs_seats_offered;
						$subtotal_quarter_month1		+= $row->ex_cs_quarter_month1;
						$subtotal_quarter_month2		+= $row->ex_cs_quarter_month2;
						$subtotal_quarter_month3		+= $row->ex_cs_quarter_month3;
						$subtotal_quarter_total			+= $ex_cs_quarter_total;
						$subtotal_sub_total				+= $ex_cs_sub_total;
						$subtotal_seats_offered_d		+= $ex_cs_seats_offered_d;
						$subtotal_quarter_month1_d		+= $row->ex_cs_quarter_month1_d;
						$subtotal_quarter_month2_d		+= $row->ex_cs_quarter_month2_d;
						$subtotal_quarter_month3_d		+= $row->ex_cs_quarter_month3_d;
						$subtotal_quarter_total_d		+= $ex_cs_quarter_total_d;
						$subtotal_sub_total_d			+= $ex_cs_sub_total_d;
						$subtotal_total_rev_traffic		+= $total_ex_cs_rev_traffic;
						$subtotal_total_percent			+= $total_ex_cs_percent;
					?>
					<tr>
						<td rowspan="2">
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->destination_from . ' - ' . $row->destination_to ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month1, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month2, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month3, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_quarter_total, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_sub_total, 0) ?>
						</td>
						<td>
							<?php echo $row->destination_to . ' - ' . $row->destination_from ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month1_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month2_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->cs_quarter_month3_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_quarter_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($cs_sub_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_cs_rev_traffic, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_cs_percent, 2) ?>%
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $row->extra_dest . ' - ' . $row->destination_to ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_cs_seats_offered, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_cs_quarter_month1, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_cs_quarter_month2, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_cs_quarter_month3, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_cs_quarter_total, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_cs_sub_total, 0) ?>
						</td>
						<td>
							<?php echo $row->destination_to . ' - ' . $row->extra_dest ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_cs_seats_offered_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_cs_quarter_month1_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_cs_quarter_month2_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->ex_cs_quarter_month3_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_cs_quarter_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($ex_cs_sub_total_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_ex_cs_rev_traffic, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($total_ex_cs_percent, 2) ?>%
						</td>
					</tr>

					<?php if ( ! isset($free_flight_cs[$key + 1]) || $prev_sector != $free_flight_cs[$key + 1]->destination_to || $prev_sector_d != $free_flight_cs[$key + 1]->destination_from): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month1, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month2, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month3, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_total, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sub_total, 0) ?>
							</td>
							<td>

							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_seats_offered_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month1_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month2_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_month3_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_quarter_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_sub_total_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_total_rev_traffic, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format(((($subtotal_seats_offered + $subtotal_seats_offered_d) > 0) ? ($subtotal_total_rev_traffic / ($subtotal_seats_offered + $subtotal_seats_offered_d)) * 100 : 0), 2) ?>%
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_seats_offered, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month1, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month2, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month3, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_total, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_sub_total, 0) ?></th>
				<th></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_seats_offered_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month1_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month2_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_month3_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_quarter_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_sub_total_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_cs_total_rev_traffic, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format(((($total_cs_seats_offered + $total_cs_seats_offered_d) > 0) ? ($total_cs_total_rev_traffic / ($total_cs_seats_offered + $total_cs_seats_offered_d)) * 100 : 0), 2) ?>%</th>
			</tr>
			<tr class="info">
				<td colspan="14"></td>
				<td colspan="3" class="text-center"><b>Entries: </b> <?php echo number_format($num_rows, 0) ?></td>
			</tr>
		</tfoot>
	</table>
</div>

<div class="table-responsive mb-xs">
	<table class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="11">TRANSIT REVENUE</th>
			</tr>
			<tr class="info">
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
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows				= 0;
				$total_quarter_month1	= 0;
				$total_quarter_month2	= 0;
				$total_quarter_month3	= 0;
				$total_subtotal			= 0;
				$total_quarter_month1_d	= 0;
				$total_quarter_month2_d	= 0;
				$total_quarter_month3_d	= 0;
				$total_subtotal_d		= 0;
				$total_total			= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($transit) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="11">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($transit as $key => $row): ?>
				<?php if ($row->destination_from == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="11">NO OPERATION</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;

						$subtotal	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
						$subtotal_d	= $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
						$total		= $subtotal + $subtotal_d;

						$total_quarter_month1	= $row->quarter_month1;
						$total_quarter_month2	= $row->quarter_month2;
						$total_quarter_month3	= $row->quarter_month3;
						$total_subtotal			= $subtotal;
						$total_quarter_month1_d	= $row->quarter_month1_d;
						$total_quarter_month2_d	= $row->quarter_month2_d;
						$total_quarter_month3_d	= $row->quarter_month3_d;
						$total_subtotal_d		= $subtotal_d;
						$total_total			= $total;

						if ($key == 0 || $prev_sector != $row->destination_to || $prev_sector_d != $row->destination_from) {
							$sub_entries				= 0;
							$subtotal_quarter_month1	= 0;
							$subtotal_quarter_month2	= 0;
							$subtotal_quarter_month3	= 0;
							$subtotal_subtotal			= 0;
							$subtotal_quarter_month1_d	= 0;
							$subtotal_quarter_month2_d	= 0;
							$subtotal_quarter_month3_d	= 0;
							$subtotal_subtotal_d		= 0;
							$subtotal_total			= 0;
						}

						$prev_sector	= $row->destination_to;
						$prev_sector_d	= $row->destination_from;

						$sub_entries++;
						$subtotal_quarter_month1	+= $row->quarter_month1;
						$subtotal_quarter_month2	+= $row->quarter_month2;
						$subtotal_quarter_month3	+= $row->quarter_month3;
						$subtotal_subtotal			+= $subtotal;
						$subtotal_quarter_month1_d	+= $row->quarter_month1_d;
						$subtotal_quarter_month2_d	+= $row->quarter_month2_d;
						$subtotal_quarter_month3_d	+= $row->quarter_month3_d;
						$subtotal_subtotal_d		+= $subtotal_d;
						$subtotal_total				+= $total;
					?>
					<tr>
						<td>
							<?php echo $row->destination_from . ' - ' . $row->destination_to ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_quarter_month1, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_quarter_month2, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_quarter_month3, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal, 0) ?>
						</td>
						<td>
							<?php echo $row->destination_to . ' - ' . $row->destination_from ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_quarter_month1_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_quarter_month2_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_quarter_month3_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_subtotal_d, 0) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($subtotal_total, 0) ?>
						</td>
					</tr>

					<?php if ( ! isset($transit[$key + 1]) || $prev_sector != $transit[$key + 1]->destination_to || $prev_sector_d != $transit[$key + 1]->destination_from): ?>
						<tr class="info">
							<td class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($row->quarter_month1, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($row->quarter_month2, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($row->quarter_month3, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal, 0) ?>
							</td>
							<td>
								
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($row->quarter_month1_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($row->quarter_month2_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($row->quarter_month3_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_d, 0) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($total, 0) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row3">
				<th class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month1, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month2, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month3, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_subtotal, 0) ?></th>
				<th></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month1_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month2_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_quarter_month3_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_subtotal_d, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_total, 0) ?></th>
			</tr>
			<tr class="info">
				<td colspan="8"></td>
				<td colspan="3" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>