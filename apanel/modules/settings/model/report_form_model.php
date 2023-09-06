<?php
class report_form_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function getReportFormList($fields) {
		$result = $this->db->setTable('report_form')
                            ->setFields($fields)
                            ->setOrderBy('id') 
                            ->runPagination();

		return $result;
	}

    public function getReportFormById($fields, $id) {
		return $this->db->setTable('report_form')
						->setFields($fields)
						->setWhere("id = '$id'")
						->setLimit(1)
						->runSelect()
						->getRow();
	}

    public function updateReportForm($data, $id) {
		$result = $this->db->setTable('report_form')
							->setValues($data)
							->setWhere("id = '$id'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update Report Form [$id]");
		}

		return $result;
	}

	public function updateStartDate($values) {
		
		$result = $this->db->setTable('report_form')
							->setValues($values)
							->setWhere('1')
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update Start Date of Report Form");
		}

		return $result;
	}

	public function updateExpirationDate($values) {
		
		$result = $this->db->setTable('report_form')
							->setValues($values)
							->setWhere('1')
							->runUpdate();

		if ($result) {
			$this->log->saveActivity("Update Start Date of Report Form");
		}

		return $result;
	}
}
