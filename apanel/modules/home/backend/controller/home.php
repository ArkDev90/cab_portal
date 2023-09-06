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
		$count3 = $this->portal_model->getLateReports();
		$totalcount = $count3->count51a + $count3->count51b + $count3->count61a + $count3->count61b + $count3->count71a + $count3->count71b + $count3->count71c + $count3->countt1a;
		$count = $this->portal_model->getSuspendedUsers();
		$count1 = $this->portal_model->getTerminatedUsers();
		$data['suspended']  = $count->result_count;
		$data['terminated'] = $count1->result_count;
		$data['late'] 		= $totalcount;
		$data['reports']	= $this->getReportList();
		$this->view->load('home', $data);
	}

	private function getReportList() {
		$client_id	= $this->login['client_id'];
		$id			= $this->login['id'];
		$reports	= $this->portal_model->getClientReportList();

		foreach ($reports as $key => $row) {
			$reports[$key]->count = $this->portal_model->getReportCount1($row->db_table);
		}

		return $reports;
	}

}