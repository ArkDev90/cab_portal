<?php

class client_mgt_model extends wc_model {



	public function __construct() {

		parent::__construct();

		$this->log = new log();

	}



	public function getClientInfo($client_fields, $client_id) {

		$client_fields = array(

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

			'c.country', 

			'status', 

			'temp_username',

			'c.entereddate'

		);

				$result = $this->db->setTable('client c')

							->leftJoin('country co ON co.id = c.country')

							->setFields($client_fields)

							->setWhere("c.id = '$client_id'")

							->setLimit(1)

							->runSelect()

							->getRow();



		return $result;

	}



	public function saveClient($data, $pass) {

		$data['temp_password'] = password_hash($pass, PASSWORD_BCRYPT);

		$result = $this->db->setTable('client')

		->setValues($data)

		->runInsert();

		

		if ($result) {

			$this->log->saveActivity("Create Client [{$data['name']}]");

		}

		return $result;

	}



	public function saveNature($nature) {

		$result = $this->db->setTable('client_nature')

		->setValues($nature)

		->runInsert();

		

		if ($result) {

			$this->log->saveActivity("Create Client Nature of Operation");

		}

		return $result;

	}



	public function updateClientNature($nature, $client_id) {

		$result = $this->db->setTable('client_nature')

		->setWhere("client_id = '$client_id'")

		->runDelete();



		if ($result) {+

			$nature['client_id'] = $client_id;



			$result = $this->db->setTable('client_nature')

			->setValuesFromPost($nature)

			->runInsert();

		}

		

		if ($result) {

			$this->log->saveActivity("Create Client Nature of Operation");

		}

		return $result;

	}



	public function updateClientStatus($status, $client_id) {

		$fields['status'] = $status;

		$result = $this->db->setTable('client')

		->setValues($fields)

		->setWhere("id = '$client_id'")

		->setLimit(1)

		->runUpdate();

		

		if ($result) {

			$this->log->saveActivity("Update Client Status");

		}

		return $result;

	}



	public function cancelReport($db_table, $id) {

		$fields['status'] = 'Cancelled';

		$result = $this->db->setTable($db_table)

		->setValues($fields)

		->setWhere("id = '$id'")

		->setLimit(1)

		->runUpdate();

		

		if ($result) {

			$this->log->saveActivity("Cancel Report");

		}

		return $result;

	}



	public function updateClientUserLevel($user_type, $nature, $id) {

		$data = array();

		$data['id'] = $id;

		$data['user_type'] = $user_type;

		$update = $this->db->setTable('client_user')

							->setValues($data)

							->setWhere("id = '$id'")

							->setLimit(1)

							->runUpdate();



		$result = $this->db->setTable('client_user_nature')

		->setWhere("user_id = '$id'")

		->runDelete();



		if ($result) {

			$nature['user_id'] = $id;



			$result = $this->db->setTable('client_user_nature')

			->setValuesFromPost($nature)

			->runInsert();

		}

		

		if ($result) {

			$this->log->saveActivity("Update Client User Level");

		}

		return $result;

	}



	



	public function deleteClientUser($id) {

		$delete = $this->db->setTable('client_user_nature')

		->setWhere("user_id = '$id'")

		->runDelete();



		$result = $this->db->setTable('client_user')

		->setWhere("id = '$id'")

		->runDelete();



		if ($result) {

			$this->log->saveActivity("Delete Client User");

		}

		return $result;

	}



	public function saveClientUserNature($nature) {

		$result = $this->db->setTable('client_user_nature')

		->setValues($nature)

		->runInsert();

		

		if ($result) {

			$this->log->saveActivity("Create User Client Nature of Operation");

		}



		return $result;

	}

	

	public function getNatureOfOperationList() {

		$result = $this->db->setTable('nature_of_operation')

							->setFields('id ind, title val')

							->setOrderBy('id')

							->runSelect()

							->getResult();



		return $result;

	}

	

	public function getNatureOfOperationListDropdown($natureids = array()) {

		$condition = '';

		if ($natureids) {

			$natureids = "'" . implode("','", $natureids) . "'";

			$condition = "id IN ($natureids)";

		}



		$result = $this->db->setTable('nature_of_operation')

							->setFields('id ind, title val')

							->setWhere($condition)

							->setOrderBy('id')

							->runSelect()

							->getResult();



		return $result;

	}



	public function getCountryList() {

		$result = $this->db->setTable('country')

							->setFields('id ind, country val')

							->setOrderBy('id')

							->runSelect()

							->getResult();



		return $result;

	}



	public function getCountry($country) {

		$result = $this->db->setTable('country')

							->setFields('country')

							->setWhere("id = '$country'")

							->setLimit(1)

							->runSelect()

							->getRow();



		return $result;

	}



	public function getReportFormList() {

		$result = $this->db->setTable('report_form')

							->setFields('db_table ind, short_title val')

							->setOrderBy('id')

							->runSelect()

							->getResult();



		return $result;

	}



	public function getClientCode() {

		$result = $this->db->setTable('client')

							->setFields('id ind, code val')

							->setOrderBy('id')

							->runSelect()

							->getResult();



		return $result;

	}



	public function getClientName() {

		$result = $this->db->setTable('client')

							->setFields('id ind, name val')

							->setOrderBy('id')

							->runSelect()

							->getResult();



		return $result;

	}



	public function resetClientTempUsername($client_id, $username) {

		$data['temp_username'] = $username;

		$result = $this->db->setTable('client')

							->setValues($data)

							->setWhere("id = '$client_id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Update Client Temp Username [$client_id]");

		}



		return $result;

	}



	public function resetClientTempPassword($client_id, $password) {

		$data['temp_password'] = password_hash($password, PASSWORD_BCRYPT);

		$result = $this->db->setTable('client')

							->setValues($data)

							->setWhere("id = '$client_id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Update Client Temp User Password [$client_id]");

		}



		return $result;

	}



	public function resetClientUserPassword($id, $password) {

		$data['password'] = password_hash($password, PASSWORD_BCRYPT);

		$result = $this->db->setTable('client_user')

							->setValues($data)

							->setWhere("id = '$id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Update Client User Password [$id]");

		}



		return $result;

	}



    public function getNatureOperation() {

		$fields = $this->fields = array('id', 'title');

		$result = $this->db->setTable('nature_of_operation')

		->setFields($fields)

		->setOrderBy('id') 

		->runPagination();



		return $result;

	}



	 public function getNatureId($data) {

		$fields = $this->fields = array('id');

		$nature = implode("','" , $data);

		$result = $this->db->setTable('nature_of_operation')

		->setFields($fields)

		->setWhere("title IN('$nature') ")

		->setOrderBy('id') 

		->runSelect()

		->getResult();



		return $result;

	}



	public function getCheckClientNature($client_id) {

		$result = $this->db->setTable('nature_of_operation n')

		->leftJoin("client_nature cn ON cn.nature_id = n.id AND client_id = '$client_id'")

		->setFields('n.id, title, nature_id')

		->setOrderBy('n.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getCheckClientUserNature($id) {

		$result = $this->db->setTable('nature_of_operation n')

		->leftJoin("client_user_nature cn ON cn.nature_id = n.id AND cn.user_id = '$id'")

		->setFields('n.id, title, nature_id')

		->setOrderBy('n.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getReportFormID($db_table) {

		$result = $this->db->setTable('report_form')

		->setFields('id')

		->setWhere("db_table = '$db_table'")

		->runSelect()

		->getRow();



		return $result;

	}



	public function getClientReportList($client_id) {

		$result = $this->db->setTable('report_form rf')

		->leftJoin("nature_report_form nrf ON nrf.report_form_id = rf.id")

		->leftJoin("client_nature cn ON cn.nature_id = nrf.nature_id")

		->leftJoin("client c ON c.id = cn.client_id")

		->setFields('rf.short_title, rf.title, db_table')

		->setWhere("c.id='$client_id'")

		->setOrderBy('rf.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getLateClientReportList($client_id) {

		$result = $this->db->setTable('report_form rf')

		->leftJoin("nature_report_form nrf ON nrf.report_form_id = rf.id")

		->leftJoin("client_nature cn ON cn.nature_id = nrf.nature_id")

		->leftJoin("client c ON c.id = cn.client_id")

		->setFields('rf.short_title, rf.title, db_table,c.name,c.id,c.code')

		->setWhere("")

		->setOrderBy('rf.id')

		->runPagination();

		// echo $this->db->getQuery();

//asd

		return $result;

	}



	public function getUsersReportList($client_id = '', $id = '') {

		$result = $this->db->setTable('report_form rf')

		->leftJoin("nature_report_form nrf ON nrf.report_form_id = rf.id")

		->leftJoin("client_user_nature cn ON cn.nature_id = nrf.nature_id")

		->leftJoin("client_user c ON c.id = cn.user_id")

		->leftJoin("client cl ON cl.id = c.client_id")

		->setFields('rf.short_title, rf.title, db_table')

		// ->setWhere("cl.id='$client_id' AND cn.user_id = '$id'")

		->setWhere("rf.id != '14'")

		->setGroupBy('rf.id')

		->setOrderBy("CASE short_title WHEN 'Monthly Ticket Sales Report' THEN '1' ELSE short_title END")

		->runSelect()

		->getResult();



		return $result;

	}



	public function getReportList($client_id, $db_table, $month, $year, $sort) {

		$condition = '';

		if ($month) {

			if($db_table == 'form51a'){

				$condition .= ' AND ' . $this->generateSearchMonth($month, array('report_quarter'));

			}else{

				$condition .= ' AND ' . $this->generateSearchMonth($month, array('report_month'));

			}

		}

		if ($year) {

			$condition .= ' AND ' . $this->generateSearchYear($year, array('year'));

		}

		if($month == 'none'){

			$condition = " AND year = '$year'";

		}

		if ($db_table == 'form51a') {

			$fields = array('id', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		else {

			$fields = array('id', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		$result = $this->db->setTable($db_table)

		->setFields($fields)

		->setWhere("client_id='$client_id' AND status = 'Approved' $condition")

		->setOrderBy($sort)

		->runPagination();



		return $result;

	}



	public function getPendingReportList($client_id, $db_table) {

		if ($db_table == 'form51a') {

			$fields = array('id', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

			}

		else {

			$fields = array('id', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		$result = $this->db->setTable($db_table)

		->setFields($fields)

		->setWhere("client_id='$client_id' AND (status = 'Pending' OR status = 'Disapproved')")

		->setOrderBy('id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getUserReportList($client_id, $db_table) {

		if ($db_table == 'form51a') {

			$fields = array('id', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

			}

		else {

			$fields = array('id', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		$result = $this->db->setTable($db_table)

		->setFields($fields)

		->setWhere("client_id='$client_id' AND status = 'Pending'")

		->setOrderBy('id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getApprovedReportList($db_table, $month, $year,$client_id, $month, $year, $sort) {

		$condition = '';

		if ($month) {

			if ($db_table == 'form51a') {

				$condition .= ' AND ' . $this->generateSearchMonth($month, array('report_quarter'));

			}else{

				$condition .= ' AND ' . $this->generateSearchMonth($month, array('report_month'));

			}

		}

		if($month == 'none'){

			$condition = " AND year = '$year'";

		}

		if ($year) {

			$condition .= ' AND ' . $this->generateSearchYear($year, array('year'));

		}

		if ($db_table == 'form51a') {

			$fields = array('id', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

			}

		else {

			$fields = array('id', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		$result = $this->db->setTable($db_table)

		->setFields($fields)

		->setWhere("client_id='$client_id' AND status = 'Approved' $condition")

		->setOrderBy($sort)

		->runPagination();



		return $result;

	}



	public function getApprovedReportList1($db_table, $month, $year, $month, $year, $sort) {

		$condition = '';

		if ($month) {

			if ($db_table == 'form51a') {

				$condition .= ' AND ' . $this->generateSearchMonth($month, array('report_quarter'));

			}else{

				$condition .= ' AND ' . $this->generateSearchMonth($month, array('report_month'));

			}

		}

		if($month == 'none'){

			$condition = " AND year = '$year'";

		}

		if ($year) {

			$condition .= ' AND ' . $this->generateSearchYear($year, array('year'));

		}

		if ($db_table == 'form51a') {

			$fields = array('a.id', 'c.name', 'c.code', 'a.client_id', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'a.status');

			}

		else {

			$fields = array('a.id', 'c.name', 'c.code', 'a.client_id','report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'a.status');

		}

		$result = $this->db->setTable($db_table.' a')

		->setFields($fields)

		->leftJoin('client c ON c.id = a.client_id')

		->setWhere("a.status = 'Approved'$condition")

		->setOrderBy($sort)

		->runPagination();

		// echo $this->db->getQuery();



		return $result;

	}



	public function getReportCount($client_id, $db_table) {

		$result = $this->db->setTable($db_table)

		->setFields('id')

		->setWhere("client_id='$client_id' AND status = 'Approved'")

		->runPagination();



		return $result;

	}



	public function getLateReportCount($client_id, $db_table) {

		if ($db_table == 'form51a') {

			$fields = array('id', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

			$cond = "DATE_ADD(LAST_DAY((CASE WHEN report_quarter = '1' THEN CONCAT(year, '-03-01') WHEN report_quarter = '2' THEN CONCAT(year, '-06-01') WHEN report_quarter = '3' THEN CONCAT(year, '-09-01') WHEN report_quarter = '4' THEN CONCAT(year, '-12-01') END)),INTERVAL 31 DAY) <= approveddate";

		}

		else {

			$cond = "DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`";

			$fields = array('id', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		$result = $this->db->setTable($db_table)

		->setFields('id')

		->setWhere($cond." AND client_id = '$client_id'")

		->runPagination();

//asd

		return $result;

	}



	public function getReportHistoryCount($client_id, $db_table) {

		$result = $this->db->setTable($db_table)

		->setFields('id')

		->setWhere("client_id='$client_id'")

		->runPagination();



		return $result;

	}



	public function getReportHistoryList($client_id, $db_table) {

		if ($db_table == 'form51a') {

			$fields = array('id', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		else {

			$fields = array('id', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		}

		$result = $this->db->setTable($db_table)

		->setFields($fields)

		->setWhere("client_id='$client_id'")

		->setOrderBy('submitteddate DESC')

		->runSelect()

		->getResult();



		return $result;

	}



public function getLateReportList($client_id, $db_table, $month, $year, $sort, $form, $code, $name) {

	$condition = '';

	if ($month) {

		if($db_table == 'form51a'){

			$condition .= " AND report_quarter = '$month'";

		}else{

			$condition .= " AND report_month = '$month'";

		}

	}

	if ($name) {

		$condition = " AND t.client_id = '$name'";

	}

	if ($year) {

		$condition .= ' AND ' . $this->generateSearchYear($year, array('year'));

	}

	if($month == 'none'){

		$condition = " AND year = '$year'";

	}

		if ($db_table == 'form51a') {

			$fields = array('t.id','t.client_id','c.name','c.code', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 't.status');

			$cond = "DATE_ADD(LAST_DAY((CASE WHEN report_quarter = '1' THEN CONCAT(year, '-03-01') WHEN report_quarter = '2' THEN CONCAT(year, '-06-01') WHEN report_quarter = '3' THEN CONCAT(year, '-09-01') WHEN report_quarter = '4' THEN CONCAT(year, '-12-01') END)),INTERVAL 31 DAY) <= approveddate ";

		}

		else {

			$cond = "DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate` ";

			$fields = array('t.id','t.client_id','c.name','c.code', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 't.status');

		}



		$result = $this->db->setTable($db_table.' t')

		->setFields($fields)

		->leftJoin('client c ON c.id = t.client_id')

		->setWhere($cond. $condition)

		->setOrderBy('t.id')

		->runPagination();

		

		// echo $this->db->getQuery();

		// var_dump($result->result_count);



		return $result;

	}

	public function getLateReportList1($month, $year, $sort, $form, $code, $name) {

		$condition = '';

		if ($month) {

			if($form == 'form51a'){

				$condition .= " AND report_quarter = '$month'";

			}else{

				$condition .= " AND report_month = '$month'";

			}

		}

		if ($name) {

			$condition .= " AND  t.client_id = '$name'";

		}

		if ($year) {

			$condition .= " AND year = '$year'";

		}

		if($month == 'none'){

			$condition = " AND year = '$year'";

		}

			if ($form == 'form51a') {

				$fields = array('t.id','t.client_id','c.name','c.code', 'report_quarter timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 't.status');

				$cond = "DATE_ADD(LAST_DAY((CASE WHEN report_quarter = '1' THEN CONCAT(year, '-03-01') WHEN report_quarter = '2' THEN CONCAT(year, '-06-01') WHEN report_quarter = '3' THEN CONCAT(year, '-09-01') WHEN report_quarter = '4' THEN CONCAT(year, '-12-01') END)),INTERVAL 31 DAY) <= approveddate ";

			}

			else {

				$cond = "DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate` ";

				$fields = array('t.id','t.client_id','c.name','c.code', 'report_month timespan', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 't.status');

			}

	

			$result = $this->db->setTable($form. ' t')

			->setFields($fields)

			->leftJoin('client c ON c.id = t.client_id')

			->setWhere($cond. $condition)

			->setOrderBy('id')

			->runPagination();

			

			// echo $this->db->getQuery();

			// var_dump($result->result_count);

	

			return $result;

		}

	

	



	public function getForm51A_Route($client_id, $id) {

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields('destination_from, destination_to')

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id' AND codeshared = '' AND extra_dest = ''")

							->setGroupBy('destination_from, destination_to')

							->setOrderBy('destination_from, destination_to')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getForm51A_cs_Route($client_id, $id) {

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields('destination_from, destination_to')

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id' AND codeshared != '' AND extra_dest = ''")

							->setGroupBy('destination_from, destination_to')

							->setOrderBy('destination_from, destination_to')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getForm51A_wrote($client_id, $id) {

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields('destination_from, destination_to, extra_dest,codeshared')

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id'  AND codeshared = '' AND extra_dest != ''")

							->setGroupBy('destination_from, destination_to, extra_dest')

							->setOrderBy('destination_from, destination_to, extra_dest')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getForm51A_cs_wrote($client_id, $id) {

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields('destination_from, destination_to, extra_dest,codeshared')

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id'  AND codeshared != '' AND extra_dest != ''")

							->setGroupBy('destination_from, destination_to, extra_dest')

							->setOrderBy('destination_from, destination_to, extra_dest')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getForm51a_direct($id, $client_id, $origin, $destination) {

		$fields = array('fd.id','form51a_id','aircraft','destination_from','destination_to','first','business','economy','extra','quarter_month1','quarter_month2','quarter_month3','quarter_month1_d','quarter_month2_d','quarter_month3_d','nflight_month1','nflight_month2','nflight_month3','nflight_month1_d','nflight_month2_d','nflight_month3_d','foctraffic_month1','foctraffic_month2','foctraffic_month3','foctraffic_month1_d','foctraffic_month2_d','foctraffic_month3_d','codeshared','cs_quarter_month1','cs_quarter_month2','cs_quarter_month3','cs_quarter_month1_d','cs_quarter_month2_d','cs_quarter_month3_d','cs_nflight_month1','cs_nflight_month2','cs_nflight_month3','cs_nflight_month1_d','cs_nflight_month2_d','cs_nflight_month3_d');	

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields($fields)

							->setOrderBy("destination_from DESC")

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id' AND destination_from = '$origin' AND destination_to = '$destination' AND extra_dest = '' AND codeshared = ''")

							->runSelect()

							->getResult();



		return $result;

	}



	public function getForm51a_fifthco($id, $client_id, $origin, $destination, $extra_dest) {

		$fields = array('fd.id','form51a_id','aircraft','destination_from','destination_to','extra_dest','first','business','economy','extra','quarter_month1','quarter_month2','quarter_month3','quarter_month1_d','quarter_month2_d','quarter_month3_d','nflight_month1','nflight_month2','nflight_month3','nflight_month1_d','nflight_month2_d','nflight_month3_d','foctraffic_month1','foctraffic_month2','foctraffic_month3','foctraffic_month1_d','foctraffic_month2_d','foctraffic_month3_d','codeshared','cs_quarter_month1','cs_quarter_month2','cs_quarter_month3','cs_quarter_month1_d','cs_quarter_month2_d','cs_quarter_month3_d','cs_nflight_month1','cs_nflight_month2','cs_nflight_month3','cs_nflight_month1_d','cs_nflight_month2_d','cs_nflight_month3_d','ex_quarter_month1','ex_quarter_month2','ex_quarter_month3','ex_quarter_month1_d','ex_quarter_month2_d','ex_quarter_month3_d','ex_nflight_month1','ex_nflight_month2','ex_nflight_month3','ex_nflight_month1_d','ex_nflight_month2_d','ex_nflight_month3_d','ex_foctraffic_month1','ex_foctraffic_month2','ex_foctraffic_month3','ex_foctraffic_month1_d','ex_foctraffic_month2_d','ex_foctraffic_month3_d','codeshared','ex_cs_quarter_month1','ex_cs_quarter_month2','ex_cs_quarter_month3','ex_cs_quarter_month1_d','ex_cs_quarter_month2_d','ex_cs_quarter_month3_d','ex_cs_nflight_month1','ex_cs_nflight_month2','ex_cs_nflight_month3','ex_cs_nflight_month1_d','ex_cs_nflight_month2_d','ex_cs_nflight_month3_d');	

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields($fields)

							->setOrderBy("destination_from DESC")

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id' AND destination_from = '$origin' AND destination_to = '$destination' AND fd.extra_dest = '$extra_dest' AND fd.extra_dest != '' AND codeshared = ''")

							->runSelect()

							->getResult();



		return $result;

	}



	public function getForm51a_cs_fifthco($id, $client_id, $origin, $destination, $extra_dest) {

		$fields = array('fd.id','form51a_id','aircraft','destination_from','destination_to','extra_dest','first','business','economy','extra','quarter_month1','quarter_month2','quarter_month3','quarter_month1_d','quarter_month2_d','quarter_month3_d','nflight_month1','nflight_month2','nflight_month3','nflight_month1_d','nflight_month2_d','nflight_month3_d','foctraffic_month1','foctraffic_month2','foctraffic_month3','foctraffic_month1_d','foctraffic_month2_d','foctraffic_month3_d','codeshared','cs_quarter_month1','cs_quarter_month2','cs_quarter_month3','cs_quarter_month1_d','cs_quarter_month2_d','cs_quarter_month3_d','cs_nflight_month1','cs_nflight_month2','cs_nflight_month3','cs_nflight_month1_d','cs_nflight_month2_d','cs_nflight_month3_d','ex_quarter_month1','ex_quarter_month2','ex_quarter_month3','ex_quarter_month1_d','ex_quarter_month2_d','ex_quarter_month3_d','ex_nflight_month1','ex_nflight_month2','ex_nflight_month3','ex_nflight_month1_d','ex_nflight_month2_d','ex_nflight_month3_d','ex_foctraffic_month1','ex_foctraffic_month2','ex_foctraffic_month3','ex_foctraffic_month1_d','ex_foctraffic_month2_d','ex_foctraffic_month3_d','codeshared','ex_cs_quarter_month1','ex_cs_quarter_month2','ex_cs_quarter_month3','ex_cs_quarter_month1_d','ex_cs_quarter_month2_d','ex_cs_quarter_month3_d','ex_cs_nflight_month1','ex_cs_nflight_month2','ex_cs_nflight_month3','ex_cs_nflight_month1_d','ex_cs_nflight_month2_d','ex_cs_nflight_month3_d');	

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields($fields)

							->setOrderBy("destination_from DESC")

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id' AND destination_from = '$origin' AND destination_to = '$destination' AND fd.extra_dest = '$extra_dest' AND fd.codeshared != '' AND fd.extra_dest != ''")

							->runSelect()

							->getResult();



		return $result;

	}



	public function getForm51a_cs_direct($id,$client_id, $origin, $destination) {

		$fields = array('fd.id','form51a_id','aircraft','destination_from','destination_to','first','business','economy','extra','quarter_month1','quarter_month2','quarter_month3','quarter_month1_d','quarter_month2_d','quarter_month3_d','nflight_month1','nflight_month2','nflight_month3','nflight_month1_d','nflight_month2_d','nflight_month3_d','foctraffic_month1','foctraffic_month2','foctraffic_month3','foctraffic_month1_d','foctraffic_month2_d','foctraffic_month3_d','codeshared','cs_quarter_month1','cs_quarter_month2','cs_quarter_month3','cs_quarter_month1_d','cs_quarter_month2_d','cs_quarter_month3_d','cs_nflight_month1','cs_nflight_month2','cs_nflight_month3','cs_nflight_month1_d','cs_nflight_month2_d','cs_nflight_month3_d');	

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

							->setFields($fields)

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id' AND destination_from = '$origin' AND destination_to = '$destination' AND fd.codeshared != '' AND fd.extra_dest = ''")

							->runSelect()

							->getResult();

							

		return $result;

	}



	public function getForm51a_transit($id,$client_id) {

		$fields = array('ft.id','form51a_id','destination_from','destination_to','quarter_month1','quarter_month2','quarter_month3','quarter_month1_d','quarter_month2_d','quarter_month3_d');

		$result = $this->db->setTable('form51a f')

							->leftJoin('form51a_transit ft ON ft.form51a_id = f.id')

							->setFields($fields)

							->setWhere("form51a_id = '$id' AND f.client_id = '$client_id'")

							->runSelect()

							->getResult();



		return $result;

	}



	public function getReportTimespan($id, $db_table) {

		if ($db_table == 'form51a') {

			$fields = 'id, report_quarter month, year';

		}

		else {

			$fields = 'id, report_month month, year';

		}

		$result = $this->db->setTable($db_table)

		->setFields($fields)

		->setWhere("id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();

		

		return $result;

	}



	public function getReportStatus($id, $db_table) {

		$result = $this->db->setTable($db_table)

		->setFields('status')

		->setWhere("id = '$id'")

		->runSelect()

		->getRow();



		return $result;

	}



	public function getForm51aDetails($client_id, $id) {

		$fields = array('report_quarter', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('form51a')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getForm51aDetails1() {

		$fields = array('report_quarter', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate', 'status');

		$result = $this->db->setTable('form51a')

		->setFields($fields)

		->setWhere("status = 'Pending'")

		->runSelect()

		->getResult();



		return $result;

	}



	public function getForm51bDetails($client_id, $id) {

		$fields = array('report_month', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('form51b')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getform51bdirect_route($client_id, $id) {

		$result = $this->db->setTable('form51b f')

							->leftJoin('form51b_direct fd ON fd.form51b_id = f.id')

							->setFields('routeTo, routeFrom')

							->setWhere("form51b_id = '$id' AND f.client_id = '$client_id'")

							->setGroupBy('routeTo, routeFrom')

							->setOrderBy('routeTo, routeFrom')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getDirectCargo51b($client_id, $id, $routeTo, $routeFrom) {

		$fields = array('fd.aircraft', 'flightNum', 'routeTo', 'routeFrom', 'cargoRev', 'cargoNonRev', 'mailRev', 'mailNonRev', 'cargoRevDep', 'cargoNonRevDep', 'mailRevDep', 'mailNonRevDep');

		

		$result = $this->db->setTable('form51b f')

		->leftJoin('form51b_direct fd ON fd.form51b_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND routeTo = '$routeTo' AND routeFrom = '$routeFrom'")

		->setOrderBy('fd.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getform51btransit_route($client_id, $id) {

		$result = $this->db->setTable('form51b f')

							->leftJoin('form51b_transit fd ON fd.form51b_id = f.id')

							->setFields('routeTo, routeFrom')

							->setWhere("form51b_id = '$id' AND f.client_id = '$client_id'")

							->setGroupBy('routeTo, routeFrom')

							->setOrderBy('routeTo, routeFrom')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getTransitCargo51b($client_id, $id, $routeTo, $routeFrom) {

		$fields = array('ft.aircraft', 'ft.routeTo', 'ft.routeFrom', 'ft.cargoRev', 'ft.cargoNonRev', 'ft.mailRev', 'ft.mailNonRev', 'ft.cargoRevDep', 'ft.cargoNonRevDep', 'ft.mailRevDep', 'ft.mailNonRevDep');

		

		$result = $this->db->setTable('form51b f')

		->leftJoin('form51b_transit ft ON ft.form51b_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND ft.routeTo = '$routeTo' AND ft.routeFrom = '$routeFrom'")

		->setOrderBy('ft.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getForm61aDetails($client_id, $id) {

		$fields = array('report_month', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('form61a')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getForm61bDetails($client_id, $id) {

		$fields = array('report_month', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('form61b')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getForm61aContent($client_id, $id) {

		$fields = array(

			'fd.report_day day',

			'fd.report_month month',

			'fd.year year',

			'a.title type',

			'aircraft_num', 

			'location', 

			'treatment',

			'areaTreated',

			'qLiters',

			'flyTimeHour',

			'flyTimeMin',

			'revenue',

			'aircraft'

		);

		$result = $this->db->setTable('form61a f')

		->leftJoin('form61a_details fd ON fd.form61a_id = f.id')

		->leftJoin('aircraft_type a ON a.id = fd.airtype_id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id'")

		->setOrderBy('fd.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getForm61bContent($client_id, $id) {

		$fields = array(

			'f.operation',

			'fd.report_day day',

			'fd.report_month month',

			'fd.year year',

			'aircraft type',

			'aircraft_num', 

			'origin', 

			'destination',

			'distance',

			'flown_hour',

			'flown_min',

			'passengers_num',

			'cargo_qty',

			'cargo_value',

			'revenue'

		);

		$result = $this->db->setTable('form61b f')

		->leftJoin('form61b_details fd ON fd.form61b_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id'")

		->setOrderBy('fd.id')

		->runPagination();



		return $result;

	}



	public function getForm71aDetails($client_id, $id) {

		$fields = array('report_month', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('form71a')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getForm71bDetails($client_id, $id) {

		$fields = array('report_month', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('form71b')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getForm71cDetails($client_id, $id) {

		$fields = array('report_month', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('form71c')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getform71b_s1tf1destination($client_id, $id) {

		$result = $this->db->setTable('form71b f')
							->leftJoin('form71b_s1tf1 fd ON fd.form71b_id = f.id')

							->setFields('origin, destination')

							->setWhere("form71b_id = '$id' AND f.client_id = '$client_id'")

							->setGroupBy('origin, destination')

							->setOrderBy('origin, destination')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getShipmentList($client_id, $id, $origin, $destination) {

		$fields = array(

			'aircraft',

			'numMawbs',

			'weight',

			'fcharge',

			'commission',

			'origin',

			'destination'

		);

		$result = $this->db->setTable('form71b f')

		->leftJoin('form71b_s1tf1 fs ON fs.form71b_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND origin = '$origin' AND destination = '$destination'")

		->setOrderBy('fs.id')

		->runSelect()

		->getResult();

		

		return $result;

	}



	public function getform71b_s2tf2destination($client_id, $id) {

		$result = $this->db->setTable('form71b f')

							->leftJoin('form71b_s2tf2 fd ON fd.form71b_id = f.id')

							->setFields('DISTINCT destination')

							->setWhere("form71b_id = '$id' AND f.client_id = '$client_id'")

							->setOrderBy('destination')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getform71b_s2tf2origin($client_id, $id) {

		$result = $this->db->setTable('form71b f')

							->leftJoin('form71b_s2tf2 fd ON fd.form71b_id = f.id')

							->setFields('DISTINCT origin')

							->setWhere("form71b_id = '$id' AND f.client_id = '$client_id'")

							->setOrderBy('origin')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getCargoConsolidation($client_id, $id, $destination, $type) {

		$fields = array(

			'aircraft',

			'numMawbs',

			'numHawbs1',

			'weight',

			'fcharge',

			'revenue',

			'numHawbs2',

			'orgWeight',

			'IncomeBreak',

			'origin',

			'destination'

		);

		$condition = '';

		

		if ($type == 'Consolidation') {

			$condition .= "f.client_id='$client_id' AND f.id = '$id' AND destination = '$destination'";

		}

		else {

			$condition .= "f.client_id='$client_id' AND f.id = '$id' AND origin = '$destination'";

		}



		$result = $this->db->setTable('form71b f')

		->leftJoin('form71b_s2tf2 fs ON fs.form71b_id = f.id')

		->setFields($fields)

		->setWhere($condition)

		->runSelect()

		->getResult();



		return $result;

	}



	public function getserialnum71b($client_id, $id) {

		$result = $this->db->setTable('form71b_serial')

		->setFields('serialnum')

		->setWhere("form71b_id='$id'")

		->runSelect()

		->getResult();

		

		return $result;

	}



	public function getform71a_s1tf1destination($client_id, $id) {

		$result = $this->db->setTable('form71a f')

							->leftJoin('form71a_s1tf1 fd ON fd.form71a_id = f.id')

							->setFields('origin, destination')

							->setWhere("form71a_id = '$id' AND f.client_id = '$client_id'")

							->setGroupBy('origin, destination')

							->setOrderBy('origin, destination')

							->runSelect()

							->getResult();

		return $result;

	}



	public function get71aShipmentList($client_id, $id, $origin, $destination) {

		$fields = array(

			'aircraft',

			'numMawbs',

			'weight',

			'fcharge',

			'commission',

			'origin',

			'destination'

		);

		$result = $this->db->setTable('form71a f')

		->leftJoin('form71a_s1tf1 fs ON fs.form71a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND origin = '$origin' AND destination = '$destination'")

		->setOrderBy('fs.id')

		->runSelect()

		->getResult();

		

		return $result;

	}



	public function getform71a_s2tf2destination($client_id, $id) {

		$result = $this->db->setTable('form71a f')

							->leftJoin('form71a_s2tf2 fd ON fd.form71a_id = f.id')

							->setFields('DISTINCT destination')

							->setWhere("form71a_id = '$id' AND f.client_id = '$client_id'")

							->setOrderBy('destination')

							->runSelect()

							->getResult();

		return $result;

	}



	public function getform71a_s2tf2origin($client_id, $id) {

		$result = $this->db->setTable('form71a f')

							->leftJoin('form71a_s2tf2 fd ON fd.form71a_id = f.id')

							->setFields('DISTINCT origin')

							->setWhere("form71a_id = '$id' AND f.client_id = '$client_id'")

							->setOrderBy('origin')

							->runSelect()

							->getResult();

		return $result;

	}



	public function get71aCargoConsolidation($client_id, $id, $destination, $type) {

		$fields = array(

			'aircraft',

			'numMawbs',

			'numHawbs1',

			'weight',

			'fcharge',

			'revenue',

			'numHawbs2',

			'orgWeight',

			'IncomeBreak',

			'origin',

			'destination'

		);

		$condition = '';

		

		if ($type == 'Consolidation') {

			$condition .= "f.client_id='$client_id' AND f.id = '$id' AND destination = '$destination'";

		}

		else {

			$condition .= "f.client_id='$client_id' AND f.id = '$id' AND origin = '$destination'";

		}



		$result = $this->db->setTable('form71a f')

		->leftJoin('form71a_s2tf2 fs ON fs.form71a_id = f.id')

		->setFields($fields)

		->setWhere($condition)

		->runSelect()

		->getResult();



		return $result;

	}



	public function getserialnum71a($client_id, $id) {

		$result = $this->db->setTable('form71a_serial')

		->setFields('serialnum')

		->setWhere("form71a_id='$id'")

		->runSelect()

		->getResult();

		

		return $result;

	}



	public function get71cDirectShipment($client_id, $id) {

		$fields = array(

			'aircraft',

			'numMawbs',

			'weight',

			'fcharge',

			'commission',

		);

		$result = $this->db->setTable('form71c f')

		->leftJoin('form71c_s1tf1 fs ON fs.form71c_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id'")

		->setOrderBy('fs.id')

		->runPagination();



		return $result;

	}



	// public function getform71c_s1tf1origin($client_id, $id) {

	// 	$result = $this->db->setTable('form71c f')

	// 						->leftJoin('form71c_s1tf1 fd ON fd.form71c_id = f.id')

	// 						->setFields('DISTINCT origin')

	// 						->setWhere("form71c_id = '$id' AND f.client_id = '$client_id'")

	// 						->setOrderBy('origin')

	// 						->runSelect()

	// 						->getResult();

	// 	return $result;

	// }



	public function getform71c_s1tf1route($client_id, $id) {

		$result = $this->db->setTable('form71c f')

							->leftJoin('form71c_s1tf1 fd ON fd.form71c_id = f.id')

							->setFields('origin, destination')

							->setWhere("form71c_id = '$id' AND f.client_id = '$client_id'")

							->setGroupBy('origin, destination')

							->setOrderBy('origin, destination')

							->runSelect()

							->getResult();

		return $result;

	}



	public function get71cFlowShipment($client_id, $id, $origin, $destination) {

		$fields = array(

			'aircraft',

			'origin',

			'destination',

			'weight'

		);

		$result = $this->db->setTable('form71c f')

		->leftJoin('form71c_s1tf1 fs ON fs.form71c_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND origin = '$origin' AND destination = '$destination'")

		->setOrderBy('origin, destination')

		->runSelect()

		->getResult();



		return $result;

	}



	public function getFormt1aDetails($client_id, $id) {

		$fields = array('report_month', 'year', 'submittedby', 'submitteddate', 'approvedby', 'approveddate');

		$result = $this->db->setTable('formt1a')

		->setFields($fields)

		->setWhere("client_id='$client_id' AND id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getFormt1aContent($client_id, $id) {

		$fields = array(

			'sector',

			'distance',

			'sk_offered',

			'seats_offered',

			'rev_pass',

			'nonrev_pass',

			'cargo',

			'sector_d',

			'distance_d',

			'sk_offered_d',

			'seats_offered_d',

			'rev_pass_d',

			'nonrev_pass_d',

			'cargo_d'

		);

		$result = $this->db->setTable('formt1a f')

		->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND codeshared = ''")

		->setOrderBy('fd.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function t1aCount($client_id, $id) {

		$fields = array(

			'fd.id'

		);

		$result = $this->db->setTable('formt1a f')

		->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND codeshared = ''")

		->setOrderBy('fd.id')

		->runPagination();



		return $result;

	}



	public function form51aDirectCount($client_id, $id) {

		$fields = array(

			'fd.id'

		);

		$result = $this->db->setTable('form51a f')

		->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND codeshared = '' AND extra_dest = ''")

		->setOrderBy('fd.id')

		->runPagination();

		// echo $this->db->getQuery();



		return $result;

	}



	public function form51aFifthCoCount($client_id, $id) {

		$fields = array(

			'fd.id'

		);

		$result = $this->db->setTable('form51a f')

		->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND codeshared = '' AND extra_dest != ''")

		->setOrderBy('fd.id')

		->runPagination();

		// echo $this->db->getQuery();



		return $result;

	}



	public function form51aFifthCoCountCS($client_id, $id) {

		$fields = array(

			'fd.id'

		);

		$result = $this->db->setTable('form51a f')

		->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND codeshared != '' AND extra_dest != ''")

		->setOrderBy('fd.id')

		->runPagination();

		// echo $this->db->getQuery();



		return $result;

	}



	public function form51aCSCount($client_id, $id) {

		$fields = array(

			'fd.id'

		);

		$result = $this->db->setTable('form51a f')

		->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND fd.codeshared != '' AND fd.extra_dest = ''")

		->setOrderBy('fd.id')

		->runPagination();



		return $result;

	}



	public function form61aCount($client_id, $id) {

		$fields = array(

			'fd.id'

		);

		$result = $this->db->setTable('form61a f')

		->leftJoin('form61a_details fd ON fd.form61a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id'")

		->setOrderBy('fd.id')

		->runPagination();



		return $result;

	}



	public function getFormt1aContentCodeShared($client_id, $id) {

		$fields = array(

			'sector',

			'distance',

			'sk_offered',

			'seats_offered',

			'rev_pass',

			'nonrev_pass',

			'cargo',

			'sector_d',

			'distance_d',

			'sk_offered_d',

			'seats_offered_d',

			'rev_pass_d',

			'nonrev_pass_d',

			'cargo_d',

			'a.title'

		);

		$result = $this->db->setTable('formt1a f')

		->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')

		->leftJoin('aircraft_type a ON fd.airtype_id = a.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND codeshared != ''")

		->setOrderBy('fd.id')

		->runSelect()

		->getResult();



		return $result;

	}



	public function t1aCountCodeShared($client_id, $id) {

		$fields = array(

			'fd.id'

		);

		$result = $this->db->setTable('formt1a f')

		->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')

		->setFields($fields)

		->setWhere("f.client_id='$client_id' AND f.id = '$id' AND codeshared != ''")

		->setOrderBy('fd.id')

		->runPagination();



		return $result;

	}



	public function getId($code) {

		$result = $this->db->setTable('client')

		->setFields('id')

		->setWhere("code = '$code'") 

		->runSelect()

		->getRow();



		return $result;

	}



	public function getClientId($id) {

		$result = $this->db->setTable('client_user')

		->setFields('client_id')

		->setWhere("id = '$id'") 

		->runSelect()

		->getRow();



		return $result;

	}



	public function getClientUserId($username) {

		$result = $this->db->setTable('client_user')

		->setFields('id')

		->setWhere("username = '$username' ") 

		->runSelect()

		->getRow();



		return $result;

	}



	public function getClientUserPassword($id) { 

		$result = $this->db->setTable('client_user')

		->setFields('password')

		->setWhere("id = '$id' ") 

		->runSelect()

		->getRow();



		return $result;

	}



	public function checkCode($code) {

		$result = $this->db->setTable('client')

							->setFields('code')

							->setWhere("code = '$code'")

							->setLimit(1)

							->runSelect(false)

							->getRow();



		if ($result) {

			return false;

		} else {

			return true;

		}

	}



	public function checkUsername($temp_username, $reference) {

		$result = $this->db->setTable('wc_users wc , client_user cu, client c')

							->setFields('wc.username, cu.username, c.temp_username')

							->setWhere("(wc.username = '$temp_username' OR cu.username = '$temp_username' OR c.temp_username = '$temp_username') AND wc.username != '$reference' AND cu.username != '$reference' AND c.temp_username != '$reference'")

							->setLimit(1)

							->runSelect(false)

							->getRow();



		if ($result) {

			return false;

		} else {

			return true;

		}

	}



	public function getTempUsername($client_id) {

		$result = $this->db->setTable('client')

							->setFields('temp_username')

							->setWhere("id = '$client_id'")

							->setLimit(1)

							->runSelect()

							->getRow();



		return ($result) ? $result->temp_username : false;

	}



	public function checkUserUname($username) {

		$result = $this->db->setTable('wc_users wc , client_user cu, client c')

							->setFields('wc.username, cu.username, c.temp_username')

							->setWhere("wc.username = '$username' OR cu.username = '$username' OR c.temp_username = '$username'")

							->setLimit(1)

							->runSelect(false)

							->getRow();



		if ($result) {

			return false;

		} else {

			return true;

		}

	}



	public function saveClientUser($data) {

		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

		$result = $this->db->setTable('client_user')

							->setValues($data)

							->runInsert();

		

		if ($result) {

			$this->log->saveActivity("Create Client User [{$data['lname']}]");

		}



		return $result;

	}



	public function getClientList($nature, $search, $natureids, $abc) {

		$condition = '';

		$condition .= $this->generateSearch($search, array('code' , 'name'));

		if ($nature && $nature != 'none') {

			$condition .= (($condition) ? ' AND ' : '') . "nature_id = '$nature'";

		} else if ($natureids) {

			$natureids = "'" . implode("','", $natureids) . "'";

			$condition .= (($condition) ? ' AND ' : '') . "nature_id IN ($natureids)";

		}

		if($abc){

			if($abc != 'ALL'){

				$condition .= "AND name LIKE '$abc%'";

			}

		}

		$result = $this->db->setTable('client c')

							->setFields('c.id, code, name, co.country, status, airline_represented')

							->leftJoin('client_nature cn ON cn.client_id = c.id AND cn.companycode = c.companycode')

							->leftJoin('country co ON co.id = c.country')

							->setWhere($condition." AND status != 'Terminated'")

							->setGroupBy('c.id')

							->setOrderBy('name')

							->runPagination();



		return $result;

	}





	public function getClientList1($nature, $search) {

		$condition = '';



		

		$result = $this->db->setTable('form51b a')

							->setFields("a.client_id,c.code,c.name,c.id,

							

							(select COUNT(client_id) from form51a WHERE DATE_ADD(LAST_DAY((CASE WHEN report_quarter = '1' THEN CONCAT(year, '-03-01') WHEN report_quarter = '2' THEN CONCAT(year, '-06-01') WHEN report_quarter = '3' THEN CONCAT(year, '-09-01') WHEN report_quarter = '4' THEN CONCAT(year, '-12-01') END)),INTERVAL 31 DAY) <= approveddate) as count51a,

							(select COUNT(client_id) from form61a WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count61a,

							(select COUNT(client_id) from form61b WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count61b,

							(select COUNT(client_id) from form71a WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count71a,

							(select COUNT(client_id) from form71b WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count71b,

							(select COUNT(client_id) from form71c WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as count71c,

							(select COUNT(client_id) from formt1a WHERE DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`) as countt1a						

							")

							->leftJoin('client as c ON a.client_id = c.id')

							->setWhere("DATE_ADD(LAST_DAY(CONCAT(year, '-', report_month, '-01')),INTERVAL 31 DAY) <= `approveddate`")

							->setOrderBy('c.id') 

							->setGroupBy('c.id')

							->runPagination();

							// echo $this->db->getQuery();

		return $result;

	}



	public function getClientUserList($fields, $client_id) {

		$result = $this->db->setTable('client_user')

							->setFields($fields)

							->setWhere("client_id = '$client_id'")

							->setOrderBy('id') 

							->runPagination();



							return $result;

						}

					

	public function getCurrentUser($fields, $username) {

		$result = $this->db->setTable('client_user')

							->setFields($fields)

							->setWhere("username = '$username'")

							->SetLimit(1)

							->runSelect()

							->getRow();

					

		return $result;

	}



	public function getCompanyName($id) {

		$result = $this->db->setTable('client_user cu')

		->leftJoin('client c ON c.id = cu.client_id')

		->setFields('c.id, c.name name')

		->setWhere("cu.id = '$id'") 

		->runSelect()

		->getRow();

		return $result;

	}



	public function getClientUserDetails($fields, $id) {

		$result = $this->db->setTable('client_user')

		->setFields($fields)

		->setWhere("id = '$id'") 

		->runSelect()

		->getRow();

		return $result;

	}



	public function getClientUserDetailsForPwReset($fields, $id) {

		$result = $this->db->setTable('client_user cu')

		->innerJoin("client as c ON c.id = cu.client_id ")

		->setFields($fields)

		->setWhere("cu.id = '$id' ") 

		->runSelect()

		->getRow();



		return $result;

	}



	public function getClientNatureList($fields, $client_id) {

		$result = $this->db->setTable('client_nature c')

							->innerJoin("nature_of_operation as n ON n.id = c.nature_id ")

							->setFields($fields)

							->setWhere("c.client_id='$client_id'")

							->setOrderBy('n.id') 

							->runPagination();



		return $result;

	}



	public function updateClient($data, $client_id) {

		$result = $this->db->setTable('client')

							->setValues($data)

							->setWhere("id = '$client_id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Update Client [$client_id]");

		}



		return $result;

	}



	public function updateClientUserProfile($data, $id) {

		$result = $this->db->setTable('client_user')

							->setValues($data)

							->setWhere("id = '$id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Update Client User [$id]");

		}



		return $result;

	}



	public function updateClientUserLoginInfo($data, $id) {

		$result = $this->db->setTable('client_user')

							->setValues($data)

							->setWhere("id = '$id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Update Client User [$id]");

		}



		return $result;

	}



	public function updateClientUserUname($data, $id) {

		$result = $this->db->setTable('client_user')

							->setValues($data)

							->setWhere("id = '$id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Reset Username of Client User[$id]");

		}



		return $result;

	}



	public function updateClientUserPassword($data, $id) {

		$result = $this->db->setTable('client_user')

							->setValues($data)

							->setWhere("id = '$id'")

							->setLimit(1)

							->runUpdate();



		if ($result) {

			$this->log->saveActivity("Reset Password of Client User[$id]");

		}



		return $result;

	}



	public function getLateReports($month, $year) {

		$condition = '';

		

		if ($month) {

			$condition .= ' AND ' . $this->generateSearchMonth($month, array('report_month'));

			

		}

		if ($year) {

			$condition .= ' AND ' . $this->generateSearchYear($year, array('year'));

		}

		

		$result = $this->db->setTable('form51a a')

							->setFields("a.id,a.client_id as client_id, c.code as code, c.name as name,

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

							->setOrderBy('id') 

							->runPagination();

		return $result;

	}



	public function getSuspendedUsers() {

		

		$result = $this->db->setTable('client c')

							->setFields('c.id, name, code, tin_no, cc.country, status, airline_represented')

							->leftJoin('country cc ON cc.id = c.country')

							->setWhere("status = 'Suspended'")

							->setOrderBy('c.id') 

							->runPagination();

		return $result;

	}



	public function getTerminatedUsers() {

		$result = $this->db->setTable('client c')

							->setFields('c.id, c.name, code, tin_no, cc.country, status, airline_represented')

							->leftJoin('country cc ON cc.id = c.country')

							->setWhere("status = 'Terminated'")

							->setOrderBy('c.id') 

							->runPagination();

		return $result;

	}



	public function getReportForms() {

		$result = $this->db->setTable('report_form')

							->setFields('id, code, title, short_title, db_table')

							->setOrderBy('id')

							->runPagination();

		return $result;

	}



	private function generateSearch($search, $array) {

		$temp = array();

		foreach ($array as $arr) {

			$temp[] = $arr . " LIKE '%" . str_replace(' ', '%', $search) . "%'";

		}

		return '(' . implode(' OR ', $temp) . ')';

	}



	private function generateSearchMonth($month, $array) {

		$temp = array();

		foreach ($array as $arr) {

			$temp[] = $arr . " LIKE '%" . str_replace(' ', '%', $month) . "%'";

		}

		return '(' . implode(' OR ', $temp) . ')';

	}



	private function generateSearchYear($year, $array) {

		$temp = array();

		foreach ($array as $arr) {

			$temp[] = $arr . " LIKE '%" . str_replace(' ', '%', $year) . "%'";

		}

		return '(' . implode(' OR ', $temp) . ')';

	}



	public function reportApproval($id, $db_table, $data) {

		$result = $this->db->setTable($db_table)

							->setValues($data)

							->setWhere("id = '$id'")

							->setLimit(1)

							->runUpdate();

		

		if ($result) {

			$this->log->saveActivity("Update Report Status");

		}



		return $result;

	}



	public function getReportQuarter($id) {

		$result = $result = $this->db->setTable('form51a')

		->setFields('id')

		->setWhere("client_id = '$id'")

		->setLimit(1)

		->runSelect()

		->getRow();



		return $result;

	}



	public function getNatureList($username) {

		$result = $this->db->setTable('wc_users_nature')

							->setFields('nature_id')

							->setWhere("username = '$username'")

							->runSelect()

							->getResult();



		$natureids = array();



		foreach ($result as $row) {

			$natureids[] = $row->nature_id;

		} 



		return $natureids;

	}



}