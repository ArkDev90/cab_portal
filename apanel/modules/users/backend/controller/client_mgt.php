<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->client_mgt_model	= new client_mgt_model();
		$this->session			= new session();
		$this->portal			= $this->checkOutModel('home/portal_model');
		$session				= new session();
		$login					= $session->get('login');
		$this->username			= $login['username'];

		$this->fields 			= array(
			'id',
			'code',
			'name',
			'email',
			'airline_represented',
			'temp_username'
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
			'country', 
			'status', 
			'temp_username',
			'entereddate'
		);
		
		$this->data = array();
	}

	public function listing() {
		$this->view->title = 'Client List';
		$natureids = $this->client_mgt_model->getNatureList($this->username);
		$data['ui'] = $this->ui;
		$data['nature_list'] = $this->client_mgt_model->getNatureOfOperationListDropdown($natureids);
		$this->view->load('client_mgt/client_mgt', $data);
	}

    public function create() {
		$data['ui'] = $this->ui;
		$data['ajax_task']		= 'ajax_create';
		$data['ajax_post']		= '';
		$data['show_input'] = true;
		$this->view->load('client_mgt/create_client', $data);
	}

	public function edit($client_id) {
		$username = $this->client_mgt_model->getTempUsername($client_id);
		$data['ui']				= $this->ui;
		$data['temp_username']	= $username;
		$data['ajax_task']		= 'ajax_edit';
		$data['ajax_post']		= "&temp_username_ref=$username&client_id=$client_id";
		$data['show_input'] = true;
		$this->view->load('client_mgt/edit_client', $data);
	}

	public function client_info($client_id) {
		$this->view->title	= 'Client Information';
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['country_list']	= $this->client_mgt_model->getCountryList();
		$data['regdate']		= $this->date->dateTimeFormat($data['regdate']);
		$data['ui']				= $this->ui;
		$data['client_id']		= $client_id;
		$data['show_input']		= false;
		$this->view->load('client_mgt/client_info', $data);
	}

	public function client_info_edit($client_id) {
		$this->view->title	= 'Client Information';
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['country_list']	= $this->client_mgt_model->getCountryList();
		$data['regdate']		= $this->date->dateTimeFormat($data['regdate']);
		$data['ui']				= $this->ui;
		$data['client_id']		= $client_id;
		$data['ajax_task']		= 'ajax_edit';
		$data['ajax_post']		= "&client_id=$client_id";
		$data['show_input']		= true;
		$this->view->load('client_mgt/client_info', $data);
	}

	public function update_operation_status() {
		$data['ui'] = $this->ui;
		$data['show_input'] = false;
		$this->view->load('client_mgt/update_operation_status', $data);
	}

	public function add_operation($client_id) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['ajax_task']		= 'ajax_add_operation';
		$data['ajax_post']		= "&client_id=$client_id";
		$data['show_input'] 	= false;
		$this->view->load('client_mgt/add_operation', $data);
	}

	public function change_status($client_id) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['ajax_task']		= 'ajax_update_status';
		$data['ajax_post']		= "&client_id=$client_id";
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/change_status', $data);
	}

	public function reports($client_id) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/reports', $data);
	}

	public function approved_reports($db_table) {
		$data['ui']			= $this->ui;
		$data['show_input'] 	= true;
		$data['db_table']	= $db_table;
		$this->view->load('client_mgt/view_approved_reports', $data);
	}

	private function ajax_reset_temp_user() {
		
		
		$client_id	= $this->input->post('client_id');
		$username	= $this->input->post('temp_username');
		$password	= $this->portal->randomPassword();
		$fields		= array('temp_username', 'email');

		$result		= $this->client_mgt_model->resetClientTempUsername($client_id, $username);
		$result		= $this->client_mgt_model->resetClientTempPassword($client_id, $password);
		$client		= $this->client_mgt_model->getClientInfo($fields, $client_id);

		$message = "<h4>New password has been generated for $client->temp_username</h4>";
		$message .= "<p><b>Account Login</b></p>";
		$message .= "<p><b>Username :</b> $client->temp_username</p>";
		$message .= "<p><b>Password :</b> $password</p>";
		$message .= "You can now logon at <b><a target='_blank' href='http://cab.gov.ph/portal/'>http://cab.gov.ph/portal/</a> - CAB PORTAL </b>";

		if ($result) {
			$this->portal->sendEmail($message, $client->email);
		}
		
		return array(
			'success'	=> $result,
			'username'	=> $client->temp_username,
			'email'		=> $client->email,
			'redirect'	=> BASE_URL . 'client_mgt/users/listing/'. $client_id
		);
		


		
	}

	private function ajax_view_approved_reports() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$db_table = $this->input->post('db_table');
		$data		= $this->input->post(array('month', 'year','sort'));
		$month		= $data['month'];
		$year		= $data['year'];
		$sort		= $data['sort'];		
		
		$pagination = $this->client_mgt_model->getApprovedReportList1($db_table, $month, $year,$client_id, $month, $year, $sort);
		
		$table = '';   
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="7" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $row) {
			$submitteddate=date_create($row->submitteddate);
			$submitteddate = date_format($submitteddate,"d M Y");
			$approveddate=date_create($row->approveddate);
			$approveddate = date_format($approveddate,"d M Y");
			
			$table .= '<tr>';
			$table .= '<td align="center">'.$row->code.'</td>';
			$table .= '<td align="center">'.$row->name.'</td>';
			if($db_table == 'form51a'){$table .= '<td align="center">'.'Traffic Flow - Quarterly Report on Scheduled International Services'.'</td>';}
			elseif($db_table == 'form51b'){$table .= '<td align="center">'.'Monthly International Cargo Traffic Flow'.'</td>';}
			elseif($db_table == 'form61a'){$table .= '<td align="center">'.'Monthly Statement of Traffic and Operating Statistics (Agricultural Aviation)'.'</td>';}
			elseif($db_table == 'form61b'){$table .= '<td align="center">'.'Monthly Statement of Traffic and Operating Statistics'.'</td>';}
			elseif($db_table == 'form71a'){$table .= '<td align="center">'.'International Airfreight Forwarder Cargo Production Report'.'</td>';}
			elseif($db_table == 'form71b'){$table .= '<td align="center">'.'Domestic Airfreight Forwarder Cargo Production Report'.'</td>';}
			elseif($db_table == 'form71c'){$table .= '<td align="center">'.'Cargo Sales Agency Report'.'</td>';}
			elseif($db_table == 'formt1a'){$table .= '<td align="center">'.'Domestic Sector Load Report'.'</td>';}
			if($db_table == 'form51a'){
			if($row->timespan == '1'){$row->timespan = '1st Quarter';}
			else if($row->timespan == '2'){$row->timespan = '2nd Quarter';}
			else if($row->timespan == '3'){$row->timespan = '3rd Quarter';}
			else if($row->timespan == '4'){$row->timespan = '4th Quarter';}
		$table .= '<td align="center">'.$row->timespan.'</td>';
		}else{
			if($row->timespan == '1'){$row->timespan = 'January';}
			else if($row->timespan == '2'){$row->timespan = 'February';}
			else if($row->timespan == '3'){$row->timespan = 'March';}
			else if($row->timespan == '4'){$row->timespan = 'April';}
			else if($row->timespan == '5'){$row->timespan = 'May';}
			else if($row->timespan == '6'){$row->timespan = 'June';}
			else if($row->timespan == '7'){$row->timespan = 'July';}
			else if($row->timespan == '8'){$row->timespan = 'August';}
			else if($row->timespan == '9'){$row->timespan = 'September';}
			else if($row->timespan == '10'){$row->timespan = 'October';}
			else if($row->timespan == '11'){$row->timespan = 'November';}
			else if($row->timespan == '12'){$row->timespan = 'December';}
			$table .= '<td align="center">'.$row->timespan.'</td>';
		}
			$table .= '<td>'.$row->year.'</td>';
			$table .= '<td align="center">'.$submitteddate.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'report_viewer/'.$row->client_id.'/'.$db_table.'/'.$row->id.'">View Approved</a></td>';		
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}
	

	public function latereports($client_id) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/latereports', $data);
	}

	public function view_report_list($client_id, $db_table) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['db_table'] 		= $db_table;
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/view_report_list', $data);
	}

	public function cancel_report($client_id, $db_table, $id) {
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['db_table'] 		= $db_table;
		$data['id'] 			= $id;
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/cancel_report', $data);
	}

	public function view_late_report_list($client_id, $db_table) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['db_table'] 		= $db_table;
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/view_late_report_list', $data);
	}

	public function report_viewer($client_id, $db_table, $id, $serial = '') {
		$this->show_report($client_id, $db_table, $id, $serial);
	}

	public function report_download($client_id, $db_table, $id, $serial = '') {
		$this->show_report($client_id, $db_table, $id, $serial, true);
	}

	private function show_report($client_id, $db_table, $report_id, $serial = '', $print = false) {
		$session 				= new session();
		$report_model			= $this->checkOutModel('reports/reporting_model');
		$login 					= $session->get('login');
		$data					= (array) $report_model->getClientInfo($client_id);
		$data['report_id'] 		= $report_id;
		$data['client_id'] 		= $client_id;
		$data['db_table'] 		= $db_table;
		$data['user_type']		= $login['groupname'];
		$data['user_id']  		= $login['id'];

		$form_name = $db_table;

		if ($db_table == 'form51a') {
			$form51a				= $report_model->getForm51a($report_id, $client_id);
			$data					= array_merge($data, $form51a);
			$period					= $data['report_quarter'];
			$data['quarter_months']	= $report_model->quarterMonths($period);
			$data['report_name']	= 'FORM 51-A : Traffic Flow - Quarterly Report on Scheduled International Services';
			$data['listing_url']	= '123123123';
		} else if ($db_table == 'form51b') {
			$form51b				= $report_model->getForm51b($report_id, $client_id);
			$data					= array_merge($data, $form51b);
			$period					= $data['report_month'];
			$data['report_name']	= 'FORM 51-B : Monthly International Cargo Traffic Flow';
			$data['listing_url']	= '123123123';
		} else if ($db_table == 'form61a') {
			$form61a				= $report_model->getForm61a($report_id, $client_id);
			$data					= array_merge($data, $form61a);
			$period					= $data['report_month'];
			$data['report_name']	= 'FORM 61-A : Monthly Statement of Traffic and Operating Statistics (Agricultural Aviation)';
			$data['listing_url']	= '123123123';
		} else if ($db_table == 'form61b') {
			$form61b				= $report_model->getForm61b($report_id, $client_id);
			$data					= array_merge($data, $form61b);
			$period					= $data['report_month'];
			$data['report_name']	= 'FORM 61-B : Monthly Statement of Traffic and Operating Statistics';
			$data['listing_url']	= '123123123';
		} else if ($db_table == 'form71a') {
			if ($serial == 'serial') {
				$form71a			= $report_model->getForm71aSerial($report_id, $client_id);
				$form_name			= 'serial_number';
			} else {
				$form71a			= $report_model->getForm71a($report_id, $client_id);
			}
			$data					= array_merge($data, $form71a);
			$period					= $data['report_month'];
			$data['report_name']	= 'FORM 71-A : International Airfreight Forwarder Cargo Production Report';
			$data['listing_url']	= '123123123';
		} else if ($db_table == 'form71b') {
			if ($serial == 'serial') {
				$form71b			= $report_model->getForm71bSerial($report_id, $client_id);
				$form_name			= 'serial_number';
			} else {
				$form71b			= $report_model->getForm71b($report_id, $client_id);
			}
			$data					= array_merge($data, $form71b);
			$period					= $data['report_month'];
			$data['report_name']	= 'FORM 71-B : Domestic Airfreight Forwarder Cargo Production Report';
			$data['listing_url']	= '123123123';
		} else if ($db_table == 'form71c') {
			$form71c				= $report_model->getForm71c($report_id, $client_id);
			$data					= array_merge($data, $form71c);
			$period					= $data['report_month'];
			$data['report_name']	= 'FORM 71-C : Cargo Sales Agency Report';
			$data['listing_url']	= '123123123';
		} else if ($db_table == 'formt1a') {
			$formt1a				= $report_model->getFormT1a($report_id, $client_id);
			$data					= array_merge($data, $formt1a);
			$period					= $data['report_month'];
			$data['report_name']	= 'FORM T-1A : Domestic Sector Load Report';
			$data['listing_url']	= '123123123';
		}
		$data['template_name']  = $form_name . '_tables';
		$data['period'] = $report_model->getPeriod($period, $db_table);
		if ($print) {
			$this->view->load('client_mgt/print_header', array(), false);
		}
		$this->view->load('client_mgt/report_viewer', $data, ! $print);
		if ($print) {
			$this->view->load('client_mgt/print_footer', array(), false);
		}
	}

	public function view_71b_serialnum($client_id, $db_table,$id) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id, $id);
		$timespan				= $this->client_mgt_model->getReportTimespan($id, $db_table);
		$data['month']			= $timespan->month;
		$data['year']			= $timespan->year;
		$data['ui'] 			= $this->ui;
		$data['id'] 			= $id;
		$data['client_id'] 		= $client_id;
		$data['db_table'] 		= $db_table;
		if ($timespan->month == '1') {$data['month'] = 'January';}
		else if ($timespan->month == '2') {$data['month'] = 'February';}
		else if ($timespan->month == '3') {$data['month'] = 'March';}
		else if ($timespan->month == '4') {$data['month'] = 'April';}
		else if ($timespan->month == '5') {$data['month'] = 'May';}
		else if ($timespan->month == '6') {$data['month'] = 'June';}
		else if ($timespan->month == '7') {$data['month'] = 'July';}
		else if ($timespan->month == '8') {$data['month'] = 'August';}
		else if ($timespan->month == '9') {$data['month'] = 'September';}
		else if ($timespan->month == '10') {$data['month'] = 'October';}
		else if ($timespan->month == '11') {$data['month'] = 'November';}
		else if ($timespan->month == '12') {$data['month'] = 'December';}
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/71b_serial_num', $data);
	}

	public function view_71a_serialnum($client_id, $db_table,$id) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id, $id);
		$timespan				= $this->client_mgt_model->getReportTimespan($id, $db_table);
		$data['month']			= $timespan->month;
		$data['year']			= $timespan->year;
		$data['ui'] 			= $this->ui;
		$data['id'] 			= $id;
		$data['client_id'] 		= $client_id;
		$data['db_table'] 		= $db_table;
		if ($timespan->month == '1') {$data['month'] = 'January';}
		else if ($timespan->month == '2') {$data['month'] = 'February';}
		else if ($timespan->month == '3') {$data['month'] = 'March';}
		else if ($timespan->month == '4') {$data['month'] = 'April';}
		else if ($timespan->month == '5') {$data['month'] = 'May';}
		else if ($timespan->month == '6') {$data['month'] = 'June';}
		else if ($timespan->month == '7') {$data['month'] = 'July';}
		else if ($timespan->month == '8') {$data['month'] = 'August';}
		else if ($timespan->month == '9') {$data['month'] = 'September';}
		else if ($timespan->month == '10') {$data['month'] = 'October';}
		else if ($timespan->month == '11') {$data['month'] = 'November';}
		else if ($timespan->month == '12') {$data['month'] = 'December';}
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/71a_serial_num', $data);
	}

	public function history($client_id) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/history', $data);
	}

	public function view_history_list($client_id, $db_table) {
		$data					= (array) $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);
		$data['ui'] 			= $this->ui;
		$data['client_id'] 		= $client_id;
		$data['db_table'] 		= $db_table;
		$data['show_input'] 	= true;
		$this->view->load('client_mgt/view_history_list', $data);
	} 

	public function late_submitted_report() {
		$data['ui'] = $this->ui;
		$data['reports'] = $this->client_mgt_model->getReportFormList();
		$data['code'] = $this->client_mgt_model->getClientCode();
		$data['name'] = $this->client_mgt_model->getClientName();
		$data['show_input'] = true;
		$this->view->load('client_mgt/late_submitted_report', $data);
	}

	public function suspended_clients() {
		$data['ui'] = $this->ui;
		$this->view->load('client_mgt/suspended_clients', $data);
	}

	public function terminated_clients() {
		$data['ui'] = $this->ui;
		$this->view->load('client_mgt/terminated_clients', $data);
	}

	private function ajax_form51a_direct_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$count = $this->client_mgt_model->form51aDirectCount($client_id, $id);
		$route = $this->client_mgt_model->getForm51A_Route($client_id, $id);

			$table = '';
			$subtotal 		= 0;
			$total	  		= 0;
			$qtr1	  		= 0;
			$qtr2	  		= 0;
			$qtr3	  		= 0;
			$subtotal1 		= 0;
			$subtotal2		= 0;
			$qtr1_d			= 0;
			$qtr2_d			= 0;
			$qtr3_d			= 0;
			$subtotal_d 	= 0;
			$subtotal1_d	= 0;
			$revsubtotal	= 0;
			$focsubtotal1	= 0;
			$focsubtotal2	= 0;
			$nflight		= 0;
			$nflight_d		= 0;
			$nflight1		= 0;
			$nflight1_d		= 0;
			$lf				= 0;
			$lf1			= 0;
			$totallf		= 0;
			$seats_offered  = 0;
			$seats_offered_d= 0;
			$seat			= 0;
			$totalseats_offered = 0;
			$totalseats_offered_d = 0;

			foreach ($route as $key => $row) {
				$pagination = $this->client_mgt_model->getForm51a_direct($id, $client_id, $row->destination_from, $row->destination_to);
				if (empty($pagination)) {
					$table = '<tr><td colspan="17" class="text-center"><b>No Operation</b></td></tr>';
				}
				$subseats_offered 		= 0;
				$subqtr1 				= 0;
				$subqtr2 				= 0;
				$subqtr3 				= 0;
				$subsubtotal 			= 0;
				$subfocsubtotal 		= 0;
				$subseats_offered_d 	= 0;
				$subqtr1_d 				= 0;
				$subqtr2_d 				= 0;
				$subqtr3_d 				= 0;
				$subsubtotal_d 			= 0;
				$subfocsubtotal2 		= 0;
				$subrevsubtotal 		= 0;
				$subtotallf				= 0;

				foreach ($pagination as $row) {
					$seats = $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3 + $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d +
							$row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3 + $row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d +
							$row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
					$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
					$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
					$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$revtraffic			= $quartersubtotal + $quartersubtotal_d;
					$subtotal 		   += $seats;
					$qtr1			   += $row->quarter_month1;
					$qtr2			   += $row->quarter_month2;
					$qtr3			   += $row->quarter_month3;
					$qtr1_d			   += $row->quarter_month1_d;
					$qtr2_d			   += $row->quarter_month2_d;
					$qtr3_d			   += $row->quarter_month3_d;
					$subtotal1 	   	   += $quartersubtotal;
					$focsubtotal1	   += $focsubtotal;
					$subtotal_d	       += $quartersubtotal_d;
					$focsubtotal2	   += $focsubtotal_d;
					$revsubtotal	   += $revtraffic;
					$seat_cap	 		= $seats * 2;
					$nflight1		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight1_d		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight		    = ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight_d		    = ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d);
					$seat               = $row->economy + $row->business + $row->first;
					$seats_offered	    = $nflight * $seat;
					$seats_offered_d    = $nflight_d * $seat;
					$lf                 = number_format(($revtraffic/($seats_offered + $seats_offered_d))*100, 2);
					
					$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
					$table .= '<td align="center">'. $row->aircraft .'</td>';
					$table .= '<td align="center">'. $row->destination_from .' - '. $row->destination_to. '</td>';
					$table .= '<td align="center">'. number_format($seats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month2, 0).'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month3, 0) .'</td>';
					$table .= '<td align="center">'. number_format($quartersubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($focsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. $row->destination_to .' - '. $row->destination_from. '</td>';
					$table .= '<td align="center">'. number_format($seats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($quartersubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($focsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($revtraffic, 0) .'</td>';
					$table .= '<td align="center">'. number_format($lf, 2) .'%</td>';
					$table .= '</tr>';
					
					$totalseats_offered += $seats_offered;
					$totalseats_offered_d += $seats_offered_d;
					$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format(($revsubtotal/($totalseats_offered + $totalseats_offered_d))*100, 2) : 0;
					$aircraft_name = $row->aircraft;

					$subseats_offered += $seats_offered;
					$subqtr1 += $row->quarter_month1;
					$subqtr2 += $row->quarter_month2;
					$subqtr3 += $row->quarter_month3;
					$subsubtotal += $quartersubtotal;
					$subfocsubtotal += $focsubtotal;
					$subseats_offered_d += $seats_offered_d;
					$subqtr1_d += $row->quarter_month1_d;
					$subqtr2_d += $row->quarter_month2_d;
					$subqtr3_d += $row->quarter_month3_d;
					$subsubtotal_d += $quartersubtotal_d;
					$subfocsubtotal2 += $focsubtotal_d;
					$subrevsubtotal += $revtraffic;
					$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
				}
				
					$table .= '<tr style="background-color:#d9edf7; color:#003366">';
					$table .= '<td align="center">'. 'SUBTOTAL:' .'</td>';
					$table .= '<td>'. '' .'</td>';
					$table .= '<td align="center">'. number_format($subseats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr2, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr3, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subfocsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. '' .'</td>';
					$table .= '<td align="center">'. number_format($subseats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subfocsubtotal2, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subrevsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subtotallf, 2) .'%</td>';
			}
			
			
				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center" colspan="2">'. 'TOTAL:' .'</td>';
				$table .= '<td align="center">'. number_format($totalseats_offered, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr3, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subtotal1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($focsubtotal1, 0) .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center">'. number_format($totalseats_offered_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr1_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr2_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr3_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subtotal_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($focsubtotal2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($revsubtotal, 0) .'</td>';
				$table .= '<td align="center">'. number_format($totallf, 2) .'%</td>';
				$table .= '</tr>';

				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center" colspan="3">'. 'Number of Flights:' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight1 .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight1_d .'</td>';
				$table .= '<td align="center" colspan="3">'. $count->result_count .' entries</td>';
				$table .= '</tr>';
			

			return array('table' => $table);
	}

	private function ajax_form51a_fifthco_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$count = $this->client_mgt_model->form51aFifthCoCount($client_id, $id);
		$route = $this->client_mgt_model->getForm51A_wrote($client_id, $id);

			$table = '';
			$subtotal 		= 0;
			$total	  		= 0;
			$qtr1	  		= 0;
			$qtr2	  		= 0;
			$qtr3	  		= 0;
			$subtotal1 		= 0;
			$subtotal2		= 0;
			$qtr1_d			= 0;
			$qtr2_d			= 0;
			$qtr3_d			= 0;
			$subtotal_d 	= 0;
			$subtotal1_d	= 0;
			$revsubtotal	= 0;
			$focsubtotal1	= 0;
			$focsubtotal2	= 0;
			$nflight		= 0;
			$nflight_d		= 0;
			$nflight1		= 0;
			$nflight1_d		= 0;
			$lf				= 0;
			$lf1			= 0;
			$totallf		= 0;
			$seats_offered  = 0;
			$seats_offered_d= 0;
			$seat			= 0;
			$totalseats_offered = 0;
			$totalseats_offered_d = 0;

			$ex_subtotal 		= 0;
			$ex_total	  		= 0;
			$ex_qtr1	  		= 0;
			$ex_qtr2	  		= 0;
			$ex_qtr3	  		= 0;
			$ex_subtotal1 		= 0;
			$ex_subtotal2		= 0;
			$ex_qtr1_d			= 0;
			$ex_qtr2_d			= 0;
			$ex_qtr3_d			= 0;
			$ex_subtotal_d 	= 0;
			$ex_subtotal1_d	= 0;
			$ex_revsubtotal	= 0;
			$ex_focsubtotal1	= 0;
			$ex_focsubtotal2	= 0;
			$ex_nflight		= 0;
			$ex_nflight_d		= 0;
			$ex_nflight1		= 0;
			$ex_nflight1_d		= 0;
			$ex_lf				= 0;
			$ex_lf1			= 0;
			$ex_totallf		= 0;
			$ex_seats_offered  = 0;
			$ex_seats_offered_d= 0;
			$ex_seat			= 0;
			$ex_totalseats_offered = 0;
			$ex_totalseats_offered_d = 0;
			
			foreach ($route as $key => $row) {
				$pagination = $this->client_mgt_model->getForm51a_fifthco($id, $client_id, $row->destination_from, $row->destination_to, $row->extra_dest);
				if (empty($pagination)) {
					$table = '<tr><td colspan="17" class="text-center"><b>No Operation</b></td></tr>';
				}

				$subseats_offered 		= 0;
				$subqtr1 				= 0;
				$subqtr2 				= 0;
				$subqtr3 				= 0;
				$subsubtotal 			= 0;
				$subfocsubtotal 		= 0;
				$subseats_offered_d 	= 0;
				$subqtr1_d 				= 0;
				$subqtr2_d 				= 0;
				$subqtr3_d 				= 0;
				$subsubtotal_d 			= 0;
				$subfocsubtotal2 		= 0;
				$subrevsubtotal 		= 0;
				$subtotallf				= 0;
				
				foreach ($pagination as $row) {
					$seats = $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3 + $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d +
							$row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3 + $row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d +
							$row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
					$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
					$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
					$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$revtraffic			= $quartersubtotal + $quartersubtotal_d;
					$subtotal 		   += $seats;
					$qtr1			   += $row->quarter_month1;
					$qtr2			   += $row->quarter_month2;
					$qtr3			   += $row->quarter_month3;
					$qtr1_d			   += $row->quarter_month1_d;
					$qtr2_d			   += $row->quarter_month2_d;
					$qtr3_d			   += $row->quarter_month3_d;
					$subtotal1 	   	   += $quartersubtotal;
					$focsubtotal1	   += $focsubtotal;
					$subtotal_d	       += $quartersubtotal_d;
					$focsubtotal2	   += $focsubtotal_d;
					$revsubtotal	   += $revtraffic;
					$seat_cap	 		= $seats * 2;
					$nflight1		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight1_d		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight		    = ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight_d		    = ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d);
					$seat               = $row->economy + $row->business + $row->first;
					$seats_offered	    = $nflight * $seat;
					$seats_offered_d    = $nflight_d * $seat;
					$lf                 = number_format(($revtraffic/($seats_offered + $seats_offered_d))*100, 2);
					
					$ex_seats = $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3 + $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d +
							$row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3 + $row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d +
							$row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3 + $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
					$ex_quartersubtotal 	= $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3;
					$ex_quartersubtotal_d  = $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d;
					$ex_focsubtotal		= $row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3;
					$ex_focsubtotal_d		= $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
					$ex_revtraffic			= $ex_quartersubtotal + $ex_quartersubtotal_d;
					$ex_subtotal 		   += $seats;
					$ex_qtr1			   += $row->ex_quarter_month1;
					$ex_qtr2			   += $row->ex_quarter_month2;
					$ex_qtr3			   += $row->ex_quarter_month3;
					$ex_qtr1_d			   += $row->ex_quarter_month1_d;
					$ex_qtr2_d			   += $row->ex_quarter_month2_d;
					$ex_qtr3_d			   += $row->ex_quarter_month3_d;
					$ex_subtotal1 	   	   += $ex_quartersubtotal;
					$ex_focsubtotal1	   += $ex_focsubtotal;
					$ex_subtotal_d	       += $ex_quartersubtotal_d;
					$ex_focsubtotal2	   += $ex_focsubtotal_d;
					$ex_revsubtotal	   	   += $ex_revtraffic;
					$ex_seat_cap	 		= $ex_seats * 2;
					$ex_nflight1		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight1_d		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight		    	= ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight_d		    = ($row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d);
					$ex_seat                = $row->economy + $row->business + $row->first;
					$ex_seats_offered	    = $ex_nflight * $ex_seat;
					$ex_seats_offered_d     = $ex_nflight_d * $ex_seat;
					$ex_lf                  = number_format(($ex_revtraffic/($ex_seats_offered+$ex_seats_offered_d))*100, 2);
					
					$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
					$table .= '<td align="center" class="dyna_column" rowspan="2">'. $row->aircraft .'</td>';
					$table .= '<td align="center">'. $row->destination_from .' - '. $row->destination_to. '</td>';
					$table .= '<td align="center">'. number_format($seats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month2, 0).'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month3, 0) .'</td>';
					$table .= '<td align="center">'. number_format($quartersubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($focsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. $row->destination_to .' - '. $row->destination_from. '</td>';
					$table .= '<td align="center">'. number_format($seats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($quartersubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($focsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($revtraffic, 0) .'</td>';
					$table .= '<td align="center">'. number_format($lf, 2) .'%</td>';
					$table .= '</tr>';
					$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
					$table .= '<td align="center">'. $row->extra_dest .' - '. $row->destination_to. '</td>';
					$table .= '<td align="center">'. number_format($ex_seats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month2, 0).'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month3, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_quartersubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_focsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. $row->destination_to .' - '. $row->extra_dest. '</td>';
					$table .= '<td align="center">'. number_format($ex_seats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_quartersubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_focsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_revtraffic, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_lf, 2) .'%</td>';
					$table .= '</tr>';
					
					$totalseats_offered += $seats_offered + $ex_seats_offered;
					$totalseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
					$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format((($revsubtotal+$ex_revsubtotal)/(($totalseats_offered + $ex_totalseats_offered) + ($totalseats_offered_d + $ex_totalseats_offered_d)))*100, 2) : 0;
					$aircraft_name = $row->aircraft;
					$subseats_offered += $seats_offered + $ex_seats_offered;
					$subqtr1 += $row->ex_quarter_month1 + $row->quarter_month1;
					$subqtr2 += $row->ex_quarter_month2 + $row->quarter_month1;
					$subqtr3 += $row->ex_quarter_month3 + $row->quarter_month3;
					$subsubtotal += $quartersubtotal;
					$subfocsubtotal += $focsubtotal;
					$subseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
					$subqtr1_d += $row->ex_quarter_month1_d + $row->quarter_month1_d;
					$subqtr2_d += $row->ex_quarter_month2_d + $row->quarter_month2_d;
					$subqtr3_d += $row->ex_quarter_month3_d + $row->quarter_month3_d;
					$subsubtotal_d += $quartersubtotal_d + $ex_quartersubtotal_d;
					$subfocsubtotal2 += $ex_focsubtotal_d + $focsubtotal_d;
					$subrevsubtotal += $ex_revtraffic + $revtraffic;
					$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
					
				}
				
					$table .= '<tr style="background-color:#d9edf7; color:#003366">';
					$table .= '<td align="center">'. 'SUBTOTAL:' .'</td>';
					$table .= '<td>'. '' .'</td>';
					$table .= '<td align="center">'. number_format($subseats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr2, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr3, 0) .'</td>';
					$table .= '<td align="center">'. ($subsubtotal + $ex_subtotal1) .'</td>';
					$table .= '<td align="center">'. ($focsubtotal1 + $ex_focsubtotal1) .'</td>';
					$table .= '<td align="center">'. '' .'</td>';
					$table .= '<td align="center">'. number_format($subseats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subfocsubtotal2, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subrevsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subtotallf, 2) .'%</td>';
			}
			
			
				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center" colspan="2">'. 'TOTAL:' .'</td>';
				$table .= '<td align="center">'. number_format($totalseats_offered, 0) .'</td>';
				$table .= '<td align="center">'. ($qtr1 + $ex_qtr1) .'</td>';
				$table .= '<td align="center">'. ($qtr2 + $ex_qtr2) .'</td>';
				$table .= '<td align="center">'. ($qtr3 + $ex_qtr3) .'</td>';
				$table .= '<td align="center">'. ($subtotal1 + $ex_subtotal1) .'</td>';
				$table .= '<td align="center">'. ($focsubtotal1 + $ex_focsubtotal1) .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center">'. $totalseats_offered_d .'</td>';
				$table .= '<td align="center">'. ($qtr1_d + $ex_qtr1_d) .'</td>';
				$table .= '<td align="center">'. ($qtr2_d + $ex_qtr2_d) .'</td>';
				$table .= '<td align="center">'. ($qtr3_d + $ex_qtr3_d) .'</td>';
				$table .= '<td align="center">'. ($subtotal_d + $ex_subtotal_d) .'</td>';
				$table .= '<td align="center">'. ($focsubtotal2 + $ex_focsubtotal2) .'</td>';
				$table .= '<td align="center">'. ($revsubtotal + $ex_revsubtotal) .'</td>';
				$table .= '<td align="center">'. number_format($totallf, 2) .'%</td>';
				$table .= '</tr>';

				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center" colspan="3">'. 'Number of Flights:' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight1 .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight1_d .'</td>';
				$table .= '<td align="center" colspan="3">'. $count->result_count .' entries</td>';
				$table .= '</tr>';
			

			return array('table' => $table);
	}

	private function ajax_form51a_cs_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$count = $this->client_mgt_model->form51aCSCount($client_id, $id);
		$route = $this->client_mgt_model->getForm51A_cs_Route($client_id, $id);
			$table = '';
			$subtotal 		= 0;
			$total	  		= 0;
			$qtr1	  		= 0;
			$qtr2	  		= 0;
			$qtr3	  		= 0;
			$subtotal1 		= 0;
			$subtotal2		= 0;
			$qtr1_d			= 0;
			$qtr2_d			= 0;
			$qtr3_d			= 0;
			$subtotal_d 	= 0;
			$subtotal1_d	= 0;
			$revsubtotal	= 0;
			$focsubtotal1	= 0;
			$focsubtotal2	= 0;
			$nflight		= 0;
			$nflight_d		= 0;
			$nflight1		= 0;
			$nflight1_d		= 0;
			$lf				= 0;
			$lf1			= 0;
			$totallf		= 0;
			$seats_offered  = 0;
			$seats_offered_d= 0;
			$seat			= 0;
			$totalseats_offered = 0;
			$totalseats_offered_d = 0;

			foreach ($route as $key => $row) {
				$pagination = $this->client_mgt_model->getForm51a_cs_direct($id, $client_id, $row->destination_from, $row->destination_to);
				if (empty($pagination)) {
					$table = '<tr><td colspan="17" class="text-center"><b>No Operation</b></td></tr>';
				}
				$subseats_offered 		= 0;
				$subqtr1 				= 0;
				$subqtr2 				= 0;
				$subqtr3 				= 0;
				$subsubtotal 			= 0;
				$subfocsubtotal 		= 0;
				$subseats_offered_d 	= 0;
				$subqtr1_d 				= 0;
				$subqtr2_d 				= 0;
				$subqtr3_d 				= 0;
				$subsubtotal_d 			= 0;
				$subfocsubtotal2 		= 0;
				$subrevsubtotal 		= 0;
				$subtotallf				= 0;

				foreach ($pagination as $row) {
				$seats = $row->cs_quarter_month1 + $row->cs_quarter_month2 + $row->cs_quarter_month3 + $row->cs_quarter_month1_d + $row->cs_quarter_month2_d + $row->cs_quarter_month3_d +
						 $row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3 + $row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d +
						 $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				$quartersubtotal 	= $row->cs_quarter_month1 + $row->cs_quarter_month2 + $row->cs_quarter_month3;
				$quartersubtotal_d  = $row->cs_quarter_month1_d + $row->cs_quarter_month2_d + $row->cs_quarter_month3_d;
				$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
				$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				$cs_revtraffic		= $focsubtotal + $focsubtotal_d;
				$subtotal 		   += $seats;
				//$total			   += $subtotal;
				$qtr1			   += $row->cs_quarter_month1;
				$qtr2			   += $row->cs_quarter_month2;
				$qtr3			   += $row->cs_quarter_month3;
				$qtr1_d			   += $row->cs_quarter_month1_d;
				$qtr2_d			   += $row->cs_quarter_month2_d;
				$qtr3_d			   += $row->cs_quarter_month3_d;
				$subtotal1 	   	   += $quartersubtotal;
				$focsubtotal1	   += $focsubtotal;
				$subtotal_d	       += $quartersubtotal_d;
				$focsubtotal2	   += $focsubtotal_d;
				$revsubtotal	   += $cs_revtraffic;
				$seat_cap	 		= $seats * 2;
				$nflight1		   += ($row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3);
				$nflight1_d		   += ($row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d);
				$nflight		    = ($row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3);
				$nflight_d		    = ($row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d);
				$seat               = $row->economy + $row->business + $row->first;
				$seats_offered	    = $nflight * $seat;
				$seats_offered_d    = $nflight_d * $seat;
				$lf                 = (!empty($seats_offered) && !empty($seats_offered_d))? number_format(($cs_revtraffic/($seats_offered + $seats_offered_d))*100, 2) : 0;
				//$entries			= count($row);
					
				$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
				$table .= '<td align="center">'. $row->codeshared .'</td>';
				$table .= '<td align="center">'. $row->destination_from .' - '. $row->destination_to. '</td>';
				$table .= '<td align="center">'. number_format($seats_offered, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->cs_quarter_month1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->cs_quarter_month2, 0).'</td>';
				$table .= '<td align="center">'. number_format($row->cs_quarter_month3, 0) .'</td>';
				$table .= '<td align="center">'. number_format($quartersubtotal, 0) .'</td>';
				$table .= '<td align="center">'. number_format($focsubtotal, 0) .'</td>';
				$table .= '<td align="center">'. $row->destination_to .' - '. $row->destination_from. '</td>';
				$table .= '<td align="center">'. number_format($seats_offered_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->cs_quarter_month1_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->cs_quarter_month2_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->cs_quarter_month3_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($quartersubtotal_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($focsubtotal_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($cs_revtraffic, 0) .'</td>';
				$table .= '<td align="center">'. number_format($lf, 2) .'%</td>';
				
				$table .= '</tr>';
					
				$totalseats_offered += $seats_offered;
				$totalseats_offered_d += $seats_offered_d;
				$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format(($revsubtotal/($totalseats_offered + $totalseats_offered_d))*100, 2) : 0;
				
				$subseats_offered += $seats_offered;
				$subqtr1 += $row->cs_quarter_month1;
				$subqtr2 += $row->cs_quarter_month2;
				$subqtr3 += $row->cs_quarter_month3;
				$subsubtotal += $quartersubtotal;
				$subfocsubtotal += $focsubtotal;
				$subseats_offered_d += $seats_offered_d;
				$subqtr1_d += $row->cs_quarter_month1_d;
				$subqtr2_d += $row->cs_quarter_month2_d;
				$subqtr3_d += $row->cs_quarter_month3_d;
				$subsubtotal_d += $quartersubtotal_d;
				$subfocsubtotal2 += $focsubtotal_d;
				$subrevsubtotal += $cs_revtraffic;
				$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
				
			}
				
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center">'. 'SUBTOTAL:' .'</td>';
				$table .= '<td>'. '' .'</td>';
				$table .= '<td align="center">'. number_format($subseats_offered, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subqtr1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subqtr2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subqtr3, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subsubtotal, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subfocsubtotal, 0) .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center">'. number_format($subseats_offered_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subqtr1_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subqtr2_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subqtr3_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subsubtotal_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subfocsubtotal2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subrevsubtotal, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subtotallf, 2) .'%</td>';
			}
			
			
				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center">'. 'TOTAL:' .'</td>';
				$table .= '<td>'. '' .'</td>';
				$table .= '<td align="center">'. number_format($totalseats_offered, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr3, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subtotal1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($focsubtotal1, 0) .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center">'. number_format($totalseats_offered_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr1_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr2_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr3_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subtotal_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($focsubtotal2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($revsubtotal, 0) .'</td>';
				$table .= '<td align="center">'. number_format($totallf, 2) .'%</td>';
				$table .= '</tr>';

				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center" colspan="3">'. 'Number of Flights:' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight_d .'</td>';
				$table .= '<td align="center" colspan="3">'. $count->result_count .' entries</td>';
				$table .= '</tr>';
			

			return array('table' => $table);
	}

	private function ajax_form51a_cs_fifthco_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$count = $this->client_mgt_model->form51aFifthCoCountCS($client_id, $id);
		$route = $this->client_mgt_model->getForm51A_cs_wrote($client_id, $id);

			$table = '';
			$subtotal 		= 0;
			$total	  		= 0;
			$qtr1	  		= 0;
			$qtr2	  		= 0;
			$qtr3	  		= 0;
			$subtotal1 		= 0;
			$subtotal2		= 0;
			$qtr1_d			= 0;
			$qtr2_d			= 0;
			$qtr3_d			= 0;
			$subtotal_d 	= 0;
			$subtotal1_d	= 0;
			$revsubtotal	= 0;
			$focsubtotal1	= 0;
			$focsubtotal2	= 0;
			$nflight		= 0;
			$nflight_d		= 0;
			$nflight1		= 0;
			$nflight1_d		= 0;
			$lf				= 0;
			$lf1			= 0;
			$totallf		= 0;
			$seats_offered  = 0;
			$seats_offered_d= 0;
			$seat			= 0;
			$totalseats_offered = 0;
			$totalseats_offered_d = 0;

			$ex_subtotal 		= 0;
			$ex_total	  		= 0;
			$ex_qtr1	  		= 0;
			$ex_qtr2	  		= 0;
			$ex_qtr3	  		= 0;
			$ex_subtotal1 		= 0;
			$ex_subtotal2		= 0;
			$ex_qtr1_d			= 0;
			$ex_qtr2_d			= 0;
			$ex_qtr3_d			= 0;
			$ex_subtotal_d 	= 0;
			$ex_subtotal1_d	= 0;
			$ex_revsubtotal	= 0;
			$ex_focsubtotal1	= 0;
			$ex_focsubtotal2	= 0;
			$ex_nflight		= 0;
			$ex_nflight_d		= 0;
			$ex_nflight1		= 0;
			$ex_nflight1_d		= 0;
			$ex_lf				= 0;
			$ex_lf1			= 0;
			$ex_totallf		= 0;
			$ex_seats_offered  = 0;
			$ex_seats_offered_d= 0;
			$ex_seat			= 0;
			$ex_totalseats_offered = 0;
			$ex_totalseats_offered_d = 0;
			
			foreach ($route as $key => $row) {
				$pagination = $this->client_mgt_model->getForm51a_cs_fifthco($id, $client_id, $row->destination_from, $row->destination_to, $row->extra_dest);
				if (empty($pagination)) {
					$table = '<tr><td colspan="17" class="text-center"><b>No Operation</b></td></tr>';
				}
				$subseats_offered 		= 0;
				$subqtr1 				= 0;
				$subqtr2 				= 0;
				$subqtr3 				= 0;
				$subsubtotal 			= 0;
				$subfocsubtotal 		= 0;
				$subseats_offered_d 	= 0;
				$subqtr1_d 				= 0;
				$subqtr2_d 				= 0;
				$subqtr3_d 				= 0;
				$subsubtotal_d 			= 0;
				$subfocsubtotal2 		= 0;
				$subrevsubtotal 		= 0;
				$subtotallf				= 0;
				
				foreach ($pagination as $row) {
					$seats = $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3 + $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d +
							$row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3 + $row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d +
							$row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
					$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
					$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
					$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$revtraffic			= $quartersubtotal + $quartersubtotal_d;
					$subtotal 		   += $seats;
					$qtr1			   += $row->quarter_month1;
					$qtr2			   += $row->quarter_month2;
					$qtr3			   += $row->quarter_month3;
					$qtr1_d			   += $row->quarter_month1_d;
					$qtr2_d			   += $row->quarter_month2_d;
					$qtr3_d			   += $row->quarter_month3_d;
					$subtotal1 	   	   += $quartersubtotal;
					$focsubtotal1	   += $focsubtotal;
					$subtotal_d	       += $quartersubtotal_d;
					$focsubtotal2	   += $focsubtotal_d;
					$revsubtotal	   += $revtraffic;
					$seat_cap	 		= $seats * 2;
					$nflight1		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight1_d		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight		    = ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight_d		    = ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d);
					$seat               = $row->economy + $row->business + $row->first;
					$seats_offered	    = $nflight * $seat;
					$seats_offered_d    = $nflight_d * $seat;
					$lf                 = number_format(($revtraffic/($seats_offered + $seats_offered_d))*100, 2);
					
					$ex_seats = $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3 + $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d +
							$row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3 + $row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d +
							$row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3 + $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
					$ex_quartersubtotal 	= $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3;
					$ex_quartersubtotal_d  = $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d;
					$ex_focsubtotal		= $row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3;
					$ex_focsubtotal_d		= $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
					$ex_revtraffic			= $ex_quartersubtotal + $ex_quartersubtotal_d;
					$ex_subtotal 		   += $seats;
					$ex_qtr1			   += $row->ex_quarter_month1;
					$ex_qtr2			   += $row->ex_quarter_month2;
					$ex_qtr3			   += $row->ex_quarter_month3;
					$ex_qtr1_d			   += $row->ex_quarter_month1_d;
					$ex_qtr2_d			   += $row->ex_quarter_month2_d;
					$ex_qtr3_d			   += $row->ex_quarter_month3_d;
					$ex_subtotal1 	   	   += $ex_quartersubtotal;
					$ex_focsubtotal1	   += $ex_focsubtotal;
					$ex_subtotal_d	       += $ex_quartersubtotal_d;
					$ex_focsubtotal2	   += $ex_focsubtotal_d;
					$ex_revsubtotal	   	   += $ex_revtraffic;
					$ex_seat_cap	 		= $ex_seats * 2;
					$ex_nflight1		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight1_d		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight		    	= ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight_d		    = ($row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d);
					$ex_seat                = $row->economy + $row->business + $row->first;
					$ex_seats_offered	    = $ex_nflight * $ex_seat;
					$ex_seats_offered_d     = $ex_nflight_d * $ex_seat;
					$ex_lf                  = number_format(($ex_revtraffic/($ex_seats_offered+$ex_seats_offered_d))*100, 2);
					
					$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
					$table .= '<td align="center" class="dyna_column" rowspan="2">'. $row->aircraft .'</td>';
					$table .= '<td align="center">'. $row->destination_from .' - '. $row->destination_to. '</td>';
					$table .= '<td align="center">'. number_format($seats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month2, 0).'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month3, 0) .'</td>';
					$table .= '<td align="center">'. number_format($quartersubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($focsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. $row->destination_to .' - '. $row->destination_from. '</td>';
					$table .= '<td align="center">'. number_format($seats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->quarter_month3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($quartersubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($focsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($revtraffic, 0) .'</td>';
					$table .= '<td align="center">'. number_format($lf, 2) .'%</td>';
					$table .= '</tr>';
					$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
					$table .= '<td align="center">'. $row->extra_dest .' - '. $row->destination_to. '</td>';
					$table .= '<td align="center">'. number_format($ex_seats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month2, 0).'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month3, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_quartersubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_focsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. $row->destination_to .' - '. $row->extra_dest. '</td>';
					$table .= '<td align="center">'. number_format($ex_seats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($row->ex_quarter_month3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_quartersubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_focsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_revtraffic, 0) .'</td>';
					$table .= '<td align="center">'. number_format($ex_lf, 2) .'%</td>';
					$table .= '</tr>';
					
					$totalseats_offered += $seats_offered + $ex_seats_offered;
					$totalseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
					$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format((($revsubtotal+$ex_revsubtotal)/(($totalseats_offered + $ex_totalseats_offered) + ($totalseats_offered_d + $ex_totalseats_offered_d)))*100, 2) : 0;
					$aircraft_name = $row->aircraft;
					$subseats_offered += $seats_offered + $ex_seats_offered;
					$subqtr1 += $row->ex_quarter_month1 + $row->quarter_month1;
					$subqtr2 += $row->ex_quarter_month2 + $row->quarter_month1;
					$subqtr3 += $row->ex_quarter_month3 + $row->quarter_month3;
					$subsubtotal += $quartersubtotal;
					$subfocsubtotal += $focsubtotal;
					$subseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
					$subqtr1_d += $row->ex_quarter_month1_d + $row->quarter_month1_d;
					$subqtr2_d += $row->ex_quarter_month2_d + $row->quarter_month2_d;
					$subqtr3_d += $row->ex_quarter_month3_d + $row->quarter_month3_d;
					$subsubtotal_d += $quartersubtotal_d + $ex_quartersubtotal_d;
					$subfocsubtotal2 += $ex_focsubtotal_d + $focsubtotal_d;
					$subrevsubtotal += $ex_revtraffic + $revtraffic;
					$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
					
				}
				
					$table .= '<tr style="background-color:#d9edf7; color:#003366">';
					$table .= '<td align="center">'. 'SUBTOTAL:' .'</td>';
					$table .= '<td>'. '' .'</td>';
					$table .= '<td align="center">'. number_format($subseats_offered, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr1, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr2, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr3, 0) .'</td>';
					$table .= '<td align="center">'. ($subsubtotal + $ex_subtotal1) .'</td>';
					$table .= '<td align="center">'. ($focsubtotal1 + $ex_focsubtotal1) .'</td>';
					$table .= '<td align="center">'. '' .'</td>';
					$table .= '<td align="center">'. number_format($subseats_offered_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr1_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr2_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subqtr3_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subsubtotal_d, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subfocsubtotal2, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subrevsubtotal, 0) .'</td>';
					$table .= '<td align="center">'. number_format($subtotallf, 2) .'%</td>';
			}
			
			
				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center" colspan="2">'. 'TOTAL:' .'</td>';
				$table .= '<td align="center">'. number_format($totalseats_offered, 0) .'</td>';
				$table .= '<td align="center">'. ($qtr1 + $ex_qtr1) .'</td>';
				$table .= '<td align="center">'. ($qtr2 + $ex_qtr2) .'</td>';
				$table .= '<td align="center">'. ($qtr3 + $ex_qtr3) .'</td>';
				$table .= '<td align="center">'. ($subtotal1 + $ex_subtotal1) .'</td>';
				$table .= '<td align="center">'. ($focsubtotal1 + $ex_focsubtotal1) .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center">'. number_format($totalseats_offered_d, 0) .'</td>';
				$table .= '<td align="center">'. ($qtr1_d + $ex_qtr1_d) .'</td>';
				$table .= '<td align="center">'. ($qtr2_d + $ex_qtr2_d) .'</td>';
				$table .= '<td align="center">'. ($qtr3_d + $ex_qtr3_d) .'</td>';
				$table .= '<td align="center">'. ($subtotal_d + $ex_subtotal_d) .'</td>';
				$table .= '<td align="center">'. ($focsubtotal2 + $ex_focsubtotal2) .'</td>';
				$table .= '<td align="center">'. ($revsubtotal + $ex_revsubtotal) .'</td>';
				$table .= '<td align="center">'. number_format($totallf, 2) .'%</td>';
				$table .= '</tr>';

				$table .= '</tr>';
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center" colspan="3">'. 'Number of Flights:' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight1 .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center" colspan="5">'. $nflight1_d .'</td>';
				$table .= '<td align="center" colspan="3">'. $count->result_count .' entries</td>';
				$table .= '</tr>';
			

			return array('table' => $table);
	}

	private function ajax_form51a_transit_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$pagination = $this->client_mgt_model->getForm51a_transit($id, $client_id);
		
			$table = '';
			if (empty($pagination)) {
				$table = '<tr><td colspan="11" class="text-center"><b>No Operation</b></td></tr>';
			}
			$qtr1	  		= 0;
			$qtr2	  		= 0;
			$qtr3	  		= 0;
			$subtotal1 		= 0;
			$subtotal2		= 0;
			$qtr1_d			= 0;
			$qtr2_d			= 0;
			$qtr3_d			= 0;
			$subtotal_d 	= 0;
			$subtotal1_d	= 0;
			$totaltransit	= 0;
			$total			= 0;
			foreach ($pagination as $row) {
				$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
				$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
				$total				= $quartersubtotal + $quartersubtotal_d;
				$qtr1				+= $row->quarter_month1;
				$qtr2				+= $row->quarter_month2;
				$qtr3				+= $row->quarter_month3;
				$subtotal1			+= $quartersubtotal;
				$qtr1_d			    += $row->quarter_month1_d;
				$qtr2_d			    += $row->quarter_month2_d;
				$qtr3_d			    += $row->quarter_month3_d;
				$subtotal2			+= $quartersubtotal_d;
				$totaltransit		+= $total;

				$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
				$table .= '<td align="center">'. $row->destination_from .' - '. $row->destination_to. '</td>';
				$table .= '<td align="center">'. number_format($row->quarter_month1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->quarter_month2, 0).'</td>';
				$table .= '<td align="center">'. number_format($row->quarter_month3, 0) .'</td>';
				$table .= '<td align="center">'. number_format($quartersubtotal, 0) .'</td>';
				$table .= '<td align="center">'. $row->destination_to .' - '. $row->destination_from. '</td>';
				$table .= '<td align="center">'. number_format($row->quarter_month1_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->quarter_month2_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($row->quarter_month3_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($quartersubtotal_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($total, 0) .'</td>';
				
				$table .= '</tr>';
			}
			if (!empty($pagination)) {
				$table .= '<tr style="background-color:#d9edf7; color:#003366">';
				$table .= '<td align="center">'. 'TOTAL TRANSIT:' .'</td>';
				$table .= '<td align="center">'. number_format($qtr1, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr3, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subtotal1, 0) .'</td>';
				$table .= '<td align="center">'. '' .'</td>';
				$table .= '<td align="center">'. number_format($qtr1_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr2_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($qtr3_d, 0) .'</td>';
				$table .= '<td align="center">'. number_format($subtotal2, 0) .'</td>';
				$table .= '<td align="center">'. number_format($totaltransit, 0) .'</td>';
			}
			

			$table .= '</tr>';
	
			return array('table' => $table);
	}
	

	public function form51a_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->name.' ['.$get->code.']', 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->telno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cperson, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->tin_no, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');
		$count = $this->client_mgt_model->form51aDirectCount($client_id, $id);
		$route = $this->client_mgt_model->getForm51A_Route($client_id, $id);

		$data = $this->client_mgt_model->getForm51aDetails($client_id, $id);
		if ($data->report_quarter == '1') {$data->report_quarter = 'First Quarter';}
		else if ($data->report_quarter == '2') {$data->report_quarter = 'Second Quarter';}
		else if ($data->report_quarter == '3') {$data->report_quarter = 'Third Quarter';}
		else if ($data->report_quarter == '4') {$data->report_quarter = 'Fourth Quarter';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 51-A : Traffic Flow - Quarterly Report on Scheduled International Services ('.$data->report_quarter.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "6");
		$pdf->Cell(192,7, 'DIRECT', 1, 1, 'C');

		$month1 = '';
		$month2 = '';
		$month3 = '';
		if ($data->report_quarter == 'First Quarter') {$month1 = 'JAN'; $month2 = 'FEB'; $month3 = 'MAR';}
		else if ($data->report_quarter == 'Second Quarter') {$month1 = 'APR'; $month2 = 'MAY'; $month3 = 'JUN';}
		else if ($data->report_quarter == 'Third Quarter') {$month1 = 'JUL'; $month2 = 'AUG'; $month3 = 'SEP';}
		else if ($data->report_quarter == 'Fourth Quarter') {$month1 = 'OCT'; $month2 = 'NOV'; $month3 = 'DEC';}
		$pdf->Cell(13,14, 'AIRCRAFT', 1,0, 'C');
		$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 12);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, $month1, 1,0, 'C');
		$pdf->Cell(8,7, $month2, 1,0, 'C');
		$pdf->Cell(8,7, $month3, 1,0, 'C');
		$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 39);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 16);
		$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 12);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, $month1, 1,0, 'C');
		$pdf->Cell(8,7, $month2, 1,0, 'C');
		$pdf->Cell(8,7, $month3, 1,0, 'C');
		$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 39);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 16);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(15,7, 'TOTAL', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(15,7, 'REV TRAFFIC', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 15);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(8,7, 'LF', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, '%', 1,1, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 8);

		$pdf->Cell(192,14,"",0,1, 'C');

		$pdf->SetFont("Arial", "", "5.8");
				// if (empty($direct)) {
				// 	$pdf->Cell(192,5,"No Operation",0,1, 'C');
				// }
				$table = '';
			$subtotal 		= 0;
			$total	  		= 0;
			$qtr1	  		= 0;
			$qtr2	  		= 0;
			$qtr3	  		= 0;
			$subtotal1 		= 0;
			$subtotal2		= 0;
			$qtr1_d			= 0;
			$qtr2_d			= 0;
			$qtr3_d			= 0;
			$subtotal_d 	= 0;
			$subtotal1_d	= 0;
			$revsubtotal	= 0;
			$focsubtotal1	= 0;
			$focsubtotal2	= 0;
			$nflight		= 0;
			$nflight_d		= 0;
			$nflight1		= 0;
			$nflight1_d		= 0;
			$lf				= 0;
			$lf1			= 0;
			$totallf		= 0;
			$seats_offered  = 0;
			$seats_offered_d= 0;
			$seat			= 0;
			$totalseats_offered = 0;
			$totalseats_offered_d = 0;

			foreach ($route as $key => $row) {
				$pagination = $this->client_mgt_model->getForm51a_direct($id, $client_id, $row->destination_from, $row->destination_to);
				$subseats_offered 		= 0;
				$subqtr1 				= 0;
				$subqtr2 				= 0;
				$subqtr3 				= 0;
				$subsubtotal 			= 0;
				$subfocsubtotal 		= 0;
				$subseats_offered_d 	= 0;
				$subqtr1_d 				= 0;
				$subqtr2_d 				= 0;
				$subqtr3_d 				= 0;
				$subsubtotal_d 			= 0;
				$subfocsubtotal2 		= 0;
				$subrevsubtotal 		= 0;
				$subtotallf				= 0;

				foreach ($pagination as $row) {
					$seats = $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3 + $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d +
							$row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3 + $row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d +
							$row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
					$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
					$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
					$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$revtraffic			= $quartersubtotal + $quartersubtotal_d;
					$subtotal 		   += $seats;
					$qtr1			   += $row->quarter_month1;
					$qtr2			   += $row->quarter_month2;
					$qtr3			   += $row->quarter_month3;
					$qtr1_d			   += $row->quarter_month1_d;
					$qtr2_d			   += $row->quarter_month2_d;
					$qtr3_d			   += $row->quarter_month3_d;
					$subtotal1 	   	   += $quartersubtotal;
					$focsubtotal1	   += $focsubtotal;
					$subtotal_d	       += $quartersubtotal_d;
					$focsubtotal2	   += $focsubtotal_d;
					$revsubtotal	   += $revtraffic;
					$seat_cap	 		= $seats * 2;
					$nflight1		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight1_d		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight		    = ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight_d		    = ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d);
					$seat               = $row->economy + $row->business + $row->first;
					$seats_offered	    = $nflight * $seat;
					$seats_offered_d    = $nflight_d * $seat;
					$lf                 = number_format(($revtraffic/($seats_offered + $seats_offered_d))*100, 2);
					
					$pdf->Cell(13,7, $row->aircraft, 1,0, 'C');
					$pdf->Cell(11,7, $row->destination_from.' - '.$row->destination_to, 1,0, 'C');
					$pdf->Cell(12,7, $seats_offered, 1,0, 'C');
					$pdf->Cell(8,7, $row->quarter_month1, 1,0, 'C');
					$pdf->Cell(8,7, $row->quarter_month2, 1,0, 'C');
					$pdf->Cell(8,7, $row->quarter_month3, 1,0, 'C');
					$pdf->Cell(15,7, $quartersubtotal, 1,0, 'C');
					$pdf->Cell(16,7, $focsubtotal, 1,0, 'C');
					$pdf->Cell(11,7, $row->destination_to.' - '.$row->destination_from, 1,0, 'C');
					$pdf->Cell(12,7, $seats_offered_d, 1,0, 'C');
					$pdf->Cell(8,7, $row->quarter_month1_d, 1,0, 'C');
					$pdf->Cell(8,7, $row->quarter_month2_d, 1,0, 'C');
					$pdf->Cell(8,7, $row->quarter_month3_d, 1,0, 'C');
					$pdf->Cell(15,7, $quartersubtotal_d, 1,0, 'C');
					$pdf->Cell(16,7, $focsubtotal_d, 1,0, 'C');
					$pdf->Cell(15,7, $revtraffic, 1,0, 'C');
					$pdf->Cell(8,7, $lf.'%', 1,1, 'C');

					
					$totalseats_offered += $seats_offered;
					$totalseats_offered_d += $seats_offered_d;
					$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format(($revsubtotal/($totalseats_offered + $totalseats_offered_d))*100, 2) : 0;
				
					$subseats_offered += $seats_offered;
					$subqtr1 += $row->quarter_month1;
					$subqtr2 += $row->quarter_month2;
					$subqtr3 += $row->quarter_month3;
					$subsubtotal += $quartersubtotal;
					$subfocsubtotal += $focsubtotal;
					$subseats_offered_d += $seats_offered_d;
					$subqtr1_d += $row->quarter_month1_d;
					$subqtr2_d += $row->quarter_month2_d;
					$subqtr3_d += $row->quarter_month3_d;
					$subsubtotal_d += $quartersubtotal_d;
					$subfocsubtotal2 += $focsubtotal_d;
					$subrevsubtotal += $revtraffic;
					$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
				
				}

				$pdf->SetFont("Arial", "B", "6");

				$pdf->Cell(13,7, 'SUBTOTAL:', 1,0, 'C');
				$pdf->Cell(11,7, '', 1,0, 'C');
				$pdf->Cell(12,7, $subseats_offered, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr1, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr2, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr3, 1,0, 'C');
				$pdf->Cell(15,7, $subsubtotal, 1,0, 'C');
				$pdf->Cell(16,7, $subfocsubtotal, 1,0, 'C');
				$pdf->Cell(11,7, '', 1,0, 'C');
				$pdf->Cell(12,7, $subsubtotal_d, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr1_d, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr2_d, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr3_d, 1,0, 'C');
				$pdf->Cell(15,7, $subsubtotal_d, 1,0, 'C');
				$pdf->Cell(16,7, $subfocsubtotal2, 1,0, 'C');
				$pdf->Cell(15,7, $subrevsubtotal, 1,0, 'C');
				$pdf->Cell(8,7, $subtotallf.'%', 1,1, 'C');

				$pdf->SetFont("Arial", "", "6");
			}
				
				$pdf->SetFont("Arial", "B", "6");

				$pdf->Cell(24,7, 'TOTAL:', 1,0, 'C');
				$pdf->Cell(12,7, $totalseats_offered, 1,0, 'C');
				$pdf->Cell(8,7, $qtr1, 1,0, 'C');
				$pdf->Cell(8,7, $qtr2, 1,0, 'C');
				$pdf->Cell(8,7, $qtr3, 1,0, 'C');
				$pdf->Cell(15,7, $subtotal1, 1,0, 'C');
				$pdf->Cell(16,7, $focsubtotal1, 1,0, 'C');
				$pdf->Cell(11,7, '', 1,0, 'C');
				$pdf->Cell(12,7, $totalseats_offered_d, 1,0, 'C');
				$pdf->Cell(8,7, $qtr1_d, 1,0, 'C');
				$pdf->Cell(8,7, $qtr2_d, 1,0, 'C');
				$pdf->Cell(8,7, $qtr3_d, 1,0, 'C');
				$pdf->Cell(15,7, $subtotal_d, 1,0, 'C');
				$pdf->Cell(16,7, $focsubtotal2, 1,0, 'C');
				$pdf->Cell(15,7, $revsubtotal, 1,0, 'C');
				$pdf->Cell(8,7, $totallf.'%', 1,1, 'C');

				$pdf->Cell(36,7,'Number of Flights:', 1,0, 'C');
				$pdf->Cell(55,7,$nflight1, 1,0, 'C');
				$pdf->Cell(11,7,'', 1,0, 'C');
				$pdf->Cell(51,7,$nflight1_d, 1,0, 'C');
				$pdf->Cell(39,7,$count->result_count.' entries', 1,0, 'C');

				$pdf->Cell(192,14,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "6");
		$pdf->Cell(192,7, 'FREE FLIGHT', 1, 1, 'C');

		$month1 = '';
		$month2 = '';
		$month3 = '';
		if ($data->report_quarter == 'First Quarter') {$month1 = 'JAN'; $month2 = 'FEB'; $month3 = 'MAR';}
		else if ($data->report_quarter == 'Second Quarter') {$month1 = 'APR'; $month2 = 'MAY'; $month3 = 'JUN';}
		else if ($data->report_quarter == 'Third Quarter') {$month1 = 'JUL'; $month2 = 'AUG'; $month3 = 'SEP';}
		else if ($data->report_quarter == 'Fourth Quarter') {$month1 = 'OCT'; $month2 = 'NOV'; $month3 = 'DEC';}
		$pdf->Cell(13,14, 'AIRCRAFT', 1,0, 'C');
		$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 12);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, $month1, 1,0, 'C');
		$pdf->Cell(8,7, $month2, 1,0, 'C');
		$pdf->Cell(8,7, $month3, 1,0, 'C');
		$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 39);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 16);
		$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 12);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, $month1, 1,0, 'C');
		$pdf->Cell(8,7, $month2, 1,0, 'C');
		$pdf->Cell(8,7, $month3, 1,0, 'C');
		$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 39);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 16);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(15,7, 'TOTAL', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(15,7, 'REV TRAFFIC', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 15);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(8,7, 'LF', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, '%', 1,1, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 8);

		$pdf->Cell(192,14,"",0,1, 'C');

		$pdf->SetFont("Arial", "", "5.8");
				// if (empty($direct)) {
				// 	$pdf->Cell(192,5,"No Operation",0,1, 'C');
				// }
				$table = '';
				$subtotal 		= 0;
				$total	  		= 0;
				$qtr1	  		= 0;
				$qtr2	  		= 0;
				$qtr3	  		= 0;
				$subtotal1 		= 0;
				$subtotal2		= 0;
				$qtr1_d			= 0;
				$qtr2_d			= 0;
				$qtr3_d			= 0;
				$subtotal_d 	= 0;
				$subtotal1_d	= 0;
				$revsubtotal	= 0;
				$focsubtotal1	= 0;
				$focsubtotal2	= 0;
				$nflight		= 0;
				$nflight_d		= 0;
				$nflight1		= 0;
				$nflight1_d		= 0;
				$lf				= 0;
				$lf1			= 0;
				$totallf		= 0;
				$seats_offered  = 0;
				$seats_offered_d= 0;
				$seat			= 0;
				$totalseats_offered = 0;
				$totalseats_offered_d = 0;
	
				$ex_subtotal 		= 0;
				$ex_total	  		= 0;
				$ex_qtr1	  		= 0;
				$ex_qtr2	  		= 0;
				$ex_qtr3	  		= 0;
				$ex_subtotal1 		= 0;
				$ex_subtotal2		= 0;
				$ex_qtr1_d			= 0;
				$ex_qtr2_d			= 0;
				$ex_qtr3_d			= 0;
				$ex_subtotal_d 	= 0;
				$ex_subtotal1_d	= 0;
				$ex_revsubtotal	= 0;
				$ex_focsubtotal1	= 0;
				$ex_focsubtotal2	= 0;
				$ex_nflight		= 0;
				$ex_nflight_d		= 0;
				$ex_nflight1		= 0;
				$ex_nflight1_d		= 0;
				$ex_lf				= 0;
				$ex_lf1			= 0;
				$ex_totallf		= 0;
				$ex_seats_offered  = 0;
				$ex_seats_offered_d= 0;
				$ex_seat			= 0;
				$ex_totalseats_offered = 0;
				$ex_totalseats_offered_d = 0;

				$count = $this->client_mgt_model->form51aFifthCoCount($client_id, $id);
				$route = $this->client_mgt_model->getForm51A_wrote($client_id, $id);
				
				foreach ($route as $key => $row) {
					$pagination = $this->client_mgt_model->getForm51a_fifthco($id, $client_id, $row->destination_from, $row->destination_to, $row->extra_dest);
					if (empty($pagination)) {
						$table = '<tr><td colspan="17" class="text-center"><b>No Operation</b></td></tr>';
					}$subseats_offered 		= 0;
					$subqtr1 				= 0;
					$subqtr2 				= 0;
					$subqtr3 				= 0;
					$subsubtotal 			= 0;
					$subfocsubtotal 		= 0;
					$subseats_offered_d 	= 0;
					$subqtr1_d 				= 0;
					$subqtr2_d 				= 0;
					$subqtr3_d 				= 0;
					$subsubtotal_d 			= 0;
					$subfocsubtotal2 		= 0;
					$subrevsubtotal 		= 0;
					$subtotallf				= 0;
					
					foreach ($pagination as $row) {
						$seats = $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3 + $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d +
								$row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3 + $row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d +
								$row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
						$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
						$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
						$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
						$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
						$revtraffic			= $quartersubtotal + $quartersubtotal_d;
						$subtotal 		   += $seats;
						$qtr1			   += $row->quarter_month1;
						$qtr2			   += $row->quarter_month2;
						$qtr3			   += $row->quarter_month3;
						$qtr1_d			   += $row->quarter_month1_d;
						$qtr2_d			   += $row->quarter_month2_d;
						$qtr3_d			   += $row->quarter_month3_d;
						$subtotal1 	   	   += $quartersubtotal;
						$focsubtotal1	   += $focsubtotal;
						$subtotal_d	       += $quartersubtotal_d;
						$focsubtotal2	   += $focsubtotal_d;
						$revsubtotal	   += $revtraffic;
						$seat_cap	 		= $seats * 2;
						$nflight1		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
						$nflight1_d		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
						$nflight		    = ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
						$nflight_d		    = ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d);
						$seat               = $row->economy + $row->business + $row->first;
						$seats_offered	    = $nflight * $seat;
						$seats_offered_d    = $nflight_d * $seat;
						$lf                 = number_format(($revtraffic/($seats_offered + $seats_offered_d))*100, 2);
						
						$ex_seats = $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3 + $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d +
								$row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3 + $row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d +
								$row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3 + $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
						$ex_quartersubtotal 	= $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3;
						$ex_quartersubtotal_d  = $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d;
						$ex_focsubtotal		= $row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3;
						$ex_focsubtotal_d		= $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
						$ex_revtraffic			= $ex_quartersubtotal + $ex_quartersubtotal_d;
						$ex_subtotal 		   += $seats;
						$ex_qtr1			   += $row->ex_quarter_month1;
						$ex_qtr2			   += $row->ex_quarter_month2;
						$ex_qtr3			   += $row->ex_quarter_month3;
						$ex_qtr1_d			   += $row->ex_quarter_month1_d;
						$ex_qtr2_d			   += $row->ex_quarter_month2_d;
						$ex_qtr3_d			   += $row->ex_quarter_month3_d;
						$ex_subtotal1 	   	   += $ex_quartersubtotal;
						$ex_focsubtotal1	   += $ex_focsubtotal;
						$ex_subtotal_d	       += $ex_quartersubtotal_d;
						$ex_focsubtotal2	   += $ex_focsubtotal_d;
						$ex_revsubtotal	   	   += $ex_revtraffic;
						$ex_seat_cap	 		= $ex_seats * 2;
						$ex_nflight1		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
						$ex_nflight1_d		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
						$ex_nflight		    	= ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
						$ex_nflight_d		    = ($row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d);
						$ex_seat                = $row->economy + $row->business + $row->first;
						$ex_seats_offered	    = $ex_nflight * $ex_seat;
						$ex_seats_offered_d     = $ex_nflight_d * $ex_seat;
						$ex_lf                  = number_format(($ex_revtraffic/($ex_seats_offered+$ex_seats_offered_d))*100, 2);
						
						$pdf->Cell(13,14, $row->aircraft, 1,0, 'C');
						$pdf->Cell(11,7, $row->destination_from.' - '.$row->destination_to, 1,0, 'C');
						$pdf->Cell(12,7, $seats_offered, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month1, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month2, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month3, 1,0, 'C');
						$pdf->Cell(15,7, $quartersubtotal, 1,0, 'C');
						$pdf->Cell(16,7, $focsubtotal, 1,0, 'C');
						$pdf->Cell(11,7, $row->destination_to.' - '.$row->destination_from, 1,0, 'C');
						$pdf->Cell(12,7, $seats_offered_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month1_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month2_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month3_d, 1,0, 'C');
						$pdf->Cell(15,7, $quartersubtotal_d, 1,0, 'C');
						$pdf->Cell(16,7, $focsubtotal_d, 1,0, 'C');
						$pdf->Cell(15,7, $revtraffic, 1,0, 'C');
						$pdf->Cell(8,7, $lf.'%', 1,1, 'C');

						$pdf->Cell(13,14, '', 0,0, 'C');
						$pdf->Cell(11,7, $row->extra_dest.' - '.$row->destination_to, 1,0, 'C');
						$pdf->Cell(12,7, $ex_seats_offered, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month1, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month2, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month3, 1,0, 'C');
						$pdf->Cell(15,7, $ex_quartersubtotal, 1,0, 'C');
						$pdf->Cell(16,7, $ex_focsubtotal, 1,0, 'C');
						$pdf->Cell(11,7, $row->destination_to.' - '.$row->extra_dest, 1,0, 'C');
						$pdf->Cell(12,7, $ex_seats_offered_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month1_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month2_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month3_d, 1,0, 'C');
						$pdf->Cell(15,7, $ex_quartersubtotal_d, 1,0, 'C');
						$pdf->Cell(16,7, $ex_focsubtotal_d, 1,0, 'C');
						$pdf->Cell(15,7, $ex_revtraffic, 1,0, 'C');
						$pdf->Cell(8,7, $ex_lf.'%', 1,1, 'C');

					
						$totalseats_offered += $seats_offered + $ex_seats_offered;
						$totalseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
						$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format((($revsubtotal+$ex_revsubtotal)/(($totalseats_offered + $ex_totalseats_offered) + ($totalseats_offered_d + $ex_totalseats_offered_d)))*100, 2) : 0;
						$aircraft_name = $row->aircraft;
						$subseats_offered += $seats_offered + $ex_seats_offered;
						$subqtr1 += $row->ex_quarter_month1 + $row->quarter_month1;
						$subqtr2 += $row->ex_quarter_month2 + $row->quarter_month1;
						$subqtr3 += $row->ex_quarter_month3 + $row->quarter_month3;
						$subsubtotal += $quartersubtotal + $ex_quartersubtotal;
						$subfocsubtotal += $focsubtotal + $ex_focsubtotal;
						$subseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
						$subqtr1_d += $row->ex_quarter_month1_d + $row->quarter_month1_d;
						$subqtr2_d += $row->ex_quarter_month2_d + $row->quarter_month2_d;
						$subqtr3_d += $row->ex_quarter_month3_d + $row->quarter_month3_d;
						$subsubtotal_d += $quartersubtotal_d + $ex_quartersubtotal_d;
						$subfocsubtotal2 += $ex_focsubtotal_d + $focsubtotal_d;
						$subrevsubtotal += $ex_revtraffic + $revtraffic;
						$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
					
					}
				
					$pdf->SetFont("Arial", "B", "6");

					$pdf->Cell(13,7, 'SUBTOTAL:', 1,0, 'C');
					$pdf->Cell(11,7, '', 1,0, 'C');
					$pdf->Cell(12,7, $subseats_offered, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr1, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr2, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr3, 1,0, 'C');
					$pdf->Cell(15,7, $subsubtotal, 1,0, 'C');
					$pdf->Cell(16,7, $subfocsubtotal, 1,0, 'C');
					$pdf->Cell(11,7, '', 1,0, 'C');
					$pdf->Cell(12,7, $subseats_offered_d, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr1_d, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr2_d, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr3_d, 1,0, 'C');
					$pdf->Cell(15,7, $subsubtotal_d, 1,0, 'C');
					$pdf->Cell(16,7, $subfocsubtotal2, 1,0, 'C');
					$pdf->Cell(15,7, $subrevsubtotal, 1,0, 'C');
					$pdf->Cell(8,7, number_format($subtotallf, 2).'%', 1,1, 'C');


					$pdf->SetFont("Arial", "", "6");

			
			}
				
			$pdf->SetFont("Arial", "B", "6");
				$pdf->Cell(24,7, 'TOTAL:', 1,0, 'C');
				$pdf->Cell(12,7, $totalseats_offered, 1,0, 'C');
				$pdf->Cell(8,7, ($qtr1 + $ex_qtr1), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr2 + $ex_qtr2), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr3 + $ex_qtr3), 1,0, 'C');
				$pdf->Cell(15,7, ($subtotal1 + $ex_subtotal1), 1,0, 'C');
				$pdf->Cell(16,7, ($focsubtotal1 + $ex_focsubtotal1), 1,0, 'C');
				$pdf->Cell(11,7, '', 1,0, 'C');
				$pdf->Cell(12,7, $totalseats_offered_d, 1,0, 'C');
				$pdf->Cell(8,7, ($qtr1_d + $ex_qtr1_d), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr2_d + $ex_qtr2_d), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr3_d + $ex_qtr3_d), 1,0, 'C');
				$pdf->Cell(15,7, ($subtotal_d + $ex_subtotal_d), 1,0, 'C');
				$pdf->Cell(16,7, ($focsubtotal2 + $ex_focsubtotal2), 1,0, 'C');
				$pdf->Cell(15,7, ($revsubtotal + $ex_revsubtotal), 1,0, 'C');
				$pdf->Cell(8,7, number_format($totallf, 2).'%', 1,1, 'C');

				$pdf->Cell(36,7,'Number of Flights:', 1,0, 'C');
				$pdf->Cell(55,7,$nflight1, 1,0, 'C');
				$pdf->Cell(11,7,'', 1,0, 'C');
				$pdf->Cell(51,7,$nflight1_d, 1,0, 'C');
				$pdf->Cell(39,7,$count->result_count.' entries', 1,0, 'C');

				$pdf->Cell(192,14,"",0,1, 'C');

				

				$pdf->SetFont("Arial", "B", "6");
				$pdf->Cell(192,7, 'CODESHARED', 1, 1, 'C');
		
				$cs = $this->client_mgt_model->getForm51a_cs_direct($id, $client_id, $row->destination_from, $row->destination_to);
				$countcs = $this->client_mgt_model->form51aCSCount($client_id, $id);

				$pdf->Cell(13,14, 'AIRCRAFT', 1,0, 'C');
				$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 12);
		
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(8,7, $month1, 1,0, 'C');
				$pdf->Cell(8,7, $month2, 1,0, 'C');
				$pdf->Cell(8,7, $month3, 1,0, 'C');
				$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 39);
		
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 16);
				$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 12);
		
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(8,7, $month1, 1,0, 'C');
				$pdf->Cell(8,7, $month2, 1,0, 'C');
				$pdf->Cell(8,7, $month3, 1,0, 'C');
				$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 39);
		
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 16);
		
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(15,7, 'TOTAL', 1,0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(15,7, 'REV TRAFFIC', 1,0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 15);
		
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(8,7, 'LF', 1,0, 'C');
				$pdf->SetY($y + 7);
				$pdf->SetX($x);
				$pdf->Cell(8,7, '%', 1,1, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 8);
		
				$pdf->Cell(192,14,"",0,1, 'C');

				$pdf->SetFont("Arial", "", "6");
				if (empty($cs)) {
					$pdf->Cell(192,5,"No Operation",0,1, 'C');
				}

			$count = $this->client_mgt_model->form51aDirectCount($client_id, $id);
			$route = $this->client_mgt_model->getForm51A_cs_Route($client_id, $id);

			$table = '';
			$subtotal 		= 0;
			$total	  		= 0;
			$qtr1	  		= 0;
			$qtr2	  		= 0;
			$qtr3	  		= 0;
			$subtotal1 		= 0;
			$subtotal2		= 0;
			$qtr1_d			= 0;
			$qtr2_d			= 0;
			$qtr3_d			= 0;
			$subtotal_d 	= 0;
			$subtotal1_d	= 0;
			$revsubtotal	= 0;
			$focsubtotal1	= 0;
			$focsubtotal2	= 0;
			$nflight		= 0;
			$nflight_d		= 0;
			$nflight1		= 0;
			$nflight1_d		= 0;
			$lf				= 0;
			$lf1			= 0;
			$totallf		= 0;
			$seats_offered  = 0;
			$seats_offered_d= 0;
			$seat			= 0;
			$totalseats_offered = 0;
			$totalseats_offered_d = 0;

			foreach ($route as $key => $row) {
				$pagination = $this->client_mgt_model->getForm51a_cs_direct($id, $client_id, $row->destination_from, $row->destination_to);
				if (empty($pagination)) {
					$table = '<tr><td colspan="17" class="text-center"><b>No Operation</b></td></tr>';
				}
				
				$subseats_offered 		= 0;
				$subqtr1 				= 0;
				$subqtr2 				= 0;
				$subqtr3 				= 0;
				$subsubtotal 			= 0;
				$subfocsubtotal 		= 0;
				$subseats_offered_d 	= 0;
				$subqtr1_d 				= 0;
				$subqtr2_d 				= 0;
				$subqtr3_d 				= 0;
				$subsubtotal_d 			= 0;
				$subfocsubtotal2 		= 0;
				$subrevsubtotal 		= 0;
				$subtotallf				= 0;

				foreach ($pagination as $row) {
				$seats = $row->cs_quarter_month1 + $row->cs_quarter_month2 + $row->cs_quarter_month3 + $row->cs_quarter_month1_d + $row->cs_quarter_month2_d + $row->cs_quarter_month3_d +
						 $row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3 + $row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d +
						 $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				$quartersubtotal 	= $row->cs_quarter_month1 + $row->cs_quarter_month2 + $row->cs_quarter_month3;
				$quartersubtotal_d  = $row->cs_quarter_month1_d + $row->cs_quarter_month2_d + $row->cs_quarter_month3_d;
				$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
				$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				$cs_revtraffic		= $focsubtotal + $focsubtotal_d;
				$subtotal 		   += $seats;
				//$total			   += $subtotal;
				$qtr1			   += $row->cs_quarter_month1;
				$qtr2			   += $row->cs_quarter_month2;
				$qtr3			   += $row->cs_quarter_month3;
				$qtr1_d			   += $row->cs_quarter_month1_d;
				$qtr2_d			   += $row->cs_quarter_month2_d;
				$qtr3_d			   += $row->cs_quarter_month3_d;
				$subtotal1 	   	   += $quartersubtotal;
				$focsubtotal1	   += $focsubtotal;
				$subtotal_d	       += $quartersubtotal_d;
				$focsubtotal2	   += $focsubtotal_d;
				$revsubtotal	   += $cs_revtraffic;
				$seat_cap	 		= $seats * 2;
				$nflight1		   += ($row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3);
				$nflight1_d		   += ($row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d);
				$nflight		    = ($row->cs_nflight_month1 + $row->cs_nflight_month2 + $row->cs_nflight_month3);
				$nflight_d		    = ($row->cs_nflight_month1_d + $row->cs_nflight_month2_d + $row->cs_nflight_month3_d);
				$seat               = $row->economy + $row->business + $row->first;
				$seats_offered	    = $nflight * $seat;
				$seats_offered_d    = $nflight_d * $seat;
				$lf                 = (!empty($seats_offered) && !empty($seats_offered_d))? number_format(($cs_revtraffic/($seats_offered + $seats_offered_d))*100, 2) : 0;
					
				$pdf->Cell(13,7, $row->codeshared, 1,0, 'C');
					$pdf->Cell(11,7, $row->destination_from.' - '.$row->destination_to, 1,0, 'C');
					$pdf->Cell(12,7, $seats_offered, 1,0, 'C');
					$pdf->Cell(8,7, $row->cs_quarter_month1, 1,0, 'C');
					$pdf->Cell(8,7, $row->cs_quarter_month2, 1,0, 'C');
					$pdf->Cell(8,7, $row->cs_quarter_month3, 1,0, 'C');
					$pdf->Cell(15,7, $quartersubtotal, 1,0, 'C');
					$pdf->Cell(16,7, $focsubtotal, 1,0, 'C');
					$pdf->Cell(11,7, $row->destination_to.' - '.$row->destination_from, 1,0, 'C');
					$pdf->Cell(12,7, $seats_offered_d, 1,0, 'C');
					$pdf->Cell(8,7, $row->cs_quarter_month1_d, 1,0, 'C');
					$pdf->Cell(8,7, $row->cs_quarter_month2_d, 1,0, 'C');
					$pdf->Cell(8,7, $row->cs_quarter_month3_d, 1,0, 'C');
					$pdf->Cell(15,7, $quartersubtotal_d, 1,0, 'C');
					$pdf->Cell(16,7, $focsubtotal_d, 1,0, 'C');
					$pdf->Cell(15,7, $cs_revtraffic, 1,0, 'C');
					$pdf->Cell(8,7, $lf.'%', 1,1, 'C');
					
					$totalseats_offered += $seats_offered;
					$totalseats_offered_d += $seats_offered_d;
					$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format(($revsubtotal/($totalseats_offered + $totalseats_offered_d))*100, 2) : 0;
					
					$subseats_offered += $seats_offered;
					$subqtr1 += $row->cs_quarter_month1;
					$subqtr2 += $row->cs_quarter_month2;
					$subqtr3 += $row->cs_quarter_month3;
					$subsubtotal += $quartersubtotal;
					$subfocsubtotal += $focsubtotal;
					$subseats_offered_d += $seats_offered_d;
					$subqtr1_d += $row->cs_quarter_month1_d;
					$subqtr2_d += $row->cs_quarter_month2_d;
					$subqtr3_d += $row->cs_quarter_month3_d;
					$subsubtotal_d += $quartersubtotal_d;
					$subfocsubtotal2 += $focsubtotal_d;
					$subrevsubtotal += $cs_revtraffic;
					$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
				}

				$pdf->SetFont("Arial", "B", "6");

				$pdf->Cell(13,7, 'SUBTOTAL:', 1,0, 'C');
				$pdf->Cell(11,7, '', 1,0, 'C');
				$pdf->Cell(12,7, $subseats_offered, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr1, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr2, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr3, 1,0, 'C');
				$pdf->Cell(15,7, $subsubtotal, 1,0, 'C');
				$pdf->Cell(16,7, $subfocsubtotal, 1,0, 'C');
				$pdf->Cell(11,7, '', 1,0, 'C');
				$pdf->Cell(12,7, $subseats_offered_d, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr1_d, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr2_d, 1,0, 'C');
				$pdf->Cell(8,7, $subqtr3_d, 1,0, 'C');
				$pdf->Cell(15,7, $subsubtotal_d, 1,0, 'C');
				$pdf->Cell(16,7, $subfocsubtotal2, 1,0, 'C');
				$pdf->Cell(15,7, $subrevsubtotal, 1,0, 'C');
				$pdf->Cell(8,7, $subtotallf.'%', 1,1, 'C');

				$pdf->SetFont("Arial", "", "5.8");
				
			}
			
			$pdf->SetFont("Arial", "B", "6");
			
			$pdf->Cell(24,7, 'TOTAL:', 1,0, 'C');
			$pdf->Cell(12,7, $totalseats_offered, 1,0, 'C');
			$pdf->Cell(8,7, $qtr1, 1,0, 'C');
			$pdf->Cell(8,7, $qtr2, 1,0, 'C');
			$pdf->Cell(8,7, $qtr3, 1,0, 'C');
			$pdf->Cell(15,7, $subtotal1, 1,0, 'C');
			$pdf->Cell(16,7, $focsubtotal1, 1,0, 'C');
			$pdf->Cell(11,7, '', 1,0, 'C');
			$pdf->Cell(12,7, $totalseats_offered_d, 1,0, 'C');
			$pdf->Cell(8,7, $qtr1_d, 1,0, 'C');
			$pdf->Cell(8,7, $qtr2_d, 1,0, 'C');
			$pdf->Cell(8,7, $qtr3_d, 1,0, 'C');
			$pdf->Cell(15,7, $subtotal_d, 1,0, 'C');
			$pdf->Cell(16,7, $focsubtotal2, 1,0, 'C');
			$pdf->Cell(15,7, $revsubtotal, 1,0, 'C');
			$pdf->Cell(8,7, number_format($totallf, 2).'%', 1,1, 'C');

			$pdf->Cell(36,7,'Number of Flights:', 1,0, 'C');
			$pdf->Cell(55,7,$nflight1, 1,0, 'C');
			$pdf->Cell(11,7,'', 1,0, 'C');
			$pdf->Cell(51,7,$nflight1_d, 1,0, 'C');
			$pdf->Cell(39,7,$countcs->result_count.' entries', 1,0, 'C');

		
		

				$pdf->Cell(192,14,"",0,1, 'C');

				$pdf->SetFont("Arial", "B", "5.8");

		$pdf->Cell(192,7, 'CODESHARED FREE FLIGHT', 1, 1, 'C');

		$month1 = '';
		$month2 = '';
		$month3 = '';
		if ($data->report_quarter == 'First Quarter') {$month1 = 'JAN'; $month2 = 'FEB'; $month3 = 'MAR';}
		else if ($data->report_quarter == 'Second Quarter') {$month1 = 'APR'; $month2 = 'MAY'; $month3 = 'JUN';}
		else if ($data->report_quarter == 'Third Quarter') {$month1 = 'JUL'; $month2 = 'AUG'; $month3 = 'SEP';}
		else if ($data->report_quarter == 'Fourth Quarter') {$month1 = 'OCT'; $month2 = 'NOV'; $month3 = 'DEC';}
		$pdf->Cell(13,14, 'AIRCRAFT', 1,0, 'C');
		$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 12);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, $month1, 1,0, 'C');
		$pdf->Cell(8,7, $month2, 1,0, 'C');
		$pdf->Cell(8,7, $month3, 1,0, 'C');
		$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 39);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 16);
		$pdf->Cell(11,14, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(12,7, 'SEATS', 'TLR',0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(12,7, 'OFFERED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 12);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(39,7, 'REVENUE PASSENGER TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, $month1, 1,0, 'C');
		$pdf->Cell(8,7, $month2, 1,0, 'C');
		$pdf->Cell(8,7, $month3, 1,0, 'C');
		$pdf->Cell(15,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 39);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(16,7, 'FOC TRAFFIC', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(16,7, 'SUB TOTAL', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 16);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(15,7, 'TOTAL', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(15,7, 'REV TRAFFIC', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 15);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(8,7, 'LF', 1,0, 'C');
		$pdf->SetY($y + 7);
		$pdf->SetX($x);
		$pdf->Cell(8,7, '%', 1,1, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 8);

		$pdf->Cell(192,14,"",0,1, 'C');

		$pdf->SetFont("Arial", "", "5.8");
				// if (empty($direct)) {
				// 	$pdf->Cell(192,5,"No Operation",0,1, 'C');
				// }
				$table = '';
				$subtotal 		= 0;
				$total	  		= 0;
				$qtr1	  		= 0;
				$qtr2	  		= 0;
				$qtr3	  		= 0;
				$subtotal1 		= 0;
				$subtotal2		= 0;
				$qtr1_d			= 0;
				$qtr2_d			= 0;
				$qtr3_d			= 0;
				$subtotal_d 	= 0;
				$subtotal1_d	= 0;
				$revsubtotal	= 0;
				$focsubtotal1	= 0;
				$focsubtotal2	= 0;
				$nflight		= 0;
				$nflight_d		= 0;
				$nflight1		= 0;
				$nflight1_d		= 0;
				$lf				= 0;
				$lf1			= 0;
				$totallf		= 0;
				$seats_offered  = 0;
				$seats_offered_d= 0;
				$seat			= 0;
				$totalseats_offered = 0;
				$totalseats_offered_d = 0;
	
				$ex_subtotal 		= 0;
				$ex_total	  		= 0;
				$ex_qtr1	  		= 0;
				$ex_qtr2	  		= 0;
				$ex_qtr3	  		= 0;
				$ex_subtotal1 		= 0;
				$ex_subtotal2		= 0;
				$ex_qtr1_d			= 0;
				$ex_qtr2_d			= 0;
				$ex_qtr3_d			= 0;
				$ex_subtotal_d 	= 0;
				$ex_subtotal1_d	= 0;
				$ex_revsubtotal	= 0;
				$ex_focsubtotal1	= 0;
				$ex_focsubtotal2	= 0;
				$ex_nflight		= 0;
				$ex_nflight_d		= 0;
				$ex_nflight1		= 0;
				$ex_nflight1_d		= 0;
				$ex_lf				= 0;
				$ex_lf1			= 0;
				$ex_totallf		= 0;
				$ex_seats_offered  = 0;
				$ex_seats_offered_d= 0;
				$ex_seat			= 0;
				$ex_totalseats_offered = 0;
				$ex_totalseats_offered_d = 0;

				$count = $this->client_mgt_model->form51aFifthCoCountCS($client_id, $id);
				$route = $this->client_mgt_model->getForm51A_cs_wrote($client_id, $id);
				
				foreach ($route as $key => $row) {
					$pagination = $this->client_mgt_model->getForm51a_cs_fifthco($id, $client_id, $row->destination_from, $row->destination_to, $row->extra_dest);
					if (empty($pagination)) {
						$table = '<tr><td colspan="17" class="text-center"><b>No Operation</b></td></tr>';
					}
					$subseats_offered 		= 0;
				$subqtr1 				= 0;
				$subqtr2 				= 0;
				$subqtr3 				= 0;
				$subsubtotal 			= 0;
				$subfocsubtotal 		= 0;
				$subseats_offered_d 	= 0;
				$subqtr1_d 				= 0;
				$subqtr2_d 				= 0;
				$subqtr3_d 				= 0;
				$subsubtotal_d 			= 0;
				$subfocsubtotal2 		= 0;
				$subrevsubtotal 		= 0;
				$subtotallf				= 0;
				
				foreach ($pagination as $row) {
					$seats = $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3 + $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d +
							$row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3 + $row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d +
							$row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
					$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
					$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
					$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
					$revtraffic			= $quartersubtotal + $quartersubtotal_d;
					$subtotal 		   += $seats;
					$qtr1			   += $row->quarter_month1;
					$qtr2			   += $row->quarter_month2;
					$qtr3			   += $row->quarter_month3;
					$qtr1_d			   += $row->quarter_month1_d;
					$qtr2_d			   += $row->quarter_month2_d;
					$qtr3_d			   += $row->quarter_month3_d;
					$subtotal1 	   	   += $quartersubtotal;
					$focsubtotal1	   += $focsubtotal;
					$subtotal_d	       += $quartersubtotal_d;
					$focsubtotal2	   += $focsubtotal_d;
					$revsubtotal	   += $revtraffic;
					$seat_cap	 		= $seats * 2;
					$nflight1		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight1_d		   += ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight		    = ($row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3);
					$nflight_d		    = ($row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d);
					$seat               = $row->economy + $row->business + $row->first;
					$seats_offered	    = $nflight * $seat;
					$seats_offered_d    = $nflight_d * $seat;
					$lf                 = number_format(($revtraffic/($seats_offered + $seats_offered_d))*100, 2);
					
					$ex_seats = $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3 + $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d +
							$row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3 + $row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d +
							$row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3 + $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
					$ex_quartersubtotal 	= $row->ex_quarter_month1 + $row->ex_quarter_month2 + $row->ex_quarter_month3;
					$ex_quartersubtotal_d  = $row->ex_quarter_month1_d + $row->ex_quarter_month2_d + $row->ex_quarter_month3_d;
					$ex_focsubtotal		= $row->ex_foctraffic_month1 + $row->ex_foctraffic_month2 + $row->ex_foctraffic_month3;
					$ex_focsubtotal_d		= $row->ex_foctraffic_month1_d + $row->ex_foctraffic_month2_d + $row->ex_foctraffic_month3_d;
					$ex_revtraffic			= $ex_quartersubtotal + $ex_quartersubtotal_d;
					$ex_subtotal 		   += $seats;
					$ex_qtr1			   += $row->ex_quarter_month1;
					$ex_qtr2			   += $row->ex_quarter_month2;
					$ex_qtr3			   += $row->ex_quarter_month3;
					$ex_qtr1_d			   += $row->ex_quarter_month1_d;
					$ex_qtr2_d			   += $row->ex_quarter_month2_d;
					$ex_qtr3_d			   += $row->ex_quarter_month3_d;
					$ex_subtotal1 	   	   += $ex_quartersubtotal;
					$ex_focsubtotal1	   += $ex_focsubtotal;
					$ex_subtotal_d	       += $ex_quartersubtotal_d;
					$ex_focsubtotal2	   += $ex_focsubtotal_d;
					$ex_revsubtotal	   	   += $ex_revtraffic;
					$ex_seat_cap	 		= $ex_seats * 2;
					$ex_nflight1		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight1_d		   += ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight		    	= ($row->ex_nflight_month1 + $row->ex_nflight_month2 + $row->ex_nflight_month3);
					$ex_nflight_d		    = ($row->ex_nflight_month1_d + $row->ex_nflight_month2_d + $row->ex_nflight_month3_d);
					$ex_seat                = $row->economy + $row->business + $row->first;
					$ex_seats_offered	    = $ex_nflight * $ex_seat;
					$ex_seats_offered_d     = $ex_nflight_d * $ex_seat;
					$ex_lf                  = number_format(($ex_revtraffic/($ex_seats_offered+$ex_seats_offered_d))*100, 2);
					
						$pdf->Cell(13,14, $row->aircraft, 1,0, 'C');
						$pdf->Cell(11,7, $row->destination_from.' - '.$row->destination_to, 1,0, 'C');
						$pdf->Cell(12,7, $seats_offered, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month1, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month2, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month3, 1,0, 'C');
						$pdf->Cell(15,7, $quartersubtotal, 1,0, 'C');
						$pdf->Cell(16,7, $focsubtotal, 1,0, 'C');
						$pdf->Cell(11,7, $row->destination_to.' - '.$row->destination_from, 1,0, 'C');
						$pdf->Cell(12,7, $seats_offered_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month1_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month2_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->quarter_month3_d, 1,0, 'C');
						$pdf->Cell(15,7, $quartersubtotal_d, 1,0, 'C');
						$pdf->Cell(16,7, $focsubtotal_d, 1,0, 'C');
						$pdf->Cell(15,7, $revtraffic, 1,0, 'C');
						$pdf->Cell(8,7, $lf.'%', 1,1, 'C');

						$pdf->Cell(13,14, '', 0,0, 'C');
						$pdf->Cell(11,7, $row->extra_dest.' - '.$row->destination_to, 1,0, 'C');
						$pdf->Cell(12,7, $ex_seats_offered, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month1, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month2, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month3, 1,0, 'C');
						$pdf->Cell(15,7, $ex_quartersubtotal, 1,0, 'C');
						$pdf->Cell(16,7, $ex_focsubtotal, 1,0, 'C');
						$pdf->Cell(11,7, $row->destination_to.' - '.$row->extra_dest, 1,0, 'C');
						$pdf->Cell(12,7, $ex_seats_offered_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month1_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month2_d, 1,0, 'C');
						$pdf->Cell(8,7, $row->ex_quarter_month3_d, 1,0, 'C');
						$pdf->Cell(15,7, $ex_quartersubtotal_d, 1,0, 'C');
						$pdf->Cell(16,7, $ex_focsubtotal_d, 1,0, 'C');
						$pdf->Cell(15,7, $ex_revtraffic, 1,0, 'C');
						$pdf->Cell(8,7, $ex_lf.'%', 1,1, 'C');

					
						$totalseats_offered += $seats_offered + $ex_seats_offered;
						$totalseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
						$totallf            = (!empty($totalseats_offered) && !empty($totalseats_offered_d))? number_format((($revsubtotal+$ex_revsubtotal)/(($totalseats_offered + $ex_totalseats_offered) + ($totalseats_offered_d + $ex_totalseats_offered_d)))*100, 2) : 0;
						$aircraft_name = $row->aircraft;
						$subseats_offered += $seats_offered + $ex_seats_offered;
						$subqtr1 += $row->ex_quarter_month1 + $row->quarter_month1;
						$subqtr2 += $row->ex_quarter_month2 + $row->quarter_month1;
						$subqtr3 += $row->ex_quarter_month3 + $row->quarter_month3;
						$subsubtotal += $quartersubtotal + $ex_quartersubtotal;
						$subfocsubtotal += $focsubtotal + $ex_focsubtotal;
						$subseats_offered_d += $seats_offered_d + $ex_seats_offered_d;
						$subqtr1_d += $row->ex_quarter_month1_d + $row->quarter_month1_d;
						$subqtr2_d += $row->ex_quarter_month2_d + $row->quarter_month2_d;
						$subqtr3_d += $row->ex_quarter_month3_d + $row->quarter_month3_d;
						$subsubtotal_d += $quartersubtotal_d + $ex_quartersubtotal_d;
						$subfocsubtotal2 += $ex_focsubtotal_d + $focsubtotal_d;
						$subrevsubtotal += $ex_revtraffic + $revtraffic;
						$subtotallf	= (!empty($subseats_offered) && !empty($subseats_offered_d))? number_format(($subrevsubtotal/($subseats_offered + $subseats_offered_d))*100, 2) : 0;
					
						
					}
				
					$pdf->SetFont("Arial", "B", "6");

					$pdf->Cell(13,7, 'SUBTOTAL:', 1,0, 'C');
					$pdf->Cell(11,7, '', 1,0, 'C');
					$pdf->Cell(12,7, $subseats_offered, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr1, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr2, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr3, 1,0, 'C');
					$pdf->Cell(15,7, $subsubtotal, 1,0, 'C');
					$pdf->Cell(16,7, $subfocsubtotal, 1,0, 'C');
					$pdf->Cell(11,7, '', 1,0, 'C');
					$pdf->Cell(12,7, $subseats_offered_d, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr1_d, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr2_d, 1,0, 'C');
					$pdf->Cell(8,7,  $subqtr3_d, 1,0, 'C');
					$pdf->Cell(15,7, $subsubtotal_d, 1,0, 'C');
					$pdf->Cell(16,7, $subfocsubtotal2, 1,0, 'C');
					$pdf->Cell(15,7, $subrevsubtotal, 1,0, 'C');
					$pdf->Cell(8,7, number_format($subtotallf, 2).'%', 1,1, 'C');
			}
				
				$pdf->SetFont("Arial", "B", "6");
				$pdf->Cell(24,7, 'TOTAL:', 1,0, 'C');
				$pdf->Cell(12,7, $totalseats_offered, 1,0, 'C');
				$pdf->Cell(8,7, ($qtr1 + $ex_qtr1), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr2 + $ex_qtr2), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr3 + $ex_qtr3), 1,0, 'C');
				$pdf->Cell(15,7, ($subtotal1 + $ex_subtotal1), 1,0, 'C');
				$pdf->Cell(16,7, ($focsubtotal1 + $ex_focsubtotal1), 1,0, 'C');
				$pdf->Cell(11,7, '', 1,0, 'C');
				$pdf->Cell(12,7, $totalseats_offered_d, 1,0, 'C');
				$pdf->Cell(8,7, ($qtr1_d + $ex_qtr1_d), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr2_d + $ex_qtr2_d), 1,0, 'C');
				$pdf->Cell(8,7, ($qtr3_d + $ex_qtr3_d), 1,0, 'C');
				$pdf->Cell(15,7, ($subtotal_d + $ex_subtotal_d), 1,0, 'C');
				$pdf->Cell(16,7, ($focsubtotal2 + $ex_focsubtotal2), 1,0, 'C');
				$pdf->Cell(15,7, ($revsubtotal + $ex_revsubtotal), 1,0, 'C');
				$pdf->Cell(8,7, number_format($totallf, 2).'%', 1,1, 'C');

				$pdf->Cell(36,7,'Number of Flights:', 1,0, 'C');
				$pdf->Cell(55,7,$nflight1, 1,0, 'C');
				$pdf->Cell(11,7,'', 1,0, 'C');
				$pdf->Cell(51,7,$nflight1_d, 1,0, 'C');
				$pdf->Cell(39,7,$count->result_count.' entries', 1,0, 'C');

				$pdf->Cell(192,14,"",0,1, 'C');

				$pdf->SetFont("Arial", "B", "6");
				$pdf->Cell(192,7, 'TRANSIT', 1, 1, 'C');
		
				$transit = $this->client_mgt_model->getForm51a_transit($id, $client_id);
		
				$pdf->Cell(20,7, 'ROUTE', 1,0, 'C');
				$pdf->Cell(15,7, $month1, 1,0, 'C');
				$pdf->Cell(15,7, $month2, 1,0, 'C');
				$pdf->Cell(15,7, $month3, 1,0, 'C');
				$pdf->Cell(20,7, 'SUB-TOTAL', 1,0, 'C');
				$pdf->Cell(20,7, 'ROUTE', 1,0, 'C');
				$pdf->Cell(15,7, $month1, 1,0, 'C');
				$pdf->Cell(15,7, $month2, 1,0, 'C');
				$pdf->Cell(15,7, $month3, 1,0, 'C');
				$pdf->Cell(20,7, 'SUB-TOTAL', 1,0, 'C');
				$pdf->Cell(22,7, 'TOTAL', 1,1, 'C');
				


				$pdf->SetFont("Arial", "", "6");
				if (empty($transit)) {
					$pdf->Cell(192,5,"No Operation",0,1, 'C');
				}
			
				$qtr1	  		= 0;
				$qtr2	  		= 0;
				$qtr3	  		= 0;
				$subtotal1 		= 0;
				$subtotal2		= 0;
				$qtr1_d			= 0;
				$qtr2_d			= 0;
				$qtr3_d			= 0;
				$subtotal_d 	= 0;
				$subtotal1_d	= 0;
				$totaltransit	= 0;
				$total			= 0;
				foreach ($transit as $row) {
					$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
					$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
					$total				= $quartersubtotal + $quartersubtotal_d;
					$qtr1				+= $row->quarter_month1;
					$qtr2				+= $row->quarter_month2;
					$qtr3				+= $row->quarter_month3;
					$subtotal1			+= $quartersubtotal;
					$qtr1_d			    += $row->quarter_month1_d;
					$qtr2_d			    += $row->quarter_month2_d;
					$qtr3_d			    += $row->quarter_month3_d;
					$subtotal2			+= $quartersubtotal_d;
					$totaltransit		+= $total;
				
					$pdf->Cell(20,7, $row->destination_from.' - '. $row->destination_to, 1,0, 'C');
					$pdf->Cell(15,7, $row->quarter_month1, 1,0, 'C');
					$pdf->Cell(15,7, $row->quarter_month2, 1,0, 'C');
					$pdf->Cell(15,7, $row->quarter_month3, 1,0, 'C');
					$pdf->Cell(20,7, $quartersubtotal, 1,0, 'C');
					$pdf->Cell(20,7, $row->destination_to.' - '. $row->destination_from, 1,0, 'C');
					$pdf->Cell(15,7, $row->quarter_month1_d, 1,0, 'C');
					$pdf->Cell(15,7, $row->quarter_month2_d, 1,0, 'C');
					$pdf->Cell(15,7, $row->quarter_month3_d, 1,0, 'C');
					$pdf->Cell(20,7, $quartersubtotal_d, 1,0, 'C');
					$pdf->Cell(22,7, $total, 1,1, 'C');
					
				}

				$pdf->SetFont("Arial", "B", "6");
				
				$pdf->Cell(20,7, 'TOTAL TRANSIT:', 1,0, 'C');
				$pdf->Cell(15,7, $qtr1, 1,0, 'C');
				$pdf->Cell(15,7, $qtr2, 1,0, 'C');
				$pdf->Cell(15,7, $qtr3, 1,0, 'C');
				$pdf->Cell(20,7, $subtotal1, 1,0, 'C');
				$pdf->Cell(20,7, '', 1,0, 'C');
				$pdf->Cell(15,7, $qtr1_d, 1,0, 'C');
				$pdf->Cell(15,7, $qtr2_d, 1,0, 'C');
				$pdf->Cell(15,7, $qtr3_d, 1,0, 'C');
				$pdf->Cell(20,7, $subtotal2, 1,0, 'C');
				$pdf->Cell(22,7, $totaltransit, 1,1, 'C');

				$pdf->Cell(192,14,"",0,1, 'C');



		$pdf->Output();
	}

	public function form51b_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$get->email = preg_split("/[\s,-]+/", $get->email);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(160,5, $get->name.' ['.$get->code.']', 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->telno, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->tin_no, 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->cperson, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email[0], 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm51bDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 51-B : Monthly International Cargo Traffic Flow ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");
		$pdf->Cell(192,7, 'DIRECT CARGO (Kilograms)', 1, 1, 'C');

		//$direct = $this->client_mgt_model->getDirectCargo51b($client_id, $id);

		$pdf->Cell(17,7, 'AIRCRAFT', 1,0, 'C');
		$pdf->Cell(17,7, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(36,3.5, 'CARGO', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(17,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 36);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(35,3.5, 'MAIL', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(16,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 35);
		$pdf->Cell(17,7, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(35,3.5, 'CARGO', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(16,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 35);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(35,3.5, 'MAIL', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(16,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 35);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$route = $this->client_mgt_model->getform51bdirect_route($client_id, $id);
		
		$totalcargoRev = 0;
		$totalcargoNonRev = 0;
		$totalmailRev = 0;
		$totalmailNonRev = 0;
		$totalcargoRevDep = 0;
		$totalcargoNonRevDep = 0;
		$totalmailRevDep = 0;
		$totalmailNonRevDep = 0;

		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->getDirectCargo51b($client_id, $id, $row->routeTo, $row->routeFrom);

			$subcargoRev = 0;
			$subcargoNonRev = 0;
			$submailRev = 0;
			$submailNonRev = 0;
			$subcargoRevDep = 0;
			$subcargoNonRevDep = 0;
			$submailRevDep = 0;
			$submailNonRevDep = 0;
			foreach ($pagination as $key => $row) {
				$pdf->Cell(17,7, $row->aircraft, 1,0, 'L');
				$pdf->Cell(17,7, $row->routeFrom.' - '.$row->routeTo, 1,0, 'L');
				$pdf->Cell(17,7, $row->cargoRev, 1,0, 'R');
				$pdf->Cell(19,7, $row->cargoNonRev, 1,0, 'R');
				$pdf->Cell(16,7, $row->mailRev, 1,0, 'R');
				$pdf->Cell(19,7, $row->mailNonRev, 1,0, 'R');
				$pdf->Cell(17,7, $row->routeTo.' - '.$row->routeFrom, 1,0, 'L');
				$pdf->Cell(16,7, $row->cargoRevDep, 1,0, 'R');
				$pdf->Cell(19,7, $row->cargoNonRevDep, 1,0, 'R');
				$pdf->Cell(16,7, $row->mailRevDep, 1,0, 'R');
				$pdf->Cell(19,7, $row->mailNonRevDep, 1,1, 'R');

				$subcargoRev += $row->cargoRev;
				$subcargoNonRev += $row->cargoNonRev;
				$submailRev += $row->mailRev;
				$submailNonRev += $row->mailNonRev;
				$subcargoRevDep += $row->cargoRevDep;
				$subcargoNonRevDep += $row->cargoNonRevDep;
				$submailRevDep += $row->mailRevDep;
				$submailNonRevDep += $row->mailNonRevDep;
			}

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(34,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(17,7, number_format($subcargoRev, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->cargoNonRev, 2), 1,0, 'R');
			$pdf->Cell(16,7, number_format($submailRev, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->mailNonRev, 2), 1,0, 'R');
			$pdf->Cell(17,7, '', 1,0, 'L');
			$pdf->Cell(16,7, number_format($subcargoRevDep, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->cargoNonRevDep, 2), 1,0, 'R');
			$pdf->Cell(16,7, number_format($submailRevDep, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->mailNonRevDep, 2), 1,1, 'R');

			$pdf->SetFont("Arial", "", "7");

			$totalcargoRev += $subcargoRev;
			$totalcargoNonRev += $subcargoNonRev;
			$totalmailRev += $submailRev;
			$totalmailNonRev += $submailNonRev;
			$totalcargoRevDep += $subcargoRevDep;
			$totalcargoNonRevDep += $subcargoNonRevDep;
			$totalmailRevDep += $submailRevDep;
			$totalmailNonRevDep += $submailNonRevDep;
		}

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(34,7, 'TOTAL ON BOARD:', 1,0, 'L');
		$pdf->Cell(17,7, number_format($subcargoRev, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->cargoNonRev, 2), 1,0, 'R');
		$pdf->Cell(16,7, number_format($submailRev, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->mailNonRev, 2), 1,0, 'R');
		$pdf->Cell(17,7, '', 1,0, 'L');
		$pdf->Cell(16,7, number_format($subcargoRevDep, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->cargoNonRevDep, 2), 1,0, 'R');
		$pdf->Cell(16,7, number_format($submailRevDep, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->mailNonRevDep, 2), 1,1, 'R');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");
		$pdf->Cell(192,7, 'TRANSIT CARGO (Kilograms)', 1, 1, 'C');

		$pdf->Cell(17,7, 'AIRCRAFT', 1,0, 'C');
		$pdf->Cell(17,7, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(36,3.5, 'CARGO', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(17,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 36);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(35,3.5, 'MAIL', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(16,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 35);
		$pdf->Cell(17,7, 'ROUTE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(35,3.5, 'CARGO', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(16,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 35);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(35,3.5, 'MAIL', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(16,3.5, 'REVENUE', 1,0, 'C');
		$pdf->Cell(19,3.5, 'NON REVENUE', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 35);
		$pdf->Cell(0,7, '', 0,1, 'C');
		
		$pdf->SetFont("Arial", "", "7");

		$route = $this->client_mgt_model->getform51btransit_route($client_id, $id);
		
		$totalcargoRev = 0;
		$totalcargoNonRev = 0;
		$totalmailRev = 0;
		$totalmailNonRev = 0;
		$totalcargoRevDep = 0;
		$totalcargoNonRevDep = 0;
		$totalmailRevDep = 0;
		$totalmailNonRevDep = 0;

		foreach ($route as $key => $row) {
			$transit = $this->client_mgt_model->getTransitCargo51b($client_id, $id, $row->routeTo, $row->routeFrom);

			$subcargoRev = 0;
			$subcargoNonRev = 0;
			$submailRev = 0;
			$submailNonRev = 0;
			$subcargoRevDep = 0;
			$subcargoNonRevDep = 0;
			$submailRevDep = 0;
			$submailNonRevDep = 0;
			foreach ($transit as $key => $row) {
				$pdf->Cell(17,7, $row->aircraft, 1,0, 'L');
				$pdf->Cell(17,7, $row->routeFrom.' - '.$row->routeTo, 1,0, 'L');
				$pdf->Cell(17,7, $row->cargoRev, 1,0, 'R');
				$pdf->Cell(19,7, $row->cargoNonRev, 1,0, 'R');
				$pdf->Cell(16,7, $row->mailRev, 1,0, 'R');
				$pdf->Cell(19,7, $row->mailNonRev, 1,0, 'R');
				$pdf->Cell(17,7, $row->routeTo.' - '.$row->routeFrom, 1,0, 'L');
				$pdf->Cell(16,7, $row->cargoRevDep, 1,0, 'R');
				$pdf->Cell(19,7, $row->cargoNonRevDep, 1,0, 'R');
				$pdf->Cell(16,7, $row->mailRevDep, 1,0, 'R');
				$pdf->Cell(19,7, $row->mailNonRevDep, 1,1, 'R');

				$subcargoRev += $row->cargoRev;
				$subcargoNonRev += $row->cargoNonRev;
				$submailRev += $row->mailRev;
				$submailNonRev += $row->mailNonRev;
				$subcargoRevDep += $row->cargoRevDep;
				$subcargoNonRevDep += $row->cargoNonRevDep;
				$submailRevDep += $row->mailRevDep;
				$submailNonRevDep += $row->mailNonRevDep;
			}

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(34,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(17,7, number_format($subcargoRev, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->cargoNonRev, 2), 1,0, 'R');
			$pdf->Cell(16,7, number_format($submailRev, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->mailNonRev, 2), 1,0, 'R');
			$pdf->Cell(17,7, '', 1,0, 'L');
			$pdf->Cell(16,7, number_format($subcargoRevDep, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->cargoNonRevDep, 2), 1,0, 'R');
			$pdf->Cell(16,7, number_format($submailRevDep, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($row->mailNonRevDep, 2), 1,1, 'R');

			$pdf->SetFont("Arial", "", "7");

			$totalcargoRev += $subcargoRev;
			$totalcargoNonRev += $subcargoNonRev;
			$totalmailRev += $submailRev;
			$totalmailNonRev += $submailNonRev;
			$totalcargoRevDep += $subcargoRevDep;
			$totalcargoNonRevDep += $subcargoNonRevDep;
			$totalmailRevDep += $submailRevDep;
			$totalmailNonRevDep += $submailNonRevDep;
		}

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(34,7, 'TOTAL TRANSIT:', 1,0, 'L');
		$pdf->Cell(17,7, number_format($subcargoRev, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->cargoNonRev, 2), 1,0, 'R');
		$pdf->Cell(16,7, number_format($submailRev, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->mailNonRev, 2), 1,0, 'R');
		$pdf->Cell(17,7, '', 1,0, 'L');
		$pdf->Cell(16,7, number_format($subcargoRevDep, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->cargoNonRevDep, 2), 1,0, 'R');
		$pdf->Cell(16,7, number_format($submailRevDep, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($row->mailNonRevDep, 2), 1,1, 'R');

		$pdf->Output();
	}

	public function form61a_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$get->email = preg_split("/[\s,-]+/", $get->email);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(160,5, $get->name.' ['.$get->code.']', 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->telno, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->tin_no, 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->cperson, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email[0], 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm61aDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 61-A : Monthly Statement of Traffic and Operating Statistics (Agricultural Aviation) ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(18,7, 'DATE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(30,3.5, 'AIRCRAFT', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(15,3.5, 'TYPE', 1,0, 'C');
		$pdf->Cell(15,3.5, 'NUMBER', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 30);
		
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(23,7, 'LOCATION', 'TLR',0, 'C');
	
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(25,3.5, 'TYPES OF', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(25,3.5, 'TREATMENT', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 25);
		
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(25,3.5, 'AREA TREATED', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(25,3.5, '(Hectares)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 25);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(25,3.5, 'QUANTITY', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(25,3.5, '(LITERS)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 25);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(22,3.5, 'REVENUE', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(22,3.5, 'EARNED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 22);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(25,3.5, 'A/C FLYING TIME', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(12.5,3.5, 'HOUR', 1,0, 'C');
		$pdf->Cell(12.5,3.5, 'MINUTES', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 25);

		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$getData = $this->client_mgt_model->getForm61aContent($client_id, $id);
		$count = $this->client_mgt_model->form61aCount($client_id, $id);

		if (empty($getData)) {
			$pdf->Cell(192,5,"No Operation",0,1, 'C');
		}
		$total_area = 0;
		$total_flown_hour = 0;
		$total_flown_min = 0;
		$total_qLiters = 0;
		$total_revenue = 0;

		foreach ($getData as $key => $row) {

			if($row->month == '1'){$month = 'Jan';}
			else if($row->month == '2'){$month = 'Feb';}
			else if($row->month == '3'){$month = 'Mar';}
			else if($row->month == '4'){$month = 'Apr';}
			else if($row->month == '5'){$month = 'May';}
			else if($row->month == '6'){$month = 'Jun';}
			else if($row->month == '7'){$month = 'Jul';}
			else if($row->month == '8'){$month = 'Aug';}
			else if($row->month == '9'){$month = 'Sep';}
			else if($row->month == '10'){$month = 'Oct';}
			else if($row->month == '11'){$month = 'Nov';}
			else if($row->month == '12'){$month = 'Dec';}

			$dec = $row->flyTimeMin / 60;
			$x = $dec;
			$y = floor($x);
			$dec = $y * 60;
			$row->flyTimeMin = $row->flyTimeMin - $dec;
			$row->flyTimeHour = $row->flyTimeHour + $y;

			$pdf->Cell(18,7, $row->day.'-'.$month.'-'.$row->year, 1,0, 'L');
			$pdf->Cell(15,7, $row->aircraft, 1,0, 'C');
			$pdf->Cell(15,7, $row->aircraft_num, 1,0, 'C');
			$pdf->Cell(23,7, $row->location, 1,0, 'C');
			$pdf->Cell(25,7, $row->treatment, 1,0, 'C');
			$pdf->Cell(25,7, number_format($row->areaTreated, 2), 1,0, 'R');
			$pdf->Cell(25,7, number_format($row->qLiters, 2), 1,0, 'R');
			$pdf->Cell(22,7, number_format($row->revenue, 2), 1,0, 'R');
			$pdf->Cell(12.5,7, $row->flyTimeHour, 1,0, 'R');
			$pdf->Cell(12.5,7, $row->flyTimeMin, 1,1, 'R');
			
			$total_area += $row->areaTreated;
			$total_flown_hour += $row->flyTimeHour;
			$total_flown_min += $row->flyTimeMin;
			$total_qLiters += $row->qLiters;
			$total_revenue += $row->revenue;
		}

		$hour_min = $total_flown_min / 60;
		$n = $hour_min;
		$whole = floor($n);
		$hour_min = $whole * 60;
		$total_flown_min = $total_flown_min - $hour_min;
		$total_flown_hour = $total_flown_hour + $whole;

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(18,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(78,7, $count->result_count.' Entries', 1,0, 'C');
		$pdf->Cell(25,7, number_format($total_area, 2), 1,0, 'R');
		$pdf->Cell(25,7, number_format($total_qLiters, 2), 1,0, 'R');
		$pdf->Cell(22,7, number_format($total_revenue, 2), 1,0, 'R');
		$pdf->Cell(12.5,7, $total_flown_hour, 1,0, 'R');
		$pdf->Cell(12.5,7, $total_flown_min, 1,1, 'R');
		
		$pdf->Output();

	}

	public function form61b_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$get->email = preg_split("/[\s,-]+/", $get->email);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(160,5, $get->name.' ['.$get->code.']', 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->telno, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->tin_no, 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->cperson, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email[0], 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm61bDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 61-B : Monthly Statement of Traffic and Operating Statistics ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(14,7, 'DATE', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(17,3.5, 'BASE OF', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(17,3.5, 'OPERATION', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 17);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(30,3.5, 'AIRCRAFT', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(18,3.5, 'TYPE', 1,0, 'C');
		$pdf->Cell(12,3.5, 'NUMBER', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 30);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(29,3.5, 'AIRPORTS SERVED', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(10,3.5, 'ORIGIN', 1,0, 'C');
		$pdf->Cell(19,3.5, 'DESTINATION', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 29);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(20,3.5, 'DISTANCE', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(20,3.5, 'Travelled (km)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 20);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(17,3.5, 'FLOWN', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(10,3.5, 'HOUR', 1,0, 'C');
		$pdf->Cell(7,3.5, 'MIN', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 17);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(18,3.5, 'TOTAL', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(18,3.5, 'PASSENGERS', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 18);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(29,3.5, 'CARGO CARRIED', 1,0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(12,3.5, 'QTY(Kg)', 1,0, 'C');
		$pdf->Cell(17,3.5, 'VALUE(Peso)', 1,0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 29);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(22,3.5, 'DERIVED', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(22,3.5, 'REVENUE (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 22);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$getData = $this->client_mgt_model->getForm61bContent($client_id, $id);

		if (empty($getData->result)) {
			$pdf->Cell(192,5,"No Operation",0,1, 'C');
		}
		$total_distance = 0;
		$total_flown_hour = 0;
		$total_flown_min = 0;
		$total_passengers_num = 0;
		$total_cargo_qty = 0;
		$total_cargo_value = 0;
		$total_revenue = 0;

		foreach ($getData->result as $key => $row) {
			if($row->month == '1'){$month = 'Jan';}
			else if($row->month == '2'){$month = 'Feb';}
			else if($row->month == '3'){$month = 'Mar';}
			else if($row->month == '4'){$month = 'Apr';}
			else if($row->month == '5'){$month = 'May';}
			else if($row->month == '6'){$month = 'Jun';}
			else if($row->month == '7'){$month = 'Jul';}
			else if($row->month == '8'){$month = 'Aug';}
			else if($row->month == '9'){$month = 'Sep';}
			else if($row->month == '10'){$month = 'Oct';}
			else if($row->month == '11'){$month = 'Nov';}
			else if($row->month == '12'){$month = 'Dec';}

			$dec = $row->flown_min / 60;
			$x = $dec;
			$y = floor($x);
			$dec = $y * 60;
			$row->flown_min = $row->flown_min - $dec;
			$row->flown_hour = $row->flown_hour + $y;

			$pdf->Cell(14,7, $row->day.'-'.$month.'-'.$row->year, 1,0, 'L');
			$pdf->Cell(17,7, $row->operation, 1,0, 'C');
			$pdf->Cell(18,7, $row->type, 1,0, 'C');
			$pdf->Cell(12,7, $row->aircraft_num, 1,0, 'C');
			$pdf->Cell(10,7, $row->origin, 1,0, 'C');
			$pdf->Cell(19,7, $row->destination, 1,0, 'C');
			$pdf->Cell(20,7, number_format($row->distance, 2), 1,0, 'R');
			$pdf->Cell(10,7, $row->flown_hour, 1,0, 'R');
			$pdf->Cell(7,7, $row->flown_min, 1,0, 'R');
			$pdf->Cell(18,7, $row->passengers_num, 1,0, 'R');
			$pdf->Cell(12,7, number_format($row->cargo_qty, 2), 1,0, 'R');
			$pdf->Cell(17,7, number_format($row->cargo_value, 2), 1,0, 'R');
			$pdf->Cell(22,7, number_format($row->revenue, 2), 1,1, 'R');

			$total_distance += $row->distance;
			$total_flown_hour += $row->flown_hour;
			$total_flown_min += $row->flown_min;
			$total_passengers_num += $row->passengers_num;
			$total_cargo_qty += $row->cargo_qty;
			$total_cargo_value += $row->cargo_value;
			$total_revenue += $row->revenue;
		}

		$pdf->SetFont("Arial", "B", "7");

		$hour_min = $total_flown_min / 60;
		$n = $hour_min;
		$whole = floor($n);
		$hour_min = $whole * 60;
		$total_flown_min = $total_flown_min - $hour_min;
		$total_flown_hour = $total_flown_hour + $whole;

		$pdf->Cell(14,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(76,7, $getData->result_count.' Entries', 1,0, 'C');
		$pdf->Cell(20,7, number_format($total_distance, 2), 1,0, 'R');
		$pdf->Cell(10,7, $total_flown_hour, 1,0, 'R');
		$pdf->Cell(7,7, $total_flown_min, 1,0, 'R');
		$pdf->Cell(18,7, $total_passengers_num, 1,0, 'R');
		$pdf->Cell(12,7, number_format($total_cargo_qty, 2), 1,0, 'R');
		$pdf->Cell(17,7, number_format($total_cargo_value, 2), 1,0, 'R');
		$pdf->Cell(22,7, number_format($total_revenue, 2), 1,1, 'R');
		
		$pdf->Output();
	}

	public function form71a_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$get->email = preg_split("/[\s,-]+/", $get->email);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(160,5, $get->name.' ['.$get->code.']', 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->telno, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->tin_no, 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->cperson, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email[0], 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm71aDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 71-A : International Airfreight Forwarder Cargo Production Report ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,7, 'CARGO DIRECT SHIPMENTS', 1,1, 'C');
		$pdf->Cell(25,7, 'AIR CARRIER', 1,0, 'C');
		$pdf->Cell(25,7, 'ORIGIN', 1,0, 'C');
		$pdf->Cell(25,7, 'DESTINATION', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(28,3.5, 'NUMBER OF', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(28,3.5, 'MAWBS USED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 28);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(28,3.5, 'CHARGEABLE', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(28,3.5, 'WEIGHT (kg)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 28);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(31,3.5, 'AIRLINE FREIGHT', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(31,3.5, 'CHARGES (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 31);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(30,3.5, 'COMMISSION', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(30,3.5, 'EARNED (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 30);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$route = $this->client_mgt_model->getform71a_s1tf1destination($client_id, $id);

		$totalnumMawbs = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalcommission = 0;

		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->get71aShipmentList($client_id, $id, $row->origin, $row->destination);

			$subnumMawbs = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subcommission = 0;
			
			foreach ($pagination as $row) {

				$pdf->SetFont("Arial", "", "7");

				$pdf->Cell(25,7, $row->aircraft, 1,0, 'C');
				$pdf->Cell(25,7, $row->origin, 1,0, 'C');
				$pdf->Cell(25,7, $row->destination, 1,0, 'C');
				$pdf->Cell(28,7, number_format($row->numMawbs, 2), 1,0, 'R');
				$pdf->Cell(28,7, number_format($row->weight, 2), 1,0, 'R');
				$pdf->Cell(31,7, number_format($row->fcharge, 2), 1,0, 'R');
				$pdf->Cell(30,7, number_format($row->commission, 2), 1,1, 'R');

				$subnumMawbs += $row->numMawbs;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subcommission += $row->commission;

			}

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(75,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(28,7, number_format($subnumMawbs, 2), 1,0, 'R');
			$pdf->Cell(28,7, number_format($subweight, 2), 1,0, 'R');
			$pdf->Cell(31,7, number_format($subfcharge, 2), 1,0, 'R');
			$pdf->Cell(30,7, number_format($subcommission, 2), 1,1, 'R');

			$totalnumMawbs += $subnumMawbs;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalcommission += $subcommission;
		}

		$pdf->Cell(75,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(28,7, number_format($totalnumMawbs, 2), 1,0, 'R');
		$pdf->Cell(28,7, number_format($totalweight, 2), 1,0, 'R');
		$pdf->Cell(31,7, number_format($totalfcharge, 2), 1,0, 'R');
		$pdf->Cell(30,7, number_format($totalcommission, 2), 1,1, 'R');

		$pdf->Cell(192,10,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,7, 'CARGO CONSOLIDATION', 1,1, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(31,3.5, 'AIRLINE / AIRFREIGHT', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(31,3.5, 'FORWARDER', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 31);
		$pdf->Cell(30,7, 'DESTINATION', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(38,3.5, 'NUMBER OF AWBS USED', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(19,3.5, 'MAWB', 1, 0, 'C');
		$pdf->Cell(19,3.5, 'HAWB', 1, 0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 38);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(28,3.5, 'CHARGEABLE', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(28,3.5, 'WEIGHT (kg)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 28);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(31,3.5, 'AIRLINE FREIGHT', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(31,3.5, 'CHARGES (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 31);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(34,3.5, 'GROSS CONSOLIDATED', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(34,3.5, 'REVENUE (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 34);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$destination = $this->client_mgt_model->getform71a_s2tf2destination($client_id, $id);

		$totalnumMawbs = 0;
		$totalnumHawbs1 = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalrevenue = 0;

		$type = 'Consolidation';

		foreach ($destination as $key => $row) {
			$pagination = $this->client_mgt_model->get71aCargoConsolidation($client_id, $id, $row->destination, $type);

			$subnumMawbs = 0;
			$subnumHawbs1 = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subrevenue = 0;

			$pdf->SetFont("Arial", "", "7");
			
			foreach ($pagination as $row) {
				$pdf->Cell(31,7, $row->aircraft, 1,0, 'C');
				$pdf->Cell(30,7, $row->destination, 1,0, 'C');
				$pdf->Cell(19,7, number_format($row->numMawbs, 2), 1,0, 'R');
				$pdf->Cell(19,7, number_format($row->numHawbs1, 2), 1,0, 'R');
				$pdf->Cell(28,7, number_format($row->weight, 2), 1,0, 'R');
				$pdf->Cell(31,7, number_format($row->fcharge, 2), 1,0, 'R');
				$pdf->Cell(34,7, number_format($row->revenue, 2), 1,1, 'R');

				$subnumMawbs += $row->numMawbs;
				$subnumHawbs1 += $row->numHawbs1;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subrevenue += $row->revenue;

			}

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(61,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(19,7, number_format($subnumMawbs, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($subnumHawbs1, 2), 1,0, 'R');
			$pdf->Cell(28,7, number_format($subweight, 2), 1,0, 'R');
			$pdf->Cell(31,7, number_format($subfcharge, 2), 1,0, 'R');
			$pdf->Cell(34,7, number_format($subrevenue, 2), 1,1, 'R');

			$totalnumMawbs += $subnumMawbs;
			$totalnumHawbs1 += $subnumHawbs1;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalrevenue += $subrevenue;
		}

		$pdf->Cell(61,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(19,7, number_format($totalnumMawbs, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($totalnumHawbs1, 2), 1,0, 'R');
		$pdf->Cell(28,7, number_format($totalweight, 2), 1,0, 'R');
		$pdf->Cell(31,7, number_format($totalfcharge, 2), 1,0, 'R');
		$pdf->Cell(34,7, number_format($totalrevenue, 2), 1,1, 'R');

		$pdf->Cell(192,10,"",0,1, 'C');

		$pdf->Cell(192,7, 'CARGO BREAKBULKING', 1,1, 'C');
		$pdf->Cell(40,7, 'ORIGIN', 1,0, 'C');
		$pdf->Cell(48,7, 'TOTAL NO. OF HAWBS USED', 1,0, 'C');
		$pdf->Cell(48,7, 'CHARGEABLE WEIGHT (Kg) ', 1,0, 'C');
		$pdf->Cell(56,7, 'INCOME FROM BREAKBULKING (Peso)', 1,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$totalnumHawbs2 = 0;
		$totalorgWeight = 0;
		$totalIncomeBreak = 0;

		$origin = $this->client_mgt_model->getform71a_s2tf2origin($client_id, $id);

		$type = 'Breakbulking';

		foreach ($origin as $key => $row) {
			$pagination = $this->client_mgt_model->get71aCargoConsolidation($client_id, $id, $row->origin, $type);

			$subnumHawbs2 = 0;
			$suborgWeight = 0;
			$subIncomeBreak = 0;
			
			foreach ($pagination as $row) {
				if ($row->origin != "") {
					$pdf->Cell(40,7, $row->origin, 1,0, 'C');
					$pdf->Cell(48,7, $row->numHawbs2, 1,0, 'R');
					$pdf->Cell(48,7, $row->orgWeight, 1,0, 'R');
					$pdf->Cell(56,7, $row->IncomeBreak, 1,1, 'R');

					$subnumHawbs2 += $row->numHawbs2;
					$suborgWeight += $row->orgWeight;
					$subIncomeBreak += $row->IncomeBreak;
				}
			}

			if ($row->origin != "") {
				$pdf->Cell(40,7, 'SUBTOTAL:', 1,0, 'L');
				$pdf->Cell(48,7, $subnumHawbs2, 1,0, 'R');
				$pdf->Cell(48,7, $suborgWeight, 1,0, 'R');
				$pdf->Cell(56,7, $subIncomeBreak, 1,1, 'R');

				$totalnumHawbs2 += $subnumHawbs2;
				$totalorgWeight += $suborgWeight;
				$totalIncomeBreak += $subIncomeBreak;
			}
		}

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(40,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(48,7, number_format($totalnumHawbs2, 2), 1,0, 'R');
		$pdf->Cell(48,7, number_format($totalorgWeight, 2), 1,0, 'R');
		$pdf->Cell(56,7, number_format($totalIncomeBreak, 2), 1,0, 'R');

		$pdf->Output();
	}

	public function form71b_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$get->email = preg_split("/[\s,-]+/", $get->email);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(160,5, $get->name.' ['.$get->code.']', 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->telno, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->tin_no, 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->cperson, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email[0], 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm71bDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 71-B : Domestic Airfreight Forwarder Cargo Production Report ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,7, 'CARGO DIRECT SHIPMENTS', 1,1, 'C');
		$pdf->Cell(25,7, 'AIR CARRIER', 1,0, 'C');
		$pdf->Cell(25,7, 'ORIGIN', 1,0, 'C');
		$pdf->Cell(25,7, 'DESTINATION', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(28,3.5, 'NUMBER OF', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(28,3.5, 'MAWBS USED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 28);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(28,3.5, 'CHARGEABLE', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(28,3.5, 'WEIGHT (kg)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 28);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(31,3.5, 'AIRLINE FREIGHT', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(31,3.5, 'CHARGES (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 31);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(30,3.5, 'COMMISSION', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(30,3.5, 'EARNED (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 30);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");
		
		$route = $this->client_mgt_model->getform71b_s1tf1destination($client_id, $id);

		$totalnumMawbs = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalcommission = 0;

		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->getShipmentList($client_id, $id, $row->origin, $row->destination);

			$subnumMawbs = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subcommission = 0;
			
			foreach ($pagination as $row) {

				$pdf->SetFont("Arial", "", "7");

				$pdf->Cell(25,7, $row->aircraft, 1,0, 'C');
				$pdf->Cell(25,7, $row->origin, 1,0, 'C');
				$pdf->Cell(25,7, $row->destination, 1,0, 'C');
				$pdf->Cell(28,7, number_format($row->numMawbs, 2), 1,0, 'R');
				$pdf->Cell(28,7, number_format($row->weight, 2), 1,0, 'R');
				$pdf->Cell(31,7, number_format($row->fcharge, 2), 1,0, 'R');
				$pdf->Cell(30,7, number_format($row->commission, 2), 1,1, 'R');

				$subnumMawbs += $row->numMawbs;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subcommission += $row->commission;

			}

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(75,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(28,7, number_format($subnumMawbs, 2), 1,0, 'R');
			$pdf->Cell(28,7, number_format($subweight, 2), 1,0, 'R');
			$pdf->Cell(31,7, number_format($subfcharge, 2), 1,0, 'R');
			$pdf->Cell(30,7, number_format($subcommission, 2), 1,1, 'R');

			$totalnumMawbs += $subnumMawbs;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalcommission += $subcommission;
		}

		$pdf->Cell(75,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(28,7, number_format($totalnumMawbs, 2), 1,0, 'R');
		$pdf->Cell(28,7, number_format($totalweight, 2), 1,0, 'R');
		$pdf->Cell(31,7, number_format($totalfcharge, 2), 1,0, 'R');
		$pdf->Cell(30,7, number_format($totalcommission, 2), 1,1, 'R');

		$pdf->Cell(192,10,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,7, 'CARGO CONSOLIDATION', 1,1, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(31,3.5, 'AIRLINE / AIRFREIGHT', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(31,3.5, 'FORWARDER', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 31);
		$pdf->Cell(30,7, 'DESTINATION', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(38,3.5, 'NUMBER OF AWBS USED', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(19,3.5, 'MAWB', 1, 0, 'C');
		$pdf->Cell(19,3.5, 'HAWB', 1, 0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 38);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(28,3.5, 'CHARGEABLE', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(28,3.5, 'WEIGHT (kg)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 28);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(31,3.5, 'AIRLINE FREIGHT', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(31,3.5, 'CHARGES (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 31);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(34,3.5, 'GROSS CONSOLIDATED', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(34,3.5, 'REVENUE (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 34);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$destination = $this->client_mgt_model->getform71b_s2tf2destination($client_id, $id);

		$totalnumMawbs = 0;
		$totalnumHawbs1 = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalrevenue = 0;

		$type = 'Consolidation';

		foreach ($destination as $key => $row) {
			$pagination = $this->client_mgt_model->getCargoConsolidation($client_id, $id, $row->destination, $type);

			$subnumMawbs = 0;
			$subnumHawbs1 = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subrevenue = 0;

			$pdf->SetFont("Arial", "", "7");
			
			foreach ($pagination as $row) {
				$pdf->Cell(31,7, $row->aircraft, 1,0, 'C');
				$pdf->Cell(30,7, $row->destination, 1,0, 'C');
				$pdf->Cell(19,7, number_format($row->numMawbs, 2), 1,0, 'R');
				$pdf->Cell(19,7, number_format($row->numHawbs1, 2), 1,0, 'R');
				$pdf->Cell(28,7, number_format($row->weight, 2), 1,0, 'R');
				$pdf->Cell(31,7, number_format($row->fcharge, 2), 1,0, 'R');
				$pdf->Cell(34,7, number_format($row->revenue, 2), 1,1, 'R');

				$subnumMawbs += $row->numMawbs;
				$subnumHawbs1 += $row->numHawbs1;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subrevenue += $row->revenue;

			}

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(61,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(19,7, number_format($subnumMawbs, 2), 1,0, 'R');
			$pdf->Cell(19,7, number_format($subnumHawbs1, 2), 1,0, 'R');
			$pdf->Cell(28,7, number_format($subweight, 2), 1,0, 'R');
			$pdf->Cell(31,7, number_format($subfcharge, 2), 1,0, 'R');
			$pdf->Cell(34,7, number_format($subrevenue, 2), 1,1, 'R');

			$totalnumMawbs += $subnumMawbs;
			$totalnumHawbs1 += $subnumHawbs1;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalrevenue += $subrevenue;
		}

		$pdf->Cell(61,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(19,7, number_format($totalnumMawbs, 2), 1,0, 'R');
		$pdf->Cell(19,7, number_format($totalnumHawbs1, 2), 1,0, 'R');
		$pdf->Cell(28,7, number_format($totalweight, 2), 1,0, 'R');
		$pdf->Cell(31,7, number_format($totalfcharge, 2), 1,0, 'R');
		$pdf->Cell(34,7, number_format($totalrevenue, 2), 1,1, 'R');

		$pdf->Cell(192,10,"",0,1, 'C');

		$pdf->Cell(192,7, 'CARGO BREAKBULKING', 1,1, 'C');
		$pdf->Cell(40,7, 'ORIGIN', 1,0, 'C');
		$pdf->Cell(48,7, 'TOTAL NO. OF HAWBS USED', 1,0, 'C');
		$pdf->Cell(48,7, 'CHARGEABLE WEIGHT (Kg) ', 1,0, 'C');
		$pdf->Cell(56,7, 'INCOME FROM BREAKBULKING (Peso)', 1,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$totalnumHawbs2 = 0;
		$totalorgWeight = 0;
		$totalIncomeBreak = 0;

		$origin = $this->client_mgt_model->getform71b_s2tf2origin($client_id, $id);

		$type = 'Breakbulking';

		foreach ($origin as $key => $row) {
			$pagination = $this->client_mgt_model->getCargoConsolidation($client_id, $id, $row->origin, $type);

			$subnumHawbs2 = 0;
			$suborgWeight = 0;
			$subIncomeBreak = 0;
			
			foreach ($pagination as $row) {
				if ($row->origin != "") {
					$pdf->SetFont("Arial", "", "7");

					$pdf->Cell(40,7, $row->origin, 1,0, 'C');
					$pdf->Cell(48,7, $row->numHawbs2, 1,0, 'R');
					$pdf->Cell(48,7, $row->orgWeight, 1,0, 'R');
					$pdf->Cell(56,7, $row->IncomeBreak, 1,1, 'R');

					$subnumHawbs2 += $row->numHawbs2;
					$suborgWeight += $row->orgWeight;
					$subIncomeBreak += $row->IncomeBreak;
				}
			}

			if ($row->origin != "") {
				$pdf->SetFont("Arial", "B", "7");

				$pdf->Cell(40,7, 'SUBTOTAL:', 1,0, 'L');
				$pdf->Cell(48,7, $subnumHawbs2, 1,0, 'R');
				$pdf->Cell(48,7, $suborgWeight, 1,0, 'R');
				$pdf->Cell(56,7, $subIncomeBreak, 1,1, 'R');

				$totalnumHawbs2 += $subnumHawbs2;
				$totalorgWeight += $suborgWeight;
				$totalIncomeBreak += $subIncomeBreak;
			}
		}

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(40,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(48,7, number_format($totalnumHawbs2, 2), 1,0, 'R');
		$pdf->Cell(48,7, number_format($totalorgWeight, 2), 1,0, 'R');
		$pdf->Cell(56,7, number_format($totalIncomeBreak, 2), 1,0, 'R');

		$pdf->Output();
	}

	public function form71c_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$get->email = preg_split("/[\s,-]+/", $get->email);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(160,5, $get->name.' ['.$get->code.']', 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->telno, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->tin_no, 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->cperson, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email[0], 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm71cDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 71-C : Cargo Sales Agency Report ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,7, 'SCHEDULED S-1 - CARGO DIRECT SHIPMENTS', 1,1, 'C');
		$pdf->Cell(38,7, 'AIR CARRIER', 1,0, 'C');

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(38,3.5, 'NUMBER OF', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(38,3.5, 'MAWBS USED', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 38);

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(38,3.5, 'CHARGEABLE', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(38,3.5, 'WEIGHT (kg)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 38);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(38,3.5, 'FREIGHT', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(38,3.5, 'CHARGES (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 38);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(40,3.5, 'COMMISSION', 'TLR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(40,3.5, 'EARNED (Peso)', 'BLR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 40);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$getData = $this->client_mgt_model->get71cDirectShipment($client_id, $id);

		if (empty($getData->result)) {
			$pdf->Cell(192,5,"No Operation",0,1, 'C');
		}
		$totalnumMawbs = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalcommission = 0;

		foreach ($getData->result as $key => $row) {
			if($row->aircraft == 'NO OPERATION'){
				$pdf->Cell(192,7, 'No Operation', 1,1, 'C');
			}else{
			$pdf->Cell(38,7, $row->aircraft, 1,0, 'C');
			$pdf->Cell(38,7, number_format($row->numMawbs, 2), 1,0, 'R');
			$pdf->Cell(38,7, number_format($row->weight, 2), 1,0, 'R');
			$pdf->Cell(38,7, number_format($row->fcharge, 2), 1,0, 'R');
			$pdf->Cell(40,7, number_format($row->commission, 2), 1,1, 'R');
			}

			$totalnumMawbs += $row->numMawbs;
			$totalweight += $row->weight;
			$totalfcharge += $row->fcharge;
			$totalcommission += $row->commission;
		}

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(38,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(38,7, number_format($totalnumMawbs, 2), 1,0, 'R');
		$pdf->Cell(38,7, number_format($totalweight, 2), 1,0, 'R');
		$pdf->Cell(38,7, number_format($totalfcharge, 2), 1,0, 'R');
		$pdf->Cell(40,7, number_format($totalcommission, 2), 1,1, 'R');

		$pdf->Cell(192,10,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,10,"",0,1, 'C');

		$pdf->Cell(192,7, 'SCHEDULED TF-1 - DIRECT FLOW SHIPMENTS', 1,1, 'C');
		$pdf->Cell(64,7, 'ORIGIN', 1,0, 'C');
		$pdf->Cell(64,7, 'DESTINATION', 1,0, 'C');
		$pdf->Cell(64,7, 'CHARGEABLE WEIGHT (Kg) ', 1,1, 'C');

		
		$pdf->SetFont("Arial", "", "7");

		$route = $this->client_mgt_model->getform71c_s1tf1route($client_id, $id);

		$totalweight = 0;
		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->get71cFlowShipment($client_id, $id, $row->origin, $row->destination);
			$subweight = 0;
			foreach ($pagination as $key => $row) {
				$pdf->SetFont("Arial", "", "7");

				$pdf->Cell(64,7, $row->origin, 1,0, 'C');
				$pdf->Cell(64,7, $row->destination, 1,0, 'R');
				$pdf->Cell(64,7, number_format($row->weight, 2), 1,1, 'R');

				$subweight += $row->weight;
			}

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(128,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(64,7, number_format($subweight, 2), 1,1, 'R');

			$totalweight += $subweight;

		}

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(128,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(64,7, number_format($totalweight, 2), 1,0, 'R');

		$pdf->Output();
	}

	public function formt1a_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$get->email = preg_split("/[\s,-]+/", $get->email);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(160,5, $get->name.' ['.$get->code.']', 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->telno, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->tin_no, 0, 1, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->cperson, 0, 0, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email[0], 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getFormt1aDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM T-1A : Domestic Sector Load Report ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(30,7, 'Sector', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(22,3.5, 'Distance', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(22,3.5, '[Kilometers]', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 22);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(29,3.5, 'Available Seat -', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(29,3.5, 'Kms Offered', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 29);
		$pdf->Cell(25,7, 'Available Seats', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(18,3.5, 'Revenue', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(18,3.5, 'Passengers', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 18);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(25,3.5, 'Non-Revenue', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(25,3.5, 'Passengers', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 25);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(25,3.5, 'Passenger Load', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(25,3.5, 'Factor', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 25);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(17,3.5, 'Cargo', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(17,3.5, '[Kilograms]', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 17);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$t1aCount = $this->client_mgt_model->t1aCount($client_id, $id);
		$getData = $this->client_mgt_model->getFormt1aContent($client_id, $id);
		if (empty($getData)) {
			$pdf->Cell(192,5,"No Operation",0,1, 'C');
		}
		$totaldistance = 0;
		$totalsk_offered = 0;
		$totalseats_offered = 0;
		$totalrev_pass = 0;
		$totalnonrev_pass = 0;
		$totalload_factor = 0;
		$totalcargo = 0;
		foreach ($getData as $key => $row) {
			$load_factor = (!empty($row->seats_offered))? ($row->rev_pass/$row->seats_offered) * 100 : 0;
			$load_factor_d = (!empty($row->seats_offered_d))? ($row->rev_pass_d/$row->seats_offered_d) * 100 : 0;

			$pdf->SetFont("Arial", "", "7");

			$pdf->Cell(30,7, $row->sector.'/'.$row->sector_d, 1,0, 'L');
			$pdf->Cell(22,7, number_format($row->distance, 0), 1,0, 'R');
			$pdf->Cell(29,7, number_format($row->sk_offered, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($row->seats_offered, 0), 1,0, 'R');
			$pdf->Cell(18,7, number_format($row->rev_pass, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($row->nonrev_pass, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($load_factor, 0).'%', 1,0, 'R');
			$pdf->Cell(17,7, number_format($row->cargo, 0), 1,1, 'R');

			$pdf->Cell(30,7, $row->sector_d.'/'.$row->sector, 1,0, 'L');
			$pdf->Cell(22,7, number_format($row->distance_d, 0), 1,0, 'R');
			$pdf->Cell(29,7, number_format($row->sk_offered_d, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($row->seats_offered_d, 0), 1,0, 'R');
			$pdf->Cell(18,7, number_format($row->rev_pass_d, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($row->nonrev_pass_d, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($load_factor_d, 0).'%', 1,0, 'R');
			$pdf->Cell(17,7, number_format($row->cargo_d, 0), 1,1, 'R');

			$subtotaldistance = $row->distance + $row->distance_d;
			$subtotalsk_offered = $row->sk_offered + $row->sk_offered_d;
			$subtotalseats_offered = $row->seats_offered + $row->seats_offered_d;
			$subtotalrev_pass = $row->rev_pass + $row->rev_pass_d;
			$subtotalnonrev_pass = $row->nonrev_pass + $row->nonrev_pass_d;
			$subtotalload_factor = $load_factor + $load_factor_d;
			$subtotalcargo = $row->cargo + $row->cargo_d;

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(30,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(22,7, number_format($subtotaldistance, 0), 1,0, 'R');
			$pdf->Cell(29,7, number_format($subtotalsk_offered, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($subtotalseats_offered, 0), 1,0, 'R');
			$pdf->Cell(18,7, number_format($subtotalrev_pass, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($subtotalnonrev_pass, 0), 1,0, 'R');
			$pdf->Cell(25,7, number_format($subtotalload_factor, 0).'%', 1,0, 'R');
			$pdf->Cell(17,7, number_format($subtotalcargo, 0), 1,1, 'R');

			$totaldistance += $subtotaldistance;
			$totalsk_offered += $subtotalsk_offered;
			$totalseats_offered += $subtotalseats_offered;
			$totalrev_pass += $subtotalrev_pass;
			$totalnonrev_pass += $subtotalnonrev_pass;
			$totalload_factor += $subtotalload_factor;
			$totalcargo += $subtotalcargo;
		}

		$totalload_factor = $totalload_factor/$t1aCount->result_count;

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(30,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(22,7, number_format($totaldistance, 0), 1,0, 'R');
		$pdf->Cell(29,7, number_format($totalsk_offered, 0), 1,0, 'R');
		$pdf->Cell(25,7, number_format($totalseats_offered, 0), 1,0, 'R');
		$pdf->Cell(18,7, number_format($totalrev_pass, 0), 1,0, 'R');
		$pdf->Cell(25,7, number_format($totalnonrev_pass, 0), 1,0, 'R');
		$pdf->Cell(25,7, number_format($totalload_factor, 0).'%', 1,0, 'R');
		$pdf->Cell(17,7, number_format($totalcargo, 0), 1,1, 'R');

		$pdf->Cell(191,5, $t1aCount->result_count.' Entries', 1,1, 'C');

		$pdf->Cell(192,10,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(191,5,"CODESHARED",1,1, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(20,3.5, 'Marketing', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(20,3.5, 'Airline', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 20);
		$pdf->Cell(20,7, 'Sector', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(20,3.5, 'Distance', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(20,3.5, '[Kilometers]', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 20);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(27,3.5, 'Available Seat -', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(27,3.5, 'Kms Offered', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 27);
		$pdf->Cell(23,7, 'Available Seats', 1,0, 'C');
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(18,3.5, 'Revenue', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(18,3.5, 'Passengers', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 18);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(23,3.5, 'Non-Revenue', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(23,3.5, 'Passengers', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 23);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(23,3.5, 'Passenger Load', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(23,3.5, 'Factor', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 23);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(17,3.5, 'Cargo', 'LTR',0, 'C');
		$pdf->SetY($y + 3.5);
		$pdf->SetX($x);
		$pdf->Cell(17,3.5, '[Kilograms]', 'LBR',0, 'C');
		$pdf->SetY($y);
		$pdf->SetX($x + 17);
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$t1aCountCodeShared = $this->client_mgt_model->t1aCountCodeShared($client_id, $id);
		$getContent = $this->client_mgt_model->getFormt1aContentCodeShared($client_id, $id);
		$totaldistance = 0;
		$totalsk_offered = 0;
		$totalseats_offered = 0;
		$totalrev_pass = 0;
		$totalnonrev_pass = 0;
		$totalload_factor = 0;
		$totalcargo = 0;
		foreach ($getContent as $key => $row) {
			$load_factor = (!empty($row->seats_offered_d))? ($row->rev_pass_d/$row->seats_offered_d) * 100 : 0;
			$load_factor_d = (!empty($row->seats_offered_d))? ($row->rev_pass_d/$row->seats_offered_d) * 100 : 0;
			$pdf->Cell(20,7, $row->title, 1,0, 'L');
			$pdf->Cell(20,7, $row->sector_d.'/'.$row->sector, 1,0, 'L');
			$pdf->Cell(20,7, number_format($row->distance, 0), 1,0, 'R');
			$pdf->Cell(27,7, number_format($row->sk_offered, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($row->seats_offered, 0), 1,0, 'R');
			$pdf->Cell(18,7, number_format($row->rev_pass, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($row->nonrev_pass, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($load_factor, 0).'%', 1,0, 'R');
			$pdf->Cell(17,7, number_format($row->cargo, 0), 1,1, 'R');

			$pdf->Cell(20,7, $row->title, 1,0, 'L');
			$pdf->Cell(20,7, $row->sector_d.'/'.$row->sector_d, 1,0, 'L');
			$pdf->Cell(20,7, number_format($row->distance_d, 0), 1,0, 'R');
			$pdf->Cell(27,7, number_format($row->sk_offered_d, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($row->seats_offered_d, 0), 1,0, 'R');
			$pdf->Cell(18,7, number_format($row->rev_pass_d, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($row->nonrev_pass_d, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($load_factor_d, 0).'%', 1,0, 'R');
			$pdf->Cell(17,7, number_format($row->cargo_d, 0), 1,1, 'R');

			$subtotaldistance = $row->distance + $row->distance_d;
			$subtotalsk_offered = $row->sk_offered + $row->sk_offered_d;
			$subtotalseats_offered = $row->seats_offered + $row->seats_offered_d;
			$subtotalrev_pass = $row->rev_pass + $row->rev_pass_d;
			$subtotalnonrev_pass = $row->nonrev_pass + $row->nonrev_pass_d;
			$subtotalload_factor = $load_factor + $load_factor_d;
			$subtotalcargo = $row->cargo + $row->cargo_d;

			$pdf->SetFont("Arial", "B", "7");

			$pdf->Cell(40,7, 'SUBTOTAL:', 1,0, 'L');
			$pdf->Cell(20,7, number_format($subtotaldistance, 0), 1,0, 'R');
			$pdf->Cell(27,7, number_format($subtotalsk_offered, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($subtotalseats_offered, 0), 1,0, 'R');
			$pdf->Cell(18,7, number_format($subtotalrev_pass, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($subtotalnonrev_pass, 0), 1,0, 'R');
			$pdf->Cell(23,7, number_format($subtotalload_factor, 0).'%', 1,0, 'R');
			$pdf->Cell(17,7, number_format($subtotalcargo, 0), 1,1, 'R');

			$totaldistance += $subtotaldistance;
			$totalsk_offered += $subtotalsk_offered;
			$totalseats_offered += $subtotalseats_offered;
			$totalrev_pass += $subtotalrev_pass;
			$totalnonrev_pass += $subtotalnonrev_pass;
			$totalload_factor += $subtotalload_factor;
			$totalcargo += $subtotalcargo;
		}

		if ($t1aCountCodeShared->result_count != 0) {
			$totalload_factor = $totalload_factor/$t1aCountCodeShared->result_count;
		}

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(40,7, 'TOTAL:', 1,0, 'L');
		$pdf->Cell(20,7, number_format($totaldistance, 0), 1,0, 'C');
		$pdf->Cell(27,7, number_format($totalsk_offered, 0), 1,0, 'R');
		$pdf->Cell(23,7, number_format($totalseats_offered, 0), 1,0, 'R');
		$pdf->Cell(18,7, number_format($totalrev_pass, 0), 1,0, 'R');
		$pdf->Cell(23,7, number_format($totalnonrev_pass, 0), 1,0, 'R');
		$pdf->Cell(23,7, number_format($totalload_factor, 0).'%', 1,0, 'R');
		$pdf->Cell(17,7, number_format($totalcargo, 0), 1,1, 'R');
		if ($t1aCountCodeShared->result_count != 0) {
			$pdf->Cell(191,5, $getContent->result_count.' Entries', 1,1, 'C');
		}
		else {
			$pdf->Cell(191,5,'0 Entries', 1,1, 'C');
		}
		
		$pdf->Output();
	}

	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_create() {
		$mail					= new PHPMailer(true);
		$temp_username 			= $this->input->post('temp_username');
		$code 					= $this->input->post('code');
		$airline_represented 	= $this->input->post('airline_represented');
		$name 					= $this->input->post('name');
		$email 					= $this->input->post('email');
		$air_type 				= $this->input->post('air_type');
		$pass					= $this->portal->randomPassword();
		
		$message = "<span style = 'font-face:arial'>Civil Aeronautics Board of the Philippines</span><br>";
		$message .= "<span style = 'font-face:arial'><b>Client Name : </b> $name </span><br>";
		$message .= "<span style = 'font-face:arial'><b>Email : </b> $email </span><br>";
		$message .= "<span style = 'font-face:arial'><b>Temporary Account Login Profile</b></span><br>";
    	$message .= "<span style = 'font-face:arial'><b>Username : </b> $temp_username </span><br>";
		$message .= "<span style = 'font-face:arial'><b>Password : </b> $pass </span><br>";
		$message .= "<span style = 'font-face:arial'>You can now logon at <a target='_blank' href='http://www.cab.gov.ph/portal/'><B>CAB - PORTAL</B></a> and create your Company Profile and Master Administrator</span><br>";
		$message .= "<span style = 'font-face:arial'>or you may copy and paste this url <B>http://www.cab.gov.ph/portal/</B> to the address bar.</span>";
		
		$this->portal->sendEmail($message, $email);

		$data = $this->input->post($this->fields);
		$result = $this->client_mgt_model->saveClient($data, $pass);
		if($result == true ) {
			$code = $data['code'];
			$client_id = $this->client_mgt_model->getId($code);
			$nature_id = $this->client_mgt_model->getNatureId($air_type);
		}

		$this->nature = array('client_id', 'nature_id');

		$nature = $this->input->post($this->nature);
		$nature['client_id'] = $client_id->id;

		foreach($nature_id as $naturer) :
			$nature['nature_id'] = $naturer->id;
			$save_nature = $this->client_mgt_model->saveNature($nature);
		endforeach;
	
		return array(
			'redirect'	=> MODULE_URL,
			'success'	=> $result
		);
	}

	function generatePassword($max_length=8) 
	{	$pass = "";
		$salt = "abcdefghijklmnopqrstuvwxyz123456789-_.";
		srand((double)microtime()*1000000);
		$i = 0;
		while ($i < 15 ) 
		{	$num = rand() % 33;
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		if ( strlen ( $pass ) > $max_length )
			$pass = substr ( $pass , 0, $max_length ) ;
		return $pass;
	}

	private function ajax_edit() {
		$client_id	= $this->input->post('client_id');
		$data		= $this->input->post($this->client_fields);

		$result		= $this->client_mgt_model->updateClient($data, $client_id);

		return array(
			'redirect'	=> MODULE_URL . 'client_info/' . $client_id,
			'success'	=> $result
		);
	}

	private function ajax_cancel_report() {
		$client_id	= $this->input->post('client_id');
		$db_table	= $this->input->post('db_table');
		$id	= $this->input->post('id');
		$result		= $this->client_mgt_model->cancelReport($db_table, $id);

		return array(
			'redirect'	=> MODULE_URL .'view_report_list/'.$client_id.'/'.$db_table,
			'success'	=> $result
		);
	}

	private function ajax_list() {
		$nature	= $this->input->post('nature');
		$search	= $this->input->post('search');
		$limit	= $this->input->post('limit');
		$abc	= $this->input->post('abc');
		
		$natureids = $this->client_mgt_model->getNatureList($this->username);
		$pagination = $this->client_mgt_model->getClientList($nature, $search, $natureids,$abc);
		$table = '';   
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="5" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td class="text-center">'. ((($pagination->page - 1) * $limit) + $key + 1) .'</td>';
			$table .= '<td>'.$row->code.'</td>';
			$table .= '<td><a href = "'.MODULE_URL.'client_info/'.$row->id.'">'.$row->name.'</a></td>';
			$table .= '<td>'.$row->country.'</td>';
			$table .= '<td class="text-center">'.$row->status.'</td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_user_list() {
		$table = '';   
			$table .= '<tr>';
			$table .= '<td style = "text-align:center">1</td>';
			$table .= '<td>Sobrecarey, Marietta P.</td>';
			$table .= '<td>Freight Forwarding Manager</td>';
			$table .= '<td>suzette.espiritu@stemiko.net</td>';
			$table .= '<td style = "text-align:center">Reset Password | Edit Profile | Reset Username</td>';
			$table .= '<td>Master Admin</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_report_list() {
		$client_id = $this->input->post('client_id');
		$pagination = $this->client_mgt_model->getClientReportList($client_id);
		$table = '';   
		if (empty($pagination)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination as $key => $row) {
			$count = $this->client_mgt_model->getReportCount($client_id, $row->db_table);
			$table .= '<tr>';
			$table .= '<td>'.$row->short_title.'</td>';
			$table .= '<td>'.$row->title.'</td>';
			$table .= '<td style = "text-align:center">'.$count->result_count.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'view_report_list/'.$client_id.'/'.$row->db_table.'">View</a></td>';
			$table .= '</tr>';
		}
		return array('table' => $table);
	}

	private function ajax_late_report_list() {
		$client_id = $this->input->post('client_id');
		$pagination = $this->client_mgt_model->getClientReportList($client_id);
		$table = '';   
		if (empty($pagination)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination as $key => $row) {
			$count = $this->client_mgt_model->getLateReportCount($client_id, $row->db_table);
			if($count->result_count > 0){			
			$table .= '<tr>';
			$table .= '<td>'.$row->short_title.'</td>';
			$table .= '<td>'.$row->title.'</td>';
			$table .= '<td align="center">'.$count->result_count.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'view_late_report_list/'.$client_id.'/'.$row->db_table.'">View</a></td>';
			$table .= '</tr>';
			}
		}
		return array('table' => $table);
	}

	private function ajax_view_report_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$db_table = $this->input->post('db_table');
		$data		= $this->input->post(array('month', 'year','sort'));
		$month		= $data['month'];
		$year		= $data['year'];
		$sort		= $data['sort'];		
		$pagination = $this->client_mgt_model->getReportList($client_id, $db_table, $month, $year, $sort);
		$table = '';   
		if (empty($pagination)) {
			$table = '<tr><td colspan="6" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			
			if($db_table == 'form51a'){
				if($row->timespan == '1') {$row->timespan = 'Quarter 1';}
				elseif($row->timespan == '2') {$row->timespan = 'Quarter 2';}
				elseif($row->timespan == '3') {$row->timespan = 'Quarter 3';}
				elseif($row->timespan == '4') {$row->timespan = 'Quarter 4';}
			}
			else{
				if ($row->timespan == '1') {$row->timespan = 'January';}
				else if ($row->timespan == '2') {$row->timespan = 'February';}
				else if ($row->timespan == '3') {$row->timespan = 'March';}
				else if ($row->timespan == '4') {$row->timespan = 'April';}
				else if ($row->timespan == '5') {$row->timespan = 'May';}
				else if ($row->timespan == '6') {$row->timespan = 'June';}
				else if ($row->timespan == '7') {$row->timespan = 'July';}
				else if ($row->timespan == '8') {$row->timespan = 'August';}
				else if ($row->timespan == '9') {$row->timespan = 'September';}
				else if ($row->timespan == '10') {$row->timespan = 'October';}
				else if ($row->timespan == '11') {$row->timespan = 'November';}
				else if ($row->timespan == '12') {$row->timespan = 'December';}
			}
			$submitteddate=date_create($row->submitteddate);
			$submitteddate = date_format($submitteddate,"d M Y");
			$approveddate=date_create($row->approveddate);
			$approveddate = date_format($approveddate,"d M Y");
			$table .= '<tr>';
			if($db_table=='form51a'){
				$table .= '<td align="center">'.$row->timespan.' '.$row->year.'</td>';
			}else{
				$table .= '<td>'.$row->timespan.' '.$row->year.'</td>';
			}
			
			$table .= '<td>'.$row->submittedby.'</td>';
			$table .= '<td style = "text-align:center">'.$submitteddate.'</td>';
			$table .= '<td>'.$row->approvedby.'</td>';
			$table .= '<td style = "text-align:center">'.$approveddate.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'report_viewer/'.$client_id.'/'.$db_table.'/'.$row->id.'">'.$row->status.'</a>&nbsp;&nbsp;<a href = "'.MODULE_URL.'cancel_report/'.$client_id.'/'.$db_table.'/'.$row->id.'">Cancel</a></td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_view_late_report_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$db_table = $this->input->post('db_table');
		$data		= $this->input->post(array('month', 'year','sort'));
		$month		= $data['month'];
		$year		= $data['year'];
		$sort		= $data['sort'];
		$pagination = $this->client_mgt_model->getLateReportList($client_id, $db_table, $month, $year, $sort);
		$table = '';   
		if (empty($pagination)) {
			$table = '<tr><td colspan="6" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			if($db_table == 'form51a'){
				if($row->timespan == '1') {$row->timespan = 'Quarter 1';}
				elseif($row->timespan == '2') {$row->timespan = 'Quarter 2';}
				elseif($row->timespan == '3') {$row->timespan = 'Quarter 3';}
				elseif($row->timespan == '4') {$row->timespan = 'Quarter 4';}
			}
			else{
				if ($row->timespan == '1') {$row->timespan = 'January';}
				else if ($row->timespan == '2') {$row->timespan = 'February';}
				else if ($row->timespan == '3') {$row->timespan = 'March';}
				else if ($row->timespan == '4') {$row->timespan = 'April';}
				else if ($row->timespan == '5') {$row->timespan = 'May';}
				else if ($row->timespan == '6') {$row->timespan = 'June';}
				else if ($row->timespan == '7') {$row->timespan = 'July';}
				else if ($row->timespan == '8') {$row->timespan = 'August';}
				else if ($row->timespan == '9') {$row->timespan = 'September';}
				else if ($row->timespan == '10') {$row->timespan = 'October';}
				else if ($row->timespan == '11') {$row->timespan = 'November';}
				else if ($row->timespan == '12') {$row->timespan = 'December';}
			}
			$submitteddate=date_create($row->submitteddate);
			$submitteddate = date_format($submitteddate,"d M Y");
			$approveddate=date_create($row->approveddate);
			$approveddate = date_format($approveddate,"d M Y");
			$table .= '<tr>';
			if($db_table=='form51a'){
				$table .= '<td align="center">'.$row->timespan.' '.$row->year.'</td>';
			}else{
				$table .= '<td>'.$row->timespan.' '.$row->year.'</td>';
			}
			
			$table .= '<td>'.$row->submittedby.'</td>';
			$table .= '<td style = "text-align:center">'.$submitteddate.'</td>';
			$table .= '<td>'.$row->approvedby.'</td>';
			$table .= '<td style = "text-align:center">'.$approveddate.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'report_viewer/'.$client_id.'/'.$db_table.'/'.$row->id.'">'.$row->status.'</a><a href = "">&nbsp;&nbsp; Cancel</a></td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}
	
	private function ajax_history_list() {
		$client_id = $this->input->post('client_id');
		$pagination = $this->client_mgt_model->getClientReportList($client_id);
		$table = '';   
		if (empty($pagination)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination as $key => $row) {
			$count = $this->client_mgt_model->getReportHistoryCount($client_id, $row->db_table);
			$table .= '<tr>';
			$table .= '<td>'.$row->short_title.'</td>';
			$table .= '<td>'.$row->title.'</td>';
			$table .= '<td style = "text-align:center">'.$count->result_count.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'view_history_list/'.$client_id.'/'.$row->db_table.'">View</a></td>';
			$table .= '</tr>';
		}
		return array('table' => $table);
	}

	private function ajax_view_reporthistory() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$db_table = $this->input->post('db_table');
		$pagination = $this->client_mgt_model->getReportHistoryList($client_id, $db_table);
		$table = '';   
		$count = 0;
		if (empty($pagination)) {
			$table = '<tr><td colspan="6" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination as $key => $row) {
			if($db_table == 'form51a'){
			if($row->timespan == '1') {$row->timespan = '1st Quarter (Jan,Feb,Mar)';}
			elseif($row->timespan == '2') {$row->timespan = '2nd Quarter (Apr,May,Jun)';}
			elseif($row->timespan == '3') {$row->timespan = '3rd Quarter (July,Aug,Sep)';}
			elseif($row->timespan == '4') {$row->timespan = '4th Quarter (Oct,Nov,Dec)';}
			}
			else{
			if ($row->timespan == '1') {$row->timespan = 'January';}
			else if ($row->timespan == '2') {$row->timespan = 'February';}
			else if ($row->timespan == '3') {$row->timespan = 'March';}
			else if ($row->timespan == '4') {$row->timespan = 'April';}
			else if ($row->timespan == '5') {$row->timespan = 'May';}
			else if ($row->timespan == '6') {$row->timespan = 'June';}
			else if ($row->timespan == '7') {$row->timespan = 'July';}
			else if ($row->timespan == '8') {$row->timespan = 'August';}
			else if ($row->timespan == '9') {$row->timespan = 'September';}
			else if ($row->timespan == '10') {$row->timespan = 'October';}
			else if ($row->timespan == '11') {$row->timespan = 'November';}
			else if ($row->timespan == '12') {$row->timespan = 'December';}
			}
			
			$submitteddate=date_create($row->submitteddate);
			$submitteddate = date_format($submitteddate,"M d, Y");

			$table .= '<tr>';
			$count += 1;
			$table .= '<td style = "text-align:center">'.$count.'</td>';
			$table .= '<td style = "text-align:center">'.$row->timespan.'</td>';
			$table .= '<td style = "text-align:center">'.$row->year.'</td>';
			$table .= '<td style = "text-align:center">'.$submitteddate.'</td>';
			$table .= '<td>'.$row->submittedby.'</td>';
			$table .= '<td style = "text-align:center">'.$row->status.'</td>';
			$table .= '</tr>';
		}
		return array('table' => $table);
	}

	private function ajax_operation_list() {
		$pagination = $this->client_mgt_model->getNatureOperation();
		$table = '';   
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			$table .= '<tr>';
			$table .= '<td><input type = "checkbox" name = "air_type[]" id = "air_type" value = "'.$row->title.'"> '.$row->title.'</td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_checked_operation_list() {
		$client_id = $this->input->post('client_id');
		$nature = $this->client_mgt_model->getCheckClientNature($client_id);

		$table = '';   
		if (empty($nature)) {
			$table = '<tr><td colspan="1" class="text-center"><b>No Records Found</b></td></tr>';
		}

		foreach ($nature as $key => $row) :
		$table .= '<tr>';
		$table .= '<td><input ' . (($row->nature_id) ? 'checked': '') . ' type = "checkbox" name = "air_type[]" id = "air_type" value = "'.$row->id.'"> '.$row->title.'</td>';
		$table .= '</tr>';
		endforeach;

		return array('table' => $table);
	}

	private function ajax_add_operation() {
		$client_id				= $this->input->post('client_id');
		$air_type 				= $this->input->post('air_type');
		$nature					= array('nature_id' => $air_type);

		$result = $this->client_mgt_model->updateClientNature($nature, $client_id);
		
		return array(
			'redirect'	=> MODULE_URL . "add_operation/$client_id",
			'success'	=> $result
		); 
	}

	private function ajax_update_status() {
		$client_id				= $this->input->post('client_id');
		$status = $this->input->post('status');
		$result = $this->client_mgt_model->updateClientStatus($status, $client_id);
		if ($result) {
			$message = 'Client Status Updated';
			return array(
				'success'	=> $result,
				'message'	=> $message
			); 
		}
	}

	private function ajax_late_submitted_report_list() {
		$id = $this->input->post('id');
		$client_id = $this->input->post('client_id');
		$db_table = $this->input->post('db_table');
		$data		= $this->input->post(array('form', 'code','name','month', 'year','sort'));
		$form		= $data['form'];
		$code		= $data['code'];
		$name		= $data['name'];	
		$month		= $data['month'];	
		$year		= $data['year'];
		$sort		= $data['sort'];
		// var_dump($data);
		$pagination = $this->client_mgt_model->getLateClientReportList($client_id);
		$table = '';   
		if (empty($pagination)) {
			$table = '<tr><td colspan="6" class="text-center"><b>No Records Found</b></td></tr>';
		}
		if($form != ''){
			$late = $this->client_mgt_model->getLateReportList1($month, $year, $sort, $form, $code, $name);
		
			foreach ($late->result as $key => $row1) {
				if ($row1->timespan == '1') {$row1->timespan = 'January';}
				else if ($row1->timespan == '2') {$row1->timespan = 'February';}
				else if ($row1->timespan == '3') {$row1->timespan = 'March';}
				else if ($row1->timespan == '4') {$row1->timespan = 'April';}
				else if ($row1->timespan == '5') {$row1->timespan = 'May';}
				else if ($row1->timespan == '6') {$row1->timespan = 'June';}
				else if ($row1->timespan == '7') {$row1->timespan = 'July';}
				else if ($row1->timespan == '8') {$row1->timespan = 'August';}
				else if ($row1->timespan == '9') {$row1->timespan = 'September';}
				else if ($row1->timespan == '10') {$row1->timespan = 'October';}
				else if ($row1->timespan == '11') {$row1->timespan = 'November';}
				else if ($row1->timespan == '12') {$row1->timespan = 'December';}
				
				if($form == 'form51a'){
				if($row1->timespan == '1') {$row1->timespan = '1st Quarter (Jan,Feb,Mar)';}
				elseif($row1->timespan == '2') {$row1->timespan = '2nd Quarter (Apr,May,Jun)';}
				elseif($row1->timespan == '3') {$row1->timespan = '3rd Quarter (July,Aug,Sep)';}
				elseif($row1->timespan == '4') {$row1->timespan = '4th Quarter (Oct,Nov,Dec)';}
				}

				if ($form == 'form51a') {$form = 'FORM 51-A';}
				else if ($form == 'form51b') {$form = 'FORM 51-B';}
				else if ($form == 'form61a') {$form = 'FORM 61-A';}
				else if ($form == 'form61b') {$form = 'FORM 51-B';}
				else if ($form == 'form71a') {$form = 'FORM 71-A International';}
				else if ($form == 'form71b') {$form = 'FORM 71-B Domestic';}
				else if ($form == 'form71c') {$form = 'FORM 71-C Cargo Sales';}
				else if ($form == 'formt1a') {$form = 'FORM T-1A';}
				else if ($form == 'MTSR') {$form = 'Monthly Ticket Sales Report';}

				$submitteddate=date_create($row1->submitteddate);
				$submitteddate = date_format($submitteddate,"d M Y");
				$approveddate=date_create($row1->approveddate);
				$approveddate = date_format($approveddate,"d M Y");

			
			$table .= '<tr>';
			$table .= '<td>'.$form.'</td>';
			$table .= '<td>'.$row1->name.' ['.$row1->code.']'.'</td>';
			$table .= '<td>'.$row1->timespan.' '.$row1->year.'</td>';
			$table .= '<td style = "text-align:center">'.$row1->submittedby.'</td>';
			$table .= '<td style = "text-align:center">'.$submitteddate.'</td>';
			$table .= '<td>'.$row1->approvedby.'</td>';
			$table .= '<td style = "text-align:center">'.$approveddate.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'report_viewer/'.$row1->client_id.'/'.$form.'/'.$row1->id.'">'.$row1->status.'</a></td>';
			// $table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'view_late_report_list/'.$row->id.'/'.$row->db_table.'">View</a></td>';
			$table .= '</tr>';
			
			}
		}else{
		foreach ($pagination->result as $key => $row) {
			$late = $this->client_mgt_model->getLateReportList($row->id, $row->db_table, $month, $year, $sort, $form, $code, $name);
			foreach ($late->result as $key => $row1) {
				if ($row1->timespan == '1') {$timespan = 'January';}
				else if ($row1->timespan == '2') {$timespan = 'February';}
				else if ($row1->timespan == '3') {$timespan = 'March';}
				else if ($row1->timespan == '4') {$timespan = 'April';}
				else if ($row1->timespan == '5') {$timespan = 'May';}
				else if ($row1->timespan == '6') {$timespan = 'June';}
				else if ($row1->timespan == '7') {$timespan = 'July';}
				else if ($row1->timespan == '8') {$timespan = 'August';}
				else if ($row1->timespan == '9') {$timespan = 'September';}
				else if ($row1->timespan == '10') {$timespan = 'October';}
				else if ($row1->timespan == '11') {$timespan = 'November';}
				else if ($row1->timespan == '12') {$timespan = 'December';}
				
				if($row->db_table == 'form51a'){
				if($row1->timespan == '1') {$timespan = '1st Quarter (Jan,Feb,Mar)';}
				elseif($row1->timespan == '2') {$timespan = '2nd Quarter (Apr,May,Jun)';}
				elseif($row1->timespan == '3') {$timespan = '3rd Quarter (July,Aug,Sep)';}
				elseif($row1->timespan == '4') {$timespan = '4th Quarter (Oct,Nov,Dec)';}
				}

				$submitteddate=date_create($row1->submitteddate);
				$submitteddate = date_format($submitteddate,"d M Y");
				$approveddate=date_create($row1->approveddate);
				$approveddate = date_format($approveddate,"d M Y");

			
			$table .= '<tr>';
			$table .= '<td>'.$row->short_title.'</td>';
			// $table .= '<td>'.$row->code.'</td>';
			$table .= '<td>'.$row1->name.' ['.$row1->code.']'.'</td>';
			if($year != ''){
				$table .= '<td>'.$row1->timespan.' '.$row1->year.'</td>';

			}else{
				$table .= '<td>'.$timespan.' '.$row1->year.'</td>';
			}
			$table .= '<td style = "text-align:center">'.$row1->submittedby.'</td>';
			$table .= '<td style = "text-align:center">'.$submitteddate.'</td>';
			$table .= '<td>'.$row1->approvedby.'</td>';
			$table .= '<td style = "text-align:center">'.$approveddate.'</td>';
			$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'report_viewer/'.$row1->client_id.'/'.$row->db_table.'/'.$row1->id.'">'.$row1->status.'</a></td>';
			// $table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'view_late_report_list/'.$row->id.'/'.$row->db_table.'">View</a></td>';
			$table .= '</tr>';
			
		}
	
	}
}
		$pagination->table = $table;
		return $pagination;

	// $id = $this->input->post('id');
	// 	$client_id = $this->input->post('client_id');
	// 	$db_table = $this->input->post('db_table');
	// 	$data		= $this->input->post(array('month', 'year','sort'));
	// 	$month		= $data['month'];
	// 	$year		= $data['year'];
	// 	$sort		= $data['sort'];
	// 	$pagination = $this->client_mgt_model->getLateReportList($client_id, $db_table, $month, $year, $sort);
	// 	$table = '';   
	// 	if (empty($pagination)) {
	// 		$table = '<tr><td colspan="6" class="text-center"><b>No Records Found</b></td></tr>';
	// 	}
	// 	foreach ($pagination->result as $key => $row) {
	// 		if($db_table == 'form51a'){
	// 			if($row->timespan == '1') {$row->timespan = 'Quarter 1';}
	// 			elseif($row->timespan == '2') {$row->timespan = 'Quarter 2';}
	// 			elseif($row->timespan == '3') {$row->timespan = 'Quarter 3';}
	// 			elseif($row->timespan == '4') {$row->timespan = 'Quarter 4';}
	// 		}
	// 		else{
	// 			if ($row->timespan == '1') {$row->timespan = 'January';}
	// 			else if ($row->timespan == '2') {$row->timespan = 'February';}
	// 			else if ($row->timespan == '3') {$row->timespan = 'March';}
	// 			else if ($row->timespan == '4') {$row->timespan = 'April';}
	// 			else if ($row->timespan == '5') {$row->timespan = 'May';}
	// 			else if ($row->timespan == '6') {$row->timespan = 'June';}
	// 			else if ($row->timespan == '7') {$row->timespan = 'July';}
	// 			else if ($row->timespan == '8') {$row->timespan = 'August';}
	// 			else if ($row->timespan == '9') {$row->timespan = 'September';}
	// 			else if ($row->timespan == '10') {$row->timespan = 'October';}
	// 			else if ($row->timespan == '11') {$row->timespan = 'November';}
	// 			else if ($row->timespan == '12') {$row->timespan = 'December';}
	// 		}
	// 		$submitteddate=date_create($row->submitteddate);
	// 		$submitteddate = date_format($submitteddate,"d M Y");
	// 		$approveddate=date_create($row->approveddate);
	// 		$approveddate = date_format($approveddate,"d M Y");
	// 		$table .= '<tr>';
	// 		if($db_table=='form51a'){
	// 			$table .= '<td align="center">'.$row->timespan.' '.$row->year.'</td>';
	// 		}else{
	// 			$table .= '<td>'.$row->timespan.' '.$row->year.'</td>';
	// 		}
			
	// 		$table .= '<td>'.$row->submittedby.'</td>';
	// 		$table .= '<td style = "text-align:center">'.$submitteddate.'</td>';
	// 		$table .= '<td>'.$row->approvedby.'</td>';
	// 		$table .= '<td style = "text-align:center">'.$approveddate.'</td>';
	// 		$table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'report_viewer/'.$client_id.'/'.$db_table.'/'.$row->id.'">'.$row->status.'</a><a href = "">&nbsp;&nbsp; Cancel</a></td>';
	// 		$table .= '</tr>';
	// 	}
	// 	$pagination->table = $table;
	// 	return $pagination;
	

	}

	private function ajax_suspended_clients_list() {
	
		$pagination = $this->client_mgt_model->getSuspendedUsers();

		if (empty($pagination->result)) {
			$table = '<tr><td colspan="11" class="text-center"><b>No Record Found</b></td></tr>';
		}
		$table = '';   
		foreach ($pagination->result as $row) {
			$table .= '<tr>';
			$table .= '<td style = "text-align:center">'.$row->id.'</td>';
			$table .= '<td style = "text-align:center">'.$row->code.'</td>';
			$table .= '<td><a href = "'.MODULE_URL.'client_info/'.$row->id.'">'.$row->name.'</a></td>';
			$table .= '<td>'.$row->tin_no.'</td>';
			$table .= '<td>'.$row->country.'</td>';
			$table .= '<td style = "text-align:center">'.$row->status.'</td>';
			$table .= '</tr>';
		}
		$pagination->table = $table;
		return $pagination;
	}

	private function ajax_terminated_clients_list() {
		$pagination = $this->client_mgt_model->getTerminatedUsers();
		
				if (empty($pagination->result)) {
					$table = '<tr><td colspan="11" class="text-center"><b>No Record Found</b></td></tr>';
				}
				$table = '';   
				foreach ($pagination->result as $row) {
					$table .= '<tr>';
					$table .= '<td style = "text-align:center">'.$row->id.'</td>';
					$table .= '<td style = "text-align:center">'.$row->code.'</td>';
					$table .= '<td><a href = "'.MODULE_URL.'client_info/'.$row->id.'">'.$row->name.'</a></td>';
					$table .= '<td>'.$row->tin_no.'</td>';
					$table .= '<td>'.$row->country.'</td>';
					$table .= '<td style = "text-align:center">'.$row->status.'</td>';
					$table .= '</tr>';
				}
				$pagination->table = $table;
				return $pagination;
	}

	private function ajax_reg_client_operation_list() {
		$table = '';   
			$table .= '<tr>';
			$table .= '<td><b>International Airfreight Forwarders</b></td>';
			$table .= '<td style = "text-align:center">No Expiration Set <a href = "'.MODULE_URL.'update_operation_status">Update</a></td>';
			$table .= '<td style = "text-align:center">Not Set</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_check_code() {
		$code	= $this->input->post('code');
		$result = $this->client_mgt_model->checkCode($code);
		return array(
			'available'	=> $result
		);
	}

	private function ajax_check_temp_username() {
		$temp_username	= $this->input->post('temp_username');
		$reference		= $this->input->post('temp_username_ref');
		$result = $this->client_mgt_model->checkUsername($temp_username, $reference);
		return array(
			'available'	=> $result
		);
	}

	private function ajax_direct_cargo_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "2">Aircraft</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
		$table .= '</tr>';

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '</tr>';

		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$route = $this->client_mgt_model->getform51bdirect_route($client_id, $id);
		
		$totalcargoRev = 0;
		$totalcargoNonRev = 0;
		$totalmailRev = 0;
		$totalmailNonRev = 0;
		$totalcargoRevDep = 0;
		$totalcargoNonRevDep = 0;
		$totalmailRevDep = 0;
		$totalmailNonRevDep = 0;

		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->getDirectCargo51b($client_id, $id, $row->routeTo, $row->routeFrom);

			$subcargoRev = 0;
			$subcargoNonRev = 0;
			$submailRev = 0;
			$submailNonRev = 0;
			$subcargoRevDep = 0;
			$subcargoNonRevDep = 0;
			$submailRevDep = 0;
			$submailNonRevDep = 0;
			
			foreach ($pagination as $row) {
				$table .= '<tr>';
				$table .= '<td>'.$row->aircraft.'</td>';
				$table .= '<td>'.$row->routeFrom.' - '.$row->routeTo.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoRev, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRev, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailRev, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailNonRev, 2).'</td>';
				$table .= '<td>'.$row->routeTo.' - '.$row->routeFrom.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoRevDep, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRevDep, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailRevDep, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailNonRevDep, 2).'</td>';
				$table .= '</tr>';

				$subcargoRev += $row->cargoRev;
				$subcargoNonRev += $row->cargoNonRev;
				$submailRev += $row->mailRev;
				$submailNonRev += $row->mailNonRev;
				$subcargoRevDep += $row->cargoRevDep;
				$subcargoNonRevDep += $row->cargoNonRevDep;
				$submailRevDep += $row->mailRevDep;
				$submailNonRevDep += $row->mailNonRevDep;

			}
			
			$table .= '<tr style = "background-color:#d9edf7; color:#003366">';
			$table .= '<td>SUBTOTAL:</td>';
			$table .= '<td></td>';
			$table .= '<td style = "text-align:right">'.number_format($subcargoRev, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRev, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($submailRev, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->mailNonRev, 2).'</td>';
			$table .= '<td></td>';
			$table .= '<td style = "text-align:right">'.number_format($subcargoRevDep, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRevDep, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($submailRevDep, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->mailNonRevDep, 2).'</td>';
			$table .= '</tr>';

			$totalcargoRev += $subcargoRev;
			$totalcargoNonRev += $subcargoNonRev;
			$totalmailRev += $submailRev;
			$totalmailNonRev += $submailNonRev;
			$totalcargoRevDep += $subcargoRevDep;
			$totalcargoNonRevDep += $subcargoNonRevDep;
			$totalmailRevDep += $submailRevDep;
			$totalmailNonRevDep += $submailNonRevDep;
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold">TOTAL:</td>';
		$table .= '<td></td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoRev, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoNonRev, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailRev, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailNonRev, 2).'</td>';
		$table .= '<td></td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoRevDep, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoNonRevDep, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailRevDep, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailNonRevDep, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_transit_cargo_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "2">Aircraft</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
		$table .= '</tr>';

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
		$table .= '</tr>';

		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$route = $this->client_mgt_model->getform51btransit_route($client_id, $id);
		$totalcargoRev = 0;
		$totalcargoNonRev = 0;
		$totalmailRev = 0;
		$totalmailNonRev = 0;
		$totalcargoRevDep = 0;
		$totalcargoNonRevDep = 0;
		$totalmailRevDep = 0;
		$totalmailNonRevDep = 0;

		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->getTransitCargo51b($client_id, $id, $row->routeTo, $row->routeFrom);
			
			$subcargoRev = 0;
			$subcargoNonRev = 0;
			$submailRev = 0;
			$submailNonRev = 0;
			$subcargoRevDep = 0;
			$subcargoNonRevDep = 0;
			$submailRevDep = 0;
			$submailNonRevDep = 0;
			
			foreach ($pagination as $row) {
				$table .= '<tr>';
				$table .= '<td>'.$row->aircraft.'</td>';
				$table .= '<td>'.$row->routeFrom.' - '.$row->routeTo.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoRev, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRev, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailRev, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailNonRev, 2).'</td>';
				$table .= '<td>'.$row->routeTo.' - '.$row->routeFrom.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoRevDep, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRevDep, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailRevDep, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->mailNonRevDep, 2).'</td>';
				$table .= '</tr>';

				$subcargoRev += $row->cargoRev;
				$subcargoNonRev += $row->cargoNonRev;
				$submailRev += $row->mailRev;
				$submailNonRev += $row->mailNonRev;
				$subcargoRevDep += $row->cargoRevDep;
				$subcargoNonRevDep += $row->cargoNonRevDep;
				$submailRevDep += $row->mailRevDep;
				$submailNonRevDep += $row->mailNonRevDep;

			}
			
			$table .= '<tr style = "background-color:#d9edf7; color:#003366">';
			$table .= '<td>SUBTOTAL:</td>';
			$table .= '<td></td>';
			$table .= '<td style = "text-align:right">'.number_format($subcargoRev, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRev, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($submailRev, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->mailNonRev, 2).'</td>';
			$table .= '<td></td>';
			$table .= '<td style = "text-align:right">'.number_format($subcargoRevDep, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargoNonRevDep, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($submailRevDep, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->mailNonRevDep, 2).'</td>';
			$table .= '</tr>';

			$totalcargoRev += $subcargoRev;
			$totalcargoNonRev += $subcargoNonRev;
			$totalmailRev += $submailRev;
			$totalmailNonRev += $submailNonRev;
			$totalcargoRevDep += $subcargoRevDep;
			$totalcargoNonRevDep += $subcargoNonRevDep;
			$totalmailRevDep += $submailRevDep;
			$totalmailNonRevDep += $submailNonRevDep;
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold">TOTAL TRANSIT:</td>';
		$table .= '<td></td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoRev, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoNonRev, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailRev, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailNonRev, 2).'</td>';
		$table .= '<td></td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoRevDep, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargoNonRevDep, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailRevDep, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalmailNonRevDep, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_view_61a_content() {
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$table = ''; 
		$pagination = $this->client_mgt_model->getForm61aContent($client_id, $id);
		$count = $this->client_mgt_model->form61aCount($client_id, $id);
		if (empty($pagination)) {
			$table = '<tr><td colspan="11" class="text-center"><b>No Operation</b></td></tr>';
		}
		$totalarea = 0;
		$totalqliters = 0;
		$totalrevenue = 0;
		$totalhour = 0;
		$totalmin = 0;

		foreach ($pagination as $key => $row) {

			if($row->month == '1'){$month = 'Jan';}
			else if($row->month == '2'){$month = 'Feb';}
			else if($row->month == '3'){$month = 'Mar';}
			else if($row->month == '4'){$month = 'Apr';}
			else if($row->month == '5'){$month = 'May';}
			else if($row->month == '6'){$month = 'Jun';}
			else if($row->month == '7'){$month = 'Jul';}
			else if($row->month == '8'){$month = 'Aug';}
			else if($row->month == '9'){$month = 'Sep';}
			else if($row->month == '10'){$month = 'Oct';}
			else if($row->month == '11'){$month = 'Nov';}
			else if($row->month == '12'){$month = 'Dec';}

			$dec = $row->flyTimeMin / 60;
			$x = $dec;
			$y = floor($x);
			$dec = $y * 60;
			$row->flyTimeMin = $row->flyTimeMin - $dec;
			$row->flyTimeHour = $row->flyTimeHour + $y;

			$table .= '<tr>';
			$table .= '<td style = "text-align:left">'.$row->day.'-'.$month.'-'.$row->year.'</td>';
			$table .= '<td style = "text-align:center">'.$row->aircraft.'</td>';
			$table .= '<td style = "text-align:center">'.$row->aircraft_num.'</td>';
			$table .= '<td style = "text-align:center">'.$row->location.'</td>';
			$table .= '<td style = "text-align:center">'.$row->treatment.'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->areaTreated, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->qLiters, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->revenue, 2).'</td>';
			$table .= '<td style = "text-align:right">'.$row->flyTimeHour.'</td>';
			$table .= '<td style = "text-align:right">'.$row->flyTimeMin.'</td>';
			$table .= '</tr>';

			$totalarea += $row->areaTreated;
			$totalqliters += $row->qLiters;
			$totalrevenue += $row->revenue;
			$totalhour += $row->flyTimeHour;
			$totalmin += $row->flyTimeMin;
		}

		$hour_min = $totalmin / 60;
		$n = $hour_min;
		$whole = floor($n);
		$hour_min = $whole * 60;
		$totalmin = $totalmin - $hour_min;
		$totalhour = $totalhour + $whole;

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:left">TOTAL:</td>';
		$table .= '<td style = "text-align:center" colspan = "4">'.$count->result_count.' Entries</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalarea, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalqliters, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalrevenue, 2).'</td>';
		$table .= '<td style = "text-align:right">'.$totalhour.'</td>';
		$table .= '<td style = "text-align:right">'.$totalmin.'</td>';
		$table .= '</tr>';
		
		return array('table' => $table);
	}

	private function ajax_view_61b_content() {
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$table = ''; 
		$pagination = $this->client_mgt_model->getForm61bContent($client_id, $id);
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="11" class="text-center"><b>No Operation</b></td></tr>';
		}
		$total_distance = 0;
		$total_flown_hour = 0;
		$total_flown_min = 0;
		$total_passengers_num = 0;
		$total_cargo_qty = 0;
		$total_cargo_value = 0;
		$total_revenue = 0;

		foreach ($pagination->result as $key => $row) {

			if($row->month == '1'){$month = 'Jan';}
			else if($row->month == '2'){$month = 'Feb';}
			else if($row->month == '3'){$month = 'Mar';}
			else if($row->month == '4'){$month = 'Apr';}
			else if($row->month == '5'){$month = 'May';}
			else if($row->month == '6'){$month = 'Jun';}
			else if($row->month == '7'){$month = 'Jul';}
			else if($row->month == '8'){$month = 'Aug';}
			else if($row->month == '9'){$month = 'Sep';}
			else if($row->month == '10'){$month = 'Oct';}
			else if($row->month == '11'){$month = 'Nov';}
			else if($row->month == '12'){$month = 'Dec';}

			$dec = $row->flown_min / 60;
			$x = $dec;
			$y = floor($x);
			$dec = $y * 60;
			$row->flown_min = $row->flown_min - $dec;
			$row->flown_hour = $row->flown_hour + $y;

			$table .= '<tr>';
			$table .= '<td style = "text-align:left">'.$row->day.'-'.$month.'-'.$row->year.'</td>';
			$table .= '<td style = "text-align:left">'.$row->operation.'</td>';
			$table .= '<td style = "text-align:center">'.$row->type.'</td>';
			$table .= '<td style = "text-align:center">'.$row->aircraft_num.'</td>';
			$table .= '<td style = "text-align:center">'.$row->origin.'</td>';
			$table .= '<td style = "text-align:center">'.$row->destination.'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->distance, 2).'</td>';
			$table .= '<td style = "text-align:right">'.$row->flown_hour.'</td>';
			$table .= '<td style = "text-align:right">'.$row->flown_min.'</td>';
			$table .= '<td style = "text-align:right">'.$row->passengers_num.'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargo_qty, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargo_value, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->revenue, 2).'</td>';
			$table .= '</tr>';

			$total_distance += $row->distance;
			$total_flown_hour += $row->flown_hour;
			$total_flown_min += $row->flown_min;
			$total_passengers_num += $row->passengers_num;
			$total_cargo_qty += $row->cargo_qty;
			$total_cargo_value += $row->cargo_value;
			$total_revenue += $row->revenue;
		}

		$hour_min = $total_flown_min / 60;
		$n = $hour_min;
		$whole = floor($n);
		$hour_min = $whole * 60;
		$total_flown_min = $total_flown_min - $hour_min;
		$total_flown_hour = $total_flown_hour + $whole;

		// $n = $total_flown_hour;
		// $whole = floor($n);      // 1
		// $fraction = $n - $whole; // .25

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:left">TOTAL:</td>';
		$table .= '<td style = "text-align:center" colspan = "5">'.$pagination->result_count.' Entries</td>';
		$table .= '<td style = "text-align:right">'.number_format($total_distance, 2).'</td>';
		$table .= '<td style = "text-align:right">'.$total_flown_hour.'</td>';
		$table .= '<td style = "text-align:right">'.$total_flown_min.'</td>';
		$table .= '<td style = "text-align:right">'.$total_passengers_num.'</td>';
		$table .= '<td style = "text-align:right">'.number_format($total_cargo_qty, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($total_cargo_value, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($total_revenue, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}
	private function ajax_cargo71a_shipment_list(){
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center">AIR CARRIER</td>';
		$table .= '<td style = "text-align:center">ORIGIN</td>';
		$table .= '<td style = "text-align:center">COUNTRY OF DESTINATION</td>';
		$table .= '<td style = "text-align:center">NUMBER OF MAWBs USED</td>';
		$table .= '<td style = "text-align:center">CHARGEABLE WEIGHT (Kilograms)</td>';
		$table .= '<td style = "text-align:center">AIRLINE FREIGHT CHARGES(Peso)</td>';
		$table .= '<td style = "text-align:center">COMMISSION EARNED(Peso)</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$route = $this->client_mgt_model->getform71a_s1tf1destination($client_id, $id);
		$totalnumMawbs = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalcommission = 0;

		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->get71aShipmentList($client_id, $id, $row->origin, $row->destination);
			$subnumMawbs = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subcommission = 0;
			
			foreach ($pagination as $row) {
				$table .= '<tr>';
				$table .= '<td style = "text-align:center">'.$row->aircraft.'</td>';
				$table .= '<td style = "text-align:center">'.$row->origin.'</td>';
				$table .= '<td style = "text-align:center">'.$row->destination.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->numMawbs, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->weight, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->fcharge, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->commission, 2).'</td>';
				$table .= '</tr>';

				$subnumMawbs += $row->numMawbs;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subcommission += $row->commission;

			}

			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "font-weight:bold; text-align:right" colspan = "3">Sub Total:</td>';
			$table .= '<td style = "text-align:right">'.number_format($subnumMawbs, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subweight, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subfcharge, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subcommission, 2).'</td>';
			$table .= '</tr>';

			$totalnumMawbs += $subnumMawbs;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalcommission += $subcommission;
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold" colspan = "3">TOTAL:</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumMawbs, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalweight, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalfcharge, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcommission, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_cargo71a_consolidation_list(){
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "2">AIRLINE/AIRFREIGHT FORWARDER</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">COUNTRY OF DESTINATION</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">NUMBER OF AWB USED</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">CHARGEABLE WEIGHT (Kilograms)</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">AIRLINE FREIGHT CHARGES(Peso)</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">GROSS CONSOLIDATED REVENUE (Peso)</td>';
		$table .= '</tr>';
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "1">MAWB</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">HAWB</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$destination = $this->client_mgt_model->getform71a_s2tf2destination($client_id, $id);

		$totalnumMawbs = 0;
		$totalnumHawbs1 = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalrevenue = 0;

		$type = 'Consolidation';

		foreach ($destination as $key => $row) {
			$pagination = $this->client_mgt_model->get71aCargoConsolidation($client_id, $id, $row->destination, $type);

			$subnumMawbs = 0;
			$subnumHawbs1 = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subrevenue = 0;
			
			foreach ($pagination as $row) {
				$table .= '<tr>';
				$table .= '<td style = "text-align:center">'.$row->aircraft.'</td>';
				$table .= '<td style = "text-align:center">'.$row->destination.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->numMawbs, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->numHawbs1, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->weight, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->fcharge, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->revenue, 2).'</td>';
				$table .= '</tr>';

				$subnumMawbs += $row->numMawbs;
				$subnumHawbs1 += $row->numHawbs1;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subrevenue += $row->revenue;

			}

			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "font-weight:bold; text-align:right" colspan = "2">Sub Total:</td>';
			$table .= '<td style = "text-align:right">'.number_format($subnumMawbs, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subnumHawbs1, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subweight, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subfcharge, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subrevenue, 2).'</td>';
			$table .= '</tr>';

			$totalnumMawbs += $subnumMawbs;
			$totalnumHawbs1 += $subnumHawbs1;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalrevenue += $subrevenue;
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold" colspan = "2">TOTAL:</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumMawbs, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumHawbs1, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalweight, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalfcharge, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalrevenue, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_cargo71a_breakbulking_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center">COUNTRY OF ORIGIN</td>';
		$table .= '<td style = "text-align:center">TOTAL NO. OF HAWBs USED</td>';
		$table .= '<td style = "text-align:center">CHARGEABLE WEIGHT (Kilograms)</td>';
		$table .= '<td style = "text-align:center">INCOME FROM BREAKBULKING(Peso)</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$origin = $this->client_mgt_model->getform71a_s2tf2origin($client_id, $id);

		$totalnumHawbs2 = 0;
		$totalorgWeight = 0;
		$totalIncomeBreak = 0;

		$type = 'Breakbulking';

		foreach ($origin as $key => $row) {
			$pagination = $this->client_mgt_model->get71aCargoConsolidation($client_id, $id, $row->origin, $type);

			$subnumHawbs2 = 0;
			$suborgWeight = 0;
			$subIncomeBreak = 0;
			
			foreach ($pagination as $row) {
				if ($row->origin != "") {
					$table .= '<tr>';
					$table .= '<td style = "text-align:center">'.$row->origin.'</td>';
					$table .= '<td style = "text-align:right">'.number_format($row->numHawbs2, 2).'</td>';
					$table .= '<td style = "text-align:right">'.number_format($row->orgWeight, 2).'</td>';
					$table .= '<td style = "text-align:right">'.number_format($row->IncomeBreak, 2).'</td>';
					$table .= '</tr>';

					$subnumHawbs2 += $row->numHawbs2;
					$suborgWeight += $row->orgWeight;
					$subIncomeBreak += $row->IncomeBreak;
				}
			}

			if ($row->origin != "") {
				$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
				$table .= '<td style = "font-weight:bold; text-align:right">Sub Total:</td>';
				$table .= '<td style = "text-align:right">'.number_format($subnumHawbs2, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($suborgWeight, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($subIncomeBreak, 2).'</td>';
				$table .= '</tr>';

				$totalnumHawbs2 += $subnumHawbs2;
				$totalorgWeight += $suborgWeight;
				$totalIncomeBreak += $subIncomeBreak;
			}
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold">TOTAL:</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumHawbs2, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalorgWeight, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalIncomeBreak, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_serialnum71b_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center">#</td>';
		$table .= '<td style = "text-align:center">House / Serial No.</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');

		$result = $this->client_mgt_model->getserialnum71b($client_id, $id);
			
		if ($result) {
			foreach ($result as $key => $row) {
				foreach ($row as $key2 => $row2) {
					$data = preg_split('/[\s,-]+/', $row2);
					$count = 1;
					foreach ($data as $value) {
						$table .= '<tr>';
						$table .= '<td style = "text-align:center">'.$count.'</td>';
						$table .= '<td style = "text-align:center">'.$value.'</td>';
						$table .= '</tr>';
						$count++;
					}
				}
			}
			$count = $count - 1;
		}
		else {
			$table .= '<tr>';
			$table .= '<td colspan = "2" style = "text-align:center">No Records Found</td>';
			$table .= '</tr>';

			$count = '0';
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold; text-align:center">TOTAL HAWBS:</td>';
		$table .= '<td style = "text-align:center">'.$count.'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	public function serialnum71b_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->name.' ['.$get->code.']', 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->telno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cperson, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->tin_no, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm71bDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 71-B : Serial Number ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,7, 'SERIAL NUMBER', 1,1, 'C');
		$pdf->Cell(96,7, '#', 1,0, 'C');
		$pdf->Cell(96,7, 'House / Serial No.', 1,0, 'C');
		
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$result = $this->client_mgt_model->getserialnum71b($client_id, $id);
			
		if ($result) {
			foreach ($result as $key => $row) {
				foreach ($row as $key2 => $row2) {
					$data = preg_split('/[\s,-]+/', $row2);
					$count = 1;
					foreach ($data as $value) {
						$pdf->Cell(96,7, $count, 1,0, 'C');
						$pdf->Cell(96,7, $value, 1,1, 'C');
						$count++;
					}
				}
			}
			$count = $count - 1;
		}
		else {
			$pdf->Cell(192,7, 'No Records Found', 1,1, 'C');

			$count = '0';
		}		

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(96,7, 'TOTAL HAWBS:', 1,0, 'C');
		$pdf->Cell(96,7, $count, 1,0, 'C');

		$pdf->Output();
	}

	private function ajax_serialnum71a_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center">#</td>';
		$table .= '<td style = "text-align:center">House / Serial No.</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');

		$result = $this->client_mgt_model->getserialnum71a($client_id, $id);
		if ($result) {
			foreach ($result as $key => $row) {
				foreach ($row as $key2 => $row2) {
					$data = preg_split('/[\s,-]+/', $row2);
					$count = 1;
					foreach ($data as $value) {
						$table .= '<tr>';
						$table .= '<td style = "text-align:center">'.$count.'</td>';
						$table .= '<td style = "text-align:center">'.$value.'</td>';
						$table .= '</tr>';
						$count++;
					}
				}
			}
			$count = $count - 1;
		}
		else {
			$table .= '<tr>';
			$table .= '<td colspan = "2" style = "text-align:center">No Records Found</td>';
			$table .= '</tr>';

			$count = '0';
		}

		

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold; text-align:center">TOTAL HAWBS:</td>';
		$table .= '<td style = "text-align:center">'.$count.'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	public function serialnum71a_pdf($client_id, $id) {
		$pdf = new fpdf('P', 'mm', 'A4');
		$pdf->AddPage();
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(192,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(192,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,5, "", 0,1, 'C');	

		$get = $this->client_mgt_model->getClientInfo($this->client_fields, $client_id);

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->name.' ['.$get->code.']', 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->telno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cperson, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->tin_no, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$data = $this->client_mgt_model->getForm71aDetails($client_id, $id);

		if ($data->report_month == '1') {$data->report_month = 'January';}
		else if ($data->report_month == '2') {$data->report_month = 'February';}
		else if ($data->report_month == '3') {$data->report_month = 'March';}
		else if ($data->report_month == '4') {$data->report_month = 'April';}
		else if ($data->report_month == '5') {$data->report_month = 'May';}
		else if ($data->report_month == '6') {$data->report_month = 'June';}
		else if ($data->report_month == '7') {$data->report_month = 'July';}
		else if ($data->report_month == '8') {$data->report_month = 'August';}
		else if ($data->report_month == '9') {$data->report_month = 'September';}
		else if ($data->report_month == '10') {$data->report_month = 'October';}
		else if ($data->report_month == '11') {$data->report_month = 'November';}
		else if ($data->report_month == '12') {$data->report_month = 'December';}

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(192,7, 'FORM 71-A : Serial Number ('.$data->report_month.' '.$data->year.')', 0, 1, 'C');
		
		$pdf->Cell(192,0.1, "", 1,1, 'C');
		$pdf->Cell(192,3, "", 0,1, 'C');

		$submitteddate = date_create($data->submitteddate);
		$submitteddate = date_format($submitteddate,"F d, Y");

		$approveddate = date_create($data->approveddate);
		$approveddate = date_format($approveddate,"F d, Y");

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $submitteddate, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved Date:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $approveddate, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(52,5, 'Submitted By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(50,5, $data->submittedby, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "8");
		$pdf->Cell(30,5, 'Approved By:', 0, 0, 'R');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(60,5, $data->approvedby, 0, 1, 'L');

		$pdf->Cell(192,5,"",0,1, 'C');

		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(192,7, 'SERIAL NUMBER', 1,1, 'C');
		$pdf->Cell(96,7, '#', 1,0, 'C');
		$pdf->Cell(96,7, 'House / Serial No.', 1,0, 'C');
		
		$pdf->Cell(0,7, '', 0,1, 'C');

		$pdf->SetFont("Arial", "", "7");

		$result = $this->client_mgt_model->getserialnum71a($client_id, $id);
			
		if ($result) {
			foreach ($result as $key => $row) {
				foreach ($row as $key2 => $row2) {
					$data = preg_split('/[\s,-]+/', $row2);
					$count = 1;
					foreach ($data as $value) {
						$pdf->Cell(96,7, $count, 1,0, 'C');
						$pdf->Cell(96,7, $value, 1,1, 'C');
						$count++;
					}
				}
			}
			$count = $count - 1;
		}
		else {
			$pdf->Cell(192,7, 'No Records Found', 1,1, 'C');

			$count = '0';
		}
		$pdf->SetFont("Arial", "B", "7");

		$pdf->Cell(96,7, 'TOTAL HAWBS:', 1,0, 'C');
		$pdf->Cell(96,7, $count, 1,0, 'C');

		$pdf->Output();
	}

	private function ajax_shipment_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center">AIR CARRIER</td>';
		$table .= '<td style = "text-align:center">ORIGIN</td>';
		$table .= '<td style = "text-align:center">COUNTRY OF DESTINATION</td>';
		$table .= '<td style = "text-align:center">NUMBER OF MAWBs USED</td>';
		$table .= '<td style = "text-align:center">CHARGEABLE WEIGHT (Kilograms)</td>';
		$table .= '<td style = "text-align:center">AIRLINE FREIGHT CHARGES(Peso)</td>';
		$table .= '<td style = "text-align:center">COMMISSION EARNED(Peso)</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$route = $this->client_mgt_model->getform71b_s1tf1destination($client_id, $id);

		$totalnumMawbs = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalcommission = 0;

		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->getShipmentList($client_id, $id, $row->origin, $row->destination);
			$subnumMawbs = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subcommission = 0;
			
			foreach ($pagination as $row) {
				$table .= '<tr>';
				$table .= '<td style = "text-align:center">'.$row->aircraft.'</td>';
				$table .= '<td style = "text-align:center">'.$row->origin.'</td>';
				$table .= '<td style = "text-align:center">'.$row->destination.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->numMawbs, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->weight, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->fcharge, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->commission, 2).'</td>';
				$table .= '</tr>';

				$subnumMawbs += $row->numMawbs;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subcommission += $row->commission;

			}

			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "font-weight:bold; text-align:right" colspan = "3">Sub Total:</td>';
			$table .= '<td style = "text-align:right">'.number_format($subnumMawbs, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subweight, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subfcharge, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subcommission, 2).'</td>';
			$table .= '</tr>';

			$totalnumMawbs += $subnumMawbs;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalcommission += $subcommission;
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold" colspan = "3">TOTAL:</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumMawbs, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalweight, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalfcharge, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcommission, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_cargo_consolidation_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "2">AIRLINE/AIRFREIGHT FORWARDER</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">COUNTRY OF DESTINATION</td>';
		$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">NUMBER OF AWB USED</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">CHARGEABLE WEIGHT (Kilograms)</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">AIRLINE FREIGHT CHARGES(Peso)</td>';
		$table .= '<td style = "text-align:center" rowspan = "2">GROSS CONSOLIDATED REVENUE (Peso)</td>';
		$table .= '</tr>';
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" rowspan = "1">MAWB</td>';
		$table .= '<td style = "text-align:center" rowspan = "1">HAWB</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$destination = $this->client_mgt_model->getform71b_s2tf2destination($client_id, $id);

		$totalnumMawbs = 0;
		$totalnumHawbs1 = 0;
		$totalweight = 0;
		$totalfcharge = 0;
		$totalrevenue = 0;

		$type = 'Consolidation';

		foreach ($destination as $key => $row) {
			$pagination = $this->client_mgt_model->getCargoConsolidation($client_id, $id, $row->destination, $type);

			$subnumMawbs = 0;
			$subnumHawbs1 = 0;
			$subweight = 0;
			$subfcharge = 0;
			$subrevenue = 0;
			
			foreach ($pagination as $row) {
				$table .= '<tr>';
				$table .= '<td style = "text-align:center">'.$row->aircraft.'</td>';
				$table .= '<td style = "text-align:center">'.$row->destination.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->numMawbs, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->numHawbs1, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->weight, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->fcharge, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->revenue, 2).'</td>';
				$table .= '</tr>';

				$subnumMawbs += $row->numMawbs;
				$subnumHawbs1 += $row->numHawbs1;
				$subweight += $row->weight;
				$subfcharge += $row->fcharge;
				$subrevenue += $row->revenue;

			}

			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "font-weight:bold; text-align:right" colspan = "2">Sub Total:</td>';
			$table .= '<td style = "text-align:right">'.number_format($subnumMawbs, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subnumHawbs1, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subweight, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subfcharge, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subrevenue, 2).'</td>';
			$table .= '</tr>';

			$totalnumMawbs += $subnumMawbs;
			$totalnumHawbs1 += $subnumHawbs1;
			$totalweight += $subweight;
			$totalfcharge += $subfcharge;
			$totalrevenue += $subrevenue;
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold" colspan = "2">TOTAL:</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumMawbs, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumHawbs1, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalweight, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalfcharge, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalrevenue, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_cargo_breakbulking_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center">COUNTRY OF ORIGIN</td>';
		$table .= '<td style = "text-align:center">TOTAL NO. OF HAWBs USED</td>';
		$table .= '<td style = "text-align:center">CHARGEABLE WEIGHT (Kilograms)</td>';
		$table .= '<td style = "text-align:center">INCOME FROM BREAKBULKING(Peso)</td>';
		$table .= '</tr>';
		
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$origin = $this->client_mgt_model->getform71b_s2tf2origin($client_id, $id);

		$totalnumHawbs2 = 0;
		$totalorgWeight = 0;
		$totalIncomeBreak = 0;

		$type = 'Breakbulking';

		foreach ($origin as $key => $row) {
			$pagination = $this->client_mgt_model->getCargoConsolidation($client_id, $id, $row->origin, $type);

			$subnumHawbs2 = 0;
			$suborgWeight = 0;
			$subIncomeBreak = 0;
			
			foreach ($pagination as $row) {
				if ($row->origin != "") {
					$table .= '<tr>';
					$table .= '<td style = "text-align:center">'.$row->origin.'</td>';
					$table .= '<td style = "text-align:right">'.number_format($row->numHawbs2, 2).'</td>';
					$table .= '<td style = "text-align:right">'.number_format($row->orgWeight, 2).'</td>';
					$table .= '<td style = "text-align:right">'.number_format($row->IncomeBreak, 2).'</td>';
					$table .= '</tr>';

					$subnumHawbs2 += $row->numHawbs2;
					$suborgWeight += $row->orgWeight;
					$subIncomeBreak += $row->IncomeBreak;
				}
			}

			if ($row->origin != "") {
				$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
				$table .= '<td style = "font-weight:bold; text-align:right">Sub Total:</td>';
				$table .= '<td style = "text-align:right">'.number_format($subnumHawbs2, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($suborgWeight, 2).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($subIncomeBreak, 2).'</td>';
				$table .= '</tr>';

				$totalnumHawbs2 += $subnumHawbs2;
				$totalorgWeight += $suborgWeight;
				$totalIncomeBreak += $subIncomeBreak;
			}
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold">TOTAL:</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnumHawbs2, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalorgWeight, 2).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalIncomeBreak, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_view_t1a_content() {
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$t1aCount = $this->client_mgt_model->t1aCount($client_id, $id);
		$pagination = $this->client_mgt_model->getFormt1aContent($client_id, $id);
		$table = '';   
		if (empty($pagination)) {
			$table = '<tr><td colspan="8" class="text-center"><b>No Operation</b></td></tr>';
		}
		$totaldistance = 0;
		$totalsk_offered = 0;
		$totalseats_offered = 0;
		$totalrev_pass = 0;
		$totalnonrev_pass = 0;
		$totalload_factor = 0;
		$totalcargo = 0;
		foreach ($pagination as $key => $row) {
			$load_factor = (!empty($row->seats_offered))? ($row->rev_pass/$row->seats_offered) * 100 : 0;
			$load_factor_d = (!empty($row->seats_offered_d))? ($row->rev_pass_d/$row->seats_offered_d) * 100 : 0;
			if ($row->sector != '' && $row->sector_d != '') {
				$table .= '<tr>';
				$table .= '<td style = "text-align:left">'.$row->sector.'/'.$row->sector_d.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->distance, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->sk_offered, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->seats_offered, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->rev_pass, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->nonrev_pass, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($load_factor, 0).'%</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargo, 0).'</td>';
				$table .= '</tr>';

				$table .= '<tr>';
				$table .= '<td style = "text-align:left">'.$row->sector_d.'/'.$row->sector.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->distance_d, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->sk_offered_d, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->seats_offered_d, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->rev_pass_d, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->nonrev_pass_d, 0).'</td>';
				$table .= '<td style = "text-align:right">'.number_format($load_factor_d, 0).'%</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->cargo_d, 0).'</td>';
				$table .= '</tr>';

				$subtotaldistance = $row->distance + $row->distance_d;
				$subtotalsk_offered = $row->sk_offered + $row->sk_offered_d;
				$subtotalseats_offered = $row->seats_offered + $row->seats_offered_d;
				$subtotalrev_pass = $row->rev_pass + $row->rev_pass_d;
				$subtotalnonrev_pass = $row->nonrev_pass + $row->nonrev_pass_d;
				$subtotalload_factor = $load_factor + $load_factor_d;
				$subtotalcargo = $row->cargo + $row->cargo_d;
			}

			$table .= '<tr style = "background-color:#d9edf7; color:black; font-weight:bold">';
			$table .= '<td style = "font-weight:bold">SUBTOTAL:</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotaldistance, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalsk_offered, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalseats_offered, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalrev_pass, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalnonrev_pass, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalload_factor, 0).'%</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalcargo, 0).'</td>';
			$table .= '</tr>';

			$totaldistance += $subtotaldistance;
			$totalsk_offered += $subtotalsk_offered;
			$totalseats_offered += $subtotalseats_offered;
			$totalrev_pass += $subtotalrev_pass;
			$totalnonrev_pass += $subtotalnonrev_pass;
			$totalload_factor += $subtotalload_factor;
			$totalcargo += $subtotalcargo;

		}

		$totalload_factor = $totalload_factor/$t1aCount->result_count;

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold">TOTAL:</td>';
		$table .= '<td style = "text-align:right">'.number_format($totaldistance, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalsk_offered, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalseats_offered, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalrev_pass, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnonrev_pass, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalload_factor, 0).'%</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargo, 0).'</td>';
		$table .= '</tr>';
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center" colspan = "8">'.$t1aCount->result_count.' Entries</td>';
		$table .= '</tr>';

		return array('table' => $table);
	}

	private function ajax_codeshared_list() {
		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "text-align:center">Marketing Airline</td>';
		$table .= '<td style = "text-align:center">Sector</td>';
		$table .= '<td style = "text-align:center">Distance [Kilometers]</td>';
		$table .= '<td style = "text-align:center">Available Seat-KMS Offered</td>';
		$table .= '<td style = "text-align:center">Available Seats</td>';
		$table .= '<td style = "text-align:center">Revenue Passengers</td>';
		$table .= '<td style = "text-align:center">Non-Revenue Passengers</td>';
		$table .= '<td style = "text-align:center">Passenger Load Factor</td>';
		$table .= '<td style = "text-align:center">Cargo [Kilograms]</td>';
		$table .= '</tr>';

		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$t1aCount = $this->client_mgt_model->t1aCountCodeShared($client_id, $id);
		$pagination = $this->client_mgt_model->getFormt1aContentCodeShared($client_id, $id);
		$totaldistance = 0;
		$totalsk_offered = 0;
		$totalseats_offered = 0;
		$totalrev_pass = 0;
		$totalnonrev_pass = 0;
		$totalload_factor = 0;
		$totalcargo = 0;
		foreach ($pagination as $key => $row) {
			$load_factor = (!empty($row->seats_offered))? ($row->rev_pass/$row->seats_offered) * 100 : 0;
			$load_factor_d = (!empty($row->seats_offered_d))? ($row->rev_pass_d/$row->seats_offered_d) * 100 : 0;
			$table .= '<tr>';
			$table .= '<td style = "text-align:left">'.$row->title.'</td>';
			$table .= '<td style = "text-align:left">'.$row->sector.'/'.$row->sector_d.'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->distance, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->sk_offered, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->seats_offered, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->rev_pass, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->nonrev_pass, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($load_factor, 0).'%</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargo, 0).'</td>';
			$table .= '</tr>';

			$table .= '<tr>';
			$table .= '<td style = "text-align:left">'.$row->title.'</td>';
			$table .= '<td style = "text-align:left">'.$row->sector_d.'/'.$row->sector.'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->distance_d, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->sk_offered_d, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->seats_offered_d, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->rev_pass_d, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->nonrev_pass_d, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($load_factor_d, 0).'%</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->cargo_d, 0).'</td>';
			$table .= '</tr>';

			$subtotaldistance = $row->distance + $row->distance_d;
			$subtotalsk_offered = $row->sk_offered + $row->sk_offered_d;
			$subtotalseats_offered = $row->seats_offered + $row->seats_offered_d;
			$subtotalrev_pass = $row->rev_pass + $row->rev_pass_d;
			$subtotalnonrev_pass = $row->nonrev_pass + $row->nonrev_pass_d;
			$subtotalload_factor = $load_factor + $load_factor_d;
			$subtotalcargo = $row->cargo + $row->cargo_d;

			$table .= '<tr style = "background-color:#d9edf7; color:black; font-weight:bold">';
			$table .= '<td style = "font-weight:bold">SUBTOTAL:</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotaldistance, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalsk_offered, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalseats_offered, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalrev_pass, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalnonrev_pass, 0).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalload_factor, 0).'%</td>';
			$table .= '<td style = "text-align:right">'.number_format($subtotalcargo, 0).'</td>';
			$table .= '</tr>';

			$totaldistance += $subtotaldistance;
			$totalsk_offered += $subtotalsk_offered;
			$totalseats_offered += $subtotalseats_offered;
			$totalrev_pass += $subtotalrev_pass;
			$totalnonrev_pass += $subtotalnonrev_pass;
			$totalload_factor += $subtotalload_factor;
			$totalcargo += $subtotalcargo;

		}

		if ($t1aCount->result_count != 0) {
			$totalload_factor = $totalload_factor/$t1aCount->result_count;
		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td style = "font-weight:bold">TOTAL:</td>';
		$table .= '<td></td>';
		$table .= '<td style = "text-align:right">'.number_format($totaldistance, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalsk_offered, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalseats_offered, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalrev_pass, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalnonrev_pass, 0).'</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalload_factor, 0).'%</td>';
		$table .= '<td style = "text-align:right">'.number_format($totalcargo, 0).'</td>';
		$table .= '</tr>';
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		if ($t1aCount) {
			$table .= '<td style = "text-align:center" colspan = "9">'.$t1aCount->result_count.' Entries</td>';
		}
		else {
			$table .= '<td style = "text-align:center" colspan = "9">0 Entries</td>';
		}
		$table .= '</tr>';

		return array('table' => $table);
	}

	private function ajax_direct71c_shipment_list() {
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');
		$pagination = $this->client_mgt_model->get71cDirectShipment($client_id, $id);
		
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="12" class="text-center"><b>No Operation</b></td></tr>';
		}

		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<th>AIR CARRIER</td>';
		$table .= '<th>NUMBER OF MAWBs USED</td>';
		$table .= '<th>CHARGEABLE WEIGHT</td>';
		$table .= '<th>FREIGHT CHARGES (Peso)</td>';
		$table .= '<th>COMMISSION EARNED (Peso)</td>';
		$table .= '</tr>';

		$totalmawbs		 = 0;
		$totalweight	 = 0;
		$totalfcharge	 = 0;
		$totalcommission = 0;
		
		foreach ($pagination->result as $key => $row) {
			if($row->aircraft == 'NO OPERATION'){
				$table = '<tr><td colspan="12" class="text-center"><b>No Operation</b></td></tr>';
			}else{
			$table .= '<tr>';
			$table .= '<td>'.$row->aircraft.'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->numMawbs, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->weight, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->fcharge, 2).'</td>';
			$table .= '<td style = "text-align:right">'.number_format($row->commission, 2).'</td>';
			$table .= '</tr>';
			}

			$totalmawbs		 += $row->numMawbs;
			$totalweight	 += $row->weight;
			$totalfcharge	 += $row->fcharge;
			$totalcommission += $row->commission;

		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td>TOTAL:</td>';
		$table .= '<td align="right">'.number_format($totalmawbs, 2).'</td>';
		$table .= '<td align="right">'.number_format($totalweight, 2).'</td>';
		$table .= '<td align="right">'.number_format($totalfcharge, 2).'</td>';
		$table .= '<td align="right">'.number_format($totalcommission, 2).'</td>';
		
		$table .= '</tr>';



		return array('table'=> $table);
	}

	private function ajax_flow71c_shipment_list() {
		$client_id = $this->input->post('client_id');
		$id = $this->input->post('id');

		$table = '';   
		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<th>ORIGIN</td>';
		$table .= '<th>DESTINATION</td>';
		$table .= '<th>CHARGEABLE WEIGHT (Kilograms)</td>';
		$table .= '</tr>';

		$route = $this->client_mgt_model->getform71c_s1tf1route($client_id, $id);

		$totalweight = 0;
		foreach ($route as $key => $row) {
			$pagination = $this->client_mgt_model->get71cFlowShipment($client_id, $id, $row->origin, $row->destination);
			$subweight = 0;
			foreach ($pagination as $key => $row) {
				$table .= '<tr>';
				$table .= '<td style = "text-align:left">'.$row->origin.'</td>';
				$table .= '<td style = "text-align:left">'.$row->destination.'</td>';
				$table .= '<td style = "text-align:right">'.number_format($row->weight, 2).'</td>';
				$table .= '</tr>';

				$subweight += $row->weight;
			}
			
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "font-weight:bold; text-align:right">Sub Total:</td>';
			$table .= '<td style = "text-align:right">'.'</td>';
			$table .= '<td style = "text-align:right">'.number_format($subweight, 2).'</td>';
			$table .= '</tr>';

			$totalweight += $subweight;

		}

		$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
		$table .= '<td>TOTAL:</td>';
		$table .= '<td></td>';
		$table .= '<td align="right">'.number_format($totalweight, 2).'</td>';
		$table .= '</tr>';
		return array('table' => $table);
	}
}