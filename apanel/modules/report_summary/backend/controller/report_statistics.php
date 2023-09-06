<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->session			= new session();
	}

	public function listing() {
		$this->view->load('report_statistics/report_statistics');
	}

	public function statistics_report51a() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_report51a', $data);
	}

	public function statistics_report51b() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_report51b', $data);
	}

	public function statistics_report61a() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_report61a', $data);
	}

	public function statistics_report61b() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_report61b', $data);
	}

	public function statistics_report71a() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_report71a', $data);
	}

	public function statistics_report71b() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_report71b', $data);
	}

	public function statistics_report71c() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_report71c', $data);
	}

	public function statistics_reportER2() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_reportER2', $data);
	}

	public function statistics_reportT1a() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_statistics/statistics_reportT1a', $data);
	}

}