<form action="" method="post" id="form51a">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		FORM 51-A : Traffic Flow - Quarterly Report on Scheduled International Services
	</div>
	<div class="panel panel-primary br-xs" style = "margin: 2%; padding: 2%">
        <div class = "row">
            <div class = "col-md-2" style = "text-align:right">
                Report Type:
            </div>
            <div class = "col-md-3" >
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('report_type')
                    ->setId('report_type')
                    ->setList(array('Per Airline' => 'Per Airline','Per RouteSector' => 'Per Route/Sector', 'Per Country' => 'Per Country', 'Historical' => 'Historical'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-2" id = "div_timeline">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('timeline')
                    ->setList(array('Per Year' => 'Per Year','Per Quarter' => 'Per Quarter', 'Per Semester' => 'Per Semester', 'Consolidated' => 'Consolidated'))
                    ->setId('timeline')
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-2" id = "div_quarter">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('quarter')
                    ->setId('quarter')
                    ->setList(array('1' => '1st Quarter (Jan,Feb,Mar)', '2' => '2nd Quarter (Apr,May,Jun)', '3' => '3rd Quarter (Jul,Aug,Sep)', '4' => '4th Quarter (Oct,Nov,Dec)'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-2" id = "div_semester">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('semester')
                    ->setId('semester')
                    ->setList(array('1' => '1st Semester', '2' => '2nd Semester'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-2" id = "div_year">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('year')
                    ->setId('year')
                    ->setList(array('2018' => '2018','2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw($show_input);
                ?>
            </div>
            <div id = "consolidated">
                <div class = "col-md-3" style = "padding:0%">
                    <?php
                        echo $ui->formField('dropdown')
                        ->setLabel('From:')
                        ->setSplit('col-md-3', 'col-md-9')
                        ->setName('start_date_cons')
                        ->setId('start_date_cons')
                        // ->setList(array('Q1 2010' => 'Q1 2010', 'Q2 2010' => 'Q2 2010', 'Q3 2010' => 'Q3 2010', 'Q4 2010' => 'Q4 2010', 'Q1 2011' => 'Q1 2011', 'Q2 2011' => 'Q2 2011', 'Q3 2011' => 'Q3 2011', 'Q4 2011' => 'Q4 2011', 'Q1 2012' => 'Q1 2012', 'Q2 2012' => 'Q2 2012', 'Q3 2012' => 'Q3 2012', 'Q4 2012' => 'Q4 2012', 'Q1 2013' => 'Q1 2013', 'Q2 2013' => 'Q2 2013', 'Q3 2013' => 'Q3 2013', 'Q4 2013' => 'Q4 2013', 'Q1 2014' => 'Q1 2014', 'Q2 2014' => 'Q2 2014', 'Q3 2014' => 'Q3 2014', 'Q4 2014' => 'Q4 2014', 'Q1 2015' => 'Q1 2015', 'Q2 2015' => 'Q2 2015', 'Q3 2015' => 'Q3 2015', 'Q4 2015' => 'Q4 2015', 'Q1 2016' => 'Q1 2016', 'Q2 2016' => 'Q2 2016', 'Q3 2016' => 'Q3 2016', 'Q4 2016' => 'Q4 2016', 'Q1 2017' => 'Q1 2017', 'Q2 2017' => 'Q2 2017', 'Q3 2017' => 'Q3 2017', 'Q4 2017' => 'Q4 2017', 'Q1 2018' => 'Q1 2018', 'Q2 2018' => 'Q2 2018', 'Q3 2018' => 'Q3 2018', 'Q4 2018' => 'Q4 2018'))
                        ->setList(array('1' => '1st Quarter', '2' => '2nd Quarter', '3' => '3rd Quarter', '4' => '4th Quarter'))
                        ->draw($show_input);
                    ?>
                </div>
                <div class = "col-md-2" id = "div_year">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('start_year_cons')
                    ->setId('start_year_cons')
                    ->setList(array('2018' => '2018','2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw($show_input);
                ?>
            </div>
                <div class = "col-md-3 col-md-offset-7" style = "padding:0%">
                    <?php
                        echo $ui->formField('dropdown')
                        ->setLabel('To:')
                        ->setSplit('col-md-3', 'col-md-9')
                        ->setName('end_date_cons')
                        ->setId('end_date_cons')
                        ->setList(array('1' => '1st Quarter', '2' => '2nd Quarter', '3' => '3rd Quarter', '4' => '4th Quarter'))
                        ->draw($show_input);
                    ?>
                </div>
                <div class = "col-md-2" id = "div_year">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('end_year_cons')
                    ->setId('end_year_cons')
                    ->setList(array('2018' => '2018','2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw($show_input);
                ?>
            </div>
            </div>
            <div id = "date_range">
                <div class = "col-md-3" style = "padding:0%">
                    <?php
                        echo $ui->formField('dropdown')
                        ->setLabel('From:')
                        ->setSplit('col-md-4', 'col-md-8')
                        ->setName('start_date')
                        ->setId('start_date')
                        ->setList(array('2007' => '2007', '2008' => '2008', '2009' => '2009', '2010' => '2010', '2011' => '2011', '2012' => '2012', '2013' => '2013', '2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017','2018' => '2018'))
                        ->draw($show_input);
                    ?>
                </div>
                <div class = "col-md-3" style = "padding:0%">
                    <?php
                        echo $ui->formField('dropdown')
                        ->setLabel('To:')
                        ->setSplit('col-md-4', 'col-md-8')
                        ->setName('end_date')
                        ->setId('end_date')
                        ->setList(array('2018' => '2018','2017' => '2017', '2016' => '2016', '2015' => '2015', '2014' => '2014', '2013' => '2013', '2012' => '2012', '2011' => '2011', '2010' => '2010'))
                        ->draw($show_input);
                    ?>
                </div>
            </div>
        </div>
        <div class = "row">
            <div class = "col-md-3"><input type="radio" name="filterby" value="alpha" id="filterby" checked = "checked"> Alphabetical</div>
            <div class = "col-md-2"><input type="radio" name="filterby" value="ranking" id="filterby"> Ranking</div>
            <div class = "col-md-4"><input type="checkbox" name="filterbySubLF" id = "load_factor" value = "load_factor" checked = "checked"> Show Load Factor</div>
        </div>
        <div class = "row" style = "margin-top:1%">
            <div class = "col-md-3"></div>
            <div class = "col-md-2"></div>
            <div class = "col-md-4"><input type="checkbox" name="filterbySubMS" id = "market_share" value = "market_share" checked = "checked"> Show Market Share</div>
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
        $('#div_timeline').show();
        $('#div_year').show();
        $('#date_range').hide();
        $('#consolidated').hide();
        $('#div_quarter').hide();
        $('#div_semester').hide();
        $('#report_type').on('change', function() {
            var report_type = $('#report_type').val();
            if (report_type == 'Historical') {
                $('#div_timeline').hide();
                $('#div_year').hide();
                $('#date_range').show();
            }
            else {
                $('#div_timeline').show();
                $('#div_year').show();
                $('#date_range').hide();
            }
        });

        $('#timeline').on('change', function() {
            var timeline = $('#timeline').val();
            if(timeline == 'Per Year'){
                $('#div_year').show();
                $('#div_quarter').hide();
                $('#div_semester').hide();
                $('#consolidated').hide();
            }
            else if (timeline == 'Consolidated') {
                $('#div_year').hide();
                $('#div_quarter').hide();
                $('#div_semester').hide();
                $('#consolidated').show();
                
            }
            else if(timeline == 'Per Quarter'){
                $('#div_year').show();
                $('#div_quarter').show();
                $('#div_semester').hide();
                $('#consolidated').hide();
            }
            else if(timeline == 'Per Semester'){
                $('#div_year').show();
                $('#div_quarter').hide();
                $('#div_semester').show();
                $('#consolidated').hide();
            }
            else {
                $('#div_timeline').show();
                $('#div_year').show();
                $('#consolidated').hide();
                $('#div_quarter').hide();
            }
        });
    });


</script>
<script>
    $("#pdf").on('click', function() {
        window.open('<?php echo MODULE_URL ?>form_51a_pdf?' + $('#form51a').serialize());
    });
    $("#csv").on('click', function() {
        window.open('<?php echo MODULE_URL ?>form_51a_csv?' + $('#form51a').serialize());
    });
</script>
