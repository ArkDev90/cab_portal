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
		$this->view->load('form_51b/form_51b_list', $data);
	}

	public function view() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('form_51b/report_viewer', $data);
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

	private function ajax_direct_cargo_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center" rowspan = "2">Aircraft</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
			$table .= '</tr>';

			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_transit_cargo_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center" rowspan = "2">Aircraft</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
			$table .= '<td style = "text-align:center" rowspan = "2">Route</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">CARGO</td>';
			$table .= '<td style = "text-align:center" colspan = "2" rowspan = "1">MAIL</td>';
			$table .= '</tr>';

			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">REVENUE</td>';
			$table .= '<td style = "text-align:center" rowspan = "1">NON REVENUE</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

}