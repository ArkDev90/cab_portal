<form action="" method="post">
<div id = "create" class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE NEW CLIENT
    </div>
    <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Code:')
            ->setSplit('col-md-3', 'col-md-4')
            ->setName('code')
            ->setId('code')
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Client Name:')
            ->setSplit('col-md-3', 'col-md-9')
            ->setName('name')
            ->setId('name')
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
            ->setValidation('required')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row note" style = "padding: 0% 3% 0% 0%">
        <div class = "col-md-3">
            
        </div>
        <div class = "col-md-9">
            If you would like to send the information to this client, please indicate their email address. <br>
            For multiple email addresses, add comma "," after each email. Maximum of 3 emails.
        </div>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Airline Represented:')
            ->setSplit('col-md-3', 'col-md-9')
            ->setName('airline_represented')
            ->setId('airline_represented')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row">
        <div class = "col-md-9 col-md-offset-3" style = "padding: 3% 0% 0% 1%">
            <b>	Master's Temporary Login Account</b>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12 font-normal" style = "padding: 0% 3% 0% 0%">
            <?php
                echo $ui->formField('text')
                ->setLabel('Username:')
                ->setSplit('col-md-3', 'col-md-4')
                ->setName('temp_username')
                ->setId('temp_username')
                ->setValidation('required')
                ->draw($show_input);
            ?>
        </div>
    </div>
    <div class = "row">
        <div class="col-md-6 col-md-offset-3 box-body table-responsive" style = "padding: 2% 0% 0% 0.5%">
            <table id="operation_list" class="table table-sidepad">
                <?php
                    echo $ui->loadElement('table')
                            ->setHeaderClass('info')
                            ->addHeader('Air Types', array('class' => 'col-md-12', 'style' => 'text-align:center'))
                            ->draw();
                ?>
                
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <button id = "create_btn" type = "button" class = "btn btn-sm btn-default">CREATE</button>
        </div>
    </div>
</div>
<div id = "confirm" class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE NEW CLIENT
    </div>
    <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Code:')
            ->setClass('outline')
            ->setSplit('col-md-4', 'col-md-4')
            ->setName('code_2')
            ->setId('code_2')
            ->draw();
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setClass('outline')
            ->setLabel('Client Name:')
            ->setSplit('col-md-4', 'col-md-8')
            ->setName('name_2')
            ->setId('name_2')
            ->draw();
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setClass('outline')
            ->setLabel('Email:')
            ->setSplit('col-md-4', 'col-md-8')
            ->setName('email_2')
            ->setId('email_2')
            ->draw();
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Airline Represented:')
            ->setClass('outline')
            ->setSplit('col-md-4', 'col-md-8')
            ->setName('airline_represented_2')
            ->setId('airline_represented_2')
            ->draw();
        ?>
    </div>
    <div class = "row">
        <div class = "col-md-8 col-md-offset-4" style = "padding: 0% 0% 0% 1%">
            <b>	Master's Temporary Login Account</b>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12 font-normal" style = "padding: 0% 5% 0% 0%">
            <?php
                echo $ui->formField('text')
                ->setLabel('Username:')
                ->setClass('outline')
                ->setSplit('col-md-4', 'col-md-5')
                ->setName('temp_username_2')
                ->setId('temp_username_2')
                ->draw();
            ?>
        </div>
    </div>
    <div class = "row">
        <div class="col-md-6 col-md-offset-4 box-body table-responsive" style = "padding: 2% 0% 0% 0.5%">
            <table id="op_list" class="table table-sidepad">
                <?php
                    echo $ui->loadElement('table')
                            ->setHeaderClass('info')
                            ->addHeader('Air Types', array('class' => 'col-md-12', 'style' => 'text-align:center'))
                            ->draw();
                ?>
                
                <tbody id = "checked">

                </tbody>
            </table>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <button type = "button" id = "back" class = "btn btn-sm btn-default">BACK</button>
            <input id = "submit" type = "submit" class = "btn btn-sm btn-primary" value = "CONFIRM">
        </div>
    </div>
</div>
</form>
<script>
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_operation_list', ajax, function(data) {
			$('#operation_list tbody').html(data.table);
			$('#pagination').html(data.pagination);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
    getList();
    
    var ajax_call2 = '';
	$('#code').on('input', function() {
		if (ajax_call2 != '') {
			ajax_call2.abort();
		}
			var code = $(this).val();
			$('#code').closest('form').find('[type="submit"]').addClass('disabled');
		ajax_call2 = $.post('<?=MODULE_URL?>ajax/ajax_check_code', 'code=' + code + '<?=$ajax_post?>', function(data) {
			var error_message = 'Code Already Exists';
			if (data.available) {
				var form_group = $('#code').closest('.form-group');
				if (form_group.find('p.help-block').html() == error_message) {
					form_group.removeClass('has-error').find('p.help-block').html('');
				}
			} else {
				$('#code').closest('.form-group').addClass('has-error').find('p.help-block').html(error_message);
			}
			$('#code').closest('form').find('[type="submit"]').removeClass('disabled');
		});
    });

    var ajax_call3 = '';
	$('#temp_username').on('input', function() {
		if (ajax_call3 != '') {
			ajax_call3.abort();
		}
		var temp_username = $(this).val();
		$('#temp_username').closest('form').find('[type="submit"]').addClass('disabled');
		ajax_call3 = $.post('<?=MODULE_URL?>ajax/ajax_check_temp_username', 'temp_username=' + temp_username + '<?=$ajax_post?>', function(data) {
			var error_message = 'Master Username Already Exists';
			if (data.available) {
				var form_group = $('#temp_username').closest('.form-group');
				if (form_group.find('p.help-block').html() == error_message) {
					form_group.removeClass('has-error').find('p.help-block').html('');
				}
			} else {
				$('#temp_username').closest('.form-group').addClass('has-error').find('p.help-block').html(error_message);
			}
			$('#temp_username').closest('form').find('[type="submit"]').removeClass('disabled');
		});
    });
</script>
<script>
    var air = [];
    $( document ).ready(function() {
       $('#confirm').hide();
       
       $('#create_btn').click(function() {
            var form_element = $(this).closest('form');
            form_element.closest('form').find('.form-group').find('input, textarea, select').trigger('blur_validate');
            if (form_element.closest('form').find('.form-group.has-error').length == 0) {
                $('#confirm').show();
                $('#create').hide();
                $('#code_2').val($('#code').val());
                $('#name_2').val($('#name').val());
                $('#email_2').val($('#email').val());
                $('#airline_represented_2').val($('#airline_represented').val());
                $('#temp_username_2').val($('#temp_username').val());

                $('#code_2').attr('disabled', true);
                $('#name_2').attr('disabled', true);
                $('#email_2').attr('disabled', true);
                $('#airline_represented_2').attr('disabled', true);
                $('#temp_username_2').attr('disabled', true);
                //console.log(air);
                if (air === '') {

                }
                else {
                    $('#operation_list tbody input[type="checkbox"]').each(function(key,value) {
                        if($(this).is(':checked')) {
                            var title = $(this).closest('tr').html();
                            $('#checked').append('<tr>' +title+ '</tr>');
                        }
                    });
                }
                $("#back").click(function() {
                    $('#create').show();
                    $('#confirm').hide();
                    $('#checked').empty();
                });
            }
            else {
				form_element.closest('form').find('.form-group.has-error').first().find('input, textarea, select').focus();
			}
        });

        $('#operation_list').on('ifToggled', 'input[type="checkbox"]', function() {
            $('#operation_list tbody input[type="checkbox"]').each(function(key,value) {
                if($(this).is(':checked')) {
                    air.push(value.value);
                }
            });
        });

       $('form').submit(function(e) {
            e.preventDefault();
            console.log($(this).serialize());
            $.post('<?=MODULE_URL?>ajax/ajax_create', $(this).serialize(), function(data) {
                if (data.success) {
                    window.location = data.redirect;
                }
            });
        });
    });
</script>

<style>
.outline {
    border : 0;
}

input[type="text"]:disabled , input[type="text"]:disabled:hover{
    background: white;
    cursor : default;
}
</style>