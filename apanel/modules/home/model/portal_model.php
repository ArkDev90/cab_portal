<?php
class portal_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log			= new log();
		$this->report_list	= array(
			'11'	=> 'form51a',
			'18'	=> 'form51b',
			'16'	=> 'form61a',
			'15'	=> 'form61b',
			'306'	=> 'form71a',
			'310'	=> 'form71b',
			'8'		=> 'form71c',
			'17'	=> 'formt1a'
		);
	}

	public function getCABDetails() {
		$result = $this->db->setTable(PRE_TABLE . '_option')
							->setFields('value email, companyname')
							->leftJoin("company ON companycode = 'CAB'")
							->setWhere("type = 'cab_email'")
							->runSelect(false)
							->getRow();

		return $result;
	}

	public function getDevEmail() {
		$result = $this->db->setTable(PRE_TABLE . '_option')
							->setFields('value email')
							->setWhere("type = 'cid_dev_email'")
							->runSelect(false)
							->getResult();

		return $result;
	}

	public function sendEmail($message, $email_list, $subject = 'CAB') {
		$cab_details	= $this->getCABDetails();
		$cab_email		= $cab_details->email;
		$cab_name		= $cab_details->companyname;
		$cid_dev		= $this->getDevEmail();

		$result = false;

		$html = "<h2>$cab_name</h2>";

		$html .= $message;

		if ($cab_email && $email_list) {
			$email_list = (is_array($email_list)) ? $email_list : explode(',', str_replace('/', ',', $email_list));
			$mail = new PHPMailer(true);
			$mail->IsSendmail();
			try {
				$mail->Subject	= $subject;

				$mail->SMTPDebug = false;
				$mail->isSMTP();                                      // Set mailer to use SMTP
				
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                       // TCP port to connect to
			
				$mail->Username =  "notifications.cab@gmail.com";            // SMTP username\\\\\\\\\\\\\
				$mail->Password =  "looftaxytjteerhn";                          // SMTP password
		
			
			
				$mail->setFrom("notifications.cab@gmail.com", 'Civil Aeronautics Board');
				
				$mail->AddBCC($cab_email);
				foreach ($cid_dev as $dev) {
					$mail->AddBCC($dev->email);
				}
				foreach ($email_list as $email) {
					$mail->AddAddress($email);
				}
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				$mail->MsgHTML($html);
				$mail->Send();

				$result = true;
			} catch (phpmailerException $e) {
				$e->errorMessage();
			}
		}

		return $result;
	}

	

	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}

	public function getUserEmail($username) {
		$result = $this->getUser($username);

		$email = '';

		if ($result) {
			$email = $result->email;
		}

		return $email;
	}

	public function getClientEmail($client_id) {
		$result = $this->db->setTable('client')
							->setFields('email')
							->setWhere("id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return ($result) ? $result->email : '';
	}

	public function getSuspendedUsers() {
		$result = $this->db->setTable('client')
							->setFields('id, name, code, tin_no, country, status')
							->setWhere("status = 'Suspended'")
							->setOrderBy('id') 
							->runPagination();
		return $result;
	}

	public function getTerminatedUsers() {
		$result = $this->db->setTable('client')
							->setFields('id, name, code, tin_no, country, status')
							->setWhere("status = 'Terminated'")
							->setOrderBy('id') 
							->runPagination();
		return $result;
	}

	public function getClientReportList() {
		$result = $this->db->setTable('report_form rf')
		->leftJoin("nature_report_form nrf ON nrf.report_form_id = rf.id")
		->leftJoin("client_nature cn ON cn.nature_id = nrf.nature_id")
		->leftJoin("client c ON c.id = cn.client_id")
		->setFields('rf.short_title, rf.title, db_table')
		->setOrderBy('rf.id')
		->setGroupBy('rf.id')
		->runSelect()
		->getResult();
		return $result;
	}

	public function getUsersReportList($client_id, $id, $user_type) {
		if($user_type == 'Master Admin'){
			$cond = "";
		}
		else{
			$cond = "cl.id='$client_id' AND cn.user_id = '$id'";
		}

		$result = $this->db->setTable('report_form rf')
		->leftJoin("nature_report_form nrf ON nrf.report_form_id = rf.id")
		->leftJoin("client_user_nature cn ON cn.nature_id = nrf.nature_id")
		->leftJoin("client_user c ON c.id = cn.user_id")
		->leftJoin("client cl ON cl.id = c.client_id")
		->setFields('rf.short_title, rf.title, db_table')
		->setWhere($cond)
		->setGroupBy('rf.id')
		->setOrderBy('rf.id')
		->runSelect()
		->getResult();

		return $result;
	}

	public function getClientUserReportList($client_id, $id, $user_table, $user_type) {
		$join_table = ($user_table == 'client_user') ? 'client_user_nature' : 'gsa_user_nature';
		$join_column = ($user_table == 'client_user') ? 'user_id' : 'gsa_user_id';

		$user_data = $this->db->setTable($user_table . ' u')
							->innerJoin("$join_table un ON un.$join_column = u.id AND un.companycode = u.companycode")
							->innerJoin('nature_report_form nrf ON nrf.nature_id = un.nature_id AND nrf.companycode = un.companycode')
							->innerJoin("report_form rf ON rf.id = nrf.report_form_id AND rf.companycode = nrf.companycode")
							->setFields('rf.short_title, rf.title, rf.db_table')
							->setWhere("u.id = '$id' AND rf.id != '14'")
							->setGroupBy('report_form_id')
							->setOrderBy("CASE short_title WHEN 'Monthly Ticket Sales Report' THEN '1' ELSE short_title END")
							->runSelect()
							->getResult();

		if ($user_type == 'Master Admin') {
			$user_data = $this->db->setTable('client c')
								->innerJoin('client_nature cn ON cn.client_id = c.id AND cn.companycode = c.companycode')
								->innerJoin('nature_report_form nrf ON nrf.nature_id = cn.nature_id AND nrf.companycode = cn.companycode')
								->innerJoin("report_form rf ON rf.id = nrf.report_form_id AND rf.companycode = nrf.companycode")
								->setFields('rf.short_title, rf.title, rf.db_table')
								->setWhere("c.id = '$client_id' AND rf.id != '14'")
								->setGroupBy('report_form_id')
								->setOrderBy("CASE short_title WHEN 'Monthly Ticket Sales Report' THEN '1' ELSE short_title END")
								->runSelect()
								->getResult();
		}

		return $user_data;
	}

	public function getReportCount($client_id, $table) {
		$result = $this->db->setTable($table)
		->setFields('COUNT(id) counter')
		->setWhere("client_id='$client_id' AND (status = 'Pending' OR status = 'Disapproved')")
		->runSelect()
		->getRow();

		return ($result) ? $result->counter : 0;
	}

	public function getReportCount1($table) {
		$result = $this->db->setTable($table)
		->setFields('COUNT(id) counter')
		->setWhere("status = 'Approved'")
		->runSelect()
		->getRow();

		return ($result) ? $result->counter : 0;
	}

	public function getLateReports() {
		$result = $this->db->setTable('form51a a')
							->setFields("COUNT(a.id) as count51a,
							(select COUNT(id) from form51b WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count51b,
							(select COUNT(id) from form61a WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count61a,
							(select COUNT(id) from form61b WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count61b,
							(select COUNT(id) from form71a WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count71a,
							(select COUNT(id) from form71b WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count71b,
							(select COUNT(id) from form71c WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count71c,
							(select COUNT(id) from formt1a WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as countt1a						
							")
							->leftJoin('client as c ON a.client_id = c.id')
							->setWhere("DATE_ADD(LAST_DAY((CASE WHEN a.report_quarter = '1' THEN CONCAT(a.year, '-03-01') WHEN a.report_quarter = '2' THEN CONCAT(a.year, '-06-01') WHEN report_quarter = '3' THEN CONCAT(a.year, '-09-01') WHEN a.report_quarter = '4' THEN CONCAT(a.year, '-12-01') END)),INTERVAL 31 DAY) <= approveddate")
							->setOrderBy('c.id') 
							->runSelect()
							->getRow();
						
		return $result;
	}

	public function resetPassword($username, $password) {
		$result = $this->getUser($username);

		if ($result) {
			$user_column = ($result->user_table == 'client') ? 'temp_username' : 'username';
			$pass_column = ($result->user_table == 'client') ? 'temp_password' : 'password';

			$data[$pass_column] = password_hash($password, PASSWORD_BCRYPT);


			$result = $this->db->setTable($result->user_table)
								->setValues($data)
								->setWhere("$user_column = '$username'")
								->setLimit(1)
								->runUpdate();
		}

		return $result;
	}

	public function checkExistingUsername($username, $reference) {
		$result = $this->getUser($username);

		if ($result && $result->username == $reference) {
			return false;
		}

		return $result;
	}

	public function getUser($username) {
		$cab_user_query		= $this->db->setTable(PRE_TABLE . '_users')
									->setFields("username id, '" . PRE_TABLE . "_users' user_table, username, password, companycode, groupname, CONCAT(firstname, ' ', middlename, ' ', lastname) name, 1 apanel_user, '' client_id, email")
									->buildSelect();

		$client_user_query	= $this->db->setTable('client_user cu')
									->setFields("cu.id, 'client_user' user_table, username, password, cu.companycode, user_type groupname, CONCAT(fname, ' ', mname, ' ', lname) name, 0 apanel_user, client_id, cu.email")
									->innerJoin('client c ON c.id = cu.client_id AND c.companycode = cu.companycode')
									->buildSelect();

		$gsa_user_query		= $this->db->setTable('gsa_user')
									->setFields("id, 'gsa_user' user_table, username, password, companycode, user_type groupname, CONCAT(fname, ' ', mname, ' ', lname) name, 0 apanel_user, 0 client_id, email")
									->buildSelect();

		$temp_company_user	= $this->db->setTable('client')
									->setFields("'', 'client' user_table, temp_username username, temp_password password, companycode, 'Temp Admin' groupname, '' name, 0 apanel_user, id client_id, email")
									->buildSelect();

		$result = $this->db->setTable("($cab_user_query UNION $client_user_query UNION $gsa_user_query UNION $temp_company_user) a")
							->setFields("id, user_table, client_id, username, password, companycode, groupname, name, apanel_user, email")
							->setWhere("username = '$username'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return $result;
	}

	public function sendReportConfirmation($report_form_id, $report_id) {
		$report_date = (($report_form_id == 11) ? "CONCAT('Quarter ', report_quarter, ' ', year)" : "CONCAT(MONTHNAME(STR_TO_DATE(report_month, '%m')), ' ', year)") . " 'Report Date'";

		$fields = array(
			"name 'Client Name'",
			"CONCAT(rf.code, ' : ', rf.title) 'Report Form'",
			$report_date,
			"submittedby 'Submitted By'",
			"submitteddate 'Submitted Date'",
			"approvedby 'Approved By'",
			"approveddate 'Approved Date'",
			"r.status",
			"r.client_id"
		);

		$result = $this->db->setTable($this->report_list[$report_form_id] . ' r')
							->innerJoin('client c ON c.id = r.client_id AND c.companycode = r.companycode')
							->innerJoin("report_form rf ON rf.id = '$report_form_id' AND rf.companycode = r.companycode")
							->setFields($fields)
							->setWhere("r.id = '$report_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		$status			= $result->status;
		$client_id		= $result->client_id;
		$client_name	= $result->{'Client Name'};
		unset($result->status);
		unset($result->client_id);

		if ($status == 'Approved') {
			$message = '<p>REPORT DETAILS :</p>';
			$message .= '<table>';
	
			foreach ($result as $label => $value) {
				$message .= '<tr>';
				$message .= '<td style="padding-right: 10px; text-align: right">' . $label . ' :</td>';
				$message .= '<td>' . $value . '</td>';
				$message .= '</tr>';
			}
	
			$message .= '</table>';
			$message .= '<br><p>This is to certify that the said report was successfully submitted to Civil Aeronautics Board(CAB).<p>';

			if (in_array($report_form_id, array(5, 6))) {
				$message .= '<p>Please be reminded that appropriate verification fees for every issued House Airway Bills should be settled, otherwise applicable penalties shall be imposed. Kindly disregard if payment has been settled. </p>';
			}

			$message .= '<p>This is a system generated message. Please do not reply.</p>';
	
			$client_email = $this->getClientEmail($client_id);

			$this->sendEmail($message, $client_email, 'Civil Aeronautics Board - Online System - ' . $client_name);
		}
	}

}