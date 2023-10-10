<?php

class controller extends wc_controller {



	public function __construct() {

		parent::__construct();

		$this->ui				= new ui();

		$this->input			= new input();

		$this->client_mgt_model	= new client_mgt_model();

		$this->session			= new session();

		$this->portal			= $this->checkOutModel('home/portal_model');

		$this->fields 			= array(

			'id',

			'fname',

			'mname',

			'lname',

			'email',

			'address',

			'country',

			'username',

			'contact',

			'birthday',

			'question_id',

			'answer',

			'designation',

			'status',

			'user_type',

			'entereddate'

		);

		$this->client_fields  	= array(

			'code', 

			'name', 

			'tin_no', 

			'address', 

			'website', 

			'telno',

			'cp_designation',

			'email', 

			'cperson', 

			'cp_contact',

			'postal_code', 

			'faxno', 

			'mobno', 

			'airline_represented', 

			'regdate', 

			'co.country', 

			'status', 

			'temp_username',

			'c.entereddate'

		);

		$this->data = array();

	}



    public function listing($client_id) {

		$this->view->title	= 'Client User List';

		$data				= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

        $data['ui']			= $this->ui;

		$data['client_id']	= $client_id;

		$this->view->load('client_mgt/users', $data);

    }



    public function create_user($client_id) {

		$data['ui'] = $this->ui;

        //$data['user_type']	= array('Form Admin' => 'Form Admin', 'Summary Viewer' => 'Summary Viewer', 'User' => 'User');
	$data['user_type']	= array('Summary Viewer' => 'Summary Viewer', 'User' => 'User');

      
        $data['client_id'] = $client_id;

		$data['ajax_task']	= 'ajax_create_user';

		$data['ajax_post']  = '';

		$data['show_input'] = true;

		$this->view->load('client_mgt/create_user', $data);

    }



	public function edit($id) {

		$data = (array) $this->client_mgt_model->getClientUserDetails($this->fields, $id);

		$company = $this->client_mgt_model->getCompanyName($id);

		$data['company_name'] = $company->name;

		$country = $data['country'];

		$getCountry = $this->client_mgt_model->getCountry($country);

		$data['country'] = $getCountry->country;

		$data['ui'] = $this->ui;

		$data['id'] = $id;

		$data['show_input'] = false;

		$this->view->load('client_mgt/account_info', $data);

	}



	public function edit_profile($id) {

		$data = (array) $this->client_mgt_model->getClientUserDetails($this->fields, $id);

		$data['countries'] = $this->client_mgt_model->getCountryList();

		$data['ui'] = $this->ui;

		$data['show_input'] = true;

		$data['id'] = $id;

		$data['ajax_task'] = 'ajax_edit';

		$data['ajax_post'] = "&id=$id";

		$this->view->load('client_mgt/edit_profile', $data);

	}



	public function edit_login_info($id) {

		$data = (array) $this->client_mgt_model->getClientUserDetails($this->fields, $id);

		$data['ui'] = $this->ui;

		$data['show_input'] = true;

		$data['id'] = $id;

		$data['ajax_task'] = 'ajax_edit_login';

		$data['ajax_post'] = "&id=$id";

		$this->view->load('client_mgt/edit_login_info', $data);

	}



	public function reset_pw($id) {

		$this->fields = array (

            'name',

            'fname',

            'mname',

            'lname',

            'cu.email',

            'user_type'

        );

        $data = (array) $this->client_mgt_model->getClientUserDetailsForPwReset($this->fields, $id);

		$data['ui'] = $this->ui;

		$data['show_input'] = true;

		$data['id'] = $id;

		$client_id = $this->client_mgt_model->getClientId($id);

		$data['client_id'] = $client_id->client_id;

		$data['ajax_task'] = 'ajax_edit_pw';

		$data['ajax_post'] = "&id=$id";

		$this->view->load('client_mgt/user_reset_pw', $data);

	}



	public function reset_uname($id) {

		$this->fields = array (

            'name',

            'fname',

            'mname',

            'lname',

            'cu.email',

            'user_type'

        );

        $data = (array) $this->client_mgt_model->getClientUserDetailsForPwReset($this->fields, $id);

		$data['ui'] = $this->ui;

		$data['show_input'] = true;

		$data['id'] = $id;

		$client_id = $this->client_mgt_model->getClientId($id);

		$data['client_id'] = $client_id->client_id;

		$data['ajax_task'] = 'ajax_edit_uname';

		$data['ajax_post'] = "&id=$id";

		$this->view->load('client_mgt/user_reset_uname', $data);

	}



    public function ajax($task) {

		$ajax = $this->{$task}();

		if ($ajax) {

			header('Content-type: application/json');

			echo json_encode($ajax);

		}

	}



	private function ajax_user_list() {

		$client_id	= $this->input->post('client_id');

		$limit		= $this->input->post('limit');

		$pagination = $this->client_mgt_model->getClientUserList($this->fields, $client_id);

		$table = '';   

		if (empty($pagination->result)) {

			$table = '<tr><td colspan="6" class="text-center"><b>No Records Found</b></td></tr>';

		}

		foreach ($pagination->result as $key => $row) {

			$table .= '<tr>';

			$table .= '<td style = "text-align:center">'. ((($pagination->page - 1) * $limit) + $key + 1) .'</td>';

			$table .= '<td>'.$row->lname.', '.$row->fname.' '.$row->mname.'</td>';

			$table .= '<td>'.$row->designation.'</td>';

			$table .= '<td>'.$row->email.'</td>';

			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'reset_pw/'.$row->id.'"> Reset Password </a> | <a href = "'.MODULE_URL.'edit/'.$row->id.'">Edit Profile </a> | <a href = "'.MODULE_URL.'reset_uname/'.$row->id.'"> Reset Username </a></td>';

			$table .= '<td>'.$row->user_type.'</td>';

			$table .= '</tr>';

		}

		$pagination->table = $table;

		unset($pagination->result);

		return $pagination;

	}



    private function ajax_create_user() {

        $mail					= new PHPMailer(true);

		$fname                  = $this->input->post('fname'); 

        $mname                  = $this->input->post('mname'); 

        $lname                  = $this->input->post('lname');   

        $email                  = $this->input->post('email'); 

        $username               = $this->input->post('username'); 

        $password               = $this->input->post('password'); 

        $client_nature 	        = $this->input->post('client_nature');

		

		$message = "<span style = 'font-face:arial'>Civil Aeronautics Board of the Philippines</span><br>";

		$message .= "<span style = 'font-face:arial'><b>Client Name : </b> $fname </span><br>";

		$message .= "<span style = 'font-face:arial'><b>Email : </b> $email </span><br>";

		$message .= "<span style = 'font-face:arial'><b>Temporary Account Login Profile</b></span><br>";

    	$message .= "<span style = 'font-face:arial'><b>Username : </b> $username </span><br>";

		$message .= "<span style = 'font-face:arial'><b>Password : </b> $password </span><br>";

		$message .= "<span style = 'font-face:arial'>You can now logon at <a target='_blank' href='http://www.cab.gov.ph/portal/'><B>CAB - PORTAL</B></a> and create your Company Profile and Master Administrator</span><br>";

		$message .= "<span style = 'font-face:arial'>or you may copy and paste this url <B>http://www.cab.gov.ph/portal/</B> to the address bar.</span>";

		

		$this->portal->sendEmail($message, $email);

		

		$this->fields 			= array(

			'lname',

			'fname',

			'mname',

			'email',

			'user_type',

			'username',

			'password',

            'client_id'

		);

		$data = $this->input->post($this->fields);

		$result = $this->client_mgt_model->saveClientUser($data);

        if($result == true ) {

			$username = $data['username'];

			$user_id = $this->client_mgt_model->getClientUserId($username);

			$nature_id = $this->client_mgt_model->getNatureId($client_nature);

		}



		$this->nature = array('user_id', 'nature_id');



		$nature = $this->input->post($this->nature);

		$nature['user_id'] = $user_id->id;



		foreach($nature_id as $naturer) :

			$nature['nature_id'] = $naturer->id;

			$save_nature = $this->client_mgt_model->saveClientUserNature($nature);

        endforeach;



		$client_id	= $this->input->post('client_id');

		

        return array(

			'redirect'	=> MODULE_URL. 'listing/' .$client_id,

			'success'	=> $result

		);

	}



	private function ajax_reset_temp_user() {

		$client_id	= $this->input->post('client_id');

		$password	= $this->portal->randomPassword();



		$result		= $this->client_mgt_model->resetClientTempPassword($client_id, $password);

		$client		= $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);



		$message = "<h4>New password has been generated for $client->temp_username</h4>";

		$message .= "<p><b>Account Login</b></p>";

		$message .= "<p><b>Username :</b> $client->temp_username</p>";

		$message .= "<p><b>Password :</b> $password</p>";

		$message .= "You can now logon at <b><a target='_blank' href='http://cab.gov.ph/portal/'>http://cab.gov.ph/portal/</a> - CAB PORTAL </b>";



		if ($result) {

			$this->portal->sendEmail($message, $client_user->email, "CAB Reportorial  Portal : Password Reset for $client_user->username");

		}



		return array(

			'success' => $result

		);



		return array(

			'redirect'	=> MODULE_URL,

			'success'	=> $result

		);

	}



    private function ajax_client_nature_list() {

        $client_id = $this->input->post('client_id');

		$this->fields = array(

			'n.id',

			'title'

		);

		$pagination = $this->client_mgt_model->getClientNatureList($this->fields, $client_id);

		$table = '';   

		if (empty($pagination->result)) {

			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';

		}

		foreach ($pagination->result as $key => $row) {

			$table .= '<tr>';

			$table .= '<td><input type = "checkbox" name = "client_nature[]" id = "client_nature" value = "'.$row->title.'"> '.$row->title.'</td>';

			$table .= '</tr>';

		}

		$pagination->table = $table;

		return $pagination;

	}



	private function ajax_edit() {

		$this->fields = array (

			'fname',

			'mname',

			'lname',

			'email',

			'address',

			'designation',

			'country',

			'contact'

		);

		$data = $this->input->post($this->fields);

		$id   = $this->input->post('id');

		$result = $this->client_mgt_model->updateClientUserProfile($data, $id);

		return array(

			'redirect'	=> MODULE_URL. 'edit/' . $id,

			'success'	=> $result

		);

	}



	private function ajax_edit_login() {

		$this->fields = array (

			'username',

			'birthday'

			// 'question_id',

			// 'answer'

		);

		$this->password = array (

			'password',

		);

		$data = $this->input->post($this->fields);

		$id = $this->input->post('id');

		$current_password = $this->input->post('password');

		$getData = $this->client_mgt_model->getClientUserDetails($this->password, $id);

		if (password_verify($current_password, $getData->password)) {

			$result = $this->client_mgt_model->updateClientUserLoginInfo($data, $id);

			$message = 'Login Information is successfully Updated';

			return array(

				'success'	=> $result,

				'message'	=> $message

			);

		}

		else {

			$message = 'Password is Incorrect';

			return array(

				'success'	=> 'false',

				'message'	=> $message

			);

		}

	}



	private function ajax_edit_uname() {

		$this->fields = array (

			'username',

		);

		$data = $this->input->post($this->fields);

		$id   = $this->input->post('id');

		$client_id   = $this->input->post('client_id');

		$result = $this->client_mgt_model->updateClientUserUname($data, $id);

		return array(

			'redirect'	=> MODULE_URL. 'listing/' . $client_id,

			'success'	=> $result

		);

	}



	private function ajax_edit_pw() {

		$id   = $this->input->post('id');

		$password	= $this->portal->randomPassword();

		$fields = array(

			'username',

			'email'

		);



		$result		= $this->client_mgt_model->resetClientUserPassword($id, $password);

		$client_user  = $this->client_mgt_model->getClientUserDetails($fields, $id);



		$message = "<h4>New password has been generated for $client_user->username</h4>";

		$message .= "<p><b>Account Login</b></p>";

		$message .= "<p><b>Password :</b> $password</p>";

		$message .= "You can now logon at <b><a target='_blank' href='http://cab.gov.ph/portal/'>http://cab.gov.ph/portal/</a> - CAB PORTAL </b>";



		if ($result) {

			$this->portal->sendEmail($message, $client_user->email, "CAB Reportorial  Portal : Password Reset for $client_user->username");

		}



		return array(

			'redirect'	=> MODULE_URL. 'reset_pw/' . $id,

			'success'	=> $result

		);

	}



	private function ajax_check_user_uname() {

		$username	= $this->input->post('username');

		$result = $this->client_mgt_model->checkUserUname($username);

		return array(

			'available'	=> $result

		);

	}



}