<?php
class controller extends wc_controller {
	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->portal_model		= new portal_model();
		$this->client_mgt_model	= $this->checkOutModel('users/client_mgt_model');
		$session				= new session();
		$this->login			= $session->get('login');
	}
	public function index() {
		$this->view->title	= 'Dashboard';
		$data['ui']			= $this->ui;
		$client_id			= $this->login['client_id'];
		$id					= $this->login['id'];
		$data['client_id']	= $client_id;
		$data['id']			= $id;
		$data['reports']	= $this->getReportList();
		$this->view->load('home',$data);
	}

	private function getReportList() {
		$client_id	= $this->login['client_id'];
		$id			= $this->login['id'];
		$user_table	= $this->login['user_table'];
		$user_type	= $this->login['groupname'];
		$reports	= $this->portal_model->getClientUserReportList($client_id, $id, $user_table, $user_type);

		foreach ($reports as $key => $row) {
			$reports[$key]->count = $this->portal_model->getReportCount($client_id, $row->db_table);
		}

		return $reports;
	}

}