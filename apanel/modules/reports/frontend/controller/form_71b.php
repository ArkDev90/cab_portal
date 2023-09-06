<?php

class controller extends wc_controller {



	public function __construct() {

		parent::__construct();

		$this->ui					= new ui();

		$this->url					= new url();

		$this->input				= new input();

		$this->session				= new session();

		$this->form71b_model		= new form71b_model();

		$this->reporting_model		= new reporting_model();

		$this->portal				= $this->checkOutModel('home/portal_model');

		$login						= $this->session->get('login');

		$this->client_id			= $login['client_id'];

		$this->user_name			= $login['name'];

		$this->user_id				= $login['id'];

		$this->user_group			= $login['groupname'];

		$this->report_form_table	= 'form71b';

		$this->report_form_id		= '310';

		

		$this->header_fields		= array(

			'year',

			'report_month'

		);

		$this->detail_fields		= array(

			'aircraft',

			'origin',

			'destination',

			'numMawbs',

			'weight',

			'fcharge',

			'commission'

		);

		$this->detail_fields2		= array(

			'c_aircraft'	=> 'aircraft',

			'c_destination'	=> 'destination',

			'c_numMawbs'	=> 'numMawbs',

			'c_numHawbs1'	=> 'numHawbs1',

			'c_weight'		=> 'weight',

			'c_revenue'		=> 'revenue',

			'c_fcharge'		=> 'fcharge',

		);

		$this->detail_fields3		= array(

			'b_origin'		=> 'origin',

			'b_numHawbs2'	=> 'numHawbs2',

			'b_orgWeight'	=> 'orgWeight',

			'b_incomeBreak'	=> 'incomeBreak',

		);

		$this->detail_fields4		= array(

			'serialnum',

			'excluded'

		);

	}



	public function listing() {

		$title = $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title		= $title;

		$data['ui']				= $this->ui;

		$data['form_title']		= $title;

		$data['month_list']	= $this->reporting_model->getMonths();

		$data['year_list']		= $this->reporting_model->getYears();

		$this->view->load('form71b/form_71b_list', $data);

	}



	public function create($year = 0, $month = 0) {

		if ( ! $this->reporting_model->checkValidDate($year, $month)) {

			$this->url->redirect(MODULE_URL);

		}

		if ($this->reporting_model->checkExistingReport($month, $year, $this->report_form_table, $this->client_id)) {

			$this->url->redirect(MODULE_URL);

		}

		$title						= $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title			= $title;

		$data['ui']					= $this->ui;

		$data['form_title']			= $title;

		$data['month_name']			= $this->reporting_model->getMonthName($month);

		$data['month_days']			= $this->reporting_model->getMonthDays($month, $year);

		$data['domestic_list']		= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'Domestic');

		$data['international_list']	= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'International');

		$data['report_month']		= $month;

		$data['year']				= $year;

		$data['serialnum']			= '';

		$data['excluded']			= '';

		$data['ajax_task']			= 'ajax_create';

		$data['ajax_post']			= '';



		$this->view->load('form71b/form_71b', $data);

	}



	public function edit($report_id) {

		$report = $this->form71b_model->getReport($this->header_fields, $report_id, $this->client_id, $this->user_id, $this->user_group);

		if ( ! $report) {

			$this->url->redirect(MODULE_URL);

		}

		$title						= $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title			= $title;

		$data						= (array) $report;

		$data['ui']					= $this->ui;

		$data['form_title']			= $title;

		$data['month_name']			= $this->reporting_model->getMonthName($report->report_month);

		$data['month_days']			= $this->reporting_model->getMonthDays($report->report_month, $report->year);

		$data['domestic_list']		= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'Domestic');

		$data['international_list']	= $this->reporting_model->getOriginDestinationList($this->report_form_id, 'International');

		$data['form_details']		= $this->form71b_model->getReportDetails($this->detail_fields, $report_id);

		$data['form_details2']		= $this->form71b_model->getReportDetails2($this->detail_fields2, $report_id);

		$data['form_details3']		= $this->form71b_model->getReportDetails3($this->detail_fields3, $report_id);

		$data['ajax_task']			= 'ajax_edit';

		$data['ajax_post']			= "&report_id=$report_id";



		$this->view->load('form71b/form_71b', $data);

	}



	public function delete($report_id) {

		$report = $this->form71b_model->getReport($this->header_fields, $report_id, $this->client_id, $this->user_id, $this->user_group);

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

		$data['form_details']	= $this->form71b_model->getReportDetails($this->detail_fields, $report_id);

		$data['form_details2']	= $this->form71b_model->getReportDetails2($this->detail_fields2, $report_id);

		$data['form_details3']	= $this->form71b_model->getReportDetails3($this->detail_fields3, $report_id);

		$data['ajax_task']		= 'ajax_delete';

		$data['ajax_post']		= "&report_id=$report_id";



		$this->view->load('form71b/form_71b_delete', $data);

	}



	public function view_draft_list() {

		$title = $this->reporting_model->getFormTitle($this->report_form_id);

		$this->view->title	= $title;

		$data['ui']			= $this->ui;

		$data['form_title']	= $title;

		$this->view->load('form71b/form_71b_draft_list', $data);

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
			
			$row_url = BASE_URL ."client_users_mgt/users/report_viewer/".$this->client_id."/form71b/".$row->id;
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

		$details2	= $this->get_merge_details();

		$details3	= $this->input->post($this->detail_fields4);

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



		$result = $this->form71b_model->saveReport($header, $details, $details2, $details3);



		if ($result && $status == 'Approved') {

			$report_id = $this->form71b_model->getReportId();

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

		$details2	= $this->get_merge_details();

		$details3	= $this->input->post($this->detail_fields4);

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



		$result = $this->form71b_model->updateReport($header, $details, $details2, $details3, $report_id, $this->client_id);



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



		$result = $this->form71b_model->deleteReport($report_id, $this->client_id);



		return array(

			'success'	=> $result,

			'redirect'	=> MODULE_URL . 'view_draft_list'

		);

	}



	private function ajax_check_report() {

		$month	= $this->input->post('month');

		$year		= $this->input->post('year');



		$result = $this->reporting_model->checkExistingReport($month, $year, $this->report_form_table, $this->client_id);



		return array(

			'existing' => $result

		);

	}



	private function get_merge_details() {

		$defaults	= array(

			'aircraft'		=> '',

			'destination'	=> '',

			'numMawbs'		=> '0',

			'numHawbs1'		=> '0',

			'weight'		=> '0',

			'revenue'		=> '0',

			'fcharge'		=> '0',

			'origin'		=> '',

			'numHawbs2'		=> '0',

			'orgWeight'		=> '0',

			'incomeBreak'	=> '0',

		);

		$data	= $this->input->post(array_merge($this->detail_fields2, $this->detail_fields3));



		$max_count = 0;



		foreach ($data as $row) {

			$max_count = (count($row) > $max_count) ? count($row) : $max_count;

		}

		

		foreach ($data as $key => $row) {

			$y = is_array($row) ? count($row) : 0;

			if ($y < $max_count) {

				for ($x = $y; $x < $max_count; $x++) {

					$data[$key][] = $defaults[$key];

				}

			}

		}

		

		return $data;

	}



}