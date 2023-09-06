<?php
class form51a_model extends wc_model {

	private $main_table		= 'form51a';
	private $sub_table		= 'form51a_direct';
	private $sub_table2		= 'form51a_transit';
	private $main_column_id	= 'form51a_id';
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
			$this->updateReportDetails($details, $report_id);
			$this->updateReportDetails2($details2, $report_id);
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
			$this->updateReportDetails($details, $report_id);
			$this->updateReportDetails2($details2, $report_id);
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

		$this->cleanNumber($details, array('economy', 'business', 'first', 'quarter_month1', 'quarter_month2', 'quarter_month3', 'foctraffic_month1', 'foctraffic_month2', 'foctraffic_month3', 'nflight_month1', 'nflight_month2', 'nflight_month3', 'quarter_month1_d', 'quarter_month2_d', 'quarter_month3_d', 'foctraffic_month1_d', 'foctraffic_month2_d', 'foctraffic_month3_d', 'nflight_month1_d', 'nflight_month2_d', 'nflight_month3_d', 'ex_quarter_month1', 'ex_quarter_month2', 'ex_quarter_month3', 'ex_foctraffic_month1', 'ex_foctraffic_month2', 'ex_foctraffic_month3', 'ex_nflight_month1', 'ex_nflight_month2', 'ex_nflight_month3', 'ex_quarter_month1_d', 'ex_quarter_month2_d', 'ex_quarter_month3_d', 'ex_foctraffic_month1_d', 'ex_foctraffic_month2_d', 'ex_foctraffic_month3_d', 'ex_nflight_month1_d', 'ex_nflight_month2_d', 'ex_nflight_month3_d', 'cs_quarter_month1', 'cs_quarter_month2', 'cs_quarter_month3', 'cs_foctraffic_month1', 'cs_foctraffic_month2', 'cs_foctraffic_month3', 'cs_nflight_month1', 'cs_nflight_month2', 'cs_nflight_month3', 'cs_quarter_month1_d', 'cs_quarter_month2_d', 'cs_quarter_month3_d', 'cs_foctraffic_month1_d', 'cs_foctraffic_month2_d', 'cs_foctraffic_month3_d', 'cs_nflight_month1_d', 'cs_nflight_month2_d', 'cs_nflight_month3_d', 'ex_cs_quarter_month1', 'ex_cs_quarter_month2', 'ex_cs_quarter_month3', 'ex_cs_foctraffic_month1', 'ex_cs_foctraffic_month2', 'ex_cs_foctraffic_month3', 'ex_cs_nflight_month1', 'ex_cs_nflight_month2', 'ex_cs_nflight_month3', 'ex_cs_quarter_month1_d', 'ex_cs_quarter_month2_d', 'ex_cs_quarter_month3_d', 'ex_cs_foctraffic_month1_d', 'ex_cs_foctraffic_month2_d', 'ex_cs_foctraffic_month3_d', 'ex_cs_nflight_month1_d', 'ex_cs_nflight_month2_d', 'ex_cs_nflight_month3_d'));

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

		$this->cleanNumber($details, array('quarter_month1', 'quarter_month2', 'quarter_month3', 'quarter_month1_d', 'quarter_month2_d', 'quarter_month3_d'));

		$result = $this->db->setTable($this->sub_table2)
							->setWhere("{$this->main_column_id} = '$report_id'")
							->runDelete();

		if ($result && $details['destination_from']) {
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