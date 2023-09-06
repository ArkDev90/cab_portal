<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : REPORTS / FORMS
	</div>
	<div class="row">&nbsp;</div>
	<div class="row">
    <div class = "font-normal">
        <?php
			echo $ui->formField('text')
			->setLabel('Start Date of Report:')
			->setSplit('col-md-4', 'col-md-5')
			->setClass('datepicker-input')
			->setAttribute(array('readonly' => ''))
			->setAddon('calendar')
			->setName('start_date')
			->setId('start_date')
			->setValue($start_date)
			->draw($show_input);
		?>
        <div class = "col-md-2" style = "color:red">
            yyyy-mm-dd
        </div>
    </div>
	</div>
	<div class="row">
    <div class = "font-normal">
        <?php
			echo $ui->formField('text')
			->setLabel('Length of Expiration:')
			->setSplit('col-md-4', 'col-md-2')
			->setName('expiration_days')
			->setId('expiration_days')
            ->setValue($expiration_days)
			->draw($show_input);
		?>
        <div class = "col-md-1" style="margin: 4px 0px 0px 0px;">
            <b>days</b>
        </div>
        <div class = "col-md-2">
            <?php
                echo $ui->formField('text')
                ->setName('expiration_months')
                ->setId('expiration_months')
                ->setValue($expiration_months)
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-1" style="margin: 4px 0px 0px 0px;">
            <b>months</b>
        </div>
    </div>
	</div>
	<div class="row">
    <div class = "font-normal">
        <?php
			echo $ui->formField('text')
			->setLabel('Report Name:')
			->setSplit('col-md-4', 'col-md-5')
			->setName('title')
			->setId('title')
            ->setValue($title)
			->draw($show_input);
		?>
    </div>
	</div>
	<div class="row">
    <div class = "font-normal">
        <?php
			echo $ui->formField('text')
			->setLabel('Revise Code:')
			->setSplit('col-md-4', 'col-md-5')
			->setName('code')
			->setId('code')
            ->setValue($code)
			->draw($show_input);
		?>
    </div>
	</div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <?php echo $ui->drawSubmit($show_input); ?>
			<a href="<?=MODULE_URL?>" class="btn btn-default">Cancel</a>
        </div>
    </div>
</div>
</form>
<?php if ($show_input): ?>
<script>
	$('form').submit(function(e) {
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
<?php endif ?>