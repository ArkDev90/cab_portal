<form action="" method="post" id = "form71c">
<div class="panel panel-primary br-xs" id="filters">
	<div class="panel-heading bb-colored text-center">
    FORM 71-C : Cargo Sales Agency Report
	</div>
    <div class = "row">
	<div class="panel panel-primary br-xs col-md-8" style = "margin: 2% 0% 2% 3%; padding: 2%">
        <div class = "row">
            <div class = "col-md-1" style = "text-align:left; padding:0% 10% 0% 1%">
                Report Type:
            </div>
            <div class = "col-md-2" style = "padding:0% 1% 0% 0%">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('report_type')
                    ->setId('report_type')
                    ->setList(array('Quarterly' => 'Quarterly','Consolidated' => 'Consolidated', 'Yearly' => 'Yearly'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-4" id = "div_quarter" style = "padding:0% 2% 0% 1%">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('quarter')
                    ->setList(array('1st Quarter' => '1st Quarter (Jan, Feb, March)', '2nd Quarter' => '2nd Quarter (Apr, May, Jun)', '3rd Quarter' => '3rd Quarter (Jul, Aug, Sep)', '4th Quarter' => '4th Quarter (Oct, Nov, Dec)'))
                    ->setId('quarter')
                    ->draw($show_input);
                ?>
            </div>
            <div id = "date_range">
            <div class = "col-md-1" style = "text-align:left; padding:0% 2% 0% 1%">
                From:
            </div>
            <div class = "col-md-2" style = "padding:0% 1% 0% 0%">
                <select name = "start_date" id = "start_date">
                    <option value = "1st Quarter" data-limit="1">1st Quarter</option>
                    <option value = "2nd Quarter" data-limit="2">2nd Quarter</option>
                    <option value = "3rd Quarter" data-limit="3">3rd Quarter</option>
                    <option value = "4th Quarter" data-limit="4">4th Quarter</option>
                </select>
            </div>
            <div class = "col-md-1" style = "text-align:left; padding:0% 2% 0% 1%">
                To:
            </div>
            <div class = "col-md-2" style = "padding:0% 1% 0% 0%">
                <select name = "end_date" id = "end_date">
                    <option value = "1st Quarter" data-prevent="1">1st Quarter</option>
                    <option value = "2nd Quarter" data-prevent="2">2nd Quarter</option>
                    <option value = "3rd Quarter" data-prevent="3">3rd Quarter</option>
                    <option value = "4th Quarter" data-prevent="4">4th Quarter</option>
                </select> 
            </div>
        </div>
            <div class = "col-md-2" id = "div_year" style = "padding:0% 2% 0% 1%">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('year')
                    ->setId('year')
                    ->setList(array('2018' => '2018', '2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw($show_input);
                ?>
            </div>
        </div>
        <div class = "row" style = "padding:2% 0% 0% 0%">
            <div class = "col-md-6 filter_col">
                <input type = "radio" name = "category" value = "summaryreport" checked = "checked"> Summary Report
                <div class = "col-md-12" style = "padding: 2% 0% 0% 5%">
                    <input type = "radio" name = "filterBy" value = "Ranking"> Ranking <br>
                    <input type = "radio" name = "filterBy" value = "Alphabetical"> Alphabetical  
                </div>
               
            </div>
           
        </div>
    </div>
    <div class="panel panel-primary br-xs col-md-3" style = "margin: 2% 2% 2% 2%; padding: 3%">
        <div class = "row filter_col">
            <div id = "h_date_range">
                <div class = "col-md-12" style = "text-align:left; padding:0% 1% 0% 1%">
                <input type = "radio" name = "category" value = "byCountry"> By Country
                </div>
                <div class = "col-md-12" style = "padding: 2% 0% 0% 5%">
                <input type = "radio" name = "c_filter" value = "Ranking"> Ranking <br>
                <input type = "radio" name = "c_filter" value = "Alphabetical"> Alphabetical  
            </div>
                
            </div>
        </div>
      
    </div>
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
        window.open('<?php echo MODULE_URL ?>form_71c_pdf?' + $('#form71c').serialize());
    });
    $("#csv").on('click', function() {
        window.open('<?php echo MODULE_URL ?>form_71c_csv?' + $('#form71c').serialize());
    });
</script>