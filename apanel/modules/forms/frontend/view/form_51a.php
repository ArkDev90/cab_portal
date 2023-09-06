<style>
	td {
		font-size: 10px !important;
	}
	td a {
		color:black;
	}
	td a:hover {
		color:#003366;
		text-decoration:underline;
	}
	th {
		font-size: 10px !important;
		text-align:center;
	}
    .nav_link {
        text-align:center;
        padding:2%;
    }
    .nav_link a {
        font-weight: normal;
        text-align:center;
        font-size:9px;
        color:black;
    }
    .nav_link a:hover {
        color:#003366;
        text-decoration:underline;
    }
    .apanel_deco_title_header {
        border-left-width: 1px;
        border-right-width: 1px;
        border-top-width: 1px;
        border-bottom: 3px dotted #005CB9;
        font-family: arial;
        font-size: 10pt;
        color: #005CB9;
        font-weight: 600;
        text-align:center;
        margin-top: 4%;
        margin-left: 30%;
        margin-right: 30%;
    }


</style>
<div class="panel panel-primary br-xs" style="width: 98%;">
	<div class="panel-heading bb-colored text-center">
    FORM 51-A : Traffic Flow - Quarterly Report on Scheduled International Services
	</div><br>
    <div class = "row" style = "padding: 1% 0% 0% 0%">
        <div class = "col-md-offset-8 col-md-3">
         <a href="<?php echo BASE_URL. 'form_51_a/draft/'?>" style="color: blue;">View DRAFT Reports</a>
        </div>
    </div>
    <form method="POST" id="form">
    <input type="text" name="client_id" hidden>
    <div class = "row" style = "padding: 1% 0% 0% 0%">
        <div class = "col-md-offset-4 col-md-3">
            <?php
                echo $ui->formField('dropdown')
                ->setLabel('<font color="#FE0853"><b>*</b></font> Report Quarter : ')
                ->setList(array('quarter_1' => '1st Quarter(Jan,Feb,Mar)', 'quarter_2' => '2nd Quarter(Apr,May,Jun)', 'quarter_3' => '3rd Quarter(Jul,Aug,Sep)', 'quarter_4' => '4th Quarter(Oct,Nov,Dec)'))
                ->setName('report_quarter')
                ->setId('report_quarter')
                ->draw();
            ?>
        </div>
    </div>
    <div class = "row" style = "padding: 1% 0% 0% 0%">
        <div class = "col-md-3 col-md-offset-4">
        <?php
                    echo $ui->formField('dropdown')
                    ->setLabel('<font color="#FE0853"><b>*</b></font> Year: ')
                    ->setName('year')
                    ->setId('year')
                    ->setList(array('2018' => '2018', '2017' => '2017', '2016' => '2016','2015' => '2015', '2014' => '2014', '2013' => '2013','2012' => '2012', '2011' => '2011', '2010' => '2010'))
                    ->draw();
                ?>
        </div>
    </div>
    <div class = "row" style = "padding: 1% 0% 0% 0%" align="center">
    <div class = "col-md-3 col-md-offset-4">
   <input type="submit" class="btn btn-sm btn-primary" value="Confirm and Proceed">
   </form>
   <!-- <a href="<?php echo BASE_URL ?>form_51_a/create/" class="btn btn-sm btn-primary">Confirm and Proceed</a> -->
    </div>
</div><div class="row">&nbsp;</div>

</div>

<div class="panel panel-primary br-xs" style="width: 98%;">
	<div class="panel-heading bb-colored text-center">
    HISTORY LISTING
	</div><br>

    <div class="box-body table-responsive no-padding">
		<table border = "1" id="list"class="table table-hover table-sidepad" style="width: 80%;" align="center">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('No.', array('class' => 'col-md-2'))
						->addHeader('Report Quarter ', array('class' => 'col-md-2'))
						->addHeader('Year', array('class' => 'col-md-2'))
						->addHeader('Date Created ', array('class' => 'col-md-2'))
						->addHeader('Created By ', array('class' => 'col-md-2'))
						->addHeader('Status', array('class' => 'col-md-2'))
						->draw();
			?>
			
			<tbody>

			</tbody>
		</table><br>
	</div>
</div>

<script>
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_list', ajax, function(data) {
			$('#list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();

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