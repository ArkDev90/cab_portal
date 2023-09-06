<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		APPROVED REPORT
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="box-body table-responsive no-padding">
					<table id="list" class="table table-hover table-sidepad">
						<?php
							echo $ui->loadElement('table')
									->setHeaderClass('info')
									->addHeader('Report Code', array('class' => 'col-md-2'))
									->addHeader('Report Name', array('class' => 'col-md-7'))
									->draw();
						?>
						<tbody>
							<?php foreach ($report_list as $row): ?>
								<tr>
									<td><?php echo $row->short_title ?></td>
									<td><a href="<?php echo MODULE_URL . 'view_approved_reports/' . $row->db_table ?>"><?php echo $row->title ?></a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>