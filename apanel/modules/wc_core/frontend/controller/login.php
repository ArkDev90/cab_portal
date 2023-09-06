<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->access		= new access();
		$this->input		= new input();
		$this->login_model	= new login();
		$this->url			= new url();
		$this->session		= new session();
		$this->log			= new log();
		$this->ajax_post	= $this->input->post('ajax');
		$this->temp_login	= $this->session->get('temp_login');
		if ($this->temp_login) {
			$this->url->redirect(BASE_URL . 'register');
		}
	}

	public function index() {
		$data = array('error_msg' => '');
		$data = $this->input->post(array(
			'username',
			'password'
		));
		if ($this->access->isApanelUser()) {
			$redirect = base64_decode($this->input->get('redirect'));
			$redirect = ( ! empty($redirect) && strpos($redirect, BASE_URL) !== false) ? $redirect : BASE_URL . 'apanel';
			$this->url->redirect($redirect);
		}
		if ($this->access->isUser()) {
			$this->url->redirect(BASE_URL);
		}
		if ($this->ajax_post) {
			header('Content-type: application/json');
		}
		if ($this->input->isPost) {
			extract($data);
			$result = $this->login_model->getUserAccess($username, $password);
			if ($result) {
				if (in_array($result->groupname, array('Temp Admin', 'Temp User'))) {
					$this->session->set('temp_login', $result);
				} else {
					$this->session->set('login', $result);
				}
				$this->access->loginUser();
				$this->log->saveActivity('Login');
				if ($this->ajax_post) {
					echo json_encode(array('success' => true));
				} else {
					$this->url->redirect(FULL_URL);
				}
			} else {
				if ($this->ajax_post) {
					echo json_encode(array(
						'show_login_form'	=> true,
						'success'			=> false,
						'error_msg'			=> 'Invalid Username or Password'
					));
				} else {
					$data['error_msg'] = 'Invalid Username or Password';
				}
			}
		}
		if ( ! $this->ajax_post) {
			$data['redirect'] = $this->input->get('redirect');
			$this->view->load('login', $data, false);
		}
	}

	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	public function verify_login() {
		$data = $this->input->post(array(
			'username',
			'password'
		));
		extract($data);
		$data = array();
		$redirect = $this->input->post('redirect');
		$redirect = ($redirect) ? base64_decode($redirect) : BASE_URL;
		$result = $this->login_model->getUserAccess($username, $password);
		if ($result) {
			if ($result['groupname'] == 'GSA') {
				$client_id		= $this->input->post('client_id');
				$client_list	= $this->login_model->getGSAClientList($username);
				if (count($client_list) == 1) {
					$client = $client_list[0];
					$client_id = $client->client_id;
				}
				if ($client_id) {
					$result['client_id'] = $client_id;
					$this->session->set('login', $result);
					$this->access->loginUser();
					$this->log->saveActivity('Login');
					$data['success'] = true;
					$data['redirect'] = $redirect;
				} else {
					$data['client_dropdown'] = $this->getGSAClientDropdown($client_list);
				}
			} else {
				if (in_array($result['groupname'], array('Temp Admin', 'Temp User'))) {
					$this->session->set('temp_login', $result);
					$redirect = BASE_URL . 'register';
				} else {
					$this->session->set('login', $result);
					$this->access->loginUser();
				}
				$this->log->saveActivity('Login');
				$data['success'] = true;
				$data['redirect'] = $redirect;
			}
		} else {
			if ($this->ajax_post) {
				echo json_encode(array(
					'show_login_form'	=> true,
					'success'			=> false,
					'error_msg'			=> 'Invalid Username or Password'
				));
			} else {
				$data['error_msg'] = 'Invalid Username or Password';
			}
		}
		return $data;
	}

	private function getGSAClientDropdown($client_list) {
		$dropdown = '';

		foreach ($client_list as $row) {
			$dropdown .= '<option value="' . $row->client_id . '">' . $row->name . '</option>'; 
		}

		if ($dropdown) {
			$dropdown = '<select name="client_id" class="form-control">' . $dropdown . '</select>';
		} 

		return $dropdown;
	}

}