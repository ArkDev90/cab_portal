<?php
class form51b_model extends wc_model {

	private $main_table		= 'form51b';
	private $sub_table		= 'form51b_direct';
	private $sub_table2		= 'form51b_transit';
	private $main_column_id	= 'form51b_id';
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
							->setWhere("{$this->main_column_id} = '$report_id'")
							->runSelect()
							->getResult();

		return $result;
	}

	public function getReportDetails2($fields, $report_id) {
		$result = $this->db->setTable($this->sub_table2)
							->setFields($fields)
							->setWhere("{$this->main_column_id} = '$report_id'")
							->runSelect()
							->getResult();

		return $result;
	}

	public function saveReport($header, $details, $details2) {
		$result = $this->db->setTable($this->main_table)
							->setValues($header)
							->runInsert();

		$report_id = $this->db->getInsertId();

		if ($result) {
			$this->report_id = $report_id;
			$result = $this->updateReportDetails($details, $report_id);
			$result = $this->updateReportDetails2($details2, $report_id);
		}

		return $result;
	}

	public function updateReport($header, $details, $details2, $report_id, $client_id) {
		$result = $this->db->setTable($this->main_table)
							->setValues($header)
							->setWhere("id = '$report_id' AND client_id = '$client_id' AND status = 'Draft'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$result = $this->updateReportDetails($details, $report_id);
			$result = $this->updateReportDetails2($details2, $report_id);
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
		$details[$this->main_column_id] = $report_id;

		$this->cleanNumber($details, array('cargoRev', 'cargoNonRev', 'mailRev', 'mailNonRev', 'cargoRevDep', 'cargoNonRevDep', 'mailRevDep', 'mailNonRevDep'));

		$result = $this->db->setTable($this->sub_table)
							->setWhere("{$this->main_column_id} = '$report_id'")
							->runDelete();

		if ($result) {
			$result = $this->db->setTable($this->sub_table)
								->setValuesFromPost($details)
								->runInsert();
		}

		return $result;
	}

	public function updateReportDetails2($details, $report_id) {
		$details[$this->main_column_id] = $report_id;

		$this->cleanNumber($details, array('cargoRev', 'cargoNonRev', 'mailRev', 'mailNonRev', 'cargoRevDep', 'cargoNonRevDep', 'mailRevDep', 'mailNonRevDep'));

		$result = $this->db->setTable($this->sub_table2)
							->setWhere("{$this->main_column_id} = '$report_id'")
							->runDelete();

		if ($result && $details['aircraft']) {
			$result = $this->db->setTable($this->sub_table2)
								->setValuesFromPost($details)
								->runInsert();
		}

		return $result;
	}

	public function getReportId() {
		return $this->report_id;
	}
	
}