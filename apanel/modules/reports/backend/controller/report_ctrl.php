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
			'title'
		);
		$this->data = array();
	}

	public function listing() {
		$data['report'] = $this->reports_model->getNatureList();
		$data['ui'] = $this->ui;
		$this->view->load('reportcontrol', $data);
	}

	public function view($id) {
		$data = (array) $this->reports_model->getNatureById($this->fields, $id);
		$data['report_list'] = $this->reports_model->getReportId($id);
		$this->view->title = 'Cargo Sales Agent';
		$data['ui'] = $this->ui;
		$data['ajax_post'] = '&id=' + $id;
		$data['show_input'] = true;
		$this->view->load('view', $data);
	}

    public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

    private function ajax_operation_list() {
		$id = $this->input->post('id');
		$formid = $this->reports_model->getReportId($id);

		$table = '';
		if (empty($formid)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}

		foreach ($formid as $key => $row) {
			$table .= '<tr>';
			$table .= '<td><input ' . (($row->report_form_id) ? 'checked': '') . ' name="reports[]"  id="reports" value="'.$row->id.'" type="checkbox"><span id="asd"><b> '.$row->code.'</b> - '.$row->title.'</div></td>';
			
			$table .= '</tr>';
		}
		
		return array('table' => $table);
	}

	private function ajax_save() {
		$id 			= $this->input->post('id');
		$report 		= $this->input->post('report');
		$nice = explode(',' , $report);

		$result = $this->reports_model->saveReportForm($id);

		$nature = array('nature_id', 'report_form_id');
		$naturist = $this->input->post($nature);
		$naturist['nature_id'] = $id;
		$naturist['report_form_id'] = $nice;

		$savist = $this->reports_model->saveNatureRepForm($naturist);
 		
		
		
		return array(
			'redirect'	=> MODULE_URL. 'view/' .$id,
			'success'	=> $result
		); 
	}


}

			