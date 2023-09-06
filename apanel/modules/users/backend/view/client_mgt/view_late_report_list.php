<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		LIST OF REPORTS <br>

        <?php 

    if($db_table == 'form51a'){echo 'FORM 51-A: Traffic Flow - Quarterly Report On Scheduled International Services';}

    else if($db_table == 'form51b'){echo 'FORM 51-B: Monthly International Cargo Traffic Flow';}

    else if($db_table == 'form61a'){echo 'FORM 61-A: Monthly Statement of Traffic and Operating Statistics (Agricultural Aviation)';}

    else if($db_table == 'form61b'){echo 'FORM 61-B: Monthly Statement of Traffic and Operating Statistics';}

    else if($db_table == 'form71a'){echo 'FORM 71-A: International Airfreight Forwarder Cargo Production Report';}

    else if($db_table == 'form71b'){echo 'FORM 71-B: Domestic Airfreight Forwarder Cargo Production Report';}

    else if($db_table == 'form71c'){echo 'FORM 71-C: Cargo Sales Agency Report';}

    else if($db_table == 'formt1a'){echo 'FORM T1-A: Domestic Sector Load Report';}

    ?>

    </div>

    <?php $this->load('client_mgt/client_info_header', $data, false) ?>

    <div class = "row" style = "padding: 1% 7% 0% 0%">

        <div class = "col-md-7">



        </div>

		<div class = "col-md-2" style = "padding: 1%">

            <?php

			if($db_table == 'form51a'){

				echo $ui->formField('dropdown')

                ->setList(array('1' => '1st Quarter', '2' => '2nd Quarter', '3' => '3rd Quarter', '4' => '4th Quarter'))

				->setNone('All Quarter')

                ->setName('month')

                ->setId('month')

                ->draw($show_input);

			}else{

				echo $ui->formField('dropdown')

                ->setList(array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', 

								'6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', 

								'11' => 'November', '12' => 'December'))

				->setNone('All Months')

                ->setName('month')

                ->setId('month')

                ->draw($show_input);

			}

                

            ?>

        </div>

        <div class = "col-md-2" style = "padding: 1%">

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

        <div class = "col-md-1" style = "padding: 1%">

            <button type = "submit" id = "submit" class = "btn btn-sm btn-default">SEARCH</button>

        </div>

    </div>

    <div class="box-body table-responsive no-padding">

		<table border = "1" id="list" class="table table-hover table-sidepad">

			<?php

				echo $ui->loadElement('table')

						->setHeaderClass('info')

						->addHeader('Report Quarter', array('class' => 'col-md-2'))

						->addHeader('Submitted By', array('class' => 'col-md-2'))

						->addHeader('Submitted Date', array('class' => 'col-md-2'))

						->addHeader('Approved By', array('class' => 'col-md-2'))

						->addHeader('Approved Date', array('class' => 'col-md-2'))

						->addHeader('Status', array('class' => 'col-md-2'))

						->draw();

			?>

			

			<tbody>



			</tbody>

			<tfoot>

				<tr class="info">

					<td colspan="4" id="pagination"></td>

					<td colspan="2" class="text-center"><b>Result: </b> <span class="result"></span></td>

				</tr>

			</tfoot>

		</table>

	</div>

</div>



<script>

	var ajax = {}

	ajax.limit = 10;

	ajax.client_id = '<?php echo $client_id ?>';

	ajax.db_table = '<?php echo $db_table ?>';

	var ajax_call = '';

	$('#submit').on('click', function () {

		ajax.page = 1;

		ajax.month = $("#month").val();

		ajax.year = $("#year").val();

		getList();

	});

	$('#pagination').on('click', 'a', function(e) {

      e.preventDefault();

      ajax.page = $(this).attr('data-page');

      getList();

    });

	function getList() {

		// filterToURL();

		if (ajax_call != '') {

			ajax_call.abort();

		}

		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_view_late_report_list', ajax, function(data) {

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



	tableSort('#list', function(value) {

		ajax.sort = value;

		ajax.page = 1;

		getList();

	});

</script>