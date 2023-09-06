<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui						= new ui();
		$this->input					= new input();
		$this->origin_destination_model	= new origin_destination_model();
		$this->session					= new session();
		$this->fields 					= array(
			'id',
			'title',
			'code',
			'type',
			'part'
		);
		$this->data = array();
	}

	public function listing() {
		$data['ui'] = $this->ui;
		// $all = (object) array('ind' => 'null', 'val' => 'Filter: All');
		$data['reports'] = $this->origin_destination_model->getReportForms('');
		// $data['domestic_list'] = array_merge(array($all),  $this->origin_destination_model->getDomesticList(''));
		// $data['international_list'] = array_merge(array($all),  $this->origin_destination_model->getInternationalList(''));
        $data['show_input'] = true;
		$this->view->load('origin_destination/origin_destination_list', $data);
	}

	public function create() {
		$data = $this->input->post($this->fields);
		$data['origin_list'] = $this->origin_destination_model->getFormList();
		$data['ui'] 			= $this->ui;
		$data['domestic_list']  = $this->origin_destination_model->getDomesticList('');
		$data['international_list'] = $this->origin_destination_model->getInternationalList('');
		$data['ajax_task']		= 'ajax_create';
		$data['ajax_post']		= '';
		$data['show_input'] 	= true;
		$this->view->load('origin_destination/origin_destination', $data);
	}
	
	public function edit($id) {
		$data = (array) $this->origin_destination_model->getOriginById($this->fields, $id);
		$data['origin_list'] = $this->origin_destination_model->getFormId($id);
		$data['origin_destination_id'] 		= $id;
		$data['ui'] = $this->ui;
		$data['domestic_list']  = $this->origin_destination_model->getDomesticList('');
		$data['international_list'] = $this->origin_destination_model->getInternationalList('');
		$data['ajax_task'] = 'ajax_edit';
		$data['ajax_post'] = "&id=$id";
		$data['show_input'] = true;
		$this->view->load('origin_destination/origin_destination', $data);
	}

	public function delete($id) {
		$data = (array) $this->origin_destination_model->getOriginById($this->fields, $id);
		$data['origin_list'] = $this->origin_destination_model->getFormId($id);
		$data['ui'] = $this->ui;
		$data['domestic_list']  = $this->origin_destination_model->getDomesticList('');
		$data['international_list'] = $this->origin_destination_model->getInternationalList('');
		$data['ajax_task'] = 'ajax_delete';
		$data['ajax_post'] = "&id=$id";
		$data['show_input'] = false;
		$data['delete_id'] = $id;
		$data['task_delete'] = true;
		$this->view->load('origin_destination/origin_destination', $data);
	}

    public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_create() {
		$data = $this->input->post($this->fields);
		$origin = $this->input->post('origin');
		$orig = explode(',' , $origin);

		$result = $this->origin_destination_model->saveOrigin($data);

		$code = $data['code'];
		$odi = $this->origin_destination_model->getFormByCode($code);


		$this->form = array('origin_destination_id', 'report_form_id');

		$form = $this->input->post($this->form);
		$form['origin_destination_id'] = $odi->id;

		$form['report_form_id'] = $orig;
		$form_insert = $this->origin_destination_model->saveForm($form);

		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_edit() {
		$data 	= $this->input->post($this->fields);
		$id   	= $this->input->post('id');
		$check 	= $this->input->post('check');
		$result = $this->origin_destination_model->updateOrigin($data, $id);

		$insert = $this->origin_destination_model->saveReportFormId($check, $id);

		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_delete() {
		$delete_id = $this->input->post('id');			
		$error_id = $this->origin_destination_model->deleteOrigin($delete_id);
		return array(
			'redirect' 	=> MODULE_URL,
			'success'	=> $error_id,
			'error_id'	=> $error_id
			);
	}

    private function ajax_origin_destination_list() {
		$sort  = $this->input->post('sort');
		$pagination = $this->origin_destination_model->getOrigin($this->fields, $sort);
		$table = '';
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td>'. $row->code .'</td>';
			$table .= '<td align="center">'. $row->title .'</td>';
			$table .= '<td align="center">'. $row->type .'</td>';
			$table .= '<td align="center">'. $row->part .'</td>';
			$table .= '<td align="center">'. date('d M Y',strtotime($row->entereddate)) .'</td>';
			$table .= '<td align="center">'.'<a href="'.MODULE_URL.'edit/'.$row->id.'">Edit</a> || <a href="'.MODULE_URL.'delete/'.$row->id.'">Delete</a>'.'</td>';

			$table .= '</tr>';
		}
		
		$pagination->table = $table;
		return $pagination;
	}

    private function ajax_form_list() {
		$id = $this->input->post('id');
		// $pagination = $this->origin_destination_model->getFormList($this->fields);
		$formid = $this->origin_destination_model->getFormId($id);
		
		$table = '';
		if (empty($formid)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}
		
		foreach ($formid as $key => $row) {
			$table .= '<tr>';
			$table .= '<td><input id = "check" type="checkbox" name = "check[]" value="'.$row->id.'"> '. $row->title .'</td>';
			$table .= '</tr>';
		}
		
		return array('table' => $table);
	}

}