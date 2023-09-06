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
    .errmsg {
    font-family: arial;
    font-size: 8pt;
    color: #D60707;
    font-weight: 500;
}
</style>
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		REPORT CONTROLLER
	</div>
    <div class = "row nav_link errmsg" id = "assign">
        Assign at least 1 report for this air type.
    </div>
   <br>
	<br><div class="box-body table-responsive no-padding">
	<div class="col-md-12">
	<div class="col-md-12">
	<input name="save" value="SAVE" style="width:100px;border-radius: 0px;float:right;" class="btn btn-xs btn-default save" type="submit">
	<input name="confirm" value="CONFIRM" style="width:100px;border-radius: 0px;float:right;margin-left:5px" class="btn btn-xs btn-default confirm" type="submit">
	<input name="back" value="BACK" style="width:100px;border-radius: 0px;float:right;" class="btn btn-xs btn-default back" type="submit">
	<br><br>
		<table border = "1" id="report" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader($title, array('class' => 'col-md-8'))
						->draw();
			
			?>

			<tbody id="tbody">

			</tbody>
		</table>
		<table border = "1" id="report_confirm" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader($title, array('class' => 'col-md-8'))
						->draw();
			?>
			
			<tbody id="report_form">

			</tbody>
			
		</table>

		
		<input name="save" value="SAVE" style="width:100px;border-radius: 0px;float:right;" class="btn btn-xs btn-default save" type="submit">
		<input name="confirm" value="CONFIRM" style="width:100px;border-radius: 0px;float:right;margin-left:5px" class="btn btn-xs btn-default confirm" type="submit">
		<input name="back" value="BACK" style="width:100px;border-radius: 0px;float:right;" class="btn btn-xs btn-default back" type="submit">
		<br><br>
		</div>
		</div>
	</div>
</div>
<script>
	
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_operation_list', ajax + '&id=' + <?= $id ?>, function(data) {
			$('#report tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();

	$(document).ready(function(){
		$("#report_form").attr('hidden', true);
		$('#report_confirm').attr('hidden', true);
		$(".confirm").hide();
		$(".back").hide();
	});

	$('#report').on('ifToggled', 'input[type="checkbox"]', function() {
		var b = $('input[type=checkbox]');
		if(b.filter(':checked').length > 0){
			$('.save').prop('disabled',false)
		} else{
			$('.save').prop('disabled',true)		
		}
		report = [];
		$('#report tbody input[type="checkbox"]').each(function(index, value) {
			if($(this).is(':checked')) {
				report.push($(this).closest('tr').find('#reports').val());
			}
		});
	});

	// $('#report').on('ifChecked', 'input[type="checkbox"]', function() {
		
	// });

	$(".back").click(function(e){
		e.preventDefault();
		$("#tbody").attr('hidden', false);
		$("#report").attr('hidden', false);
		$('#report_confirm').attr('hidden', true);
		$(".confirm").hide();
		$(".save").show();
		$(".back").hide();
		$('#report_form').empty();

	});

	$(".save").click(function(e){
		e.preventDefault();
		$("#tbody").attr('hidden', true);
		$("#report").attr('hidden', true);
		$('#report_confirm').attr('hidden', false);
		$(".confirm").show();
		$(".save").hide();
		$(".back").show();

		$("#report_form").attr('hidden', false);
		if (report === '') {
			$("#report_form").html('No checked');
            }
            else {
                // report.forEach(function(index,value) {
					
			$('#report tbody input[type="checkbox"]').each(function() {
				if ($(this).is(':checked')) {
					var title = $(this).closest('tr').html();
					$("#report_form").append('<tr>'+title+'</tr>');
				}
		});
                // });
            }
	});
	$(".confirm").click(function(e){
	$.post('<?=MODULE_URL?>ajax/ajax_save', '&report=' + report + '&id=' + <?= $id ?>, function(data) {
		if (data.success) {
			window.location = data.redirect;
		}
	});

	});


</script>

