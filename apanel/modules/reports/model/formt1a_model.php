<?php
class formt1a_model extends wc_model {

	private $main_table		= 'formt1a';
	private $sub_table		= 'formt1a_details';
	private $main_column_id	= 'formt1a_id';
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
							->setWhere("formt1a_id = '$report_id'")
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
		$details['formt1a_id'] = $report_id;

		$this->cleanNumber($details, array('sector', 'distance', 'sk_offered', 'seats_offered', 'rev_pass', 'nonrev_pass', 'cargo', 'sector_d', 'distance_d', 'sk_offered_d', 'seats_offered_d', 'rev_pass_d', 'nonrev_pass_d', 'cargo_d'));

		$result = $this->db->setTable($this->sub_table)
							->setWhere("formt1a_id = '$report_id'")
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