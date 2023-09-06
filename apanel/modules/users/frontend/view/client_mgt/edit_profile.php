<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		PERSONAL INFORMATION
	</div>
    <div class = "row" style = "padding: 3% 3% 0% 0%">
        <div class = "col-md-3" style = "text-align:right">
            Member Name:
        </div>
        <div class = "col-md-3" >
            <?php
                echo $ui->formField('text')
                ->setName('lname')
                ->setId('lname')
                ->setValue($lname)
                ->setValidation('required')
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-3" >
            <?php
                echo $ui->formField('text')
                ->setName('fname')
                ->setId('fname')
                ->setValue($fname)
                ->setValidation('required')
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-3">
            <?php
                echo $ui->formField('text')
                ->setName('mname')
                ->setId('mname')
                ->setValue($mname)
                ->draw($show_input);
            ?>
        </div>
    </div>
    <div class = "row note" style = "padding: 0% 3% 0% 0%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-3" >
            Last Name
        </div>
        <div class = "col-md-3" >
            First Name
        </div>
        <div class = "col-md-3">
            Middle Name
        </div>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Address:')
            ->setSplit('col-md-3', 'col-md-9')
            ->setName('address')
            ->setId('address')
            ->setValue($address)
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('dropdown')
            ->setLabel('Country:')
            ->setSplit('col-md-3', 'col-md-3')
            ->setName('country')
            ->setId('country')
            ->setValue($country)
            ->setList($countries)
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Email:')
            ->setSplit('col-md-3', 'col-md-9')
            ->setName('email')
            ->setId('email')
            ->setValue($email)
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row note" style = "padding: 0% 3% 0% 0%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-9" >
            Use backslash "/" for multiple email address.
        </div>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Contact No:')
            ->setSplit('col-md-3', 'col-md-9')
            ->setName('contact')
            ->setId('contact')
            ->setValue($contact)
            ->setAttribute(array('onkeypress' => 'validate(event)'))
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row note" style = "padding: 0% 3% 0% 0%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-9" >
            Use backslash "/" for multiple contact numbers.
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <?php echo $ui->drawSubmit($show_input); ?>
			<a href="<?=MODULE_URL?>account_info/<?php echo $id ?>" class="btn btn-default">Cancel</a>
        </div>
    </div>
</div>
</form>
<?php if ($show_input): ?>
<script>
$(document).ready(function () {
  //called when key is pressed in textbox
  $("#contact").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 47 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});

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