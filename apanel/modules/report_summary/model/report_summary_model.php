<?php
class report_summary_model extends wc_model {

	public function __construct() {
		parent::__construct();
		$this->log = new log();
	}

	public function getClientInfo($client_fields, $client_id) {
		$result = $this->db->setTable('client c')
							->leftJoin('country co ON co.id = c.country')
							->setFields($client_fields)
							->setWhere("c.id = '$client_id'")
							->setLimit(1)
							->runSelect()
							->getRow();
							
		return $result;
	}

	public function get51A($report_type, $quarter, $year, $timeline, $semester,$filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons){
		$sort = '';
		
			if ($filterby == 'ranking') {
				$sort = 'total DESC';
			}
			else {
				$sort = 'c.name ASC';
			}
			//papush lang
		
		$cond = '';
		if($timeline == 'Per Year'){
			$cond = "f.status='Approved' AND year = '$year'";
		}

		else if($timeline == 'Per Quarter'){
		$cond = "f.status='Approved' AND report_quarter = '$quarter' AND year = '$year'";
		}

		else if($timeline == "Per Semester"){
			if($semester == '1' ){
				$cond = "f.status='Approved' AND (report_quarter='1' OR report_quarter='2') AND year = '$year'";
			}
			else{
				$cond = "f.status='Approved' AND (report_quarter='3' OR report_quarter='4') AND year = '$year'";
			}
			
		}
		else if($timeline == "Consolidated"){
			$cond = "f.status='Approved' AND ((report_quarter >='$start_date_cons' AND year = '$start_year_cons') AND (report_quarter<='$end_date_cons' AND year = '$end_year_cons'))";
				// var_dump($cond);
		}
		
	
		$result = $this->db->setTable('form51a f')
		->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')
		->leftJoin('form51a_transit ft ON ft.form51a_id = f.id')
		->leftJoin('client c ON c.id = f.client_id')
		->leftJoin('country d ON d.id = c.country')
		->leftJoin('origin_destination e ON fd.destination_to = e.code')
		->setFields('c.name, e.title country, fd.destination_from, fd.destination_to, SUM(fd.quarter_month1 + fd.quarter_month2 + fd.quarter_month3) as incoming, SUM(fd.quarter_month1_d + fd.quarter_month2_d + fd.quarter_month3_d) as outgoing, SUM(fd.quarter_month1 + fd.quarter_month2 + fd.quarter_month3 + fd.quarter_month1_d + fd.quarter_month2_d + fd.quarter_month3_d) as total, SUM((fd.economy + fd.business + fd.first) * (fd.nflight_month1 + fd.nflight_month2 + fd.nflight_month3)) as seats1, SUM((fd.economy + fd.business + fd.first) * (fd.nflight_month1_d + fd.nflight_month2_d + fd.nflight_month3_d)) as seats2')
		->setWhere($cond)
		->setOrderBy($sort)
		->setGroupBy('c.name')
		->runSelect()
		->getResult();

		return $result;
	}

	public function get51BAC($report_type, $quarter, $year, $category, $a_rank_alpha, $c_rank_alpha, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (report_month = "1" OR report_month = "2" OR report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (report_month = "4" OR report_month = "5" OR report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (report_month = "7" OR report_month = "8" OR report_month = "9")';
			}
			else {
				$condition .= ' AND (report_month = "10" OR report_month = "11" OR report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (report_month >= "1" AND report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (report_month >= "1" AND report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (report_month >= "1" AND report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (report_month >= "4" AND report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (report_month >= "4" AND report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (report_month >= "7" AND report_month <= "12")';
			}
			else {
				$condition .= ' AND (report_month >= "10" AND report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$sort = '';
		if ($category == 'by Airline') {
			if ($a_rank_alpha == 'Ranking') {
				$sort = 'total DESC';
			}
			else {
				$sort = 'c.name ASC';
			}
			$group = 'c.name';
		}
		else if ($category == 'by Country') {
			if ($c_rank_alpha == 'Ranking') {
				$sort = 'total DESC';
			}
			else {
				$sort = 'co.country ASC';
			}
			$group = 'c.name, routeTo, routeFrom';
		}
		else {
			$group = '';
		}
		$result = $this->db->setTable('form51b f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('country co ON co.id = c.country')
							->leftJoin('form51b_direct fd ON fd.form51b_id = f.id')
							->leftJoin('origin_destination od ON od.code = fd.routeFrom')
							->setFields('od.title, co.country, c.name, fd.aircraft, routeTo, routeFrom, cargoRev, cargoRevDep, (cargoRev + cargoRevDep) as total')
							->setWhere("f.status='Approved' AND year = '$year'".$condition)
							->setGroupBy($group)
							->setOrderBy($sort)
							->runSelect()
							->getResult();
		return $result;
	}

	public function getTotal51BWeight() {
		$result = $this->db->setTable('form51b f')
							->leftJoin('form51b_direct fd ON fd.form51b_id = f.id')
							->setFields('SUM(cargoRev) as totalchargeableweight')
							->setWhere("status='Approved'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function get51AH($start_date, $end_date) {
		$condition = "AND (year >= '$start_date' AND year <= '$end_date')";
		$result = $this->db->setTable('form51a f')
							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields('fd.aircraft, SUM(fd.quarter_month1 + fd.quarter_month2 + fd.quarter_month3) as incoming, SUM(fd.quarter_month1_d + fd.quarter_month2_d + fd.quarter_month3_d) as outgoing, SUM(fd.quarter_month1 + fd.quarter_month2 + fd.quarter_month3 + fd.quarter_month1_d + fd.quarter_month2_d + fd.quarter_month3_d) as total, c.id, c.name')
							->setWhere("f.status='Approved'".$condition)
							->setGroupBy('c.name')
							->runSelect()
							->getResult();

		return $result;
	}

	public function get51AHTotal($a, $id) {
		$result = $this->db->setTable('form51a f')
							->leftJoin('form51a_direct fd ON fd.form51a_id = f.id')
							->setFields('fd.aircraft, SUM(fd.quarter_month1 + fd.quarter_month2 + fd.quarter_month3 + fd.quarter_month1_d + fd.quarter_month2_d + fd.quarter_month3_d) as total')
							->setWhere("f.status='Approved' AND year = '$a' AND f.client_id = '$id'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function get51BH($start_year, $end_year) {
		$condition = "AND (year >= '$start_year' AND year <= '$end_year')";
		$result = $this->db->setTable('form51b f')
							->leftJoin('form51b_direct fd ON fd.form51b_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields('fd.aircraft, (sum(cargoRev) + sum(cargoRevDep)) as total, c.id, c.name')
							->setWhere("f.status='Approved'".$condition)
							->setGroupBy('c.name')
							->runSelect()
							->getResult();

		return $result;
	}

	public function get51BHTotal($a, $id) {
		$result = $this->db->setTable('form51b f')
							->leftJoin('form51b_direct fd ON fd.form51b_id = f.id')
							->setFields('(sum(cargoRev) + sum(cargoRevDep)) as total')
							->setWhere("f.status='Approved' AND year = '$a' AND f.client_id = '$id'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function getAirlines() {
		$result = $this->db->setTable('client c')
							->leftJoin("client_nature cn ON cn.client_id = c.id")
							->leftJoin("nature_report_form nrf ON nrf.nature_id = cn.nature_id")
							->setFields("c.id ind, c.name val")
							->setOrderBy('c.name')
							->setWhere("c.status != 'Terminated' AND nrf.report_form_id = '17'")
							->runSelect()
							->getResult();
		return $result;
	}

	public function get61aAirlines() {
		$result = $this->db->setTable('form61a f')
							->leftJoin('form61a_details fd ON f.client_id = fd.form61a_id')
							->leftJoin('client c ON f.client_id = c.id')
							->setFields("c.id ind, name val")
							->setOrderBy('name')
							->setGroupBy('name')
							->runSelect()
							->getResult();
		return $result;
	}

	public function get61ASummary($report_type, $quarter, $year, $start_date, $end_date, $rank_alpha) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$sort = '';
		if ($rank_alpha == 'Ranking') {
			$sort = 'areaTreated desc, qLiters desc';
		}
		else {
			$sort = 'c.name ASC';
		}
		$result = $this->db->setTable('form61a f')
							->leftJoin('form61a_details fd ON fd.form61a_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields("c. name aircraft, SUM(areaTreated) as areaTreated, SUM(qLiters) as qLiters, SUM(distance) as distance,
							GROUP_CONCAT(DISTINCT location ORDER BY location ASC SEPARATOR ', ') as location, SUM(flyTimeHour) as hours, SUM(flyTimeMin) as minutes, SUM(revenue) as revenue")
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setOrderBy($sort)
							->setGroupBy('c.name')
							->runSelect()
							->getResult();

		return $result;
	}

	public function get61aSummaryPerOperator($report_type, $quarter, $year, $start_date, $end_date, $airline, $month) {
		$result = $this->db->setTable('form61a f')
							->leftJoin('form61a_details fd ON fd.form61a_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('aircraft_type a ON a.id = fd.aircraft')
							->setFields("GROUP_CONCAT(DISTINCT aircraft ORDER BY aircraft ASC SEPARATOR ', ') as aircraft, GROUP_CONCAT(DISTINCT aircraft_num ORDER BY aircraft_num ASC SEPARATOR ', ') as aircraft_num, SUM(areaTreated) as areaTreated, SUM(qLiters) as qLiters, 
										GROUP_CONCAT(DISTINCT location ORDER BY location ASC SEPARATOR ', ') as location, SUM(flyTimeHour) as hours, SUM(flyTimeMin) as minutes, SUM(revenue) as revenue")
							->setWhere("f.status='Approved' AND f.year = '$year' AND f.report_month = '$month' AND f.client_id = '$airline'")
							->setGroupBy('f.report_month')
							->runSelect()
							->getRow();
		return $result;
	}

	public function get61BSummary($report_type, $quarter, $year, $start_date, $end_date, $rank_alpha, $passenger_cargo) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$sort = '';
		if ($rank_alpha == 'Ranking') {
			if ($passenger_cargo == 'Passenger') {
				$sort = 'passengers_num DESC';
			}
			else {
				$sort = 'cargo_qty DESC';
			}
		}
		else {
			$sort = 'name ASC';
		}
		$result = $this->db->setTable('form61b f')
							->leftJoin('form61b_details fd ON fd.form61b_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields('name, sum(cargo_qty) as cargo_qty, sum(passengers_num) as passengers_num, origin, destination,
										sum(distance) as distance, sum(flown_hour) as hours, sum(flown_min) as minutes, sum(revenue) as revenue')
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setOrderBy($sort)
							->setGroupBy('name')
							->runSelect()
							->getResult();

		return $result;
	}

	public function get61bSummaryPerOperator($report_type, $quarter, $year, $start_date, $end_date, $airline) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		
		$result = $this->db->setTable('form61b f')
							->leftJoin('form61b_details fd ON fd.form61b_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields('name, aircraft, aircraft_num, cargo_qty, passengers_num, origin, destination,
										distance, flown_hour, flown_min, revenue')
							->setWhere("f.status='Approved' AND f.year = '$year' AND f.client_id = '$airline'".$condition)
							->setGroupBy('f.report_month')
							->runSelect()
							->getResult();
		return $result;
	}

	public function get71BRanked($report_type, $quarter, $year, $start_date, $end_date, $rank_category, $rank) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$group = '';
		$lmit = '';
		$sort = '';
		if ($rank == 'By Country') {
			$group = 'f1.origin';
			$limit = '';
			$sort = '';
		}
		else if ($rank == 'Top 30') {
			$group = 'c.name';
			$limit = '30';
			if ($rank_category == 'Direct Shipment') {
				$sort = 'f1.weight DESC';
			}
			else if ($rank_category == 'Consolidation') {
				$sort = 'f2.weight DESC';
			}
			else if ($rank_category == 'Breakbulking') {
				$sort = 'f2.orgWeight DESC';
			}
			else {
				$sort = 'weight DESC';
			}
		}
		else {
			$limit = '';
			$group = 'c.name';
			if ($rank_category == 'Direct Shipment') {
				$sort = 'f1.weight DESC';
			}
			else if ($rank_category == 'Consolidation') {
				$sort = 'f2.weight DESC';
			}
			else if ($rank_category == 'Breakbulking') {
				$sort = 'f2.orgWeight DESC';
			}
			else {
				$sort = 'weight DESC';
			}
		}
		if ($rank_category == 'Direct Shipment') {
			$fields = 'f1.weight weight, c.name';
		}
		else if ($rank_category == 'Consolidation') {
			$fields = 'f2.weight weight, c.name';
		}
		else if ($rank_category == 'Breakbulking') {
			$fields = 'f2.orgWeight weight, c.name';
		}
		else {
			$fields = '(f1.weight + f2.weight + f2.orgWeight) as weight, c.name';
		}
		$result = $this->db->setTable('form71b f')
							->leftJoin('form71b_s1tf1 f1 ON f1.form71b_id = f.id')
							->leftJoin('form71b_s2tf2 f2 ON f2.form71b_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields($fields) 	 	
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setGroupBy($group)
							->setOrderBy($sort)
							->setLimit($limit)
							->runSelect()
							->getResult();
		return $result;
	}

	public function getTotal71BWeight($rank_category) {
		if ($rank_category == 'Direct Shipment') {
			$fields = 'SUM(f1.weight) weight, f.id';
		}
		else if ($rank_category == 'Consolidation') {
			$fields = 'SUM(f2.weight) weight, f.id';
		}
		else if ($rank_category == 'Breakbulking') {
			$fields = 'SUM(f2.orgWeight) weight, f.id';
		}
		$result = $this->db->setTable('form71b f')
							->leftJoin('form71b_s1tf1 f1 ON f1.form71b_id = f.id')
							->leftJoin('form71b_s2tf2 f2 ON f2.form71b_id = f.id')
							->setFields($fields) 	 	
							->setWhere("f.status='Approved'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function get71bSummary($report_type, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$fields = 'c.name, f1.numMawbs numMawbs1, f1.weight weight1, f1.fcharge fcharge1, f1.commission, f2.numMawbs numMawbs2, f2.numHawbs1, f2.weight weight2, f2.fcharge fcharge2, f2.revenue, f2.numHawbs2, f2.orgWeight, f2.incomeBreak';
		$result = $this->db->setTable('form71b f')
							->leftJoin('form71b_s1tf1 f1 ON f1.form71b_id = f.id')
							->leftJoin('form71b_s2tf2 f2 ON f2.form71b_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields($fields) 	 	
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setGroupBy('c.id')
							->setOrderBy('c.id')
							->runSelect()
							->getResult();
		return $result;
	}

	public function getT1ATotalCargoSeatPass($report_type, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('SUM(rev_pass + rev_pass_d) as totalpassenger, SUM(seats_offered + seats_offered_d) as totalseats, SUM(cargo + cargo_d) as totalcargo') 	 	
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->runSelect()
							->getRow();
		return $result;
	}

	public function getT1AbyAirline($report_type, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('c.name, (rev_pass + rev_pass_d) as passenger, (seats_offered + seats_offered_d) as seats, (cargo + cargo_d) as cargo') 	 	
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setGroupBy('c.name')
							->setOrderBy('c.id')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getT1AH($start_year, $end_year) {
		$condition = "AND (year >= '$start_year' AND year <= '$end_year')";
		$result = $this->db->setTable('formt1a f')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields('c.name, c.id')
							->setWhere("f.status='Approved'".$condition)
							->setGroupBy('c.name')
							->runSelect()
							->getResult();
		return $result;
	}

	public function getT1AHTotal($a, $id) {
		$result = $this->db->setTable('formt1a f')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('(sum(rev_pass) + sum(rev_pass_d)) as passenger, (sum(seats_offered) + sum(seats_offered_d)) as seats, (sum(cargo) + sum(cargo_d)) as cargo')
							->setWhere("f.status = 'Approved' AND f.client_id = '$id' AND year = '$a'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function getT1AHistTotalCargoSeatPass($a) {
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('year, SUM(rev_pass + rev_pass_d) as totalpassenger, SUM(seats_offered + seats_offered_d) as totalseats, SUM(cargo + cargo_d) as totalcargo') 	 	
							->setWhere("f.status='Approved' AND f.year = '$a'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function getSector($report_type, $quarter, $year, $start_date, $end_date, $airline) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('fd.sector, fd.sector_d') 	 	
							->setWhere("f.status='Approved' AND f.year = '$year' AND f.client_id = '$airline'".$condition)
							->setGroupBy('sector, sector_d')
							->setOrderBy('c.id')
							->runSelect()
							->getResult();
							
		return $result;
	}

	public function getAirline($airline) {
		$result = $this->db->setTable('client')
							->setFields('name')
							->setWhere("id = '$airline'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function getT1AperAirline($report_type, $year, $month, $airline, $sector, $sector_d) {
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('c.name, (rev_pass + rev_pass_d) as passenger, (seats_offered + seats_offered_d) as seats, (cargo + cargo_d) as cargo') 	 	
							->setWhere("f.status='Approved' AND c.id = '$airline' AND f.year = '$year' AND report_month = '$month' AND sector = '$sector' AND sector_d = '$sector_d'")
							->setGroupBy('sector, sector_d')
							->runSelect()
							->getRow();
		return $result;
	}

	public function getT1ATotalperAirline($report_type, $year, $month, $airline) {
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('c.name, SUM(rev_pass + rev_pass_d) as passenger, SUM(seats_offered + seats_offered_d) as seats, SUM(cargo + cargo_d) as cargo') 	 	
							->setWhere("f.status='Approved' AND c.id = '$airline' AND f.year = '$year' AND report_month = '$month'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function getAirlinesList() {
		$result = $this->db->setTable('client')
							->setFields('id, name')
							->setOrderBy('id')
							->runSelect()
							->getResult();
		return $result;
	}

	public function getSectorList($report_type, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('fd.sector, fd.sector_d') 	 	
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setGroupBy('sector, sector_d')
							->setOrderBy('c.id')
							->runSelect()
							->getResult();
		return $result;
	}

	public function getT1AbySector($report_type, $quarter, $year, $start_date, $end_date, $id, $sector, $sector_d) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$result = $this->db->setTable('formt1a f')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('formt1a_details fd ON fd.formt1a_id = f.id')
							->setFields('(rev_pass + rev_pass_d) as passenger, (seats_offered + seats_offered_d) as seats, (cargo + cargo_d) as cargo') 	 	
							->setWhere("f.status='Approved' AND c.id = '$id' AND f.year = '$year' AND sector = '$sector' AND sector_d = '$sector_d'".$condition)
							->setGroupBy('sector, sector_d')
							->runSelect()
							->getRow();
		return $result;
	}

	public function get71ARanked($report_type, $quarter, $year, $start_date, $end_date, $rank_category, $rank) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$group = '';
		$lmit = '';
		$sort = '';
		if ($rank == 'By Country') {
			$group = 'f1.origin';
			$limit = '';
			$sort = '';
		}
		else if ($rank == 'Top 30') {
			$group = 'c.name';
			$limit = '30';
			if ($rank_category == 'Direct Shipment') {
				$sort = 'f1.weight DESC';
			}
			else if ($rank_category == 'Consolidation') {
				$sort = 'f2.weight DESC';
			}
			else if ($rank_category == 'Breakbulking') {
				$sort = 'f2.orgWeight DESC';
			}
			else {
				$sort = 'weight DESC';
			}
		}
		else {
			$limit = '';
			$group = 'c.name';
			if ($rank_category == 'Direct Shipment') {
				$sort = 'f1.weight DESC';
			}
			else if ($rank_category == 'Consolidation') {
				$sort = 'f2.weight DESC';
			}
			else if ($rank_category == 'Breakbulking') {
				$sort = 'f2.orgWeight DESC';
			}
			else {
				$sort = 'weight DESC';
			}
		}
		if ($rank_category == 'Direct Shipment') {
			$fields = 'f1.weight weight, c.name';
		}
		else if ($rank_category == 'Consolidation') {
			$fields = 'f2.weight weight, c.name';
		}
		else if ($rank_category == 'Breakbulking') {
			$fields = 'f2.orgWeight weight, c.name';
		}
		else {
			$fields = '(f1.weight + f2.weight + f2.orgWeight) as weight, c.name';
		}
		$result = $this->db->setTable('form71a f')
							->leftJoin('form71a_s1tf1 f1 ON f1.form71a_id = f.id')
							->leftJoin('form71a_s2tf2 f2 ON f2.form71a_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields($fields) 	 	
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setGroupBy($group)
							->setOrderBy($sort)
							->setLimit($limit)
							->runSelect()
							->getResult();
		return $result;
	}

	public function getTotal71AWeight($rank_category) {
		if ($rank_category == 'Direct Shipment') {
			$fields = 'SUM(f1.weight) weight, f.id';
		}
		else if ($rank_category == 'Consolidation') {
			$fields = 'SUM(f2.weight) weight, f.id';
		}
		else if ($rank_category == 'Breakbulking') {
			$fields = 'SUM(f2.orgWeight) weight, f.id';
		}
		$result = $this->db->setTable('form71a f')
							->leftJoin('form71a_s1tf1 f1 ON f1.form71a_id = f.id')
							->leftJoin('form71a_s2tf2 f2 ON f2.form71a_id = f.id')
							->setFields($fields) 	 	
							->setWhere("f.status='Approved'")
							->runSelect()
							->getRow();
		return $result;
	}

	public function get71aSummary($report_type, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}
		$fields = 'c.name, f1.numMawbs numMawbs1, f1.weight weight1, f1.fcharge fcharge1, f1.commission, f2.numMawbs numMawbs2, f2.numHawbs1, f2.weight weight2, f2.fcharge fcharge2, f2.revenue, f2.numHawbs2, f2.orgWeight, f2.incomeBreak';
		$result = $this->db->setTable('form71a f')
							->leftJoin('form71a_s1tf1 f1 ON f1.form71a_id = f.id')
							->leftJoin('form71a_s2tf2 f2 ON f2.form71a_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->setFields($fields) 	 	
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setGroupBy('c.id')
							->setOrderBy('c.id')
							->runSelect()
							->getResult();
		return $result;
	}

	public function get71cSummary($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}

		$sort = '';
		if ($category == 'summaryreport') {
			if ($filterBy == 'Ranking') {
				$sort = 'weight ASC';
			}
			else {
				$sort = 'c.name ASC';
			}
		}
	
		$result = $this->db->setTable('form71c f')
							->leftJoin('form71c_s1tf1 fd ON fd.form71c_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('country d ON d.id = c.country')
							->setFields('c.name, d.country, SUM(weight)* 2 as weight')
							->setWhere("f.status='Approved' AND f.year = '$year'".$condition)
							->setOrderBy($sort)
							->setGroupBy('c.name')
							->runSelect()
							->getResult();
		return $result;
	}

	public function get71cSummaryDomestic($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}

		$sort = '';
		if ($category == 'summaryreport') {
			if ($filterBy == 'Ranking') {
				$sort = 'weight DESC';
			}
			else {
				$sort = 'c.name ASC';
			}
		}
	
		$result = $this->db->setTable('form71c f')
							->leftJoin('form71c_s1tf1 fd ON fd.form71c_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('origin_destination d ON d.title = fd.destination')
							->leftJoin('earth_part e ON d.part = e.id')
							->setFields('c.name, d.title, e.title part, SUM(weight) as weight, d.type')
							->setWhere("f.status='Approved' AND f.year = '$year' AND d.type = 'Domestic'".$condition)
							->setOrderBy($sort)
							->setGroupBy('d.title')
							->runSelect()
							->getResult();
							// echo $this->db->getQuery();
		return $result;
	}

	public function get71cSummaryInternational($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}

		$sort = '';
		if ($category == 'summaryreport') {
			if ($filterBy == 'Ranking') {
				$sort = 'weight DESC';
			}
			else {
				$sort = 'c.name ASC';
			}
		}
	
		$result = $this->db->setTable('form71c f')
							->leftJoin('form71c_s1tf1 fd ON fd.form71c_id = f.id')
							->leftJoin('client c ON c.id = f.client_id')
							->leftJoin('origin_destination d ON d.title = fd.destination')
							->leftJoin('earth_part e ON d.part = e.id')
							->setFields('c.name, d.title, e.title part, SUM(weight) as weight, d.type')
							->setWhere("f.status='Approved' AND f.year = '$year' AND d.type = 'International'".$condition)
							->setOrderBy($sort)
							->setGroupBy('part')
							->runSelect()
							->getResult();
		return $result;
	}

	public function getT1ASector($report_type, $quarter, $year, $start_date, $end_date) {
		$condition = '';
		if ($report_type == 'Quarterly') {
			if ($quarter == "1st Quarter") {
				$condition .= ' AND (f.report_month = "1" OR f.report_month = "2" OR f.report_month = "3")';
			}
			else if ($quarter == "2nd Quarter") {
				$condition .= ' AND (f.report_month = "4" OR f.report_month = "5" OR f.report_month = "6")';
			}
			else if ($quarter == "3rd Quarter") {
				$condition .= ' AND (f.report_month = "7" OR f.report_month = "8" OR f.report_month = "9")';
			}
			else {
				$condition .= ' AND (f.report_month = "10" OR f.report_month = "11" OR f.report_month = "12")';
			}
		}
		else if ($report_type == 'Consolidated') {
			if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "6")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "9")';
			}
			else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "1" AND f.report_month <= "12")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "9")';
			}
			else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "4" AND f.report_month <= "12")';
			}
			else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
				$condition .= ' AND (f.report_month >= "7" AND f.report_month <= "12")';
			}
			else {
				$condition .= ' AND (f.report_month >= "10" AND f.report_month <= "12")';
			}
		}
		else {
			$condition = '';
		}

		$result = $this->db->setTable('formt1a_details fd')
							->innerJoin('formt1a f ON f.id = fd.formt1a_id AND fd.companycode = f.companycode')
							->innerJoin('client c ON c.id = f.client_id AND c.companycode = f.companycode')
							->setFields('c.name, c.id')
							->setWhere("f.status = 'Approved' AND sector != 'NO OPERATION'")
							->setGroupBy('c.id')
							->runSelect()
							->getResult();

		$fields = array("CONCAT(sector, ' - ', sector_d) sector");

		foreach ($result as $client) {
			$fields[] = "IF(f.client_id = '{$client->id}', rev_pass + rev_pass_d, 0) '{$client->name}|P'";
			$fields[] = "IF(f.client_id = '{$client->id}', seats_offered + seats_offered_d, 0) '{$client->name}|S'";
			$fields[] = "IF(f.client_id = '{$client->id}', cargo + cargo_d, 0) '{$client->name}|C'";
		}

		$result = $this->db->setTable('formt1a_details fd')
							->innerJoin('formt1a f ON f.id = fd.formt1a_id AND fd.companycode = f.companycode')
							->innerJoin('client c ON c.id = f.client_id AND c.companycode = f.companycode')
							->setFields($fields)
							->setWhere("f.status = 'Approved' AND sector != 'NO OPERATION' AND f.year = '$year'".$condition)
							->setGroupBy('sector, sector_d')
							->runSelect()
							->getResult();

		return $result;
	}

	public function getHAWBS($airline, $filter, $from_month, $from_year, $to_month, $to_year) {
		if($filter == '1'){
			$table = 'form71a';
			$left  = "form71a_s2tf2 a ON a.form71a_id = m.id";
		}else{
			$table = 'form71b';
			$left  = "form71b_s2tf2 a ON a.form71b_id = m.id";
		}

		$result = $this->db->setTable($table.' m')
							->setFields("report_month, year, numHawbs1, numHawbs2")
							->leftJoin($left)
							// ->setWhere("m.client_id = '$airline' AND CONCAT(year, '-', RIGHT(CONCAT('0', report_month), 2), '-00') >= CONCAT('$from_year', '-', '$from_month', '-00') AND CONCAT(year, '-', report_month, '-00') <= CONCAT('$to_year', '-', '$to_month', '-00')")
							->setWhere("m.client_id = '$airline' AND (CONCAT(year, '-', RIGHT(CONCAT('0', report_month), 2), '-00') BETWEEN CONCAT('$from_year', '-', '$from_month', '-00') AND CONCAT('$to_year', '-', '$to_month', '-00'))")
							->setOrderBy("CONCAT(year, '-', RIGHT(CONCAT('0', report_month), 2), '-00')")
							->runSelect()
							->getResult();
							// echo $this->db->getQuery();
		return $result;

		
	}

}