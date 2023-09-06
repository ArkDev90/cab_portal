<?php

class controller extends wc_controller {



	public function __construct() {

		parent::__construct();

		$this->ui					= new ui();

		$this->url					= new url();

		$this->input				= new input();

		$this->session				= new session();

		$this->form61b_model		= new form61b_model();

		$this->reporting_model		= new reporting_model();

		$this->portal				= $this->checkOutModel('home/portal_model');

		$login						= $this->session->get('login');

		$this->client_id			= $login['client_id'];

		$this->user_name			= $login['name'];

		$this->user_id				= $login['id'];

		$this->user_group			= $login['groupname'];

		$this->report_form_table	= 'form61b';

		$this->report_form_id		= '15';

		

		$this->header_fields		= array(

			'year',

			'report_month'

		);

		$this->detail_fields		= array(

			'report_day',

			'aircraft',

			'aircraft_num',

			'origin',

			'destination',

			'distance',

			'flown_hour',

			'flown_min',

			'passengers_num',

			'cargo_qty',

			'cargo_value',

			'revenue'

		);

	}



	public function listing() {

		$title = $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title	= $title;

		$data['ui']			= $this->ui;

		$data['form_title']	= $title;

		$data['month_list']	= $this->reporting_model->getMonths();

		$data['year_list']	= $this->reporting_model->getYears();

		$this->view->load('form61b/form_61b_list', $data);

	}



	public function create($year = 0, $month = 0) {

		if ( ! $this->reporting_model->checkValidDate($year, $month)) {

			$this->url->redirect(MODULE_URL);

		}

		if ($this->reporting_model->checkExistingReport($month, $year, $this->report_form_table, $this->client_id)) {

			$this->url->redirect(MODULE_URL);

		}

		$title					= $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title		= $title;

		$data['ui']				= $this->ui;

		$data['form_title']		= $title;

		$data['month_name']		= $this->reporting_model->getMonthName($month);

		$data['month_days']		= $this->reporting_model->getMonthDays($month, $year);

		$data['report_month']	= $month;

		$data['operation']		= '';

		$data['year']			= $year;

		$data['ajax_task']		= 'ajax_create';

		$data['ajax_post']		= '';



		$this->view->load('form61b/form_61b', $data);

	}



	public function edit($report_id) {

		$report = $this->form61b_model->getReport($this->header_fields, $report_id, $this->client_id, $this->user_id, $this->user_group);

		if ( ! $report) {

			$this->url->redirect(MODULE_URL);

		}

		$title					= $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title		= $title;

		$data					= (array) $report;

		$data['ui']				= $this->ui;

		$data['form_title']		= $title;

		$data['month_name']		= $this->reporting_model->getMonthName($report->report_month);

		$data['month_days']		= $this->reporting_model->getMonthDays($report->report_month, $report->year);

		$data['operation']		= $this->form61b_model->getOperation($report_id);

		$data['form_details']	= $this->form61b_model->getReportDetails($this->detail_fields, $report_id);

		$data['ajax_task']		= 'ajax_edit';

		$data['ajax_post']		= "&report_id=$report_id";



		$this->view->load('form61b/form_61b', $data);

	}



	public function delete($report_id) {

		$report = $this->form61b_model->getReport($this->header_fields, $report_id, $this->client_id, $this->user_id, $this->user_group);

		if ( ! $report) {

			$this->url->redirect(MODULE_URL);

		}

		$title					= $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title		= $title;

		$data					= (array) $report;

		$data['ui']				= $this->ui;

		$data['form_title']		= $title;

		$data['month_name']		= $this->reporting_model->getMonthName($report->report_month);

		$data['month_days']		= $this->reporting_model->getMonthDays($report->report_month, $report->year);

		$data['form_details']	= $this->form61b_model->getReportDetails($this->detail_fields, $report_id);

		$data['ajax_task']		= 'ajax_delete';

		$data['ajax_post']		= "&report_id=$report_id";



		$this->view->load('form61b/form_61b_delete', $data);

	}



	public function view_draft_list() {

		$title = $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title	= $title;

		$data['ui']			= $this->ui;

		$data['form_title']	= $title;

		$data['month_list']	= $this->reporting_model->getMonths();

		$data['year_list']	= $this->reporting_model->getYears();

		$this->view->load('form61b/form_61b_draft_list', $data);

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



		$pagination = $this->reporting_model->getReportList($this->report_form_table, $this->client_id, 'report_month');

		$table = '';   

		if (empty($pagination->result)) {

			$table = '<tr><td colspan="5" class="text-center"><b>No Records Found</b></td></tr>';

		}

		foreach ($pagination->result as $key => $row) {
			$approveddate = "-";
			if($this->date->dateFormat($row->approveddate) != "")
			{
				$approveddate = $this->date->dateFormat($row->approveddate);
			}
			else
			{
				$approveddate = "N/A";
			}

			$approvedby = "-";
			if($row->approvedby != "")
			{
				$approvedby = $row->approvedby;
			}
			else
			{
				$approvedby = "N/A";
			}

			$status = $row->status;
			if($row->status == "Draft" || $row->status == "Temp" || $row->status == "Pending")
			{
				$status = "<b class='text-red'>".$row->status."</b>";
			}
			
			$row_url = BASE_URL ."client_users_mgt/users/report_viewer/".$this->client_id."/form61b/".$row->id;
			$table .= '<tr>';
			$table .= '<td class="text-center">'. ((($pagination->page - 1) * $limit) + $key + 1) .'</td>';
			$table .= '<td class="text-center"><a href="' . $row_url . '">' . $this->reporting_model->getMonthName($row->report_month) . ' ' . $row->year . '</a></td>';
			$table .= '<td class="text-center"><a href="' . $row_url . '">' . $approveddate  . '</a></td>';
			$table .= '<td class="text-center"><a href="' . $row_url . '">' . $approvedby . '</a></td>';
			$table .= '<td class="text-center"><a href="' . $row_url . '">' . $status . '</a></td>';
			$table .= '</tr>';
		}

		$pagination->table = $table;

		return $pagination;

	}



	private function ajax_draft_list() {

		$limit = $this->input->post('limit');



		$pagination = $this->reporting_model->getReportDraftList($this->report_form_table, $this->client_id, 'report_month');

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

			$table .= '<td class="text-center">' . $this->reporting_model->getMonthName($row->report_month) . ' ' . $row->year . '</td>';

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

		$details	= $this->input->post($this->detail_fields);

		$operation	= $this->input->post('operation');

		$details	= array_merge($details, $header);

		$submit		= $this->input->post('submit_type');



		$header['client_id']	= $this->client_id;

		$header['operation']	= $operation;

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



		$result = $this->form61b_model->saveReport($header, $details);



		if ($result && $status == 'Approved') {

			$report_id = $this->form61b_model->getReportId();

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

		$details	= $this->input->post($this->detail_fields);

		$operation	= $this->input->post('operation');

		$details	= array_merge($details, $header);

		$submit		= $this->input->post('submit_type');



		$header['client_id']	= $this->client_id;

		$header['operation']	= $operation;

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



		$result = $this->form61b_model->updateReport($header, $details, $report_id, $this->client_id);



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



		$result = $this->form61b_model->deleteReport($report_id, $this->client_id);



		return array(

			'success'	=> $result,

			'redirect'	=> MODULE_URL . 'view_draft_list'

		);

	}



	private function ajax_check_report() {

		$month = $this->input->post('month');

		$year = $this->input->post('year');



		$result = $this->reporting_model->checkExistingReport($month, $year, $this->report_form_table, $this->client_id);



		return array(

			'existing' => $result

		);

	}



}