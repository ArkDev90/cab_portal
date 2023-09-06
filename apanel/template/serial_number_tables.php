<div class="table-responsive mb-xs">
	<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
		<thead>
			<tr class="info">
				<th colspan="2">SERIAL NUMBER</th>
			</tr>
			<tr class="info">
				<th class="col-md-6">#</th>
				<th class="col-md-6">HOUSER / SERIAL NO. </th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($serial)): ?>
				<tr>
					<td colspan="2" class="text-center">NO OPERATION</td>
				</tr>
			<?php else: ?>
				<?php foreach ($serial as $key => $value): ?>
					<tr>
						<td class="text-center"><?php echo $key + 1 ?></td>
						<td class="text-center"><?php echo $value ?></td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</tbody>
		<tfoot>
			<tr class="info">
				<th class="text-center">TOTAL HAWBs:</th>
				<th class="text-center"><?php echo count($serial) ?></th>
			</tr>
		</tfoot>
	</table>
</div>