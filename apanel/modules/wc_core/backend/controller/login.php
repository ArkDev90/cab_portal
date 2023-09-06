<?php
class controller extends wc_controller {

	public function index() {
		$url				= new url();
		$access				= new access();
		$input				= new input();
		$url->redirect(str_replace('apanel/', '', BASE_URL) . (($input->get('redirect')) ? '?redirect=' . $input->get('redirect') : ''));
		$login_model		= new login();
		$session			= new session();
		$log				= new log();
		$ajax				= $input->post('ajax');
		$data = array('error_msg' => '');
		$data = $input->post(array(
			'username',
			'password'
		));
		if ($access->isApanelUser()) {
			$redirect = base64_decode($input->get('redirect'));
			$redirect = ( ! empty($redirect) && strpos($redirect, BASE_URL) !== false) ? $redirect : BASE_URL;
			$url->redirect($redirect);
		}
		if ($ajax) {
			header('Content-type: application/json');
		}
		if ($input->isPost) {
			extract($data);
			$result = $login_model->getUserAccess($username, $password);
			if ($result) {
				$locktime = $login_model->checkLockedAccount($username);
				if ($locktime) {
					$data['locktime'] = $this->date->datetimeFormat($locktime->locktime);
				} else {
					$session->set('login', $result);
					$access->loginUser();
					$log->saveActivity('Login');
					if ($ajax) {
						echo json_encode(array('success' => true));
					} else {
						$url->redirect(FULL_URL);
					}
				}
			} else {
				if ($ajax) {
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
		if ( ! $ajax) {
			$this->view->load('login', $data, false);
		}
	}

}