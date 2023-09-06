<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="7">CARGO DIRECT SHIPMENTS</th>
			</tr>
			<tr class="info">
				<th class="col-md-2">AIR CARRIER</th>
				<th class="col-md-2">ORIGIN</th>
				<th class="col-md-2">DESTINATION</th>
				<th class="col-md-1">NUMBER OF AWBs USED</th>
				<th class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>
				<th class="col-md-2">AIRLINE FREIGHT CHARGES (Philippine Peso)</th>
				<th class="col-md-1">COMMISSION EARNED (Philippine Peso)</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows			= 0;
				$total_numMawbs		= 0;
				$total_weight		= 0;
				$total_fcharge		= 0;
				$total_commission	= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($direct) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="7">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr class="no_operation">
						<td class="text-center" colspan="7">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_numMawbs		+= $row->numMawbs;
						$total_weight		+= $row->weight;
						$total_fcharge		+= $row->fcharge;
						$total_commission	+= $row->commission;

						if ($key == 0 || $prev_sector != $row->destination || $prev_sector_d != $row->origin) {
							$sub_entries			= 0;
							$subtotal_numMawbs		= 0;
							$subtotal_weight		= 0;
							$subtotal_fcharge		= 0;
							$subtotal_commission		= 0;
						}

						$prev_sector	= $row->destination;
						$prev_sector_d	= $row->origin;

						$sub_entries++;
						$subtotal_numMawbs			+= $row->numMawbs;
						$subtotal_weight			+= $row->weight;
						$subtotal_fcharge			+= $row->fcharge;
						$subtotal_commission			+= $row->commission;
					?>

					<tr>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->origin ?>
						</td>
						<td>
							<?php echo $row->destination ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->numMawbs, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->weight, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->fcharge, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->commission, 2) ?>
						</td>
					</tr>

					<?php if ( ! isset($direct[$key + 1]) || $prev_sector != $direct[$key + 1]->destination || $prev_sector_d != $direct[$key + 1]->origin): ?>
						<tr class="info">
							<td colspan="3" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_numMawbs, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_weight, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_fcharge, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_commission, 2) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row">
				<th colspan="3" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_numMawbs, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_weight, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_fcharge, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_commission, 2) ?></th>
			</tr>
			<tr class="info">
				<td colspan="5" id="pagination"></td>
				<td colspan="2" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="table-responsive mb-xs">
	<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="7">CARGO CONSOLIDATION</th>
			</tr>
			<tr class="info">
				<th rowspan="2" class="col-md-2">AIRFREIGHT FORWARDER</th>
				<th rowspan="2" class="col-md-2">DESTINATION</th>
				<th colspan="2" class="col-md-2">NUMBER OF AWBs USED</th>
				<th rowspan="2" class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>
				<th rowspan="2" class="col-md-2">AIRLINE FREIGHT CHARGES (Philippine Peso)</th>
				<th rowspan="2" class="col-md-2">GROSS CONSOLIDATED REVENUE  (Philippine Peso)</th>
			</tr>
			<tr class="info">
				<th>MAWB</th>
				<th>HAWB</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows			= 0;
				$total_numMawbs		= 0;
				$total_weight		= 0;
				$total_numHawbs1	= 0;
				$total_fcharge		= 0;
				$total_revenue		= 0;

				$prev_sector	= '';
			?>
			<?php if (empty($consolidation) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="7">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($consolidation as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr >
						<td class="text-center" colspan="7">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_numMawbs		+= $row->numMawbs;
						$total_weight		+= $row->weight;
						$total_numHawbs1	+= $row->numHawbs1;
						$total_fcharge		+= $row->fcharge;
						$total_revenue		+= $row->revenue;

						if ($key == 0 || $prev_sector != $row->destination) {
							$sub_entries			= 0;
							$subtotal_numMawbs		= 0;
							$subtotal_numHawbs1		= 0;
							$subtotal_weight		= 0;
							$subtotal_fcharge		= 0;
							$subtotal_revenue		= 0;
						}

						$prev_sector	= $row->destination;

						$sub_entries++;
						$subtotal_numMawbs			+= $row->numMawbs;
						$subtotal_numHawbs1			+= $row->numHawbs1;
						$subtotal_weight			+= $row->weight;
						$subtotal_fcharge			+= $row->fcharge;
						$subtotal_revenue			+= $row->revenue;
					?>
					<tr>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->destination ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->numMawbs, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->numHawbs1, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->weight, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->fcharge, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->revenue, 2) ?>
						</td>
					</tr>

					<?php if ( ! isset($consolidation[$key + 1]) || $prev_sector != $consolidation[$key + 1]->destination): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_numMawbs, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_numHawbs1, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_weight, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_fcharge, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_revenue, 2) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row2">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_numMawbs, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_numHawbs1, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_weight, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_fcharge, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_revenue, 2) ?></th>
			</tr>
			<tr class="info">
				<td colspan="5" id="pagination"></td>
				<td colspan="2" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="table-responsive mb-xs">
	<table id="tableList3" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="4">CARGO BREAKBULKING</th>
			</tr>
			<tr class="info">
				<th class="col-md-3">ORIGIN</th>
				<th class="col-md-3">TOTAL NO. OF HAWBs USED</th>
				<th class="col-md-3">CHARGEABLE WEIGHT (Kilograms)</th>
				<th class="col-md-2">INCOME FROM BREAKBULKING (Philippine Peso)</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows			= 0;
				$total_numHawbs2	= 0;
				$total_orgWeight	= 0;
				$total_incomeBreak	= 0;

				$prev_sector	= '';
			?>
			<?php if (empty($breakbulking) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="7">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($breakbulking as $key => $row): ?>
				<?php if ($row->origin == 'NO OPERATION'): ?>
					<tr>
						<td class="text-center" colspan="4">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_numHawbs2	+= $row->numHawbs2;
						$total_orgWeight	+= $row->orgWeight;
						$total_incomeBreak	+= $row->incomeBreak;

						if ($key == 0 || $prev_sector != $row->origin) {
							$sub_entries			= 0;
							$subtotal_numHawbs2		= 0;
							$subtotal_orgWeight		= 0;
							$subtotal_incomeBreak	= 0;
						}

						$prev_sector	= $row->origin;

						$sub_entries++;
						$subtotal_numHawbs2			+= $row->numHawbs2;
						$subtotal_orgWeight			+= $row->orgWeight;
						$subtotal_incomeBreak		+= $row->incomeBreak;
					?>
					<tr>
						<td>
							<?php echo $row->origin ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->numHawbs2, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->orgWeight, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->incomeBreak, 2) ?>
						</td>
					</tr>
					<?php if ( ! isset($breakbulking[$key + 1]) || $prev_sector != $breakbulking[$key + 1]->origin): ?>
						<tr class="info">
							<td class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_numHawbs2, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_orgWeight, 2) ?>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_incomeBreak, 2) ?>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_numHawbs2, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_orgWeight, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_incomeBreak, 2) ?></th>
			</tr>
			<tr class="info">
				<td colspan="2" id="pagination"></td>
				<td colspan="2" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>