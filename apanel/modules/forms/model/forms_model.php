<?php
class forms_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function getForm51a() {
		$result = $this->db->setTable('form51a')
							->setFields('id, client_id, report_quarter, year, status, entereddate, enteredby')
							->runPagination();

		return $result;
	}

	public function getForm51a_direct($data) {
		$result = $this->db->setTable('form51a_direct')
							->setFields($data)
							->setWhere('form51a_id = "1"')
							->runPagination();

		return $result;
	}

	public function getDomesticList($search = '') {
		$result = $this->db->setTable('origin_destination')
						->setFields('code ind, title val')
						->setWhere('type = "Domestic"')
						->setOrderBy('title')
						->runSelect()
						->getResult();

		return $result;
	}

	public function getInternationalList($search = '') {
		$result = $this->db->setTable('origin_destination')
						->setFields('code ind, title val')
						->setWhere('type = "International"')
						->setOrderBy('title')
						->runSelect()
						->getResult();

		return $result;
	}

	public function AddForm51a($data,$client_id) {
		$data['client_id'] = $client_id;
		$result = $this->db->setTable('form51a')
		->setValues($data)
		->runInsert();
		
		if ($result) {
			$this->log->saveActivity("Create Form51a Type [{$data['client_id']}]");
		}

		return $result;
	}

	public function AddEntries($data) {
		$result = $this->db->setTable('form51a_direct')
		->setValues($data)
		->runInsert();
		
		if ($result) {
			$this->log->saveActivity("Create Form51a Type [{$data['form51a_id']}]");
		}

		return $result;
	}


}

