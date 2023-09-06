<?php
class form61b_model extends wc_model {

	private $main_table		= 'form61b';
	private $sub_table		= 'form61b_details';
	private $main_column_id	= 'form61b_id';
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
							->setWhere("form61b_id = '$report_id'")
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
		$details['form61b_id'] = $report_id;
		$details['distance'] = str_replace(',', '', $details['distance']);
		$this->cleanNumber($details, array('passengers_num', 'revenue', 'flown_hour', 'flown_min', 'cargo_qty', 'cargo_value'));

		$result = $this->db->setTable($this->sub_table)
							->setWhere("form61b_id = '$report_id'")
							->runDelete();

		if ($result) {
			$result = $this->db->setTable($this->sub_table)
								->setValuesFromPost($details)
								->runInsert();
		}

		return $result;
	}

	public function getOperation($report_id) {
		$result = $this->db->setTable($this->main_table)
							->setFields('operation')
							->setWhere("id = '$report_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return ($result) ? $result->operation : '';
	}

	public function getReportId() {
		return $this->report_id;
	}

}