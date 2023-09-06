<style>
	
</style>
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
    FORM 51-A : Statistic Report
	</div>
	<div class="panel panel-primary br-xs" style = "margin: 2%; padding: 2%">
        <div class = "row">
            <div class = "col-md-2" style = "text-align:right">
                Report Type:
            </div>
            <div class = "col-md-3" >
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('reprt_type')
                    ->setId('reprt_type')
                    ->setList(array('quarterly' => 'Quarterly', 'consolidated' => 'Consolidated', 'yearly' => 'Yearly'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-4" >
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('timeline')
                    ->setId('timeline')
                    ->setList(array('1st Quarter(Jan,Feb,Mar)' => '1st Quarter(Jan,Feb,Mar)', '2nd Quarter(Apr,May,Jun)' => '2nd Quarter(Apr,May,Jun)', '3rd Quarter(Jul,Aug,Sep)' => '3rd Quarter(Jul,Aug,Sep)', '4th Quarter(Oct,Nov,Dec)' => '4th Quarter(Oct,Nov,Dec)'))
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-3">
                <?php
                    echo $ui->formField('dropdown')
                    ->setName('year')
                    ->setId('year')
                    ->setList(array('2018' => '2018', '2017' => '2017', '2016' => '2016','2015' => '2015', '2014' => '2014', '2013' => '2013','2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw($show_input);
                ?>
            </div>
            
        </div>
        <div class="panel panel-primary br-xs">
        Total Code Shared Flights Passenger vs. Total Revenue Outgoing
        <div style="color: #a94442;background-color: #f2dede;border-color: #ebccd1;font-size:20px;text-align:center;">No Existing Data</div>
    </div>
    
    </div>
</div>