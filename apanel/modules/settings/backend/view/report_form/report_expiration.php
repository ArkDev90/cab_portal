<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : NO. of DAYS EXPIRATION OF REPORT
	</div>
    <form method="POST" id="form">
    <div class = "row font-normal" style = "padding: 3% 5% 0% 0%">
        <?php
			echo $ui->formField('text')
			->setLabel('No of Days for Daily Report :')
			->setSplit('col-md-6', 'col-md-2')
			->setName('days')
			->setId('days')
			->draw($show_input);
		?>
        <div class = "col-md-1" style="margin: 0px 0px 0px 0px;">
            <b>days</b>
        </div>
    </div>
    <div class = "row font-normal" style = "padding: 1% 5% 0% 0%">
        <?php
			echo $ui->formField('text')
			->setLabel('No of Months for Annual Report :')
			->setSplit('col-md-6', 'col-md-2')
			->setName('month')
			->setId('month')
			->draw($show_input);
		?>
        <div class = "col-md-1" style="margin: 0px 0px 0px 0px;">
            <b>months</b>
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
			$.post('<?=MODULE_URL?>ajax/ajax_edit_report_expiration', $(this).serialize(), function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>