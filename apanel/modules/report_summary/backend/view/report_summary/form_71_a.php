<form action="" method="post" id = "form71a">
<div class="panel panel-primary br-xs" id="filters">
	<div class="panel-heading bb-colored text-center">
        FORM 71-A : International Airfreight Forwarder Cargo Production Report
	</div>
    <div class = "row">
    <div class = "col-md-1" style = "text-align:left; padding:2% 7% 0% 5%">
        Report Type:
    </div>
    <div class = "col-md-2" style = "padding:2% 0% 0% 0%">
        <?php
            echo $ui->formField('dropdown')
            ->setName('report_type')
            ->setId('report_type')
            ->setList(array('Quarterly' => 'Quarterly','Consolidated' => 'Consolidated', 'Yearly' => 'Yearly'))
            ->draw($show_input);
        ?>
    </div>
    <div class = "col-md-4" id = "div_quarter" style = "padding:2% 2% 0% 1%">
        <?php
            echo $ui->formField('dropdown')
            ->setName('quarter')
            ->setList(array('1st Quarter' => '1st Quarter (Jan, Feb, March)', '2nd Quarter' => '2nd Quarter (Apr, May, Jun)', '3rd Quarter' => '3rd Quarter (Jul, Aug, Sep)', '4th Quarter' => '4th Quarter (Oct, Nov, Dec)'))
            ->setId('quarter')
            ->draw($show_input);
        ?>
    </div>
    <div id = "date_range">
        <div class = "col-md-1" style = "text-align:left; padding:2% 2% 0% 1%">
            From:
        </div>
        <div class = "col-md-2" style = "padding:2% 1% 0% 0%">
            <select name = "start_date" id = "start_date">
                <option value = "1st Quarter" data-limit="1">1st Quarter</option>
                <option value = "2nd Quarter" data-limit="2">2nd Quarter</option>
                <option value = "3rd Quarter" data-limit="3">3rd Quarter</option>
                <option value = "4th Quarter" data-limit="4">4th Quarter</option>
            </select>
        </div>
        <div class = "col-md-1" style = "text-align:left; padding:2% 2% 0% 1%">
            To:
        </div>
        <div class = "col-md-2" style = "padding:2% 1% 0% 0%">
            <select name = "end_date" id = "end_date">
                <option value = "1st Quarter" data-prevent="1">1st Quarter</option>
                <option value = "2nd Quarter" data-prevent="2">2nd Quarter</option>
                <option value = "3rd Quarter" data-prevent="3">3rd Quarter</option>
                <option value = "4th Quarter" data-prevent="4">4th Quarter</option>
            </select>
        </div>
    </div>
    <div class = "col-md-2" id = "div_year" style = "padding:2% 2% 0% 1%">
        <?php
            echo $ui->formField('dropdown')
            ->setName('year')
            ->setId('year')
            ->setList(array('2018' => '2018', '2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
            ->draw($show_input);
        ?>
    </div>
</div>
<div class="panel panel-primary br-xs col-md-7" style = "margin: 2% 0% 2% 3%; padding: 1%">
    <div class = "row" style = "padding:2% 0% 0% 0%">
        <div class = "col-md-12 filter_col">
            <input type = "radio" name = "category" value = "Ranking" checked = "checked"> Ranking
            <div class = "col-md-12" style = "padding: 2% 0% 0% 15%">
                <input type = "radio" name = "rank" value = "Top 30" checked = "checked"> Top 30 &nbsp;&nbsp;&nbsp;
                <input type = "radio" name = "rank" value = "All"> All &nbsp;&nbsp;&nbsp;
                <input type = "radio" name = "rank" value = "By Country"> By Country 
            </div>
            <div class = "col-md-12 sub_filter" style = "padding: 5% 0% 0% 25%">
                <input type = "radio" name = "rank_category" value = "Direct Shipment"> Direct Shipment 
                <div class = "col-md-12" style = "padding: 2% 0% 0% 10%">
                    <input type = "checkbox" name = "ds_market_share" value = "Market Share"> Market Share <br>
                    <input type = "checkbox" name = "ds_cmarket_share" value = "Cumulative Market Share"> Cummulative Market Share 
                </div>
            </div>
            <div class = "col-md-12 sub_filter" style = "padding: 5% 0% 0% 25%">
                <input type = "radio" name = "rank_category" value = "Consolidation"> Consolidation 
                <div class = "col-md-12" style = "padding: 2% 0% 0% 10%">
                    <input type = "checkbox" name = "c_market_share" value = "Market Share"> Market Share <br>
                    <input type = "checkbox" name = "c_cmarket_share" value = "Cumulative Market Share"> Cummulative Market Share 
                </div>
            </div>
            <div class = "col-md-12 sub_filter" style = "padding: 5% 0% 0% 25%">
                <input type = "radio" name = "rank_category" value = "Breakbulking"> Breakbulking 
                <div class = "col-md-12" style = "padding: 2% 0% 0% 10%">
                    <input type = "checkbox" name = "b_market_share" value = "Market Share"> Market Share <br>
                    <input type = "checkbox" name = "b_cmarket_share" value = "Cumulative Market Share"> Cummulative Market Share 
                </div>
            </div>
            <div class = "col-md-12 sub_filter" style = "padding: 5% 0% 0% 25%">
                <input type = "radio" name = "rank_category" value = "Total"> Total 
                <div class = "col-md-12" style = "padding: 2% 0% 0% 10%">
                    <input type = "checkbox" name = "t_market_share" value = "Market Share"> Market Share <br>
                    <input type = "checkbox" name = "t_cmarket_share" value = "Cumulative Market Share"> Cummulative Market Share 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-primary br-xs col-md-4" style = "margin: 2% 2% 2% 2%; padding: 1%">
   <div class = "row" style = "padding:2% 0% 0% 0%">
        <div class = "col-md-12 filter_col">
            <input type = "radio" name = "category" value = "Summary"> Summary per AFF
            <div class = "col-md-12" style = "padding: 10% 0% 0% 10%">
                <input type = "checkbox" name = "direct_shipment" value = "Direct Shipment"> Direct Shipment 
                <div class = "col-md-12" style = "padding: 2% 0% 0% 15%">
                    <input type = "checkbox" name = "ds_summary1" value = "MAWBs"> MAWBs <br>
                    <input type = "checkbox" name = "ds_summary2" value = "Chargeable Weight"> Chargeable Weight <br>
                    <input type = "checkbox" name = "ds_summary3" value = "Airline Freight Charges"> Airline Freight Charges <br>
                    <input type = "checkbox" name = "ds_summary4" value = "Commission Earned"> Commission Earned
                </div>
            </div>
            <div class = "col-md-12" style = "padding: 5% 0% 0% 10%">
                <input type = "checkbox" name = "consolidation" value = "Consolidation"> Consolidation 
                <div class = "col-md-12" style = "padding: 2% 0% 0% 15%">
                    <input type = "checkbox" name = "c_summary1" value = "MAWBs"> MAWBs <br>
                    <input type = "checkbox" name = "c_summary2" value = "HAWBs"> HAWBs <br>
                    <input type = "checkbox" name = "c_summary3" value = "Chargeable Weight"> Chargeable Weight <br>
                    <input type = "checkbox" name = "c_summary4" value = "Airline Freight Charges"> Airline Freight Charges <br>
                    <input type = "checkbox" name = "c_summary5" value = "Gross Consolidated Revenue"> Gross Consolidated Revenue
                </div>
            </div>
            <div class = "col-md-12" style = "padding: 5% 0% 0% 10%">
                <input type = "checkbox" name = "breakbulking" value = "Breakbulking"> Breakbulking 
                <div class = "col-md-12" style = "padding: 2% 0% 0% 15%">
                    <input type = "checkbox" name = "b_summary1" value = "HAWBs"> HAWBs <br>
                    <input type = "checkbox" name = "b_summary2" value = "Chargeable Weight"> Chargeable Weight <br>
                    <input type = "checkbox" name = "b_summary3" value = "Income"> Income
                </div>
            </div>
        </div>
    </div><br><br><br>
</div>

<div class = "row" style = "margin: 0% 0% 2% 2%">
    File Type: 
    <span style="margin-left:2px;">
        <button type = "button" class = "btn btn-flat btn-primary" id = "pdf">PDF</button>
    </span>
    <span style="margin-left:2px;">
        <button type = "button" class = "btn btn-flat btn-primary" id = "csv">CSV</button>
    </span>
</div>
</div>
</form>
<script>
$(document).ready(function(){
    $('#div_quarter').show();
    $('#div_year').show();
    $('#date_range').hide();
    $('#report_type').on('change', function() {
        var report_type = $('#report_type').val();
        if (report_type == 'Quarterly') {
            $('#div_quarter').show();
            $('#div_year').show();
            $('#date_range').hide();
        }
        else if (report_type == 'Consolidated') {
            $('#div_quarter').hide();
            $('#div_year').show();
            $('#date_range').show();
        }
        else {
            $('#div_quarter').hide();
            $('#div_year').show();
            $('#date_range').hide();
        }
    });
    $('#filters').on('ifToggled', 'input[name="category"]', function () {
        $('#filters input[type="radio"]:not(input[name="category"]), #filters input[type="checkbox"]').iCheck('disable').iCheck('uncheck');
        $(this).closest('.filter_col').find('input[type="radio"], input[type="checkbox"]').iCheck('enable');
    });
    $('#filters').on('ifToggled', 'input[name="rank_category"]', function () {
        $('.sub_filter input[type="radio"]:not(input[name="rank_category"]), .sub_filter input[type="checkbox"]').iCheck('disable').iCheck('uncheck');
        $(this).closest('.sub_filter').find('input[type="radio"], input[type="checkbox"]').iCheck('enable');
    });
    $('#start_date').on('change', function() {
        var limit = removeComma($(this).find('option:selected').attr('data-limit'));
        var curr_end_val = removeComma($('#end_date option:selected').attr('data-prevent'));
        $('#end_date option').each(function() {
            if (removeComma($(this).attr('data-prevent')) >= limit) {
                $(this).attr('disabled', false);
                if (limit > curr_end_val) {
                    $('#end_date').val($('#end_date option[data-prevent="' + limit + '"]').val());
                }
            } else {
                $(this).attr('disabled', true);
            }
        });
        drawTemplate();
    });
});
</script>
<script>
    $("#pdf").on('click', function() {
        window.open('<?php echo MODULE_URL ?>form_71a_pdf?' + $('#form71a').serialize());
    });
    $("#csv").on('click', function() {
        window.open('<?php echo MODULE_URL ?>form_71a_csv?' + $('#form71a').serialize());
    });
</script>