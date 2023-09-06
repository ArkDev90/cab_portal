<form action="" method="post">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE USER INFORMATION
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
                ->setValidation('required')
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-3" >
            <?php
                echo $ui->formField('text')
                ->setName('fname')
                ->setId('fname')
                ->setValidation('required')
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-3">
            <?php
                echo $ui->formField('text')
                ->setName('mname')
                ->setId('mname')
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
            ->setLabel('Email:')
            ->setSplit('col-md-3', 'col-md-9')
            ->setName('email')
            ->setId('email')
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row note" style = "padding: 0% 3% 0% 0%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-9" >
            Use comma "," for multiple email address.
        </div>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('dropdown')
            ->setLabel('User Level:')
            ->setSplit('col-md-3', 'col-md-3')
            ->setName('user_type')
            ->setId('user_type')
            ->setNone('Select User Level')
            ->setList($user_type)
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row" style = "padding: 1% 3% 0% 0%">
        <div class = "col-md-3" style = "text-align:right; font-weight:bold">
            Nature of Operation :
        </div>
        <div class = "col-md-5" style = "line-height:2em">
            <div class="col-md-12 box-body table-responsive" style = "padding: 2% 0% 0% 0%">
            <table id="client_nature_list" class="table table-sidepad" style = "border:0px solid white">
                <tbody>
                    
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('User Name:')
            ->setSplit('col-md-3', 'col-md-3')
            ->setName('username')
            ->setId('username')
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('password')
            ->setLabel('Password:')
            ->setSplit('col-md-3', 'col-md-3')
            ->setName('password')
            ->setId('password')
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
	<div id="confirm">
        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
            <?php
                echo $ui->formField('password')
                ->setLabel('Confirm Password:')
                ->setSplit('col-md-3', 'col-md-3')
                ->setName('confirm_pw')
                ->setId('confirm_pw')
                ->setValidation('required')
                ->draw($show_input); 
                
                echo $ui->formField('hidden')
                    ->setName('client_id')
                    ->setValue($client_id)
                    ->draw();
            ?>
        </div>
    </div>
    <div class="row">
		<div class="col-md-3">&nbsp;</div>
		<div class="col-md-3 text-left has-error" id="pass_errmsg"></div>
	</div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <a href="<?=MODULE_URL?>client_user_list/<?php echo $client_id ?>" class="btn btn-sm btn-default">CANCEL</a>
            <button type = "submit" class = "btn btn-sm btn-primary">ADD</button>
        </div>
    </div>
</div>
</form>
<?php if ($show_input): ?>
<script>  
    var ajax = {}
    ajax.client_id = '<?= $client_id ?>';
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_client_nature_list', ajax, function(data) {
			$('#client_nature_list tbody').html(data.table);
			$('#pagination').html(data.pagination);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
    getList();

    var ajax_call2 = '';
	$('#username').on('input', function() {
		if (ajax_call2 != '') {
			ajax_call2.abort();
		}
		var username = $(this).val();
		$('#username').closest('form').find('[type="submit"]').addClass('disabled');
		ajax_call2 = $.post('<?=MODULE_URL?>ajax/ajax_check_user_uname', 'username=' + username + '<?=$ajax_post?>', function(data) {
			var error_message = 'Username Already Exists';
			if (data.available) {
				var form_group = $('#username').closest('.form-group');
				if (form_group.find('p.help-block').html() == error_message) {
					form_group.removeClass('has-error').find('p.help-block').html('');
				}
			} else {
				$('#username').closest('.form-group').addClass('has-error').find('p.help-block').html(error_message);
			}
			$('#username').closest('form').find('[type="submit"]').removeClass('disabled');
		});
    });

    $(document).ready(function(){
        $('#confirm_pw').change(function(){
            if($("#password").val() == $("#confirm_pw").val()){
                $('#pass_errmsg').html("");
                $('#confirm').removeClass('has-error');
                $("button[type = 'submit'").attr('disabled', false);
            }else{
            $('#pass_errmsg').html("<h5><span class=\"help-block small\" style =\"color:red; font-family:verdana; font-size:9px\">&nbsp;Password did not matched!</span></h5>");
                $('#confirm_pw').val("");
                $('#confirm').addClass('has-error');
                $("button[type = 'submit'").attr('disabled', true);
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