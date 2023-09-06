<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->session			= new session();
		$this->user_mgt_model	= new user_mgt_model();
		$this->portal			= $this->checkOutModel('home/portal_model');
		$this->fields 			= array(
			'username',
			'email',
			'firstname',
			'lastname',
			'middlename'
		);
		$this->login_fields		= array(
			'birthdate',
			'question',
			'answer',
			'username'
		);
		$this->profile_fields	= array(
			'firstname',
			'lastname',
			'middlename',
			'address',
			'email',
			'country',
			'email',
			'phone'
		);
	}

	public function listing() {
		$this->view->title	= 'CAB Users';
		$data['ui']			= $this->ui;
		$this->view->load('user_mgt/user_mgt', $data);
	}

	public function create() {
		$this->view->title		= 'Create CAB User';
		$data['airtype_list']	= $this->user_mgt_model->getAirtypeList();
		$data['ui']				= $this->ui;
		$data['ajax_task']		= 'ajax_create';
		$data['show_input']		= true;
		$this->view->load('user_mgt/add_user', $data);
	}

	public function reset_pw($username) {
		$data['ui']      = $this->ui;
		$data['uname']  = $username;
		$data['ajax_task']  = 'ajax_reset_pw';
		$this->view->load('user_mgt/user_reset_pw', $data);
	}

	public function reset_uname($username) {
		$data['ui']			= $this->ui;
		$data['username']	= $username;
		$data['ajax_task']	= 'ajax_reset_uname';
		$data['ajax_post']	= "&username_ref=$username";
		$this->view->load('user_mgt/user_reset_uname', $data);
	}

	public function view($username) {
		$this->view->title		= 'Account Info';
		$data					= (array) $this->user_mgt_model->getUserInfo($username);
		$data['ui']				= $this->ui;
		$data['username']		= $username;
		$data['show_input']		= false;
		$this->view->load('user_mgt/account_info', $data);
	}

	public function edit_profile($username) {
		$this->view->title		= 'Edit Personal Info';
		$data					= (array) $this->user_mgt_model->getUserInfo($username);
		$data['ui']				= $this->ui;
		$data['country_list']	= $this->user_mgt_model->getCountryList();
		$data['ajax_post']		= "&username_ref=$username";
		$data['ajax_task']		= 'ajax_edit_profile';
		$data['show_input']		= true;
		$this->view->load('user_mgt/edit_profile', $data);
	}

	public function edit_login_info($username) {
		$this->view->title		= 'Edit Login Info';
		$data					= (array) $this->user_mgt_model->getUserInfo($username);
		$data['ui']				= $this->ui;
		$data['birthdate']		= $this->date->dateFormat($data['birthdate']);
		$data['username']		= $username;
		$data['sec_quest_list']	= $this->user_mgt_model->getSecQuestionList();
		$data['ajax_post']		= "&username_ref=$username";
		$data['ajax_task']		= 'ajax_edit_login';
		$data['show_input']		= true;
		$this->view->load('user_mgt/edit_login_info', $data);
	}

	public function change_nature($username) {
		$data = (array) $this->user_mgt_model->getUserDetails($this->fields, $username);
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$data['user_name'] = $username;
		$data['ajax_task'] = 'ajax_edit_nature';
		$data['ajax_post'] = "&user_name=$username";
		$this->view->load('user_mgt/change_nature', $data);
	}

	public function change_password() {
		$data['ui'] = $this->ui;
		$session = new session();
		$login = $session->get('login');
		$username = $login['username'];
		$data['show_input'] = true;
		$data['ajax_task'] = 'ajax_edit_password';
		$data['ajax_post'] = "&username=$username";
		$this->view->load('user_mgt/change_password', $data);
	}

	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_list() {
		$sort	= $this->input->post('sort');
		$search	= $this->input->post('search');
		$pagination = $this->user_mgt_model->getUserPagination($sort, $search);
		$table = '';
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td>' . $row->firstname . '</td>';
			$table .= '<td>' . $row->lastname . '</td>';
			$table .= '<td>' . $row->username . '</td>';
			$table .= '<td>' . $row->groupname . '</td>';
			$table .= '<td>' . $row->email . '</td>';
			if (USERNAME == $row->username) {
				$table .= '<td class = "text-center">
						<a href="' . MODULE_URL . 'reset_pw/' . $row->username . '" class="cab-link">Reset Password</a> | 
						<a href="' . MODULE_URL . 'change_password/' . $row->username . '" class="cab-link">Change Password</a> |
						<a href="' . MODULE_URL . 'reset_uname/' . $row->username . '" class="cab-link">Reset Username</a> | 
						<a href="' . MODULE_URL . 'view/' . $row->username . '" class="cab-link">Edit Profile</a> |
						<a href="' . MODULE_URL . 'change_nature/' . $row->username . '" class="cab-link">Edit Nature of Operation</a> 
						</td>';
			}
			else {
				$table .= '<td class = "text-center">
						<a href="' . MODULE_URL . 'reset_pw/' . $row->username . '" class="cab-link">Reset Password</a> | 
						<span style = "text-align:center; font-weight:bold; color:gray"> Change Password </span>|
						<a href="' . MODULE_URL . 'reset_uname/' . $row->username . '" class="cab-link">Reset Username</a> | 
						<a href="' . MODULE_URL . 'view/' . $row->username . '" class="cab-link">Edit Profile</a> |
						<a href="' . MODULE_URL . 'change_nature/' . $row->username . '" class="cab-link">Edit Nature of Operation</a> 
						</td>';
			}
			$table .= '<td>' . $row->stat . '</td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		unset($pagination->result);
		return $pagination;
	}

	private function ajax_create() {
		$data				= $this->input->post($this->fields);
		$nature				= $this->input->post('nature');
		$data['password']	= $this->portal->randomPassword();
		$summary_viewer		= $this->input->post('summary_check');
		$email				= $this->portal->getUserEmail($data['username']);
		$data['groupname']	= ($summary_viewer) ? 'CAB Summary Viewer' : 'CAB Admin';

		$result = $this->user_mgt_model->saveUser($data, $nature);

		if ($result) {
			$message = "<h4>New {$data['groupname']} Account Created</h4>";
			$message .= "<p><b>Temp Account Login</b></p>";
			$message .= "<p><b>Username :</b> {$data['username']}</p>";
			$message .= "<p><b>Password :</b> {$data['password']}</p>";
			$message .= "You can now logon at <b><a target='_blank' href='http://cab.gov.ph/portal/'>http://cab.gov.ph/portal/</a> - CAB PORTAL </b>";
			$this->portal->sendEmail($message, $email);
		}

		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_edit_login() {
		$data		= $this->input->post($this->login_fields);
		$username	= $this->input->post('username_ref');
		
		$data['birthdate'] = $this->date->dateDbFormat($data['birthdate']);
		
		$result = $this->user_mgt_model->updateUser($data, $username);

		return array(
			'redirect'	=> MODULE_URL . 'view/' . $data['username'],
			'success' => $result
		);
	}

	private function ajax_edit_profile() {
		$data		= $this->input->post($this->profile_fields);
		$username	= $this->input->post('username_ref');

		$result = $this->user_mgt_model->updateUser($data, $username);

		return array(
			'redirect'	=> MODULE_URL . 'view/' . $username,
			'success' => $result
		);
	}

	private function ajax_reset_pw() {
		$username	= $this->input->post('username');
		$password	= $this->portal->randomPassword();
		
		$result		= $this->user_mgt_model->resetPassword($username, $password);
		$email		= $this->user_mgt_model->getUserEmail($username);

		$message = "<h4>New password has been generated for $username</h4>";
		$message .= "<p><b>Account Login</b></p>";
		$message .= "<p><b>Username :</b> $username</p>";
		$message .= "<p><b>Password :</b> $password</p>";
		$message .= "You can now logon at <b><a target='_blank' href='http://cab.gov.ph/portal/'>http://cab.gov.ph/portal/</a> - CAB PORTAL </b>";

		if ($result) {
			$this->portal->sendEmail($message, $email);
		}

		return array(
			'success' => $result
		);
	}

	private function ajax_edit_password() {
		$password = $this->input->post('password');
		$current_password = $this->input->post('current_password');
		$username   = $this->input->post('username');
		$getData = $this->user_mgt_model->getUserPassword($username);
		if (password_verify($current_password, $getData->password)) {
			$result = $this->user_mgt_model->editUserPassword($username, $password);
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
	}

	private function ajax_checked_operation_list() {
		$username = $this->input->post('username');
		$nature = $this->user_mgt_model->getCheckUserNature($username);

		$table = '';   
		if (empty($nature)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}

		foreach ($nature as $key => $row) :
		$table .= '<tr>';
		$table .= '<td><input ' . (($row->nature_id) ? 'checked': '') . ' type = "checkbox" name = "air_type[]" id = "air_type" value = "'.$row->id.'"> '.$row->title.'</td>';
		$table .= '</tr>';
		endforeach;

		return array('table' => $table);
	}

	private function ajax_edit_nature() {
		$username 	= $this->input->post('user_name');
		$air_type 	= $this->input->post('air_type');
		$nature		= array('nature_id' => $air_type);
		$result 	= $this->user_mgt_model->updateUserNature($nature, $username);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_reset_uname() {
		$data		= $this->input->post(array('username'));
		$username	= $this->input->post('username_ref');

		$result = $this->user_mgt_model->updateUser($data, $username);

		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_check_username() {
		$username	= $this->input->post('username');
		$reference	= $this->input->post('username_ref');

		$result		= $this->user_mgt_model->checkUsername($username, $reference);

		return array(
			'available'	=> $result
		);
	}

}