<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		LIST OF LATE SUBMITTED REPORTS

	</div>

    <div class="panel panel-info br-xs" id = "filter_list">

        <div class="panel-heading bb-colored text-center">

            FILTER LIST

        </div>

        <div class = "row">

            <div class = "col-md-1">

                

            </div>

			<div class = "col-md-2" style = "padding-top:1%">

                <?php

                    echo $ui->formField('dropdown')

                    ->setName('form')

                    ->setId('form')

                    ->setList($reports)

				   ->setPlaceholder('All Reports')

                    ->draw($show_input);

                ?>

            </div>

			<!-- <div class = "col-md-2" style = "padding-top:1%">

                <?php

                //     echo $ui->formField('dropdown')

                //     ->setName('code')

                //     ->setId('code')

                //     ->setList($code)

				//    ->setNone('All Client Code')

                //     ->draw($show_input);

                ?>

            </div> -->

			<div class = "col-md-2" style = "padding-top:1%"> 

                <?php

                    echo $ui->formField('dropdown')

                    ->setName('name')

                    ->setId('name')

                    ->setList($name)

				   ->setPlaceholder('All Client Name')

                    ->draw($show_input);

                ?>

            </div> 

            <div class = "col-md-2" style = "padding-top:1%" id="not51">

                <?php

                    echo $ui->formField('dropdown')

                    ->setList(array('1' => 'January', '2' => 'February', '3' => 'March','4' => 'April','5' => 'May','6' => 'June','7' => 'July','8' => 'August','9' => 'September','10' => 'October','11' => 'November','12' => 'December'))

                    ->setName('month')

                    ->setId('month')

				   ->setPlaceholder('All Months')

                    ->draw($show_input);

                ?>

            </div>

			<!-- <div class = "col-md-2 hidden" style = "padding-top:1%" id="form51">

                <?php

                //    echo $ui->formField('dropdown')

				//    ->setList(array('1' => '1st Quarter', '2' => '2nd Quarter', '3' => '3rd Quarter', '4' => '4th Quarter'))

				//    ->setNone('All Quarter')

				//    ->setName('month')

				//    ->setId('month')

				//    ->draw($show_input);

                ?>

            </div> -->

            <div class = "col-md-2" style = "padding-top:1%; padding-left: 0%">

                <?php

                    for($i=2010;$i<=date('Y');$i++)
		    {
    			$years[$i] = $i;
		    }

                echo $ui->formField('dropdown')

				->setList($years)

				->setName('year')
                		->setId('year')
               			->draw($show_input);
                ?>

            </div>

			<!-- <div class="row"> -->

			<div class = "col-md-2" style = "padding-top:1%; padding-bottom: 1%">

                <button type = "button" id= "submit" class = "btn btn-primary btn-sm">View Result</button>

            </div>

			<!-- </div> -->

        </div>

    </div>

	<div class="box-body table-responsive no-padding">

		<table border = "1" id="list" class="table table-hover table-sidepad">

			<?php

				echo $ui->loadElement('table')

						->setHeaderClass('info')

						->addHeader('Report Form', array('class' => 'col-md-1'))

						->addHeader('Client Name', array('class' => 'col-md-2'))

						->addHeader('Report Date', array('class' => 'col-md-1'))

						->addHeader('Submitted By', array('class' => 'col-md-1'))

						->addHeader('Submitted Date', array('class' => 'col-md-1'))

						->addHeader('Approved By', array('class' => 'col-md-1'))

						->addHeader('Approved Date', array('class' => 'col-md-1'))

						->addHeader('', array('class' => 'col-md-1'))

						->draw();

			?>

			

			<tbody>



			</tbody>

			<tfoot>

			<th colspan="7"><div id = "pagination"></div></th>

			<th colspan="3"><b>Result: </b> <span class="result"></span></th>

			</tfoot>

		</table>

	</div>

</div>



<script>

$('#pagination').on('click', 'a', function(e) {

      e.preventDefault();

      ajax.page = $(this).attr('data-page');

      getList();

    });

	var ajax = {}

		ajax.limit = 10;

	var ajax_call = '';

	$('#submit').on('click', function () {

		ajax.page = 1;

		ajax.form = $("#form").val();

		ajax.code = $("#code").val();

		ajax.name = $("#name").val();

		ajax.month = $("#month").val();

		ajax.year = $("#year").val();

		getList();

	});

	function getList() {

		// filterToURL();

		if (ajax_call != '') {

			ajax_call.abort();

		}

		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_late_submitted_report_list', ajax, function(data) {

			console.log(data.table);

			$('#list tbody').html(data.table);

			$('#pagination').html(data.pagination);

			if (ajax.page > data.page_limit && data.page_limit > 0) {

				ajax.page = data.page_limit;

				getList();

			}

			$('#list tfoot .result').html('None');

			if (data.result_count > 0) {

				var min = (ajax.limit * (data.page - 1));

				min = min+1;

				var max = ((ajax.limit * data.page) > data.result_count) ? data.result_count : ajax.limit * data.page;

				$('#list tfoot .result').html(min + ' - ' + max + ' of ' + data.result_count);

			}

		});

	}

	getList();

</script>