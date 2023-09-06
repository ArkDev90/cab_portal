<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->input		= new input();
		$this->forgot_model	= new forgot();
		$this->portal		= $this->checkOutModel('home/portal_model');
	}

	public function index() {
		$reset = $this->input->get('reset');
		if ($reset) {
			$this->view->load('forgot_reset', array('reset' => $reset), false);
		} else {
			$this->view->load('forgot', array(), false);
		}
	}

	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_reset_pw() {
		$username	= $this->input->post('username');
		$reset		= $this->input->post('reset');
		$result		= $this->portal->getUser($username);

		if ($reset) {
			$password	= $this->input->post('password');
			$reset		= explode('CABPORTAL', base64_decode($reset));
			$result		= $this->portal->getUser($reset[3]);
			$reset_pass	= false;
			if ($result && $result->password == $reset[2]) {
				$reset_pass		= $this->portal->resetPassword($reset[3], $password);
			}

			return array(
				'success' => !!($reset_pass)
			);
		}

		if (empty($reset) && $result) {
			$link = $result->user_table . 'CABPORTAL' . $result->id . 'CABPORTAL' . $result->password . 'CABPORTAL' . $result->username;

			$reset_url = MODULE_URL . '?reset=' . base64_encode($link);

			$message = "<h4>Password Reset</h4>";
			$message .= "<p><b>Please Ignore this Message if you did NOT Reset your Password</b></p>";
			$message .= "<br>";
			$message .= '<p><b>You can reset your password at <br></b> <a href="' . $reset_url . '">' . $reset_url . '</a></p>';

			$this->portal->sendEmail($message, $result->email);
		}

		return array(
			'success'	=> ($result->email) ? true : false,
			'redirect'	=> BASE_URL . 'login',
			'error_msg'	=> ($result->email) ? '' : 'Incorrect Username'
		);
	}

	public function verify_login() {

	}

}