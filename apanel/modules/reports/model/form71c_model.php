<?php
class form71c_model extends wc_model {

	private $main_table		= 'form71c';
	private $sub_table		= 'form71c_s1tf1';
	private $main_column_id	= 'form71c_id';
	private $report_id		= '';

	public function getReport($fields, $report_id, $client_id, $user_id, $usergroup = '') {
		$result = $this->db->setTable($this->main_table)
							->setFields($fields)
							// ->setWhere("id = '$report_id' AND client_id = '$client_id' AND (submittedby_id = '$user_id' OR '$usergroup' = 'Master Admin') AND status = 'Draft'")
							->setWhere("id = '$report_id' AND client_id = '$client_id' AND status = 'Draft'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return $result;
	}

	public function getReportDetails($fields, $report_id) {
		$result = $this->db->setTable($this->sub_table)
							->setFields($fields)
							->setWhere("form71c_id = '$report_id'")
							->setOrderBy('id')
							->runSelect()
							->getResult();
		return $result;
	}

	public function saveReport($header, $details) {
		$result = $this->db->setTable($this->main_table)
							->setValues($header)
							->runInsert();

		$report_id = $this->db->getInsertId();

		if ($result) {
			$this->report_id = $report_id;
			$result = $this->updateReportDetails($details, $report_id);
		}

		return $result;
	}

	public function updateReport($header, $details, $report_id, $client_id) {

		$result = $this->db->setTable($this->main_table)
							->setValues($header)
							->setWhere("id = '$report_id' AND client_id = '$client_id' AND status = 'Draft'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$result = $this->updateReportDetails($details, $report_id);
		}

		return $result;
	}

	public function deleteReport($report_id, $client_id) {
		$result = $this->db->setTable($this->main_table)
							->setValues(array('status' => 'Deleted'))
							->setWhere("id = '$report_id' AND client_id = '$client_id' AND status = 'Draft'")
							->setLimit(1)
							->runUpdate();

		return $result;
	}

	public function updateReportDetails($details, $report_id) {
		$details['form71c_id'] = $report_id;

		$this->cleanNumber($details, array('weight', 'numMawbs', 'commission', 'fcharge'));

		$result = $this->db->setTable($this->sub_table)
							->setWhere("form71c_id = '$report_id'")
							->runDelete();

		if ($result) {
			$result = $this->db->setTable($this->sub_table)
								->setValuesFromPost($details)
								->runInsert();
		}

		return $result;
	}

	public function getReportId() {
		return $this->report_id;
	}
	
}