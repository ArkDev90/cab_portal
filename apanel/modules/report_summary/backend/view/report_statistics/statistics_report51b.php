<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
    FORM 51-B : Statistic Report
	</div>
	<div class="panel panel-primary br-xs" style = "margin: 2%; padding: 2%">
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
                    <?php
                        echo $ui->formField('dropdown')
                        ->setName('start_date')
                        ->setId('start_date')
                        ->setList(array('1st Quarter' => '1st Quarter', '2nd Quarter' => '2nd Quarter', '3rd Quarter' => '3rd Quarter', '4th Quarter' => '4th Quarter'))
                        ->draw($show_input);
                    ?>
                </div>
                <div class = "col-md-1" style = "text-align:left; padding:0% 2% 0% 1%">
                    To:
                </div>
                <div class = "col-md-2" style = "padding:0% 1% 0% 0%">
                    <?php
                        echo $ui->formField('dropdown')
                        ->setName('end_date')
                        ->setId('end_date')
                        ->setList(array('1st Quarter' => '1st Quarter', '2nd Quarter' => '2nd Quarter', '3rd Quarter' => '3rd Quarter', '4th Quarter' => '4th Quarter'))
                        ->draw($show_input);
                    ?>
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
        <div class="panel panel-primary br-xs" style = "margin:2% 0% 0% 0%">
            Total Cargo Flow Incoming vs. Total Cargo Flow Outgoing 
            <!-- <div style="color: #a94442;background-color: #f2dede;border-color: #ebccd1;font-size:20px;text-align:center;">No Existing Data</div> -->
        </div>
    </div>
</div>
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
        $('#filters').on('ifToggled', 'input[name="fdgf"]', function () {
            $('#filters input[type="radio"], #filters input[type="checkbox"]').iCheck('disable').iCheck('uncheck');
            $('#filters input[name="fdgf"]').iCheck('enable');
            $(this).closest('.filter_col').find('input[type="radio"], input[type="checkbox"]').iCheck('enable');
        });
    });
</script>