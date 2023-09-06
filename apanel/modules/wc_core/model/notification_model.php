<?php
class notification_model extends wc_model {

	public function getNonSubmission() {
		$summary_report	= $this->getSummaryReport();

		$result = $this->db->setTable('client c')
							->setFields("c.name, c.email, nrf.report_form_id, noo.title, DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 31 DAY), IF(nrf.report_form_id = 11, CONCAT('Quarter ', QUARTER(DATE_SUB(CURDATE(), INTERVAL 31 DAY)), ' %Y'), '%M %Y')) period, rf.code")
							->innerJoin('client_nature cn ON cn.client_id = c.id AND cn.companycode = c.companycode')
							->innerJoin('nature_of_operation noo ON noo.id = cn.nature_id AND noo.companycode = cn.companycode')
							->innerJoin("nature_report_form nrf ON nrf.nature_id = cn.nature_id AND nrf.companycode = cn.companycode")
							->innerJoin('report_form rf ON rf.id = nrf.report_form_id AND rf.companycode = nrf.companycode')
							->leftJoin("($summary_report) sr ON nrf.report_form_id = sr.report_form_id AND sr.client_id = c.id AND sr.status = 'Approved' AND LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 31 DAY)) = LAST_DAY(report_date)")
							->setWhere("c.status = 'Active' AND sr.companycode IS NULL AND nrf.report_form_id != 14 AND LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 31 DAY)) = DATE_SUB(CURDATE(), INTERVAL 31 DAY) AND 0 = IF(nrf.report_form_id = 11,MOD(MONTH(LAST_DAY(DATE_SUB(CURDATE(), INTERVAL 31 DAY))), 3) , 0)")
							->setGroupBy('c.id, nrf.report_form_id')
							->setOrderBy('c.name, nrf.report_form_id')
							->runSelect()
							->getResult();

		return $result;
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
								->setFields("companycode, $report_form_id report_form_id, client_id, CONCAT(year, '-', (report_quarter * 3), '-01') report_date, year, approveddate, status")
								->buildSelect();
		}
		
		foreach ($monthly as $report_form_id => $report) {
			$query[] = $this->db->setTable($report)
								->setFields("companycode, $report_form_id report_form_id, client_id, CONCAT(year, '-', report_month, '-01') report_date, year, approveddate, status")
								->buildSelect();
		}

		return implode(' UNION ', $query);
	}

	public function getEndingSubscription($interval) {
		$result = $this->db->setTable('client c')
							->innerJoin('client_nature cn ON cn.client_id = c.id AND cn.companycode = c.companycode')
							->innerJoin('nature_of_operation noo ON noo.id = cn.nature_id AND noo.companycode = cn.companycode')
							->innerJoin('client_nature_expiration cne ON cne.client_nature_id = cn.id AND cne.companycode = cn.companycode')
							->setFields('c.name, c.email, cne.expdate, c.name, c.email, DATE(cne.expdate - INTERVAL 60 DAY) noticedate, cn.nature_id, noo.title')
							->setWhere("DATE(cne.expdate - INTERVAL $interval DAY) = DATE(DATE_FORMAT(NOW(),'%Y-%m-%d'))")
							->runSelect()
							->getResult();

		return $result;
	}

}