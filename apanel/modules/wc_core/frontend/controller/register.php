<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->input			= new input();
		$this->register_model	= new register();
		$this->session			= new session();
		$this->ui				= new ui();
		$this->url				= new url();
		$this->portal			= $this->checkOutModel('home/portal_model');
		$this->login			= $this->session->get('login');
		$this->temp_login		= $this->session->get('temp_login');
		if ($this->login || ! $this->temp_login) {
			$this->url->redirect(BASE_URL);
		}
		$this->temp_login		= (object) $this->temp_login;
		$this->client_fields	= array(
			'tin_no',
			'address',
			'country',
			'postal_code',
			'email',
			'website',
			'telno',
			'faxno',
			'mobno',
			'cperson',
			'cp_designation',
			'cp_contact'
		);
		$this->user_fields		= array(
			'username',
			'password',
			'fname',
			'mname',
			'lname',
			'designation',
			'address',
			'country',
			'email',
			'contact'
		);
	}

	public function index() {
		$client_id				= $this->temp_login->client_id;
		$fields					= array_merge(array('code', 'name'), $this->client_fields);
		$data					= (array) $this->register_model->getClient($fields, $client_id);
		$data['ui']				= $this->ui;
		$data['country_list']	= $this->register_model->getCountryList();
		$data['nature_list']	= $this->register_model->getCompanyNature($client_id);
		$data['form_type']		= ($data['cperson']) ? 'user' : 'company';
		$this->view->load('register', $data, false);
	}

	public function ajax($task) {
		if ( ! $this->input->isPost) {
			exit();
		}
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_update_client() {
		$data = $this->input->post($this->client_fields);

		$client_id = $this->temp_login->client_id;

		$result = $this->register_model->updateClient($data, $client_id);
		
		return array(
			'success'	=> $result,
			'redirect'	=> BASE_URL . 'register'
		);
	}

	private function ajax_register_user() {
		$data = $this->input->post($this->user_fields);

		$client_id = $this->temp_login->client_id;

		$result = false;

		if ($this->temp_login->user_table == 'client') {
			$result = $this->register_model->registerUser($data, $client_id);
		} else if ($this->temp_login->user_table == 'client_user') {
			$result = $this->register_model->updateClientUser($data, $this->temp_login->id);
		} else if ($this->temp_login->user_table == 'gsa_user') {
			$result = $this->register_model->updateGSAUser($data, $this->temp_login->id);
		}

		if ($result) {
			if ($this->temp_login->user_table == 'client') {
				$result = $this->register_model->clearTempUserAccess($client_id);
			}

			$this->access->logoutUser();

			$username 	= $this->input->post('username');
			$password 	= $this->input->post('password');
			$email 		= $this->input->post('email');

			$message = "<span style = 'font-face:arial'>Civil Aeronautics Board of the Philippines</span><br>";
			$message .= "<span style = 'font-face:arial'><b>Username : </b> $username </span><br>";
			$message .= "<span style = 'font-face:arial'><b>Password : </b> $password </span><br>";
			$message .= "<span style = 'font-face:arial'>You can now logon at <a target='_blank' href='http://www.cab.gov.ph/portal/'><B>CAB - PORTAL</B></a> and create your Company Profile and Master Administrator</span><br>";
			$message .= "<span style = 'font-face:arial'>or you may copy and paste this url <B>http://www.cab.gov.ph/portal/</B> to the address bar.</span>";
			
			$this->portal->sendEmail($message, $email);
		}

		return array(
			'succes'	=> ($result) ? true : false,
			'redirect'	=> BASE_URL. 'login'
		);
	}

	private function ajax_check_username() {
		$username	= $this->input->post('username');
		$reference	= $this->input->post('username_ref');

		$result		= $this->portal->checkExistingUsername($username, $reference);

		return array(
			'available'	=> ($result) ? false : true
		);
	}

}