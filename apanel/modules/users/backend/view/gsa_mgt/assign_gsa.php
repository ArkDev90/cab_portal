<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE GENERAL SALES AGENT
    </div>
    <div class = "row">
        <div class = "col-md-12 head_link" style = "padding: 3% 2% 2% 3%">
            <a href = "<?= MODULE_URL ?>create"> GSA INFORMATION </a> |
            <a href = "<?MODULE_URL ?>assign_gsa"> ASSIGN STAKEHOLDER </a> | 
            <a href = "<?MODULE_URL ?>confirm_gsa"> CONFIRMATION </a>
        </div>
    </div>
    <div class = "row">
        <div class="col-md-6 col-md-offset-3 box-body table-responsive" style = "padding: 2% 0% 0% 0.5%">
            <table id="operation_list" class="table table-sidepad">
                <?php
                    echo $ui->loadElement('table')
                            ->setHeaderClass('info')
                            ->addHeader('Select Nature of Operations', array('class' => 'col-md-12', 'style' => 'text-align:center'))
                            ->draw();
                ?>
                
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <td><center><button type = "button" class = "btn btn-sm btn-primary">FILTER</button></center></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class = "row">
        <div class="col-md-6 col-md-offset-3 box-body table-responsive" style = "padding: 2% 0% 0% 0.5%">
            <table id="stakeholders_list" class="table table-sidepad">
                <?php
                    echo $ui->loadElement('table')
                            ->setHeaderClass('info')
                            ->addHeader('List Of Stakeholders', array('class' => 'col-md-12', 'style' => 'text-align:center'))
                            ->draw();
                ?>
                
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <button type = "button" class = "btn btn-sm btn-default">CANCEL</button>
            <button type = "button" class = "btn btn-sm btn-primary">SUBMIT</button>
        </div>
    </div>
</div>
<script>
	var ajax = {}
    var ajax2 = {}
	var ajax_call = '';
    var ajax_call2 = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_operation_list', ajax, function(data) {
			$('#operation_list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}

    function getList2() {
		if (ajax_call2 != '') {
			ajax_call2.abort();
		}
        ajax_call2 = $.post('<?=MODULE_URL?>ajax/ajax_stakeholders_list', ajax, function(data) {
			$('#stakeholders_list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}

	getList();
    getList2();
</script>