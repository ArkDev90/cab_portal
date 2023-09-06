<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->session			= new session();
		$this->gsa_model		= new gsa_model();
		$this->portal			= $this->checkOutModel('home/portal_model');
		$this->fields			= array(
			'company',
			'fname',
			'lname',
			'mname',
			'email',
			'address',
			'contact',
			'username',
			'password'
		);

		$this->edit_fields		= array(
			'fname',
			'lname',
			'mname',
			'company',
			'address',
			'email',
			'contact'
		);
	}

	public function listing() {
		$this->view->title = 'GSA List';
		$data['ui'] = $this->ui;
		$this->view->load('gsa_mgt/gsa_mgt', $data);
	}

	public function view($gsa_user_id) {
		$this->view->title		= 'View GSA';
		$data					= (array) $this->gsa_model->getGSA($this->edit_fields, $gsa_user_id);
		$data['ui']				= $this->ui;
		$data['client_list']	= $this->gsa_model->getGSAClient($gsa_user_id);
		$data['user_id']		= $gsa_user_id;
		$data['show_input']		= false;
		$this->view->load('gsa_mgt/view_gsa', $data);
	}

	public function create() {
		$this->view->title		= 'Create GSA';
		$data['ui']				= $this->ui;
		$data['nature_list']	= $this->gsa_model->getNatureList();
		$data['ajax_task']		= 'ajax_create';
		$data['show_input']		= true;
		$this->view->load('gsa_mgt/create_gsa', $data);
	}

	public function edit($gsa_user_id) {
		$this->view->title		= 'Edit GSA';
		$data					= (array) $this->gsa_model->getGSA($this->edit_fields, $gsa_user_id);
		$data['ui']				= $this->ui;
		$data['client_list']	= $this->gsa_model->getGSAClient($gsa_user_id);
		$data['ajax_task']		= 'ajax_edit';
		$data['ajax_post']		= "&id_ref=$gsa_user_id";
		$data['show_input']		= true;
		$this->view->load('gsa_mgt/view_gsa', $data);
	}

	public function assign_gsa() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('gsa_mgt/assign_gsa', $data);
	}

	public function confirm_gsa() {
		$data['ui'] = $this->ui;
		$data['show_input'] = false;
		$this->view->load('gsa_mgt/confirm_gsa', $data);
	}

	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_create() {
		$data	= $this->input->post($this->fields);
		$client	= $this->input->post('client');
		$nature	= $this->input->post('nature');

		$result	= $this->gsa_model->saveGSA($data, $client, $nature);

		if ($result) {
			$message = "<h4>New GSA Account Created</h4>";
			$message .= "<p><b>Temp Account Login</b></p>";
			$message .= "<p><b>Username :</b> {$data['username']}</p>";
			$message .= "<p><b>Password :</b> {$data['password']}</p>";
			$message .= "You can now logon at <b><a target='_blank' href='http://cab.gov.ph/portal/'>http://cab.gov.ph/portal/</a> - CAB PORTAL </b>";
			$this->portal->sendEmail($message, $data['email']);
		}

		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result,
		);
	}

	private function ajax_edit() {
		$data			= $this->input->post($this->edit_fields);
		$gsa_user_id	= $this->input->post('id_ref');

		$result = $this->gsa_model->updateGSA($data, $gsa_user_id);

		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result,
		);
	}

	private function ajax_get_client() {
		$nature		= $this->input->post('nature');

		$result		= $this->gsa_model->getClientFromNature($nature);

		return array(
			'success'	=> (boolean) $result,
			'result'	=> $result
		);
	}

	private function ajax_list() {
		$search		= $this->input->post('search');
		$limit		= $this->input->post('limit');
		$pagination = $this->gsa_model->getGSAPagination($search);
		$table = '';
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="6" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td style = "text-align:center">'. ((($pagination->page - 1) * $limit) + $key + 1) .'</td>';
			$table .= '<td>' . $row->company . '</td>';
			$table .= '<td><a href="' . MODULE_URL . 'view/' . $row->id . '">' . $row->lname . ', ' . $row->fname . ' ' . $row->mname . '</a></td>';
			$table .= '<td>' . $row->email . '</td>';
			$table .= '<td class="text-center">' . $row->status . '</td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_check_username() {
		$username	= $this->input->post('username');
		$reference	= $this->input->post('username_ref');

		$result		= $this->gsa_model->checkUsername($username, $reference);

		return array(
			'available'	=> $result
		);
	}

}