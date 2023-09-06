<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		Report Viewer
    </div>
    <div class = "row" style = "padding: 3% 3% 0% 0%">
        <div class = "col-md-5" style = "text-align:right">
            Client Name :
        </div>
        <div class = "col-md-7">
            <b>101 New York Logistics Corporation</b> [ AF-285 ]
        </div>
    </div>
    <div class = "row" style = "padding: 1% 3% 0% 0%">
        <div class = "col-md-5" style = "text-align:right">
            Address :
        </div>
        <div class = "col-md-7">
            No.11A Sunblest compound KM 23 West Service Road Cupang Muntinlupa City, Philippines
        </div>
    </div>
    <div class = "row" style = "padding: 1% 3% 1% 0%">
        <div class = "col-md-5" style = "text-align:right">
            Email Address :
        </div>
        <div class = "col-md-7">
            aie.sobrecarey2015@gmail.com
        </div>
    </div>
    <div class = "row navhead">
        <ul style = "list-style-type: none">
            <li><a href = "<?php echo MODULE_URL ?>listing">[ Back to Main ]</a></li>
            <li><a href = "<?php echo MODULE_URL ?>client_info">[ Client Info ]</a></li>  
            <li><a href = "<?php echo MODULE_URL ?>users">[ Users ]</a></li> 
            <li><a href = "<?php echo MODULE_URL ?>add_operation">[ Add Nature of Operation ]</a></li>
            <li><a href = "<?php echo MODULE_URL ?>change_status">[ Change Status ]</a></li>
            <li><a href = "<?php echo MODULE_URL ?>reports">[ View All Reports ]</a></li> 
            <li><a href = "<?php echo MODULE_URL ?>history">[ View History Listing ]</a></li>
        </ul>
    </div>
    <div class = "row report_name">
        FORM T-1A : Domestic Sector Load Report (November 2018)
    </div>
    <div class = "row nav_link">
        <a href = "">Back to FORM T-1A : Domestic Sector Load Report List </a>
    </div>
    <div class = "row dl_button">
        <button type = "button" class = "btn btn-info btn-md" style = "font-weight:bold">DOWNLOAD REPORT</button>
    </div>
    <div class = "row" style = "margin: 1% 2% 0% 2%">
        <table border = "1" id = "first_table" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('Sector')
                        ->addHeader('Distance [KMs]')
                        ->addHeader('Available Seat-KMS Offered')
                        ->addHeader('Available Seats')
                        ->addHeader('Revenue Passengers')
                        ->addHeader('Non-Revenue Passengers')
                        ->addHeader('Passenger Load Factor')
                        ->addHeader('Cargo [Kilograms]')
						->draw();
			?>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <td>SUBTOTAL:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>TOTAL:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
		</table>
    </div>
    <div class = "row" style = "margin: 1% 2% 0% 2%">
        <table border = "1" id = "second_table" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('CODESHARED', array('colspan' => '9'))
						->draw();
			?>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <td>SUBTOTAL:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>TOTAL:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
		</table>
    </div>
</div>

<script>
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_first_list', ajax, function(data) {
			$('#list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();

    var ajax2 = {}
	var ajax_call2 = '';
    function getList2() {
		if (ajax_call2 != '') {
			ajax_call2.abort();
		}
		ajax_call2 = $.post('<?=MODULE_URL?>ajax/ajax_codeshared_list', ajax, function(data) {
			$('#second_table tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList2();
			}
		});
	}
    getList2();
</script>
