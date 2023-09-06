<?php
class reports_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function getNatureList() {
		$result = $this->db->setTable('nature_of_operation')
                            ->setFields('id,title')
                            ->setOrderBy('title') 
							->runSelect()
							->getResult();

		return $result;
	}

	public function getNatureById($fields, $id) {
		return $this->db->setTable('nature_of_operation')
						->setFields('id,title')
						->setWhere("id = '$id'")
						->setLimit(1)
						->runSelect()
						->getRow();
	}

	public function getReportId($id) {
		$result = $this->db->setTable('report_form rf')
		->leftJoin("nature_report_form as nrf ON nrf.report_form_id = rf.id AND nrf.nature_id = '$id'")
		->setFields('rf.id, title, code, nrf.report_form_id')
		->setOrderBy('rf.id')
		->setGroupBy('rf.id')
		->runSelect()
		->getResult();

		return $result;
	}

	public function saveReportForm($id) {
		$result = $this->db->setTable('nature_report_form')
		->setWhere("nature_id = '$id'")
		->runDelete();
		
		if ($result) {
			$this->log->saveActivity("Create Report Form");
		}

		return $result;
	}

	public function saveNatureRepForm($reportform) {
		$result = $this->db->setTable('nature_report_form')
		->setValuesFromPost($reportform)
		->runInsert();
	}
	
	public function getForm51a() {
		$result = $this->db->setTable('form51a as f')
							->leftJoin('client as c ON c.id = f.client_id')
							->setFields('f.id, f.client_id as client_id, f.report_quarter as report_quarter, f.year as year, f.status as status, f.entereddate as entereddate, f.enteredby as enteredby, c.code as code, c.name as name')
							->runPagination();

		return $result;
	}

}
