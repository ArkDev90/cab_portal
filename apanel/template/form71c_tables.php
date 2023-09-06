<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="text-center" colspan="5">SCHEDULED S-1 - CARGO DIRECT SHIPMENTS</th>
			</tr>
			<tr class="info">
				<th class="col-md-4">AIR CARRIER</th>
				<th class="col-md-3">NUMBER OF MAWBs USED</th>
				<th class="col-md-3">CHARGEABLE WEIGHT (Kilograms)</th>
				<th class="col-md-3">FREIGHT CHARGES (Philippine Peso)</th>
				<th class="col-md-3">COMMISSION EARNED (Philippine Peso)</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows			= 0;
				$total_weight		= 0;
				$total_numMawbs		= 0;
				$total_commission	= 0;
				$total_fcharge		= 0;
			?>
			<?php if (empty($direct) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="5">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr class="no_operation">
						<td class="text-center" colspan="5">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php 
						$num_rows++;
						$total_weight		+= $row->weight;
						$total_numMawbs		+= $row->numMawbs;
						$total_commission	+= $row->commission;
						$total_fcharge		+= $row->fcharge;
					?>
					<tr class="entry">
						<td>
							<?php echo $row->aircraft ?>
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
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row">
				<th colspan="1" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_numMawbs, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_weight, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_fcharge, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_commission, 2) ?></th>
			</tr>
			<tr class="info">
				<td colspan="3" id="pagination"></td>
				<td colspan="2" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="row">&nbsp;</div>
<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="text-center" colspan="3">SCHEDULED TF-1 - DIRECT FLOW SHIPMENTS</th>
			</tr>
			<tr class="info">
				<th class="col-md-2">ORIGIN</th>
				<th class="col-md-2">DESTINATION</th>
				<th class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows			= 0;
				$total_weight		= 0;

				$prev_sector	= '';
				$prev_sector_d	= '';
			?>
			<?php if (empty($direct) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="3">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $key => $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr class="no_operation">
						<td class="text-center" colspan="3">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php 
						$num_rows++;
						$total_weight		+= $row->weight;

						if ($key == 0 || $prev_sector != $row->destination || $prev_sector_d != $row->origin) {
							$subtotal_weight = 0;
						}
						
						$prev_sector	= $row->destination;
						$prev_sector_d	= $row->origin;

						$subtotal_weight += $row->weight;
					?>
					<tr class="entry">
						<td>
							<?php echo $row->origin ?>
						</td>
						<td>
							<?php echo $row->destination ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->weight, 2) ?>
						</td>
					</tr>

					<?php if ( ! isset($direct[$key + 1]) || $prev_sector != $direct[$key + 1]->destination || $prev_sector_d != $direct[$key + 1]->origin): ?>
						<tr class="info">
							<td colspan="2" class="text-right blue_text">
								<b>SUBTOTAL:</b>
							</td>
							<td class="text-right blue_text">
								<?php echo number_format($subtotal_weight, 2) ?>
							</td>
							</td>
						</tr>
					<?php endif ?>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row">
				<th colspan="2" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text">
					<?php echo number_format($total_weight, 2) ?>
				</th>
			</tr>
			<tr class="info">
				<td colspan="2" id="pagination"></td>
				<td colspan="1" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>