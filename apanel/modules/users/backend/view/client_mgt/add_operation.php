<style>
    table {
        border:0px;
    }
</style>
<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		ADD NATURE OF OPERATION FOR THIS CLIENT
    </div>
    <?php $this->load('client_mgt/client_info_header', $data, false) ?>
    <div class = "row">
        <div class="col-md-6 col-md-offset-3 box-body table-responsive" style = "padding: 2% 0% 0% 0.5%">
            <table id="operation_list" class="table table-sidepad">
                <?php
                    echo $ui->loadElement('table')
                            ->setHeaderClass('info')
                            ->addHeader('LIST OF NATURE OF OPERATIONS', array('class' => 'col-md-12', 'style' => 'text-align:center'))
                            ->draw();
                ?>
                
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <button type = "submit" class = "btn btn-sm btn-default">UPDATE</button>
        </div>
    </div>
</div>
</form>
<script>
	var ajax = {}
	ajax.client_id = '<?= $client_id ?>';
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_checked_operation_list', ajax, function(data) {
			$('#operation_list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();

    $('form').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '<?=$ajax_post?>', function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>