<?php
class reporting_model extends wc_model {

	public function getFullName($id) {
		$result = $this->db->setTable('client_user')
							->setFields('fname, lname')
							->setWhere("id='$id'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function getFormTitle($report_form_id) {
		$result = $this->db->setTable('report_form')
							->setFields('code, title')
							->setWhere("id = '$report_form_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return ($result) ? $result->code . ' - ' . $result->title : '';
	}

	public function getReportList($report_form_table, $client_id, $fiscal) {
		$report_period = ($report_form_table == 'form51a') ? 'report_quarter' : 'report_month';
		


		$result = $this->db->setTable($report_form_table)
							->setFields($fiscal . ', year, status, submittedby, submitteddate, approvedby, approveddate, id')
							->setWhere("client_id = '$client_id' AND status IN('Approved', 'Draft', 'Disapproved', 'Pending')")
							->setOrderBy("entereddate DESC, year DESC, $report_period DESC")
							->runPagination();

		return $result;
	}

	public function getReportDraftList($report_form_table, $client_id, $fiscal) {
		$result = $this->db->setTable($report_form_table)
							->setFields($fiscal . ', year, status, submittedby, submittedby_id, submitteddate, id')
							->setWhere("client_id = '$client_id' AND status = 'Draft'")
							->runPagination();

		return $result;
	}

	public function checkExistingReport($month, $year, $report_form_table, $client_id) {
		$result = $this->db->setTable($report_form_table)
							->setFields('report_month, year, status, submittedby')
							->setWhere("client_id = '$client_id' AND report_month = '$month' AND year = '$year' AND status IN('Draft', 'Pending', 'Approved')")
							->setLimit(1)
							->runSelect()
							->getRow();

		return ($result) ? true : false;
	}

	public function checkExistingQuarterReport($quarter, $year, $report_form_table, $client_id) {
		$result = $this->db->setTable($report_form_table)
							->setFields('report_quarter, year, status, submittedby')
							->setWhere("client_id = '$client_id' AND report_quarter = '$quarter' AND year = '$year' AND status IN('Draft', 'Pending', 'Approved')")
							->setLimit(1)
							->runSelect()
							->getRow();

		return ($result) ? true : false;
	}

	public function getOriginDestinationList($report_form_id, $type, $code = false) {
		$fields = array('title ind', 'title val');
		if ($code) {
			$fields = array("IF(code = '-', title, code) ind", "CONCAT(IF(code = '-', '', CONCAT(code, ' - ')), title) val");
		}
		$report_type = '';
		if ($type) {
			$report_type = "AND od.type = '$type'";
		}

		$result = $this->db->setTable('origin_destination_form odf')
							->innerJoin('origin_destination od ON od.id = odf.origin_destination_id AND od.companycode = odf.companycode')
							->setFields($fields)
							->setWhere("odf.report_form_id = '$report_form_id' $report_type")
							->setOrderBy('val')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getMonthDays($month, $year) {
		$days = array();
		$end_date = date('t', strtotime("$year-$month-1"));;

		for ($day = 1; $day <= $end_date; $day++) {
			$days[] = (object) array(
				'ind'	=> $day,
				'val'	=> $day
			);
		}

		return $days;
	}

	public function getQuarterName($quarter) {
		$ordinal	= $this->ordinalValue($quarter);
		$months		= $this->quarterMonths($quarter);
		$months		= implode(', ', $months);
		return  "$ordinal Quarter ($months)";
	}

	public function getMonthName($month) {
		return date('F', mktime(0, 0, 0, $month, 10));
	}

	public function getQuarters() {
		$quarters = array();

		for ($quarter = 1; $quarter <= 4; $quarter++) {
			$quarters[] = (object) array(
				'ind'	=> $quarter,
				'val'	=> $this->getQuarterName($quarter)
			);
		}

		return $quarters;
	}

	public function getMonths() {
		$months = array();

		for ($month = 1; $month <= 12; $month++) {
			$months[] = (object) array(
				'ind'	=> $month,
				'val'	=> $this->getMonthName($month)
			);
		}

		return $months;
	}

	public function getYears() {
		$years = array();

		for ($year = date('Y'); $year >= 2010; $year--) {
			$years[] = (object) array(
				'ind'	=> $year,
				'val'	=> $year
			);
		}

		return $years;
	}

	public function checkValidDate($year, $month) {
		if ($year < 2010 || $year > date('Y') || $month < 1 || $month > 12) {
			return false;
		}

		return true;
	}

	public function quarterMonths($quarter) {
		$quarters = array();

		$months = $this->getMonths();

		foreach ($months as $month) {
			if (ceil($month->ind / 3) == $quarter) {
				$quarters[] = substr($month->val, 0, 3);
			}
		}

		return $quarters;
	}

	public function ordinalValue($number) {
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
			return $number . 'th';
		} else {
			return $number . $ends[$number % 10];
		}
	}

	public function getPeriod($period, $form) {
		$period_name = '';
		if ($form == 'form51a') {
			if ($period == '1') {
				$period_name = 'First Quarter';
			} elseif ($period == '2') {
				$period_name = 'Second Quarter';
			} elseif ($period == '3') {
				$period_name = 'Third Quarter';
			} elseif ($period == '4') {
				$period_name = 'Fourth Quarter';
			}
		} else {
			$date = DateTime::createFromFormat('!m', $period);
			$period_name = $date->format('F');
		}
		return $period_name;
	}
		
	public function getClientInfo($client_id) {
		$fields = array(
			'code', 
			'name', 
			'tin_no', 
			'address', 
			'website', 
			'telno',
			'cp_designation',
			'email', 
			'cperson', 
			'cp_contact',
			'postal_code', 
			'faxno', 
			'mobno', 
			'airline_represented', 
			'regdate', 
			'co.country', 
			'status', 
			'temp_username',
			'c.entereddate'
		);

		$result = $this->db->setTable('client c')
							->leftJoin('country co ON co.id = c.country')
							->setFields($fields)
							->setWhere("c.id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		return $result;
	}

	public function getForm51a($report_id, $client_id) {
		$data	= array();
		$data	= (array) $this->db->setTable('form51a')
							->setFields(array(
								'year',
								'report_quarter',
								'status',
								'submittedby',
								'submitteddate',
								'approvedby',
								'approveddate',
								'enteredby'
							))
							->setWhere("id = '$report_id' AND client_id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		if ( ! $data) {
			return false;
		}

		$data['direct']			= $this->db->setTable('form51a_direct')
											->setFields(array(
												'aircraft',
												'destination_from',
												'destination_to',
												'codeshared',
												'extra',
												'extra_dest',
												'economy',
												'business',
												'first',
												'quarter_month1',
												'quarter_month2',
												'quarter_month3',
												'foctraffic_month1',
												'foctraffic_month2',
												'foctraffic_month3',
												'nflight_month1',
												'nflight_month2',
												'nflight_month3',
												'quarter_month1_d',
												'quarter_month2_d',
												'quarter_month3_d',
												'foctraffic_month1_d',
												'foctraffic_month2_d',
												'foctraffic_month3_d',
												'nflight_month1_d',
												'nflight_month2_d',
												'nflight_month3_d'
											))
											->setWhere("form51a_id = '$report_id' AND extra IN ('no', '')")
											->runSelect()
											->getResult();

		$data['direct_cs']		= $this->db->setTable('form51a_direct')
											->setFields(array(
												'aircraft',
												'destination_from',
												'destination_to',
												'codeshared',
												'extra',
												'extra_dest',
												'economy',
												'business',
												'first',
												'cs_quarter_month1',
												'cs_quarter_month2',
												'cs_quarter_month3',
												'cs_foctraffic_month1',
												'cs_foctraffic_month2',
												'cs_foctraffic_month3',
												'cs_nflight_month1',
												'cs_nflight_month2',
												'cs_nflight_month3',
												'cs_quarter_month1_d',
												'cs_quarter_month2_d',
												'cs_quarter_month3_d',
												'cs_foctraffic_month1_d',
												'cs_foctraffic_month2_d',
												'cs_foctraffic_month3_d',
												'cs_nflight_month1_d',
												'cs_nflight_month2_d',
												'cs_nflight_month3_d'
											))
											->setWhere("form51a_id = '$report_id' AND extra IN ('no', '') AND codeshared != ''")
											->runSelect()
											->getResult();

		$data['free_flight']		= $this->db->setTable('form51a_direct')
												->setFields(array(
													'aircraft',
													'destination_from',
													'destination_to',
													'codeshared',
													'extra',
													'extra_dest',
													'economy',
													'business',
													'first',
													'quarter_month1',
													'quarter_month2',
													'quarter_month3',
													'foctraffic_month1',
													'foctraffic_month2',
													'foctraffic_month3',
													'nflight_month1',
													'nflight_month2',
													'nflight_month3',
													'quarter_month1_d',
													'quarter_month2_d',
													'quarter_month3_d',
													'foctraffic_month1_d',
													'foctraffic_month2_d',
													'foctraffic_month3_d',
													'nflight_month1_d',
													'nflight_month2_d',
													'nflight_month3_d',
													'ex_quarter_month1',
													'ex_quarter_month2',
													'ex_quarter_month3',
													'ex_foctraffic_month1',
													'ex_foctraffic_month2',
													'ex_foctraffic_month3',
													'ex_nflight_month1',
													'ex_nflight_month2',
													'ex_nflight_month3',
													'ex_quarter_month1_d',
													'ex_quarter_month2_d',
													'ex_quarter_month3_d',
													'ex_foctraffic_month1_d',
													'ex_foctraffic_month2_d',
													'ex_foctraffic_month3_d',
													'ex_nflight_month1_d',
													'ex_nflight_month2_d',
													'ex_nflight_month3_d'
												))
												->setWhere("form51a_id = '$report_id' AND (extra NOT IN ('no', '') OR aircraft = 'NO OPERATION')")
												->runSelect()
												->getResult();

		$data['free_flight_cs']		= $this->db->setTable('form51a_direct')
										->setFields(array(
											'aircraft',
											'destination_from',
											'destination_to',
											'codeshared',
											'extra',
											'extra_dest',
											'economy',
											'business',
											'first',
											'cs_quarter_month1',
											'cs_quarter_month2',
											'cs_quarter_month3',
											'cs_foctraffic_month1',
											'cs_foctraffic_month2',
											'cs_foctraffic_month3',
											'cs_nflight_month1',
											'cs_nflight_month2',
											'cs_nflight_month3',
											'cs_quarter_month1_d',
											'cs_quarter_month2_d',
											'cs_quarter_month3_d',
											'cs_foctraffic_month1_d',
											'cs_foctraffic_month2_d',
											'cs_foctraffic_month3_d',
											'cs_nflight_month1_d',
											'cs_nflight_month2_d',
											'cs_nflight_month3_d',
											'ex_cs_quarter_month1',
											'ex_cs_quarter_month2',
											'ex_cs_quarter_month3',
											'ex_cs_foctraffic_month1',
											'ex_cs_foctraffic_month2',
											'ex_cs_foctraffic_month3',
											'ex_cs_nflight_month1',
											'ex_cs_nflight_month2',
											'ex_cs_nflight_month3',
											'ex_cs_quarter_month1_d',
											'ex_cs_quarter_month2_d',
											'ex_cs_quarter_month3_d',
											'ex_cs_foctraffic_month1_d',
											'ex_cs_foctraffic_month2_d',
											'ex_cs_foctraffic_month3_d',
											'ex_cs_nflight_month1_d',
											'ex_cs_nflight_month2_d',
											'ex_cs_nflight_month3_d'
										))
										->setWhere("form51a_id = '$report_id' AND ((extra NOT IN ('no', '') AND codeshared != '') OR aircraft = 'NO OPERATION')")
										->runSelect()
										->getResult();

		$data['transit']	= $this->db->setTable('form51a_transit')
										->setFields(array(
											'destination_from',
											'destination_to',
											'quarter_month1',
											'quarter_month2',
											'quarter_month3',
											'quarter_month1_d',
											'quarter_month2_d',
											'quarter_month3_d'
										))
										->setWhere("form51a_id = '$report_id'")
										->runSelect()
										->getResult();

		return $data;
	}

	public function getForm51b($report_id, $client_id) {
		$data = (array) $this->db->setTable('form51b')
								->setFields(array(
									'year',
									'report_month',
									'status',
									'submittedby',
									'submitteddate',
									'approvedby',
									'approveddate',
									'enteredby'
								))
								->setWhere("id = '$report_id' AND client_id = '$client_id'")
								->setLimit(1)
								->runSelect()
								->getRow();

		$data['direct'] = $this->db->setTable('form51b_direct')
									->setFields(array(
										'routeTo',
										'routeFrom',
										'aircraft',
										'flightNum',
										'cargoRev',
										'cargoNonRev',
										'mailRev',
										'mailNonRev',
										'cargoRevDep',
										'cargoNonRevDep',
										'mailRevDep',
										'mailNonRevDep'
									))
									->setWhere("form51b_id = '$report_id'")
									->setOrderBy('routeTo, routeFrom')
									->runSelect()
									->getResult();


		$data['transit'] = $this->db->setTable('form51b_transit')
									->setFields(array(
										'routeTo',
										'routeFrom',
										'aircraft',
										'cargoRev',
										'cargoNonRev',
										'mailRev',
										'mailNonRev',
										'cargoRevDep',
										'cargoNonRevDep',
										'mailRevDep',
										'mailNonRevDep'
									))
									->setWhere("form51b_id = '$report_id'")
									->setOrderBy('routeTo, routeFrom')
									->runSelect()
									->getResult();

		return $data;
	}

	public function getForm61a($report_id, $client_id) {
		$data = (array) $this->db->setTable('form61a')
								->setFields(array(
									'year',
									'report_month',
									'status',
									'submittedby',
									'submitteddate',
									'approvedby',
									'approveddate',
									'enteredby'
								))
								->setWhere("id = '$report_id' AND client_id = '$client_id'")
								->setLimit(1)
								->runSelect()
								->getRow();


		$data['direct'] = $this->db->setTable('form61a_details')
									->setFields(array(
										'report_day',
										'aircraft',
										'aircraft_num',
										'location',
										'treatment',
										'areaTreated',
										'qLiters',
										'revenue',
										'flyTimeHour',
										'flyTimeMin'
									))
									->setWhere("form61a_id = '$report_id'")
									->runSelect()
									->getResult();

		return $data;
	}

	public function getForm61b($report_id, $client_id) {
		$data = (array) $this->db->setTable('form61b')
								->setFields(array(
									'year',
									'report_month',
									'status',
									'submittedby',
									'submitteddate',
									'approvedby',
									'approveddate',
									'enteredby',
									'operation'
								))
								->setWhere("id = '$report_id' AND client_id = '$client_id'")
								->setLimit(1)
								->runSelect()
								->getRow();

		$data['direct'] = $this->db->setTable('form61b_details')
									->setFields(array(
										'report_day',
										'aircraft',
										'aircraft_num',
										'origin',
										'destination',
										'distance',
										'flown_hour',
										'flown_min',
										'passengers_num',
										'cargo_qty',
										'cargo_value',
										'revenue'
									))
									->setWhere("form61b_id = '$report_id'")
									->runSelect()
									->getResult();

		return $data;
	}

	public function getForm71a($report_id, $client_id) {
		$data = (array) $this->db->setTable('form71a')
							->setFields(array(
								'year',
								'report_month',
								'status',
								'submittedby',
								'submitteddate',
								'approvedby',
								'approveddate',
								'enteredby'
							))
							->setWhere("id = '$report_id' AND client_id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();


		$data['direct'] = $this->db->setTable('form71a_s1tf1')
									->setFields(array(
										'aircraft',
										'origin',
										'destination',
										'numMawbs',
										'weight',
										'fcharge',
										'commission'
									))
									->setWhere("form71a_id = '$report_id'")
									->setOrderBy('origin')
									->runSelect()
									->getResult();

		$data['consolidation'] = $this->db->setTable('form71a_s2tf2')
										->setFields(array(
											'aircraft',
											'destination',
											'numMawbs',
											'numHawbs1',
											'weight',
											'revenue',
											'fcharge',
										))
										->setWhere("form71a_id = '$report_id' AND aircraft != ''")
										->setOrderBy('destination')
										->runSelect()
										->getResult();


		$data['breakbulking'] = $this->db->setTable('form71a_s2tf2')
										->setFields(array(
											'origin',
											'numHawbs2',
											'orgWeight',
											'incomeBreak',
										))
										->setWhere("form71a_id = '$report_id' AND origin != ''")
										->runSelect()
										->getResult();

		return $data;
	}

	public function getForm71aSerial($report_id, $client_id) {
		$data = (array) $this->db->setTable('form71a')
							->setFields(array(
								'year',
								'report_month',
								'status',
								'submittedby',
								'submitteddate',
								'approvedby',
								'approveddate',
								'enteredby'
							))
							->setWhere("id = '$report_id' AND client_id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();


		$serial_result = $this->db->setTable('form71a_serial')
									->setFields('serialnum, excluded')
									->setWhere("form71a_id = '$report_id'")
									->setLimit(1)
									->runSelect()
									->getRow();

		if ( ! $serial_result) {
			$serial_result = (object) array(
				'serialnum'	=> '',
				'excluded'	=> ''
			);
		}

		$total_hawbs	= 0;
		$included_list	= array();
		$excluded_list	= array();

		$serialnum		= str_replace(array("\n", "\r\n"), ",", $serial_result->serialnum);
		$serialnum		= str_replace(array("\t", ' '), "", $serialnum);
		$serialnum		= explode(',', $serialnum);

		$excluded		= str_replace(array("\n", "\r\n"), ",", $serial_result->excluded);
		$excluded		= str_replace(array("\t", ' '), "", $excluded);
		$excluded		= explode(',', $excluded);

		foreach ($excluded as $exclude) {
			$temp_excluded = explode('-', $exclude);
			if (count($temp_excluded) == 1) {
				if ($temp_excluded[0] != '') {
					$excluded_list[] = $temp_excluded[0];
				}
			} else if (count($temp_excluded) > 1) {
				preg_match('/\d+$/', $temp_excluded[0], $value1);
				$value1 = ($value1) ? $value1[0] : '';
				$pre1 = str_replace($value1, '', $temp_excluded[0]);
				preg_match('/\d+$/', $temp_excluded[count($temp_excluded) - 1], $value2);
				$value2 = ($value2) ? $value2[0] : '';
				$pre2 = str_replace($value2, '', $temp_excluded[count($temp_excluded) - 1]);
				if (($pre1 == $pre2 && strlen($value1) == strlen($value2)) || ($pre1 == '' && $pre2 == '')) {
					for ($x = $value1; $x <= $value2; $x++) {
						$y = $x;
						while (strlen($y) < strlen($value1) && $pre1 != '') $y = "0" . $y;
						if ($pre1 . $y != '') {
							$excluded_list[] = $pre1 . $y;
						}
					}
				}
			}
		}

		foreach ($serialnum as $serial) {
			$temp_serial = explode('-', $serial);
			if (count($temp_serial) == 1) {
				if ($temp_serial[0] != '') {
					$included_list[] = $temp_serial[0];
				}
			} else if (count($temp_serial) > 1) {
				preg_match('/\d+$/', $temp_serial[0], $value1);
				$value1 = ($value1) ? $value1[0] : '';
				$pre1 = str_replace($value1, '', $temp_serial[0]);
				preg_match('/\d+$/', $temp_serial[count($temp_serial) - 1], $value2);
				$value2 = ($value2) ? $value2[0] : '';
				$pre2 = str_replace($value2, '', $temp_serial[count($temp_serial) - 1]);
				if (($pre1 == $pre2 && strlen($value1) == strlen($value2)) || ($pre1 == '' && $pre2 == '')) {
					for ($x = $value1; $x <= $value2; $x++) {
						$y = $x;
						while (strlen($y) < strlen($value1) && $pre1 != '') $y = "0" . $y;
						if ( ! in_array($pre1 . $y, $excluded_list) && $pre1 . $y != '') {
							$included_list[] = $pre1 . $y;
						}
					}
				}
			}
		}

		$data['serial'] = $included_list;

		return $data;
	}

	public function getForm71b($report_id, $client_id) {
		$data = (array) $this->db->setTable('form71b')
							->setFields(array(
								'year',
								'report_month',
								'status',
								'submittedby',
								'submitteddate',
								'approvedby',
								'approveddate',
								'enteredby'
							))
							->setWhere("id = '$report_id' AND client_id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();


		$data['direct'] = $this->db->setTable('form71b_s1tf1')
									->setFields(array(
										'aircraft',
										'origin',
										'destination',
										'numMawbs',
										'weight',
										'fcharge',
										'commission'
									))
									->setWhere("form71b_id = '$report_id'")
									->setOrderBy('origin, destination')
									->runSelect()
									->getResult();

		$data['consolidation'] = $this->db->setTable('form71b_s2tf2')
										->setFields(array(
											'aircraft',
											'destination',
											'numMawbs',
											'numHawbs1',
											'weight',
											'revenue',
											'fcharge',
										))
										->setWhere("form71b_id = '$report_id' AND aircraft != ''")
										->setOrderBy('destination')
										->runSelect()
										->getResult();


		$data['breakbulking'] = $this->db->setTable('form71b_s2tf2')
										->setFields(array(
											'origin',
											'numHawbs2',
											'orgWeight',
											'incomeBreak',
										))
										->setWhere("form71b_id = '$report_id' AND origin != ''")
										->setOrderBy('origin')
										->runSelect()
										->getResult();

		return $data;
	}

	public function getForm71bSerial($report_id, $client_id) {
		$data = (array) $this->db->setTable('form71b')
							->setFields(array(
								'year',
								'report_month',
								'status',
								'submittedby',
								'submitteddate',
								'approvedby',
								'approveddate',
								'enteredby'
							))
							->setWhere("id = '$report_id' AND client_id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		$serial_result = $this->db->setTable('form71b_serial')
									->setFields('serialnum, excluded')
									->setWhere("form71b_id = '$report_id'")
									->setLimit(1)
									->runSelect()
									->getRow();

		if ( ! $serial_result) {
			$serial_result = (object) array(
				'serialnum'	=> '',
				'excluded'	=> ''
			);
		}

		$total_hawbs	= 0;
		$included_list	= array();
		$excluded_list	= array();

		$serialnum		= str_replace(array("\n", "\r\n"), ",", $serial_result->serialnum);
		$serialnum		= str_replace(array("\t", ' '), "", $serialnum);
		$serialnum		= explode(',', $serialnum);

		$excluded		= str_replace(array("\n", "\r\n"), ",", $serial_result->excluded);
		$excluded		= str_replace(array("\t", ' '), "", $excluded);
		$excluded		= explode(',', $excluded);

		foreach ($excluded as $exclude) {
			$temp_excluded = explode('-', $exclude);
			if (count($temp_excluded) == 1) {
				if ($temp_excluded[0] != '') {
					$excluded_list[] = $temp_excluded[0];
				}
			} else if (count($temp_excluded) > 1) {
				preg_match('/\d+$/', $temp_excluded[0], $value1);
				$value1 = ($value1) ? $value1[0] : '';
				$pre1 = str_replace($value1, '', $temp_excluded[0]);
				preg_match('/\d+$/', $temp_excluded[count($temp_excluded) - 1], $value2);
				$value2 = ($value2) ? $value2[0] : '';
				$pre2 = str_replace($value2, '', $temp_excluded[count($temp_excluded) - 1]);
				if (($pre1 == $pre2 && strlen($value1) == strlen($value2)) || ($pre1 == '' && $pre2 == '')) {
					for ($x = $value1; $x <= $value2; $x++) {
						$y = $x;
						while (strlen($y) < strlen($value1) && $pre1 != '') $y = "0" . $y;
						if ($pre1 . $y != '') {
							$excluded_list[] = $pre1 . $y;
						}
					}
				}
			}
		}

		foreach ($serialnum as $serial) {
			$temp_serial = explode('-', $serial);
			if (count($temp_serial) == 1) {
				if ($temp_serial[0] != '') {
					$included_list[] = $temp_serial[0];
				}
			} else if (count($temp_serial) > 1) {
				preg_match('/\d+$/', $temp_serial[0], $value1);
				$value1 = ($value1) ? $value1[0] : '';
				$pre1 = str_replace($value1, '', $temp_serial[0]);
				preg_match('/\d+$/', $temp_serial[count($temp_serial) - 1], $value2);
				$value2 = ($value2) ? $value2[0] : '';
				$pre2 = str_replace($value2, '', $temp_serial[count($temp_serial) - 1]);
				if (($pre1 == $pre2 && strlen($value1) == strlen($value2)) || ($pre1 == '' && $pre2 == '')) {
					for ($x = $value1; $x <= $value2; $x++) {
						$y = $x;
						while (strlen($y) < strlen($value1) && $pre1 != '') $y = "0" . $y;
						if ( ! in_array($pre1 . $y, $excluded_list) && $pre1 . $y != '') {
							$included_list[] = $pre1 . $y;
						}
					}
				}
			}
		}

		$data['serial'] = $included_list;

		return $data;
	}

	public function getForm71c($report_id, $client_id) {
		$data = (array) $this->db->setTable('form71c')
							->setFields(array(
								'year',
								'report_month',
								'status',
								'submittedby',
								'submitteddate',
								'approvedby',
								'approveddate',
								'enteredby'
							))
							->setWhere("id = '$report_id' AND client_id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		$data['direct'] = $this->db->setTable('form71c_s1tf1')
									->setFields(array(
										'origin',
										'destination',
										'aircraft',
										'numMawbs',
										'weight',
										'fcharge',
										'commission'
									))
									->setWhere("form71c_id = '$report_id'")
									->setOrderBy('id')
									->runSelect()
									->getResult();

		return $data;
	}

	public function getFormT1a($report_id, $client_id) {
		$data = (array) $this->db->setTable('formt1a')
							->setFields(array(
								'year',
								'report_month',
								'status',
								'submittedby',
								'submitteddate',
								'approvedby',
								'approveddate',
								'enteredby'
							))
							->setWhere("id = '$report_id' AND client_id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();

		$data['direct'] = $this->db->setTable('formt1a_details')
									->setFields(array(
										'codeshared',
										'sector',
										'distance',
										'sk_offered',
										'seats_offered',
										'rev_pass',
										'nonrev_pass',
										'cargo',
										'sector_d',
										'distance_d',
										'sk_offered_d',
										'seats_offered_d',
										'rev_pass_d',
										'nonrev_pass_d',
										'cargo_d'
									))
									->setWhere("formt1a_id = '$report_id' AND codeshared = ''")
									->setOrderBy('sector, sector_d')
									->runSelect()
									->getResult();

		$data['direct_cs'] = $this->db->setTable('formt1a_details')
									->setFields(array(
										'codeshared',
										'sector',
										'distance',
										'sk_offered',
										'seats_offered',
										'rev_pass',
										'nonrev_pass',
										'cargo',
										'sector_d',
										'distance_d',
										'sk_offered_d',
										'seats_offered_d',
										'rev_pass_d',
										'nonrev_pass_d',
										'cargo_d'
									))
									->setWhere("formt1a_id = '$report_id' AND codeshared != ''")
									->setOrderBy('sector, sector_d')
									->runSelect()
									->getResult();

		return $data;
	}

}