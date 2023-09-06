<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		ACCOUNT INFORMATION
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12 text-center">
							<h5><b>Personal Information</b> [ <a href = "<?= MODULE_URL ?>edit_profile/<?= $username ?>"> Edit </a> ]</h5>
						</div>
					</div>
					<?php
						echo $ui->formField('text')
								->setLabel('First Name:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('firstname')
								->setId('firstname')
								->setValue($firstname)
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Middle Name:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('middlename')
								->setId('middlename')
								->setValue($middlename)
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Last Name:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('lastname')
								->setId('lastname')
								->setValue($lastname)
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Email:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('email')
								->setId('email')
								->setValue($email)
								->draw($show_input);
					?>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-12 text-center">
							<h5><b>Login Information</b> [ <a href = "<?= MODULE_URL ?>edit_login_info/<?= $username ?>"> Edit </a> ]</h5>
						</div>
					</div>
					<?php
						echo $ui->formField('text')
								->setLabel('Birth Date:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('birthdate')
								->setId('birthdate')
								->setValue($birthdate)
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Username:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('username')
								->setId('username')
								->setValue($username)
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Reg Date:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('registrationdate')
								->setId('registrationdate')
								->setValue($registrationdate)
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Last Login:')
								->setSplit('col-md-4', 'col-md-8')
								->setName('checktime')
								->setId('checktime')
								->setValue($checktime)
								->draw($show_input);
					?>
				</div>
			</div>
		</form>
	</div>
</div>