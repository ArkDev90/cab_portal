<?php
class form71a_model extends wc_model {

	private $main_table		= 'form71a';
	private $sub_table		= 'form71a_s1tf1';
	private $sub_table2		= 'form71a_s2tf2';
	private $sub_table3		= 'form71a_serial';
	private $main_column_id	= 'form71a_id';
	private $report_id		= '';

	public function getReport($fields, $report_id, $client_id, $user_id, $usergroup = '') {
		$result = $this->db->setTable($this->main_table)
							->setFields($fields)
							// ->setWhere("id = '$report_id' AND client_id = '$client_id' AND (submittedby_id = '$user_id' OR '$usergroup' = 'Master Admin') AND status = 'Draft'")
							->setWhere("id = '$report_id' AND client_id = '$client_id' AND status = 'Draft'")
							->setLimit(1)
							->runSelect()
							->getRow();

		$result2 = $this->db->setTable($this->sub_table3)
							->setFields('serialnum, excluded')
							->setWhere("{$this->main_column_id} = '$report_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		if ( ! $result2) {
			$result2 = (object) array(
				'serialnum'	=> '',
				'excluded'	=> ''
			);
		}

		$result = (object) array_merge((array) $result, (array) $result2);

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
							->setWhere("{$this->main_column_id} = '$report_id' AND aircraft != ''")
							->runSelect()
							->getResult();

		return $result;
	}

	public function getReportDetails3($fields, $report_id) {
		$result = $this->db->setTable($this->sub_table2)
							->setFields($fields)
							->setWhere("{$this->main_column_id} = '$report_id' AND origin != ''")
							->runSelect()
							->getResult();

		return $result;
	}

	public function saveReport($header, $details, $details2, $details3) {
		$result = $this->db->setTable($this->main_table)
							->setValues($header)
							->runInsert();

		$report_id = $this->db->getInsertId();

		if ($result) {
			$this->report_id = $report_id;
			$this->updateReportDetails($details, $report_id);
			$this->updateReportDetails2($details2, $report_id);
			$this->updateReportDetails3($details3, $report_id);
		}

		return $result;
	}

	public function updateReport($header, $details, $details2, $details3, $report_id, $client_id) {
		$result = $this->db->setTable($this->main_table)
							->setValues($header)
							->setWhere("id = '$report_id' AND client_id = '$client_id' AND status = 'Draft'")
							->setLimit(1)
							->runUpdate();

		if ($result) {
			$this->updateReportDetails($details, $report_id);
			$this->updateReportDetails2($details2, $report_id);
			$this->updateReportDetails3($details3, $report_id);
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

		$this->cleanNumber($details, array('numMawbs', 'weight', 'fcharge', 'commission'));

		$result = $this->db->setTable($this->sub_table)
							->setWhere("{$this->main_column_id} = '$report_id'")
							->runDelete();

		if ($result && $details['aircraft']) {
			$result = $this->db->setTable($this->sub_table)
								->setValuesFromPost($details)
								->runInsert();
		}

		return $result;
	}

	public function updateReportDetails2($details, $report_id) {
		$details[$this->main_column_id] = $report_id;

		$this->cleanNumber($details, array('numMawbs', 'numHawbs1', 'weight', 'fcharge', 'revenue', 'numHawbs2', 'orgWeight', 'incomeBreak'));

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

	public function updateReportDetails3($details, $report_id) {
		$details[$this->main_column_id] = $report_id;

		$result = $this->db->setTable($this->sub_table3)
							->setWhere("{$this->main_column_id} = '$report_id'")
							->runDelete();

		if ($result && $details['serialnum']) {
			$result = $this->db->setTable($this->sub_table3)
								->setValues($details)
								->runInsert();
		}

		return $result;
	}

	public function getReportId() {
		return $this->report_id;
	}

}