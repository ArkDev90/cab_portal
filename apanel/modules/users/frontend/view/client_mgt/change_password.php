<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CHANGE PASSWORD
	</div>
    <div class="col-md-12" style ="padding: 2% 0%; color:red; font-family:verdana; font-size:12px; text-align:center" id="error_message"></div>
    <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
        <?php
            echo $ui->formField('password')
            ->setLabel('Current Password:')
            ->setSplit('col-md-3', 'col-md-4')
            ->setName('current_password')
            ->setId('current_password')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('password')
            ->setLabel('New Password:')
            ->setSplit('col-md-3', 'col-md-4')
            ->setName('password')
            ->setId('password')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row note" style = "padding: 0% 3% 1% 0%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-9" >
            Min of 6 characters; A-Z, 0-9, period and underscore are only accepted.
        </div>
    </div>
    <div id="confirm">
        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">
            <?php
                echo $ui->formField('password')
                ->setLabel('Confirm New Password:')
                ->setSplit('col-md-3', 'col-md-4')
                ->setName('confirm_password')
                ->setId('confirm_password')
                ->draw($show_input);
            ?>
        </div>
    </div>
    <div class="row">
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-3 text-left has-error" id="pass_errmsg"></div>
	</div>
    <!-- <div class = "row" style = "padding: 1% 3% 1% 3%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-7 reminder">
            <center>Answer the question below for your protection.</center><br>
            <div class = "col-md-12" style = "text-align:center; font-weight:normal; font-family: arial; font-size: 9pt; color: #005CB9;">
                Who was your childhood hero?
            </div>
            <div class = "col-md-3">
            </div>
            <div class = "col-md-6">
                <?php
                    echo $ui->formField('password')
                    ->setName('answer')
                    ->setId('answer')
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-3">
            </div>
            <div class = "col-md-12" style = "text-align:center; font-weight:normal; font-family: arial; font-size: 9pt; color: #005CB9;">
                Your Birthday (YYYY-MM-DD)
            </div>
            <div class = "col-md-3">
            </div>
            <div class = "col-md-6">
                <?php
                    echo $ui->formField('text')
                    ->setName('birthday')
                    ->setId('birthday')
                    ->draw($show_input);
                ?>
            </div>
            <div class = "col-md-3">
            </div>
        </div>
    </div> -->
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
			<a href="<?=MODULE_URL?>" class="btn btn-sm btn-default">CANCEL</a>
			<button type = "submit" class="btn btn-sm btn-primary">SAVE</button>
        </div>
    </div>
</div>
</form>
<?php if ($show_input): ?>
<script>
    $('#confirm_password').change(function(){
        if($("#password").val() == $("#confirm_password").val()){
            $('#pass_errmsg').html("");
            $('#confirm').removeClass('has-error');
            $("button[type = 'submit'").attr('disabled', false);
        }else{
            $('#pass_errmsg').html("<h5><span class=\"help-block small\" style =\"color:red; font-family:verdana; font-size:9px\">&nbsp;Password did not matched!</span></h5>");
            $('#confirm_password').val("");
            $('#confirm').addClass('has-error');
            $("button[type = 'submit'").attr('disabled', true);
        }
    });

    $('form').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '<?=$ajax_post?>', function(data) {
				if (data.success) {
					//window.location = data.redirect;
                    $('#current_password').val("");
                    //$('#answer').val("");
                    $('#password').val("");
                    $('#confirm_password').val("");
                    //$('#birthday').val("");
                    $('#error_message').html(data.message);
				}
                else {
                    $('#current_password').val("");
                    //$('#answer').val("");
                    $('#password').val("");
                    $('#confirm_password').val("");
                    //$('#birthday').val("");
                    $('#error_message').html(data.message);
                }
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>
<?php endif ?>