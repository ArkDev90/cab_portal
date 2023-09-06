<form action="" method="post">

<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		<?php echo $name; ?> : PROFILE

	</div>

    <div id = "update">

        <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Code:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('code')

                ->setId('code')

                ->setClass('outline')

                ->setValue($code)

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Name:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('name')

                ->setId('name')

                ->setClass('outline')

                ->setValue($name)

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Address:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('address')

                ->setId('address')

                ->setClass('outline')

                ->setValue($address)

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Tin No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('tin_no')

                ->setId('tin_no')

                ->setClass('outline')

                ->setValue($tin_no)

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Country:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('country')

                ->setId('country')

                ->setValue($country)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Postal Code:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('postal_code')

                ->setId('postal_code')

                ->setValue($postal_code)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Telephone No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('telno')

                ->setId('telno')

                ->setValue($telno)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row note" style = "padding: 0% 3% 0% 0%">

            <div class = "col-md-4">

                

            </div>

            <div class = "col-md-8" >

                Use backslash "/" for multiple telephone numbers.

            </div>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Fax No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('faxno')

                ->setId('faxno')

                ->setValue($faxno)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row note" style = "padding: 0% 3% 0% 0%">

            <div class = "col-md-4">

                

            </div>

            <div class = "col-md-8" >

                Use backslash "/" for multiple fax numbers.

            </div>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Contact No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('mobno')

                ->setId('mobno')

                ->setValue($mobno)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row note" style = "padding: 0% 3% 0% 0%">

            <div class = "col-md-4">

                

            </div>

            <div class = "col-md-8" >

                Use backslash "/" for multiple mobile numbers.

            </div>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Email:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('email')

                ->setId('email')

                ->setValue($email)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Website:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('website')

                ->setId('website')

                ->setValue($website)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Contact Person:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('cperson')

                ->setId('cperson')

                ->setValue($cperson)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Designation:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('cp_designation')

                ->setId('cp_designation')

                ->setValue($cp_designation)

                ->draw($show_input);

            ?>

        </div>

        <div class = "row">

            <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">

                <a href="<?=MODULE_URL?>company_profile" class="btn btn-sm btn-default">CANCEL</a>

                <button type = "button" id = "save" class = "btn btn-sm btn-primary">SAVE</button>

            </div>

        </div>

    </div>

    <div id = "confirm_page">

        <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Code:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('code2')

                ->setId('code2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Name:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('name2')

                ->setId('name2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Address:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('address2')

                ->setId('address2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Tin No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('tin_no2')

                ->setId('tin_no2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Country:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('country2')

                ->setId('country2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Postal Code:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('postal_code2')

                ->setId('postal_code2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Telephone No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('telno2')

                ->setId('telno2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Fax No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('faxno2')

                ->setId('faxno2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Contact No:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('mobno2')

                ->setId('mobno2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Email:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('email2')

                ->setId('email2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Website:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('website2')

                ->setId('website2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Contact Person:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('cperson2')

                ->setId('cperson2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

            <?php

                echo $ui->formField('text')

                ->setLabel('Designation:')

                ->setSplit('col-md-4', 'col-md-5')

                ->setName('cp_designation2')

                ->setId('cp_designation2')

                ->setClass('outline')

                ->setAttribute(array('readonly' => 'true'))

                ->draw($show_input);

            ?>

        </div>

        <div class = "row">

            <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">

                <a id = "back" type = "button" class="btn btn-sm btn-default">BACK</a>

                <button type = "submit" class = "btn btn-sm btn-primary">CONFIRM</button>

            </div>

        </div>

    </div>

</div>

</form>

<script>

        

	$( document ).ready(function() {

		$('#confirm_page').hide();

        $("#save").click(function() {

			$('#confirm_page').show();

			$('#update').hide();

			$('#country2').val($('#country').val());

			$('#code2').val($('#code').val());

			$('#name2').val($('#name').val());

			$('#address2').val($('#address').val());

			$('#tin_no2').val($('#tin_no').val());

			$('#postal_code2').val($('#postal_code').val());

			$('#telno2').val($('#telno').val());

			$('#faxno2').val($('#faxno').val());

			$('#mobno2').val($('#mobno').val());

			$('#email2').val($('#email').val());

			$('#website2').val($('#website').val());

			$('#cperson2').val($('#cperson').val());

			$('#cp_designation2').val($('#cp_designation').val());

		});

        $("#back").click(function() {

			$('#update').show();

			$('#confirm_page').hide();

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

	});

</script>



<style>

.outline {

    border : 0;

    background: white!important;

}



input[type="text"]:disabled , input[type="text"]:disabled:hover{

    background: white;

    cursor : default;

}

</style>

