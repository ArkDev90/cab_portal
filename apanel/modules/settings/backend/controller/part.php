<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->part_model		= new part_model();
		$this->session			= new session();
		$this->fields 			= array(
			'id',
			'type',
			'code',
			'title'
		);
		$this->data = array();
	}

	public function listing() {
		$data['ui'] = $this->ui;
        $data['show_input'] = true;
		$this->view->load('part/part_list', $data);
	}

	public function create() {
		$data = $this->input->post($this->fields);
		$data['ui'] 			= $this->ui;
		$data['ajax_task']		= 'ajax_create';
		$data['ajax_post']		= '';
		$data['show_input'] 	= true;
		$this->view->load('part/part', $data);
	}

	public function edit($id) {
		$data = (array) $this->part_model->getPartById($this->fields, $id);
		$data['ui'] = $this->ui;
		$data['ajax_task'] = 'ajax_edit';
		$data['ajax_post'] = "&id=$id";
		$data['show_input'] = true;
		$this->view->load('part/part', $data);
	}

	public function delete($id) {
		$data = (array) $this->part_model->getPartById($this->fields, $id);
		$data['ui'] = $this->ui;
		$data['ajax_task'] = 'ajax_delete';
		$data['ajax_post'] = "&id=$id";
		$data['show_input'] = false;
		$data['delete_id'] = $id;
		$data['task_delete'] = true;
		$this->view->load('part/part', $data);
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
		$result = $this->part_model->savePart($data);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_edit() {
		$data = $this->input->post($this->fields);
		$id   = $this->input->post('id');
		$result = $this->part_model->updatePart($data, $id);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	private function ajax_delete() {
		$delete_id = $this->input->post('id');			
		$error_id = $this->part_model->deletePart($delete_id);
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $error_id,
			'error_id'	=> $error_id
		);
	}


    private function ajax_part_list() {
		$pagination = $this->part_model->getPart();
		$table = '';
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td align="center">'. $row->code .'</td>';
			$table .= '<td>'. $row->title .'</td>';
			$table .= '<td align="center">'. date('d M Y',strtotime($row->entereddate)) .'</td>';
			$table .= '<td align="center">'.'<a href="'.MODULE_URL.'edit/'.$row->id.'">Edit</a> || <a href="'.MODULE_URL.'delete/'.$row->id.'">Delete</a>'.'</td>';

			$table .= '</tr>';
		}
		
		$pagination->table = $table;
		return $pagination;
	}

}