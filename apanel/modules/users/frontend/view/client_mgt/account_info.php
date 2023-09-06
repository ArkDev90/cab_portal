<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		ACCOUNT INFORMATION
	</div>
    <div class = "row">
        <div class = "col-md-6 font-normal" style = "padding: 3% 0% 0% 0%">
            <div class = "col-md-offset-5">
                <b>Personal Information</b> [ <a href = "<?= MODULE_URL ?>edit_profile/<?php echo $id ?>"> Edit </a> ]
            </div>
            <?php
                echo $ui->formField('text')
                ->setLabel('First Name:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('fname')
                ->setId('fname')
                ->setValue($fname)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Last Name:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('lname')
                ->setId('lname')
                ->setValue($lname)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Middle Name:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('mname')
                ->setId('mname')
                ->setValue($mname)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Address:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('address')
                ->setId('address')
                ->setValue($address)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Country:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('country')
                ->setId('country')
                ->setValue($country)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Email Address:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('email')
                ->setId('email')
                ->setValue($email)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Contact No:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('contact')
                ->setId('contact')
                ->setValue($contact)
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-6 font-normal " style = "padding: 3% 0% 0% 0%">
            <div class = "col-md-offset-5">
                <b>Login Information</b> [ <a href = "<?= MODULE_URL ?>edit_login_info/<?php echo $id ?>"> Edit </a> ]
            </div>
            <?php
                echo $ui->formField('text')
                ->setLabel('Company:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('company')
                ->setId('company')
                ->setValue($company_name) 
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('User Level:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('level')
                ->setId('level')
                ->setValue($user_type)
                ->draw($show_input);
            ?>
            <!-- <?php
                echo $ui->formField('text')
                ->setLabel('Security Question:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('question_id')
                ->setId('question_id')
                ->setValue($question_id)
                ->draw($show_input);
            ?> -->
            <?php
                echo $ui->formField('text')
                ->setLabel('Birthday:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('birthday')
                ->setId('birthday')
                ->setValue($birthday)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Username:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('username')
                ->setId('username')
                ->setValue($username)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Registration Date:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('reg_date')
                ->setId('reg_date')
                ->setValue($entereddate)
                ->draw($show_input);
            ?>
            <?php
                echo $ui->formField('text')
                ->setLabel('Last Login:')
                ->setSplit('col-md-5', 'col-md-7')
                ->setName('last_login')
                ->setId('last_login')
                ->draw($show_input);
            ?>
        </div>
    </div>
</div>