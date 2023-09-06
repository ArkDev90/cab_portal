<?php
setcookie("emailupdated", 1, time() + (86400 * 30), "/");
?>

<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		<?php echo $name; ?> : PROFILE

	</div>

    <div class = "row font-normal" style = "padding: 3% 3% 1% 3%">

        <center>[<a href = "<?php MODULE_URL ?>edit_company_profile">Edit Company Profile</a>]</center>

    </div>

    <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Code:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('code')

            ->setId('code')

            ->setValue($code)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Name:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('name')

            ->setId('name')

            ->setValue($name)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Tin No:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('tin_no')

            ->setId('tin_no')

            ->setValue($tin_no)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row">

        <div class = "col-md-1">

        </div>

        <div class = "col-md-4">

            <b>CONTACT INFORMATION</b>

        </div>

    </div>

    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Address:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('address')

            ->setId('address')

            ->setValue($address)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Country:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('country')

            ->setId('country')

            ->setValue($country)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Postal Code:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('postal_code')

            ->setId('postal_code')

            ->setValue($postal_code)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Telephone No:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('telno')

            ->setId('telno')

            ->setValue($telno)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Fax No:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('faxno')

            ->setId('faxno')

            ->setValue($faxno)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Email:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('email')

            ->setId('email')

            ->setValue($email)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Website:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('website')

            ->setId('website')

            ->setValue($website)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Contact Person:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('cperson')

            ->setId('cperson')

            ->setValue($cperson)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Contact No:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('mobno')

            ->setId('mobno')

            ->setValue($mobno)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Designation:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('cp_designation')

            ->setId('cp_designation')

            ->setValue($cp_designation)

            ->draw($show_input);

        ?>

    </div>

    <div class = "row">

        <div class = "col-md-1">

        </div>

        <div class = "col-md-4">

            <b>	REGISTRATION INFORMATION</b>

        </div>

    </div>

    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Reporting Type:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('report_type')

            ->setId('report_type')

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Anniversary Date:')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('anniv_date')

            ->setId('anniv_date')

            ->draw($show_input);

        ?>

    </div>

    <div class = "row font-normal" style = "padding: 0% 3% 0% 0%">

        <?php

            echo $ui->formField('text')

            ->setLabel('Registration Date :')

            ->setSplit('col-md-4', 'col-md-4')

            ->setName('entereddate')

            ->setId('entereddate')

            ->setValue($entereddate)

            ->draw($show_input);

        ?>

    </div>

</div>

