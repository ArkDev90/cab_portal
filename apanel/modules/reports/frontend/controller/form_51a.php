<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui					= new ui();
		$this->url					= new url();
		$this->input				= new input();
		$this->session				= new session();
		$this->form51a_model		= new form51a_model();
		$this->reporting_model		= new reporting_model();
		$this->portal				= $this->checkOutModel('home/portal_model');
		$login						= $this->session->get('login');
		$this->client_id			= $login['client_id'];
		$this->user_name			= $login['name'];
		$this->user_id				= $login['id'];
		$this->user_group			= $login['groupname'];
		$this->report_form_table	= 'form51a';
		$this->report_form_id		= '11';
		
		$this->header_fields		= array(
			'year',
			'report_quarter'
		);
		$this->detail_fields		= array(
			'aircraft',
			'destination_from',
			'destination_to',
			'codeshared',
			'extra',
			'extra_dest',
			'economy',
			'business',
			'first',
			'quarter_month1',
			'quarter_month2',
			'quarter_month3',
			'foctraffic_month1',
			'foctraffic_month2',
			'foctraffic_month3',
			'nflight_month1',
			'nflight_month2',
			'nflight_month3',
			'quarter_month1_d',
			'quarter_month2_d',
			'quarter_month3_d',
			'foctraffic_month1_d',
			'foctraffic_month2_d',
			'foctraffic_month3_d',
			'nflight_month1_d',
			'nflight_month2_d',
			'nflight_month3_d',
			'ex_quarter_month1',
			'ex_quarter_month2',
			'ex_quarter_month3',
			'ex_foctraffic_month1',
			'ex_foctraffic_month2',
			'ex_foctraffic_month3',
			'ex_nflight_month1',
			'ex_nflight_month2',
			'ex_nflight_month3',
			'ex_quarter_month1_d',
			'ex_quarter_month2_d',
			'ex_quarter_month3_d',
			'ex_foctraffic_month1_d',
			'ex_foctraffic_month2_d',
			'ex_foctraffic_month3_d',
			'ex_nflight_month1_d',
			'ex_nflight_month2_d',
			'ex_nflight_month3_d',
			'cs_quarter_month1',
			'cs_quarter_month2',
			'cs_quarter_month3',
			'cs_foctraffic_month1',
			'cs_foctraffic_month2',
			'cs_foctraffic_month3',
			'cs_nflight_month1',
			'cs_nflight_month2',
			'cs_nflight_month3',
			'cs_quarter_month1_d',
			'cs_quarter_month2_d',
			'cs_quarter_month3_d',
			'cs_foctraffic_month1_d',
			'cs_foctraffic_month2_d',
			'cs_foctraffic_month3_d',
			'cs_nflight_month1_d',
			'cs_nflight_month2_d',
			'cs_nflight_month3_d',
			'ex_cs_quarter_month1',
			'ex_cs_quarter_month2',
			'ex_cs_quarter_month3',
			'ex_cs_foctraffic_month1',
			'ex_cs_foctraffic_month2',
			'ex_cs_foctraffic_month3',
			'ex_cs_nflight_month1',
			'ex_cs_nflight_month2',
			'ex_cs_nflight_month3',
			'ex_cs_quarter_month1_d',
			'ex_cs_quarter_month2_d',
			'ex_cs_quarter_month3_d',
			'ex_cs_foctraffic_month1_d',
			'ex_cs_foctraffic_month2_d',
			'ex_cs_foctraffic_month3_d',
			'ex_cs_nflight_month1_d',
			'ex_cs_nflight_month2_d',
			'ex_cs_nflight_month3_d'
		);
		$this->detail_fields2		= array(
			't_destination_from' => 'destination_from',
			't_destination_to' => 'destination_to',
			't_quarter_month1' => 'quarter_month1',
			't_quarter_month2' => 'quarter_month2',
			't_quarter_month3' => 'quarter_month3',
			't_quarter_month1_d' => 'quarter_month1_d',
			't_quarter_month2_d' => 'quarter_month2_d',
			't_quarter_month3_d' => 'quarter_month3_d'
		);
	}

	public function listing() {
		$title = $this->reporting_model->getFormTitle($this->report_form_id);
		$this->view->title		= $title;
		$data['ui']				= $this->ui;
		$data['form_title']		= $title;
		$data['quarter_list']	= $this->reporting_model->getQuarters();
		$data['year_list']		= $this->reporting_model->getYears();
		$this->view->load('form51a/form_51a_list', $data);
	}

	public function create($year = 0, $quarter = 0) {
		if ( ! $this->reporting_model->checkValidDate($year, $quarter)) {
			$this->url->redirect(MODULE_URL);
		}
		if ($this->reporting_model->checkExistingQuarterReport($quarter, $year, $this->report_form_table, $this->client_id)) {
			$this->url->redirect(MODULE_URL);
		}
		$title						= $this->reporting_model->getFormTitle($this->report_form_id);
		$this->view->title			= $title;
		$data['ui']					= $this->ui;
		$data['form_title']			= $title;
		$data['quarter_name']		= $this->reporting_model->getQuarterName($quarter);
		$data['quarter_months']		= $this->reporting_model->quarterMonths($quarter);
		$data['origin_list']		= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'Domestic', true);
		$data['destination_list']	= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'International', true);
		$data['mix_list']			= $this->reporting_model->getOriginDestinationList($this->report_form_id, '', true);
		$data['report_quarter']		= $quarter;
		$data['year']				= $year;
		$data['ajax_task']			= 'ajax_create';
		$data['ajax_post']			= '';

		$this->view->load('form51a/form_51a', $data);
	}

	public function edit($report_id) {
		$report = $this->form51a_model->getReport($this->header_fields, $report_id, $this->client_id, $this->user_id, $this->user_group);
		if ( ! $report) {
			$this->url->redirect(MODULE_URL);
		}
		$title						= $this->reporting_model->getFormTitle($this->report_form_id);
		$this->view->title			= $title;
		$data						= (array) $report;
		$data['ui']					= $this->ui;
		$data['form_title']			= $title;
		$data['quarter_name']		= $this->reporting_model->getQuarterName($report->report_quarter);
		$data['quarter_months']		= $this->reporting_model->quarterMonths($report->report_quarter);
		$data['form_details']		= $this->form51a_model->getReportDetails($this->detail_fields, $report_id);
		$data['form_details2']		= $this->form51a_model->getReportDetails2($this->detail_fields2, $report_id);
		$data['origin_list']		= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'Domestic', true);
		$data['destination_list']	= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'International', true);
		$data['mix_list']			= $this->reporting_model->getOriginDestinationList($this->report_form_id, '', true);
		$data['ajax_task']			= 'ajax_edit';
		$data['ajax_post']			= "&report_id=$report_id";

		$this->view->load('form51a/form_51a', $data);
	}

	public function delete($report_id) {
		$report = $this->form51a_model->getReport($this->header_fields, $report_id, $this->client_id, $this->user_id, $this->user_group);
		if ( ! $report) {
			$this->url->redirect(MODULE_URL);
		}
		$title					= $this->reporting_model->getFormTitle($this->report_form_id);
		$this->view->title		= $title;
		$data					= (array) $report;
		$data['ui']				= $this->ui;
		$data['form_title']		= $title;
		$data['form_details']	= $this->form51a_model->getReportDetails($this->detail_fields, $report_id);
		$data['form_details2']	= $this->form51a_model->getReportDetails2($this->detail_fields2, $report_id);
		$data['quarter_months']	= $this->reporting_model->quarterMonths($report->report_quarter);
		$data['quarter_name']	= $this->reporting_model->getQuarterName($report->report_quarter);
		$data['month_days']		= $this->reporting_model->getMonthDays($report->report_quarter, $report->year);
		$data['ajax_task']		= 'ajax_delete';
		$data['ajax_post']		= "&report_id=$report_id";

		$this->view->load('form51a/form_51a_delete', $data);
	}

	public function view_draft_list() {
		$title = $this->reporting_model->getFormTitle($this->report_form_id);
		$this->view->title	= $title;
		$data['ui']			= $this->ui;
		$data['form_title']	= $title;
		$data['month_list']	= $this->reporting_model->getMonths();
		$data['year_list']	= $this->reporting_model->getYears();
		$this->view->load('form51a/form_51a_draft_list', $data);
	}

	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_list() {
		$limit = $this->input->post('limit');

		$pagination = $this->reporting_model->getReportList($this->report_form_table, $this->client_id, 'report_quarter');
		$table = '';   
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="5" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td class="text-center">'. ((($pagination->page - 1) * $limit) + $key + 1) .'</td>';
			$table .= '<td class="text-center">' . $this->reporting_model->getQuarterName($row->report_quarter) . ' ' . $row->year . '</td>';
			$table .= '<td class="text-center">' . $this->date->dateFormat($row->submitteddate) . '</td>';
			$table .= '<td class="text-center">' . $row->submittedby . '</td>';
			$table .= '<td class="text-center">' . $row->status . '</td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_draft_list() {
		$limit = $this->input->post('limit');

		$pagination = $this->reporting_model->getReportDraftList($this->report_form_table, $this->client_id, 'report_quarter');
		$name = $this->reporting_model->getFullName($this->user_id);
		$table = '';   
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="5" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$action_link = 'N/A';
			if ($row->submittedby_id == $this->user_id || $this->user_group == 'Master Admin' || ((stripos($row->submittedby, $name->fname) !== FALSE) && (stripos($row->submittedby, $name->lname) !== FALSE))) {
				$action_link = '<a href="' . MODULE_URL . 'edit/' . $row->id . '">Edit</a> | <a href="' . MODULE_URL . 'delete/' . $row->id . '">Delete</a>';
			}

			$table .= '<tr>';
			$table .= '<td class="text-center">'. ((($pagination->page - 1) * $limit) + $key + 1) .'</td>';
			$table .= '<td class="text-center">' . $this->reporting_model->getQuarterName($row->report_quarter) . ' ' . $row->year . '</td>';
			$table .= '<td class="text-center">' . $this->date->dateFormat($row->submitteddate) . '</td>';
			$table .= '<td class="text-center">' . $row->submittedby . '</td>';
			$table .= '<td class="text-center">' . $action_link . '</td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_create() {
		$header		= $this->input->post($this->header_fields);
		$details	= $this->input->post('data_values');
		$details	= $this->getValuesFromJSON($details);
		$details2	= $this->input->post($this->detail_fields2);
		$submit		= $this->input->post('submit_type');

		$header['client_id']	= $this->client_id;
		$status					= ($submit == 'submit') ? 'Approved' : 'Draft';

		if ($status == 'Approved' && ! in_array($this->user_group, array('Master Admin'))) {
			$status = 'Pending';
		}

		$header['status']		= $status;

		$header['submittedby']		= $this->user_name;
		$header['submittedby_id']	= $this->user_id;
		$header['submitteddate']	= $this->date->dateDbFormat();
		if ($status == 'Approved') {
			$header['approvedby']	= $this->user_name;
			$header['approveddate']	= $this->date->dateDbFormat();
		}

		$result = $this->form51a_model->saveReport($header, $details, $details2);

		if ($result && $status == 'Approved') {
			$report_id = $this->form51a_model->getReportId();
			$this->portal->sendReportConfirmation($this->report_form_id, $report_id);
		}

		return array(
			'success'	=> $result,
			'redirect'	=> MODULE_URL
		);
	}

	private function ajax_edit() {
		$report_id	= $this->input->post('report_id');
		$header		= $this->input->post($this->header_fields);
		$details	= $this->input->post('data_values');
		$details	= $this->getValuesFromJSON($details);
		$details2	= $this->input->post($this->detail_fields2);
		$submit		= $this->input->post('submit_type');

		$header['client_id']	= $this->client_id;
		$status					= ($submit == 'submit') ? 'Approved' : 'Draft';

		if ($status == 'Approved' && ! in_array($this->user_group, array('Master Admin'))) {
			$status = 'Pending';
		}

		$header['status']		= $status;
		if ($status == 'Approved') {
			$header['submittedby']		= $this->user_name;
			$header['submittedby_id']	= $this->user_id;
			$header['submitteddate']	= $this->date->dateDbFormat();
			$header['approvedby']		= $this->user_name;
			$header['approveddate']		= $this->date->dateDbFormat();
		}

		$result = $this->form51a_model->updateReport($header, $details, $details2, $report_id, $this->client_id);

		if ($result && $status == 'Approved') {
			$this->portal->sendReportConfirmation($this->report_form_id, $report_id);
		}

		return array(
			'success'	=> $result,
			'redirect'	=> MODULE_URL
		);
	}

	private function ajax_delete() {
		$report_id	= $this->input->post('report_id');

		$result = $this->form51a_model->deleteReport($report_id, $this->client_id);

		return array(
			'success'	=> $result,
			'redirect'	=> MODULE_URL . 'view_draft_list'
		);
	}

	private function ajax_check_report() {
		$quarter	= $this->input->post('quarter');
		$year		= $this->input->post('year');

		$result = $this->reporting_model->checkExistingQuarterReport($quarter, $year, $this->report_form_table, $this->client_id);

		return array(
			'existing' => $result
		);
	}

	private function getValuesFromJSON($data) {
		$temp = array();
		$objs = array();
		foreach ($data as $values) {
			$objs[] = json_decode(stripcslashes($values));
		}
		foreach ($objs as $obj_key => $obj) {
			foreach ($obj as $key => $value) {
				$temp[$key][$obj_key] = addslashes($value);
			}
		}
		return $temp;
	}

}