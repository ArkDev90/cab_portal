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
        FORM 61-B : Monthly Statement of Traffic and Operating Statistics (February 2018)
    </div>
    <div class = "row nav_link">
        <a href = "">Back to FORM 61-B : Monthly Statement of Traffic and Operating Statistics List </a>
    </div>
    <div class = "row dl_button">
        <button type = "button" class = "btn btn-info btn-md" style = "font-weight:bold">DOWNLOAD REPORT</button>
    </div>
    <div class = "row table" style = "margin: 1% 0% 0% 0%">
        <table cellspacing = "0" id = "report_list" class="table-hover table-sidepad" border = "1">
			<thead>
               <tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">
                    <th rowspan="2">DATE</th>
                    <th colspan="2">AIRCRAFT</th>
                    <th colspan="2">AIRPORTS SERVED</th>
                    <th rowspan="2">DISTANCE TRAVELLED (Kilometers)</th>
                    <th colspan="2">FLOWN</th>
                    <th rowspan="2">TOTAL PASSENGERS</th>
                    <th colspan="3">CARGO CARRIED</th>
                    <th rowspan="2">DERIVED REVENUE (Peso)</th>
                </tr>
                <tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">
                    <th>TYPE</th>
                    <th>NUMBER</th>
                    <th>ORIGIN</th>
                    <th>DESTINATION</th>
                    <th>HOUR</th>
                    <th>MINUTES</th>
                    <th>QTY (Kilograms)</th>
                    <th>VALUE (Peso)</th>
                    <th>TYPE</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
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
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_report_list', ajax, function(data) {
			$('#report_list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
			}
		});
	}
    getList();
</script>
