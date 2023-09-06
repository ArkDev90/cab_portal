<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->reports_model	= new reports_model();
		$this->session			= new session();
		$this->fields 			= array(
			'id',
			'client_id',
			'report_quarter',
			'year',
			'status'
		);
	}

	public function listing() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('form_51a/form_51a_list', $data);
	}

	public function view() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('form_51a/report_viewer', $data);
	}

    public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

    public function ajax_list()
	{
		
		$pagination = $this->reports_model->getForm51a($this->fields);
	
		$table = '';
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			if($row->report_quarter == 'quarter_1'){$row->report_quarter = '1st Quarter (Jan,Feb,Mar)';}
			else if($row->report_quarter == 'quarter_2'){$row->report_quarter = '2nd Quarter (Apr,May,Jun)';}
			else if($row->report_quarter == 'quarter_3'){$row->report_quarter = '3rd Quarter (Jul,Aug,Sep)';}
			else if($row->report_quarter == 'quarter_4'){$row->report_quarter = '4th Quarter (Oct,Nov,Dec)';}
			
			$table .= '<tr>';
			$table .= '<td align="center">'. $row->code .'</td>';
			$table .= '<td align="center">'. $row->name .'</td>';
			$table .= '<td align="center">'. 'Traffic Flow - Quarterly Report on Scheduled International Services' .'</td>';
			$table .= '<td align="center">'. $row->report_quarter .'</td>';
			$table .= '<td align="center">'. $row->year .'</td>';
			$table .= '<td align="center">'. date("M j, Y",strtotime($row->entereddate)) .'</td>';
			$table .= '<td align="center">'. '<a href="'.BASE_URL.'form51_a/view/'.$row->id.'">View</a>' .'</td>';
			
			$table .= '</tr>';

		}
		
		

		$pagination->table = $table;
		return $pagination;
	}

}