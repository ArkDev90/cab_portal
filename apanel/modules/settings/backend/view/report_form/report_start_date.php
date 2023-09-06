<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : START DATE OF REPORT
	</div>
    <form method="POST" id="form">
    <div class = "row font-normal" style = "padding: 3% 5% 0% 0%">
        <?php
			echo $ui->formField('text')
			->setLabel('Starting Report Date :')
            ->setSplit('col-md-6', 'col-md-3')
            ->setClass('datepicker-input')
            ->setAddon('calendar')
			->setName('start_date')
			->setId('start_date')
			->draw($show_input);
		?>
        <div class = "col-md-2" style = "color:red">
            yyyy-mm-dd
        </div> 
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <a href="" data-toggle="back_page"><button type = "button" class = "btn btn-sm btn-default">Cancel</button></a>
            <input type="submit" class = "btn btn-sm btn-primary" value="Save">
        </div>
    </div>
    </form>
</div>
<script>
$('#form').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			$.post('<?=MODULE_URL?>ajax/ajax_edit_startdate', $(this).serialize(), function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>