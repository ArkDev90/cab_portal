<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->session			= new session();
	}

	public function listing() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('form_71b/form_71b_list', $data);
	}

	public function view() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('form_71b/report_viewer', $data);
	}

    public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

    private function ajax_list() {
		$table = '';   
			$table .= '<tr>';
			$table .= '<td style = "text-align:center">AF-094</td>';
            $table .= '<td>Natural Logistics, Inc.</td>';
            $table .= '<td style = "text-align:center">Cargo Sales Agency Report</td>';
            $table .= '<td style = "text-align:center">December</td>';
            $table .= '<td style = "text-align:center">2017</td>';
            $table .= '<td style = "text-align:center">2018-01-31</td>';
            $table .= '<td style = "text-align:center"><a href = "'.MODULE_URL.'view">View Report</a></td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_shipment_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center">AIR CARRIER</td>';
			$table .= '<td style = "text-align:center">ORIGIN</td>';
			$table .= '<td style = "text-align:center">COUNTRY OF DESTINATION</td>';
			$table .= '<td style = "text-align:center">NUMBER OF MAWBs USED</td>';
			$table .= '<td style = "text-align:center">CHARGEABLE WEIGHT (Kilograms)</td>';
			$table .= '<td style = "text-align:center">AIRLINE FREIGHT CHARGES(Peso)</td>';
			$table .= '<td style = "text-align:center">COMMISSION EARNED(Peso)</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_cargo_consolidation_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center" rowspan = "2">AIRLINE/AIRFREIGHT FORWARDER</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">COUNTRY OF DESTINATION</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">NUMBER OF AWB USED</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">CHARGEABLE WEIGHT (Kilograms)</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">AIRLINE FREIGHT CHARGES(Peso)</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">GROSS CONSOLIDATED REVENUE (Peso)</td>';
			$table .= '</tr>';

			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center" rowspan = "1">MAWB</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">HAWB</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_cargo_breakbulking_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center">COUNTRY OF ORIGIN</td>';
			$table .= '<td style = "text-align:center">TOTAL NO. OF HAWBs USED</td>';
			$table .= '<td style = "text-align:center">CHARGEABLE WEIGHT (Kilograms)</td>';
			$table .= '<td style = "text-align:center">INCOME FROM BREAKBULKING(Peso)</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

}