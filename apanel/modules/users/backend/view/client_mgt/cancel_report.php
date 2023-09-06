<div class="panel panel-primary br-xs">
    <div class="panel-heading bb-colored text-center">
        Report Cancellation
    </div>
    <div class = "row table-responsive" style = "margin: 3% 0% 0% 0%">
        <center><span style = "font-weight:bold; color:red">Are you sure you want to cancel this report?</span></center>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <button type = "submit" id = "submit" class="btn btn-primary">Yes</button>
			<a href="<?=MODULE_URL?>" class="btn btn-default" data-toggle = "back_page">No</a>
        </div>
    </div>
</div>
<script>
    var ajax = {}
	ajax.client_id = '<?php echo $client_id ?>';
	ajax.db_table = '<?php echo $db_table ?>';
	ajax.id = '<?php echo $id ?>';
    
    $('#submit').click(function() {
		$.post('<?=MODULE_URL?>ajax/ajax_cancel_report', ajax, function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
</script>