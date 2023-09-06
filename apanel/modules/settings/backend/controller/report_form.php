<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->report_form_model	= new report_form_model();
		$this->session			= new session();
		$this->fields 			= array(
			'id',
			'code',
			'title',
			'start_date',
			'expiration_days',
			'expiration_months'
		);
		$this->data = array();
	}

	public function listing() {
		$data['ui'] = $this->ui;
		$this->view->load('report_form/report_list', $data);
	}

	public function edit($id) {
		$data = (array) $this->report_form_model->getReportFormById($this->fields, $id);
		$data['ui'] = $this->ui;
		$data['ajax_task'] = 'ajax_edit';
		$data['ajax_post'] = "&id=$id";
		$data['show_input'] = true;
		$this->view->load('report_form/report_form', $data);
	}

	public function report_expiration() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_form/report_expiration', $data);
	}

	public function report_start_date() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_form/report_start_date', $data);
	}

    public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

    private function ajax_report_list() {
		$pagination = $this->report_form_model->getReportFormList($this->fields);
		$table = '';   
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td>'.$row->title.'</td>';
            $table .= '<td>'.$row->code.'</td>';
            $table .= '<td style = "text-align:center">Daily</td>';
            $table .= '<td style = "text-align:center">'.$row->start_date.'</td>';
            $table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'edit/'.$row->id.'">Edit</a></td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_edit() {
		$data = $this->input->post($this->fields);
		$date   = $this->input->post('start_date');
		$newDate = date("Y-m-d", strtotime($date));
		$data['start_date'] = $newDate;
		$id   = $this->input->post('id');
		$result = $this->report_form_model->updateReportForm($data, $id);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_edit_startdate() {
		$values = array('start_date');
		$date   = $this->input->post('start_date');
		$newDate = date("Y-m-d", strtotime($date));
		$vals = $this->input->post($values);
		$vals['start_date'] = $newDate;
		$result = $this->report_form_model->updateStartDate($vals);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}
	
	private function ajax_edit_report_expiration() {
		$values = array('expiration_days, expiration_months');
		$days   = $this->input->post('days');
		$months = $this->input->post('month');
		
		$vals['expiration_days'] = $days;
		$vals['expiration_months'] = $months;
		$result = $this->report_form_model->updateExpirationDate($vals);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

}