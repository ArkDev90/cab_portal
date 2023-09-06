<?php

class controller extends wc_controller {



	public function __construct() {

		parent::__construct();

		$this->ui				= new ui();

		$this->input			= new input();

		$this->client_mgt_model	= new client_mgt_model();

		$this->session			= new session();

		$this->fields 			= array(

			'id',

			'fname',

			'mname',

			'lname',

			'email',

			'address',

			'country',

			'username',

			'contact',

			'birthday',

			'question_id',

			'answer',

			'designation',

			'status',

			'user_type',

			'entereddate'

		);

		$this->client_fields  	= array(

			'code', 

			'name', 

			'tin_no', 

			'address', 

			'website', 

			'telno',

			'cp_designation',

			'email', 

			'cperson', 

			'cp_contact',

			'postal_code', 

			'faxno', 

			'mobno', 

			'airline_represented', 

			'regdate', 

			'country', 

			'status', 

			'temp_username',

			'entereddate'

		);

    } 



	public function account_info() {

		$session = new session();

		$login = $session->get('login');

		$id = $login['id'];

		$data = (array) $this->client_mgt_model->getClientUserDetails($this->fields, $id);

		$country = $data['country'];

		$getCountry = $this->client_mgt_model->getCountry($country);

		$data['country'] = $getCountry->country;

		$company = $this->client_mgt_model->getCompanyName($id);

		$data['company_name'] = $company->name;

		$data['ui'] = $this->ui;

		$data['show_input'] = false;

		$this->view->load('client_mgt/account_info', $data);

	}



	public function edit_profile($id) {

		$data = (array) $this->client_mgt_model->getClientUserDetails($this->fields, $id);

		$data['countries'] = $this->client_mgt_model->getCountryList();

		$data['ui'] = $this->ui;

		$data['show_input'] = true;

		$data['id'] = $id;

		$data['ajax_task'] = 'ajax_edit';

		$data['ajax_post'] = "&id=$id";

		$this->view->load('client_mgt/edit_profile', $data);

	}



	public function company_profile() {

		$session = new session();

		$login = $session->get('login');

		$client_id = $login['client_id'];

		$data = (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$data['ui'] = $this->ui;

		$data['show_input'] = false;

		$data['client_id'] = $client_id;

		$data['ajax_task'] = 'ajax_edit_companyprofile';

		$data['ajax_post'] = "&client_id=$client_id";

		$this->view->load('client_mgt/company_profile', $data);

	}



	public function edit_company_profile() {

		$session = new session();

		$login = $session->get('login');

		$client_id = $login['client_id'];

		$data = (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$data['ui'] = $this->ui;

		$data['show_input'] = true;

		$data['client_id'] = $client_id;

		$data['ajax_task'] = 'ajax_edit_company_profile';

		$data['ajax_post'] = "&client_id=$client_id";

		$this->view->load('client_mgt/edit_company_profile', $data);

	}



	public function edit_login_info($id) {

		$data = (array) $this->client_mgt_model->getClientUserDetails($this->fields, $id);

		$data['ui'] = $this->ui;

		$data['show_input'] = true;

		$data['id'] = $id;

		$data['ajax_task'] = 'ajax_edit_login';

		$data['ajax_post'] = "&id=$id";

		$this->view->load('client_mgt/edit_login_info', $data);

	}



	public function change_password() {

		$data['ui'] = $this->ui;

		$session = new session();

		$login = $session->get('login');

		$id = $login['id'];

		$data['show_input'] = true;

		$data['ajax_task'] = 'ajax_change_password';

		$data['ajax_post'] = "&id=$id";

		$this->view->load('client_mgt/change_password', $data);

	}



	public function ajax($task) {

		$ajax = $this->{$task}();

		if ($ajax) {

			header('Content-type: application/json');

			echo json_encode($ajax);

		}

	}



	private function ajax_edit() {

		$this->fields = array (

			'fname',

			'mname',

			'lname',

			'email',

			'address',

			'country',

			'contact'

		);

		$data = $this->input->post($this->fields);

		$id   = $this->input->post('id');

		$result = $this->client_mgt_model->updateClientUserProfile($data, $id);

		return array(

			'redirect'	=> MODULE_URL. 'account_info/' . $id,

			'success'	=> $result

		);

	}



	private function ajax_edit_login() {

		$this->fields = array (

			'username',

			'birthday',

			'question_id',

			'answer'

		);

		$data = $this->input->post($this->fields);

		$id   = $this->input->post('id');

		$result = $this->client_mgt_model->updateClientUserLoginInfo($data, $id);

		return array(

			'redirect'	=> MODULE_URL. 'account_info/' . $id,

			'success'	=> $result

		);

	}



	private function ajax_edit_company_profile() {

		$data = $this->input->post($this->client_fields);

		$client_id   = $this->input->post('client_id');

		$result = $this->client_mgt_model->updateClient($data, $client_id);

		return array(

			'redirect'	=> MODULE_URL. 'company_profile',

			'success'	=> $result

		);

	}



	private function ajax_change_password() {

		$this->fields = array('password', 'answer', 'birthday');

		$password = $this->input->post('password');

		$current_password = $this->input->post('current_password');

		// $answer = $this->input->post('answer');

		// $birthday = $this->input->post('birthday');

		$id   = $this->input->post('id');

		$getData = $this->client_mgt_model->getClientUserDetails($this->fields, $id);

		//if (($getData->birthday == $birthday) && ($getData->answer == $answer)) {

			if (password_verify($current_password, $getData->password)) {

				$result = $this->client_mgt_model->resetClientUserPassword($id, $password);

				$message = 'Password successfully updated';

				return array(

					'success'	=> $result,

					'message'	=> $message

				);

			}

			else {

				$message = 'Password is incorrect';

				return array(

					'success'	=> 'false',

					'message'	=> $message

				);

			}

		//}

		// else {

		// 	$message = 'Answer to Security Question or Date of Birth is Incorrect';

		// 	return array(

		// 		'success'	=> 'false',

		// 		'message'	=> $message

		// 	);

		// }

	}



	private function ajax_check_username() {

		$username	= $this->input->post('username');

		$result = $this->client_mgt_model->checkUserUname($username);

		return array(

			'available'	=> $result

		);

	}



}