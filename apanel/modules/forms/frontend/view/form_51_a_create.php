<style>
td{
    font-size: 12px !important;
    color: black;
    font-family: Arial, Helvetica, sans-serif;
}
.table_border {
    border: 1px #003366 solid;
    font-family: Arial;
    color: #D7E0E9;
    font-size: 9pt;
    border-radius: 2px;
	background-color: #D7E0E9;
}
td b{
	color: #003366;
	font-size: 10px;
}

.table_line2_left, .table_line1_left, .table_line2_left_right{
	color: #003366;
	font-size: 10px;
}



</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<form method="POST" id="form">
<div class="panel panel-primary br-xs" style="width: 98%;">
	<div class="panel-heading bb-colored text-center">
    DIRECT PASSENGER TRAFFIC
	</div><br>
    <div class="panel panel-primary br-xs" style="width: 98%;margin-left: 6px;"><br>
    <div class="col-md-2 col-md-offset-1">Report Date:</div>
    <div class="col-md-4">3rd Quarter (Jul,Aug,Sep)</div>
    <div class="col-md-2 col-md-offset-1">Report Year:</div>2018
    <div class="row">&nbsp;</div>
    </div>

    <div class="panel panel-primary br-xs" style="width: 98%;margin-left: 6px;">
	<div class="panel-heading bb-colored text-center">
    DIRECT PASSENGER TRAFFIC
	</div>
    <div class = "row nav_link errmsg" id = "assign" style="color:red">
    - Please Fill Up Flight Details -
    </div>

    <table align="center" cellspacing="0" border="0" width="100%" class="arial9" style="border:none;">
		
		<tbody><tr>
			<td align="right">Aircraft Used :</td><td align="left">&nbsp;
							<input type="text" name="aircraft" value="" class="input_black" style="width: 150">
			</td>
			<td align="right">First Class :</td>
			<td align="left">&nbsp;
							<input type="text" name="first" tabindex="4" value="" maxlength="250" class="input_black" style="width:150px;" id="f_class" onkeypress="validate(event)" onBlur="compute()">
			</td>
		</tr>
		<tr>
			<!-- original
			<td align="right"><input id = "ffreedom" type = "checkbox" name="extra"  value = "yes" onclick = "extraf(this.value)"/></td><td align="left">&nbsp; Fifth Freedom</td> -->

			
			
			<td align="right">
				&nbsp;
			</td>

			<td align="left">
							 <label class="f51a_control control--radio"><input id="freedom" type="radio" name="extra" value="yes" data-waschecked="false">
				  <div class="f51a_control__indicator"></div>
				 </label>
			&nbsp; Fifth Freedom</td>
		
			<td align="right">Business Class :</td>
			<td align="left">&nbsp;
							<input type="text" name="business" tabindex="5" value="" maxlength="250" class="input_black" style="width: 150px;" id="b_class" onkeypress="validate(event)" onBlur="compute()">
			</td>
		</tr>
		<tr>
			<!-- original
				<td align="right">
				<input id = "coterminal" type = "checkbox" name="extra" value="yes"  onclick = "extraf(this.value)"/>
			</td>  -->
			<td align="right">
				&nbsp;
			</td> 
			<td align="left">
								<label class="f51a_control control--radio"><input id="coterminal" type="radio" name="extra" value="no" checked="" data-waschecked="true">
				<div class="f51a_control__indicator"></div>
				</label>
				&nbsp; Co - Terminal</td>
			<td align="right">Economy Class :</td>
			<td align="left">&nbsp;
				
				<input type="text" tabindex="6" id="e_class" name="economy" value="" maxlength="250" class="input_black" style="width:150px;" onkeypress="validate(event)" onBlur="compute()">
			</td>
		</tr>

		<tr>
			<td></td><td></td>
			<input type="text" id="total" hidden>
			<td align="right">Total Seats :</td><td align="left">&nbsp;<span style="padding-left: 5px; font-size: ; font-weight: bold;" id="seats_offered"><input style="border:none;background:  transparent;" type="text" id="ts" name="ts" disabled=""></span></td>
		</tr>
		
	
		</tbody></table>
    
    <div class="row">
    <div class="col-md-12">
    <div class="col-md-2" align="right">Route: </div>
        <div class="col-md-3">
        <?php
                echo $ui->formField('dropdown')
				->setName('destination_from')
				->setList($domestic_list)
                ->setId('destination_from')
                ->draw();
            ?>
        </div>

        <div class="col-md-3">
        <?php
                echo $ui->formField('dropdown')
				->setName('destination_to')
				->setList($international_list)
				->setId('destination_to')				
                ->draw();
            ?>
        </div>

        <div class="col-md-3" id="r3" hidden>
        <?php
                echo $ui->formField('dropdown')
                ->setName('extra_dest')
                ->setId('extra_dest')
                ->draw();
            ?>
        </div>

 

   </div>
   </div>



    <table align="center" cellspacing="0" border="0" width="100%" class="arial9" style="border:none;">
		<tbody><tr><td>&nbsp;</td></tr>
		<tr>
			<td></td>
			<td colspan="3" align="center"><b><span id="routeFrom"></span>   <span id="routeTo"></span></b></td>
			 <td rowspan="5" style="background: #000000; width:0; height: 100%"></td>
			 <td colspan="3" align="center"><b><span id="routeTo2"></span>   <span id="routeFrom2"></span></b></td>
		</tr>
		<tr>
			<td align="right" width=""></td>
			<td align="center" width=""><b><p id="m1">APR</p></b></td>
			<td align="center" width=""><b><p id="m2">MAY</p></b></td>
			<td align="center" width=""><b><p id="m3">JUN</p></b></td>
			
			<td align="center" width=""><b><p id="m1_d">APR</p></b></td>
			<td align="center" width=""><b><p id="m2_d">MAY</p></b></td>
			<td align="center" width=""><b><p id="m3_d">JUN</p></b></td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td align="right" width="">Passenger Traffic :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange(this)" onkeypress="validate(event)" name="quarter_month1" id="ptraffic1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="ptrafficChange(this)" onkeypress="validate(event)" name="quarter_month2" id="ptraffic2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="ptrafficChange(this)" onkeypress="validate(event)" name="quarter_month3" id="ptraffic3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange_d(this)" onkeypress="validate(event)" name="quarter_month1_d" id="ptraffic1_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange_d(this)" onkeypress="validate(event)" name="quarter_month2_d" id="ptraffic2_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange_d(this)" onkeypress="validate(event)" name="quarter_month3_d" id="ptraffic3_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
		</tr>
		<tr>
			<td align="right" width="">Number of Flights :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange(this)" onkeypress="validate(event)" name="nflight_month1" id="nflight1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange(this)" onkeypress="validate(event)" name="nflight_month2" id="nflight2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange(this)" onkeypress="validate(event)" name="nflight_month3" id="nflight3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="nflightChange_d(this)" onkeypress="validate(event)" name="nflight_month1_d" id="nflight1_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange_d(this)" onkeypress="validate(event)" name="nflight_month2_d" id="nflight2_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange_d(this)" onkeypress="validate(event)" name="nflight_month3_d" id="nflight3_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
		</tr>
		<tr>
			<td align="right" width="">FOC Traffic :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="foctraffic_month1" id="foctraffic1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="foctraffic_month2" id="foctraffic2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="foctraffic_month3" id="foctraffic3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="foctraffic_month1_d" id="foctraffic1_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="foctraffic_month2_d" id="foctraffic2_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="foctraffic_month3_d" id="foctraffic3_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
		</tr>
		
		<!-- added for codeshared -->
		<tr><td height="10px"></td></tr>
		<tr align="center">

			<td style="padding-left: 50px; font-weight: bold; font-size: 14px; color: #1e2fDA">CODE SHARED</td>
		</tr>
		<tr>
			<td style="text-align: right; padding-right: 15px;">
						 <label class="f51a_codeshared_control control--radio"><input type="radio" name="iscodeshared" id="iscodeshared" data-waschecked="false"> Code Shared Flight  <div class="f51a_codeshared_control__indicator"></div>
		 	</label></td>
			
		</tr>
		<tr>
			<td colspan="6" style="text-align: left;">
				<span style="margin-left: 80px;display: inline-block;">Marketing Airline:</span>
								<input class="input_black" type="text" name="codeshared" value="" style="width: 200px; font-size: 10px;">
							</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td></td>
			<td colspan="3" align="center">&nbsp;</td>
			 <td rowspan="5" style="background: #000000; width:2px; height: 100%"></td>
			 <td colspan="3" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td align="right" width=""></td>
			<td align="center" width=""><b><p id="m1">APR</p></b></td>
			<td align="center" width=""><b><p id="m2">MAY</p></b></td>
			<td align="center" width=""><b><p id="m3">JUN</p></b></td>
			
			<td align="center" width=""><b><p id="m1_d">APR</p></b></td>
			<td align="center" width=""><b><p id="m2_d">MAY</p></b></td>
			<td align="center" width=""><b><p id="m3_d">JUN</p></b></td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
		
			<td align="right" width="">Passenger Traffic :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="cs_ptrafficChange(this)" onkeypress="validate(event)" name="cs_ptraffic1" id="cs_ptraffic1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="cs_ptrafficChange(this)" onkeypress="validate(event)" name="cs_ptraffic2" id="cs_ptraffic2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="cs_ptrafficChange(this)" onkeypress="validate(event)" name="cs_ptraffic3" id="cs_ptraffic3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
			<td align="center" width="">
							<input type="text" onchange="cs_ptrafficChange_d(this)" onkeypress="validate(event)" name="cs_ptraffic1_d" id="cs_ptraffic1_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="cs_ptrafficChange_d(this)" onkeypress="validate(event)" name="cs_ptraffic2_d" id="cs_ptraffic2_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="cs_ptrafficChange_d(this)" onkeypress="validate(event)" name="cs_ptraffic3_d" id="cs_ptraffic3_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
		</tr>
		<tr>
			<td align="right" width="">Number of Flights :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="cs_nflightChange(this)" onkeypress="validate(event)" name="cs_nflight1" id="cs_nflight1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="cs_nflightChange(this)" onkeypress="validate(event)" name="cs_nflight2" id="cs_nflight2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="cs_nflightChange(this)" onkeypress="validate(event)" name="cs_nflight3" id="cs_nflight3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="cs_nflightChange_d(this)" onkeypress="validate(event)" name="cs_nflight1_d" id="cs_nflight1_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="cs_nflightChange_d(this)" onkeypress="validate(event)" name="cs_nflight2_d" id="cs_nflight2_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="cs_nflightChange_d(this)" onkeypress="validate(event)" name="cs_nflight3_d" id="cs_nflight3_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
		</tr>

		<!-- Added -->
		<tr>
			<td align="right" width="">FOC Traffic :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="cs_foctraffic1" id="cs_foctraffic1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="cs_foctraffic2" id="cs_foctraffic2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="cs_foctraffic3" id="cs_foctraffic3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="cs_foctraffic1_d" id="cs_foctraffic1_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="cs_foctraffic2_d" id="cs_foctraffic2_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="cs_foctraffic3_d" id="cs_foctraffic3_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
		</tr>
		<!-- End -->

	<!------------------------------------------------------ WITH FREE FLIGHT -------------------------->
		</tbody></table>

		<table align="center" cellspacing="0" border="0" width="100%" id="table" style="border:none;" hidden>
		<tbody><tr><td>&nbsp;</td></tr>
		<tr>
			<td></td>
			<td colspan="3" align="center"><b><span id="routeFrom"></span>   <span id="routeTo"></span></b></td>
			 <td rowspan="5" style="background: #000000; width:2px; height: 100%"></td>
			 <td colspan="3" align="center"><b><span id="routeTo2"></span>   <span id="routeFrom2"></span></b></td>
		</tr>
		<tr>
			<td align="right" width=""></td>
			<td align="center" width=""><b><p id="m1">APR</p></b></td>
			<td align="center" width=""><b><p id="m2">MAY</p></b></td>
			<td align="center" width=""><b><p id="m3">JUN</p></b></td>
			
			<td align="center" width=""><b><p id="m1_d">APR</p></b></td>
			<td align="center" width=""><b><p id="m2_d">MAY</p></b></td>
			<td align="center" width=""><b><p id="m3_d">JUN</p></b></td>
			<td width="100">&nbsp;</td>
		</tr>
		<tr>
			<td align="right" width="">Passenger Traffic :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange(this)" onkeypress="validate(event)" name="eptraffic1" id="ptraffic1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="ptrafficChange(this)" onkeypress="validate(event)" name="eptraffic2" id="ptraffic2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="ptrafficChange(this)" onkeypress="validate(event)" name="eptraffic3" id="ptraffic3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange_d(this)" onkeypress="validate(event)" name="eptraffic1_d" id="ptraffic1_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange_d(this)" onkeypress="validate(event)" name="eptraffic2_d" id="ptraffic2_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="ptrafficChange_d(this)" onkeypress="validate(event)" name="eptraffic3_d" id="ptraffic3_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
		</tr>
		<tr>
			<td align="right" width="">Number of Flights :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange(this)" onkeypress="validate(event)" name="enflight1" id="nflight1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange(this)" onkeypress="validate(event)" name="enflight2" id="nflight2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange(this)" onkeypress="validate(event)" name="enflight3" id="nflight3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="nflightChange_d(this)" onkeypress="validate(event)" name="enflight1_d" id="nflight1_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange_d(this)" onkeypress="validate(event)" name="enflight2_d" id="nflight2_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="nflightChange_d(this)" onkeypress="validate(event)" name="enflight3_d" id="nflight3_d" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			
		</tr>
		<tr>
			<td align="right" width="">FOC Traffic :&nbsp;</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="efoctraffic1" id="foctraffic1" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="efoctraffic2" id="foctraffic2" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange(this)" onkeypress="validate(event)" name="efoctraffic3" id="foctraffic3" maxlength="10" class="input_black" style="width:50px;" value="">
			</td>

			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="cs_foctraffic_month1_d" id="efoctraffic1_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="cs_foctraffic_month2_d" id="efoctraffic2_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
			<td align="center" width="">
							<input type="text" onchange="foctrafficChange_d(this)" name="cs_foctraffic_month3_d" id="efoctraffic3_d" maxlength="10" class="input_black" style="width:50px;" onkeypress="validate(event)" value="">
			</td>
		</tr>
		</table>
<br>
<div align="center"><input type="submit" name="button_add" value="ADD"></div><br>
    </div>

	</form>

	<table align="center" cellspacing="1" cellpadding="1" border="1" width="100%" id="table1" class="table_border arial8">
		<tbody>

		</tbody>
	</table>
	<br><br>
		<table align="center" cellspacing="1" cellpadding="1" border="1" width="100%" id="table2" class="table_border arial8">
			<tbody>
			
			</tbody>
		</table>

</div>

<script>
$('input[name=extra]').on('click', function() {
	$('#r3').toggle($('#freedom').prop('checked'));
	$('#table').toggle($('#freedom').prop('checked'));
});

var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_table1_list', ajax, function(data) {
			$('#table1 tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();
	var ajax1 = {}
	var ajax_call1 = '';
	function getList1() {
		if (ajax_call1 != '') {
			ajax_call1.abort();
		}
		ajax_call1 = $.post('<?=MODULE_URL?>ajax/ajax_table2_list', ajax1, function(data) {
			$('#table2 tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList1();
			}
		});
	}
	getList1();
	
function compute()
	{	
		var f_class 	= $("#f_class").val();
		f_class			= f_class.replace(/\,/g,'');
		var b_class 	= $("#b_class").val();
		b_class			= b_class.replace(/\,/g,'');
		var e_class 	= $("#e_class").val();
		e_class			= e_class.replace(/\,/g,'');
		
		var total			= 0;
		total				= parseInt(f_class) + parseInt(b_class) + parseInt(e_class);
		
		$("#ts").val(total);
		formatNumber('ts');
		
		formatNumber('f_class');
		formatNumber('b_class');
		formatNumber('e_class');

		
	}

function validate(evt) 
	{
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
			if( !regex.test(key) ) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			}
	}

$('#form').submit(function(e) {
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

