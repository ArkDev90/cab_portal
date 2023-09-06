
<form action="" method="post" id = "HAWBS">
<div class="panel panel-primary br-xs" id="filters">
	<div class="panel-heading bb-colored text-center">
		CAB Form : Summary of HAWBS
	</div>
    <div class = "row">&nbsp;</div>
        <div class = "row">
            <div class="col-md-12">
            <div class = "col-md-1 text-right">
                From:
            </div>
            <div class = "col-md-2">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('from_month')
                    ->setId('from_month')
                    ->setList(array('01' => 'January','02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-1" id = "div_year">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('from_year')
                    ->setId('from_year')
                    ->setList(array('2018' => '2018', '2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-1 text-right">
                To:
            </div>
            <div class = "col-md-2">
            <?php
                echo $ui->formField('dropdown')
                ->setName('to_month')
                ->setId('to_month')
                ->setList(array('01' => 'January','02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'))
                ->draw($show_input);
            ?>
            </div>
            <div class = "col-md-1" id = "div_report_year">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('to_year')
                    ->setId('to_year')
                    ->setList(array('2018' => '2018', '2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-1 text-right">
                Filter By:
            </div>
            <div class = "col-md-2" id = "filterdiv">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('filter')
                    ->setId('filter')
                    ->setList(array('1' => 'International', '2' => 'Domestic'))
                    ->draw($show_input);
                ?>
            </div>
            </div>
        </div>

        <div class = "row">
            <div class="col-md-12">
            <div class = "col-md-2 text-right" style="padding: 5px 1px 1px 1px;">
                International Fee: Php
            </div>
            <div class = "col-md-2">
                <?php
                    echo $ui->formField('text')
                    ->setName('inter_fee')
                    ->setId('inter_fee')
                    ->setValue('50.00')
                    ->setValidation('decimal')
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-2 text-right" style="padding: 5px 1px 1px 1px;">
            Domestic Fee: Php
            </div>
            <div class = "col-md-2">
                <?php
                    echo $ui->formField('text')
                    ->setName('dom_fee')
                    ->setId('dom_fee')
                    ->setValue('40.00')
                    ->setValidation('decimal')
                    ->draw($show_input);
                ?>
            </div>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
        <div class="col-md-12 text-center">
        <div class = "col-md-3"></div>
            <div class = "col-md-6 text-center">
                <?php
                    echo $ui->formField('dropdown')
                    ->setLabel('Client Name:')
                    ->setSplit('col-md-3', 'col-md-6')
                    ->setName('client')
                    ->setId('client')
                    ->setList($airlines)
                    ->setValue('')
                    ->draw($show_input);
                ?>
            </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-12 text-center">
        <div class = "col-md-3"></div>
            <div class = "col-md-6">
                <div class="col-md-3"><label for="client_code"><?php echo 'Client Code: '; ?></label></div>
                <div class = "col-md-1"><label for="client_code"><?php echo 'MAF'; ?></label></div>
            </div>
        </div>
        </div>

        <div class="row">&nbsp;</div>
        <div class="row">
        <div class="col-md-12 text-center">
        <div class = "col-md-3"></div>
       
            <div class="row">
            <div class = "col-md-1 text-right" style="padding: 5px 1px 1px 1px;">Additional Filter: </div>
                <div class="col-md-12">
                <input type="checkbox" name="add_filter" id="direct" value="direct"> Cargo Direct
                <input type="checkbox" name="add_filter" id="consolidation" value="consolidation"> Cargo Consolidation
                <input type="checkbox" name="add_filter" id="breakbulking" value="breakbulking"> Cargo Breakbulking
                </div>
            </div>
            </div>        
        </div>
        <div class="row">&nbsp;</div>
        <div class="row col-md-12 text-center">
        <button type = "button" id = "filter_button" disabled style="font-size: 8pt; font-weight: bold;  border: 0px solid; padding: 5px; text-decoration: none; color: gray; background: #EEE;width: 100px;">Filter</button>
        </div>
        
        <div class="row">&nbsp;</div>        
        <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4 text-center">
        <span id="fromto"><b>From: </b></span><span id="fmonth"></span> <span id="fyear"></span> - <span id="tmonth"></span> <span id="tyear"></span>               
        </div>
        <div class="col-md-2"></div>        
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-8">
        <table border="1" id="list" class="table table-hover table-sidepad" style="width:100%">
        <?php
                        echo $ui->loadElement('table')
                                ->setHeaderClass('info')
                                ->addHeader('', array('class' => 'col-md-2'))
                                ->addHeader('No. of HAWBS ', array('class' => 'col-md-2'))
                                ->addHeader('Total Fee (Php)', array('class' => 'col-md-2'))
                                ->draw();
                    ?>
                    <tbody></tbody>
                    <tfoot id="foot">
                    <td><b>Total</b></td>
                    <td><b></b></td>
                    <td><b></b></td>
                    
                    </tfoot>
                </table>
        </div>
        <div class="col-md-2"></div>
        
        <div class="row">&nbsp;</div>

        <div class="row col-md-12 text-center">
        <button type = "button" id="download" class = "btn btn-info btn-md" style = "font-weight:bold">DOWNLOAD REPORT</button>
        </div>
        

        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>
        <div class="row">&nbsp;</div>


</div>

<script>
 var client_id = $('#client').val();
 $(document).ready(function(){
    $('#fromto').hide();
 });

 $('#filters').on('ifToggled', 'input[name="add_filter"]', function () {
    var b = $('input[type=checkbox]');
		if(b.filter(':checked').length > 0){
			$('#filter_button').prop('disabled',false)
            $('#filter_button').css('color', '#444');            
		} else{
			$('#filter_button').prop('disabled',true)		
            $('#filter_button').css('color', '#999');            
		}
    // $('#filter_button').attr('disabled',false);
    // $('#filter_button').css('border', 'solid 1px');
// console.log($('input[name="add_filter"]').each(function() { x += $(this).is(':checked'); }));

// var x = "";
// $('input[type=checkbox]').each(function () {
// // console.log (this.checked);
    
//     var x = (this.checked ? "true" : "false");
//     x += $(this).is(':checked');
   
// });

});


$('#filter_button').on('click', function(){
    $('#foot').hide();
    $('#fromto').show();
    // $.post('<?=MODULE_URL?>ajax/ajax_view_hawbs', '&client_id='+client_id, function(data) {
        var client_ids  = $('#client').val();
        var from_month  = $('#from_month').val();
        var from_year   = $('#from_year').val();
        var to_month    = $('#to_month').val();
        var to_year     = $('#to_year').val();
        var inter_fee   = $('#inter_fee').val();
        var dom_fee     = $('#dom_fee').val(); 
        var filter      = $('#filter').val();
        var f_month     = jQuery("#from_month :selected").text();
        var t_month     = jQuery("#to_month :selected").text();
        $('#fmonth').html(f_month); 
        $('#fyear').html(from_year); 
        $('#tmonth').html(t_month); 
        $('#tyear').html(to_year); 
        
        $.post('<?=MODULE_URL?>ajax/ajax_view_hawbs', '&client_id='+client_ids+'&from_month='+from_month+'&from_year='+from_year+'&to_month='+to_month+'&to_year='+to_year+'&inter_fee='+inter_fee+'&dom_fee='+dom_fee+'&filter='+filter, function(data) {
        $('#list tbody').html(data.table);
        });
    // });

});

$("#download").on('click', function() {
        window.open('<?php echo MODULE_URL ?>HAWBS_pdf?' + $('#HAWBS').serialize());
    });
</script>