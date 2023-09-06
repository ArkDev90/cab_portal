<?php
class stakeholder_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function getReportTitle($report_id) {
		$result = $this->db->setTable('report_form')
							->setFields('title')
							->setWhere("id = '$report_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return ($result) ? $result->title : '';
	}

	public function getAirTypeDropdown() {
		$result = $this->db->setTable('report_form')
							->setFields('id ind, title val')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getNatureDropdown() {
		$result = $this->db->setTable('nature_of_operation')
							->setFields('id ind, title val')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getNatureData() {
		$result = $this->db->setTable('nature_of_operation n')
							->leftJoin('nature_report_form nrf ON nrf.nature_id = n.id AND nrf.companycode = n.companycode')
							->leftJoin('report_form rf ON rf.id = nrf.report_form_id AND rf.companycode = nrf.companycode')
							->setFields('n.id, report_form_id, rf.title')
							->setOrderBy('n.id')
							->runSelect()
							->getResult();

		$list = array();

		if ($result) {
			foreach ($result as $row) {
				$list[$row->id] = (isset($list[$row->id])) ? $list[$row->id] : array();

				$list[$row->id][] = array(
					'ind' => $row->report_form_id,
					'val' => $row->title
				);
			}
		}

		return $list;
	}

	public function getLateReports($report_id, $report_date, $report_filter) {
		$summary_report = $this->getSummaryReport();

		$result = $this->db->setTable("($summary_report) sr")
							->setFields("c.name, $report_date report_date")
							->innerJoin('report_form rf ON rf.id = sr.report_form_id AND rf.companycode = sr.companycode')
							->innerJoin('client c ON c.id = sr.client_id AND c.companycode = sr.companycode')
							->setWhere("c.status = 'Active' AND DATE_ADD(LAST_DAY(DATE_FORMAT($report_date,'%Y-%m-%01')),INTERVAL 31 DAY) <= approveddate AND $report_date <= '$report_filter' AND sr.status = 'Approved' AND sr.report_form_id = '$report_id'")
							->runSelect()
							->getResult();

		return $result;
	}

	public function getUnsubmittedReports($report_id, $report_date, $month_query) {
		$summary_report = $this->getSummaryReport();

		$result = $this->db->setTable('client c')
							->setFields("c.name, CONCAT(mq.year, '-', mq.month, '-', '01') report_date")
							->innerJoin("($month_query) mq ON 1 = 1")
							->innerJoin('client_nature cn ON cn.client_id = c.id AND cn.companycode = c.companycode')
							->innerJoin("nature_report_form nrf ON nrf.report_form_id = '$report_id' AND nrf.nature_id = cn.nature_id AND nrf.companycode = cn.companycode")
							->leftJoin("($summary_report) sr ON nrf.report_form_id = sr.report_form_id AND sr.client_id = c.id AND YEAR($report_date) = mq.year AND MONTH($report_date) = mq.month AND sr.status = 'Approved'")
							->setWhere("c.status = 'Active' AND sr.companycode IS NULL")
							->setGroupBy('c.id, mq.year, mq.month')
							->setOrderBy('c.name, mq.year, mq.month')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getReportCheckList($report_id, $year, $month_query, $report_date) {
		$check_list = $this->getReportCheckListQuery($report_id, $year, $month_query, $report_date);

		$result = $check_list->runSelect()
								->getResult();

		return $result;
	}

	public function getCheckListExpirationCount($report_id, $year, $month_query, $report_date) {
		$check_list		= $this->getReportCheckListQuery($report_id, $year, $month_query, $report_date);
		$check_query	= $check_list->buildSelect();

		$result = $check_list->setTable("($check_query) a")
								->setFields('COUNT(*) expired')
								->setWhere("expdate IS NOT NULL AND expdate >= CURDATE()")
								->runSelect(false)
								->getRow();

		return ($result) ? $result->expired : 0;
	}

	private function getReportCheckListQuery($report_id, $year, $month_query, $report_date) {
		$summary_report = $this->getSummaryReport();

		$query = $this->db->setTable('client c')
							->setFields("c.name, mq.month_num, mq.month, IF(rs.report_date IS NULL, 'none', IF(DATE_ADD(LAST_DAY(DATE_FORMAT($report_date,'%Y-%m-%01')),INTERVAL 31 DAY) <= rs.approveddate, 'late', 'submitted')) status, approveddate, cne.expdate, IF(cne.expdate IS NULL, 'not set', IF(cne.expdate <= CURDATE(), 'expired', 'active')) expiration")
							->innerJoin("($month_query) mq ON 1 = 1")
							->leftJoin('client_nature cn ON cn.client_id = c.id AND cn.companycode = c.companycode')
							->leftJoin('client_nature_expiration cne ON cne.client_nature_id = cn.id AND cne.companycode = cn.companycode')
							->innerJoin("nature_report_form nrf ON nrf.report_form_id = '$report_id' AND nrf.nature_id = cn.nature_id AND nrf.companycode = cn.companycode")
							->leftJoin("($summary_report) rs ON rs.client_id = c.id AND rs.report_form_id = nrf.report_form_id AND YEAR($report_date) = '$year' AND MONTH($report_date) = mq.month_num AND rs.status = 'Approved'")
							->setWhere("c.status = 'Active'")
							->setGroupBy('c.id, month_num')
							->setOrderBy('c.name, month_num');

		return $query;
	}

	private function getSummaryReport() {
		$monthly	= array(
			'18'	=> 'form51b',
			'16'	=> 'form61a',
			'15'	=> 'form61b',
			'306'	=> 'form71a',
			'310'	=> 'form71b',
			'8'		=> 'form71c',
			'17'	=> 'formt1a'
		);

		$quarterly	= array(
			'11'	=> 'form51a'
		);

		$query = array();
		
		foreach ($quarterly as $report_form_id => $report) {
			$query[] = $this->db->setTable($report)
								->setFields("companycode, $report_form_id report_form_id, client_id, CONCAT('quarter_', report_quarter) report_date, year, approveddate, status")
								->buildSelect();
		}
		
		foreach ($monthly as $report_form_id => $report) {
			$query[] = $this->db->setTable($report)
								->setFields("companycode, $report_form_id report_form_id, client_id, CONCAT(year, '-', report_month, '-', '0') report_date, year, approveddate, status")
								->buildSelect();
		}

		return implode(' UNION ', $query);
	}

	private function generateSearch($search, $array) {
		$temp = array();
		foreach ($array as $arr) {
			$temp[] = $arr . " LIKE '%" . str_replace(' ', '%', $search) . "%'";
		}
		return '(' . implode(' OR ', $temp) . ')';
	}

}