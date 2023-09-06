<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->operations_model	= new operations_model();
		$this->session			= new session();
		$this->fields 			= array(
			'title'
		);
		$this->data = array();
	}

	public function listing() {
		$data['ui'] = $this->ui;
		$this->view->load('operations/operations_list', $data);
	}

	public function create() {
		$data				= $this->input->post($this->fields);
		$data['ui'] 		= $this->ui;
		$data['ajax_task']	= 'ajax_create';
		$data['ajax_post']	= '';
		$data['show_input'] = true;
		$this->view->load('operations/operation', $data);
	}

	public function edit($id) {
		$data = (array) $this->operations_model->getNatureById($this->fields, $id);
		$data['ui'] = $this->ui;
		$data['ajax_task']		= 'ajax_edit';
		$data['ajax_post'] = "&id=$id";
		$data['show_input'] = true;
		$this->view->load('operations/operation', $data);
	}

	public function delete($id) {
		$data = (array) $this->operations_model->getNatureById($this->fields, $id);
		$data['ui'] = $this->ui;
		$data['ajax_task'] = 'ajax_delete';
		$data['ajax_post'] = "&id=$id";
		$data['show_input'] = false;
		$data['delete_id'] = $id;
		$data['task_delete'] = true;
		$this->view->load('operations/operation', $data);
	}

    public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_operation_list() {
		$pagination = $this->operations_model->getNatureOperation();
		$table = '';   
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td>'.$row->title.'</td>';
			$table .= '<td>'.$this->date->dateTimeFormat($row->entereddate).'</td>';
			$table .= '<td><a href = "'.MODULE_URL.'edit/'.$row->id.'">Edit</a> | <a href = "'.MODULE_URL.'delete/'.$row->id.'">Delete</a></td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_create() {
		$data = $this->input->post($this->fields);
		$result = $this->operations_model->saveOperation($data);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_edit() {
		$data = $this->input->post($this->fields);
		$id   = $this->input->post('id');
		$result = $this->operations_model->updateNatureofOperation($data, $id);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_delete() {
		$id = $this->input->post('id');			
		$error_id = $this->operations_model->deleteNatureofOperation($id);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $error_id,
			'error_id'	=> $error_id
		);
	}

	private function ajax_check_title() {
		$title	= $this->input->post('title');
		$result = $this->operations_model->checkTitle($title);
		return array(
			'available'	=> $result
		);
	}

}