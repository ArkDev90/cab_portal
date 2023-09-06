<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th class="col-md-2" rowspan="2">DATE</th>
				<th class="col-md-2" colspan="2">AIRCRAFT</th>
				<th class="col-md-1" rowspan="2">LOCATION</th>
				<th class="col-md-1" rowspan="2">TYPES OF TREATMENT</th>
				<th class="col-md-1" rowspan="2">AREA TREATED (Hectares)</th>
				<th class="col-md-1" rowspan="2">QUANTITY (Liters)</th>
				<th class="col-md-1" rowspan="2">REVENUE EARNED (Peso)</th>
				<th class="col-md-2" colspan="2">A/C FLYING TIME</th>
			</tr>
			<tr class="info">
				<th>TYPE</th>
				<th>NUMBER</th>
				<th>HOURS</th>
				<th>MINUTES</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num_rows			= 0;
				$total_areaTreated	= 0;
				$total_qLiters		= 0;
				$total_revenue		= 0;
				$total_flyTimeHour	= 0;
				$total_flyTimeMin	= 0;
			?>
			<?php if (empty($direct) && empty($enteredby)): ?>
				<tr>
					<td class="text-center" colspan="10">NO OPERATION</td>
				</tr>
			<?php endif ?>
			<?php foreach ($direct as $row): ?>
				<?php if ($row->aircraft == 'NO OPERATION'): ?>
					<tr class="no_operation">
						<td class="text-center" colspan="10">
							NO OPERATION
						</td>
					</tr>
				<?php elseif ($row): ?>
					<?php
						$num_rows++;
						$total_areaTreated	+= $row->areaTreated;
						$total_qLiters		+= $row->qLiters;
						$total_revenue		+= $row->revenue;
						$total_flyTimeHour	+= $row->flyTimeHour;
						$total_flyTimeMin	+= $row->flyTimeMin;

						$x = $row->flyTimeMin / 60;
						$y = floor($x);
						$dec = $y * 60;
						$row->flyTimeMin = $row->flyTimeMin - $dec;
						$row->flyTimeHour = $row->flyTimeHour + $y;
					?>
					<tr>
						<td class="text-center">
							<?php echo $period . ' ' . $row->report_day; ?>
						</td>
						<td>
							<?php echo $row->aircraft ?>
						</td>
						<td>
							<?php echo $row->aircraft_num ?>
						</td>
						<td>
							<?php echo $row->location ?>
						</td>
						<td>
							<?php echo $row->treatment ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->areaTreated, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->qLiters, 2) ?>
						</td>
						<td class="text-right">
							<?php echo number_format($row->revenue, 2) ?>
						</td>
						<td class="text-right">
							<?php echo $row->flyTimeHour ?>
						</td>
						<td class="text-right">
							<?php echo $row->flyTimeMin ?>
						</td>
					</tr>
				<?php endif ?>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr class="info total_row">
				<th colspan="5" class="text-right blue_text">TOTAL:</th>
				<th class="text-right blue_text"><?php echo number_format($total_areaTreated, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_qLiters, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_revenue, 2) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_flyTimeHour, 0) ?></th>
				<th class="text-right blue_text"><?php echo number_format($total_flyTimeMin, 0) ?></th>
			</tr>
			<tr class="info">
				<td colspan="7" id="pagination"></td>
				<td colspan="3" class="text-center"><b>Entries: </b> <?php echo $num_rows ?></td>
			</tr>
		</tfoot>
	</table>
</div>