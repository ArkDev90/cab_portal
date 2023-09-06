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
		$this->view->load('form_71c/form_71c_list', $data);
	}

	public function view() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('form_71c/report_viewer', $data);
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

	private function ajax_direct_shipment_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center">AIR CARRIER</td>';
			$table .= '<td style = "text-align:center">NUMBER OF MAWBs USED</td>';
			$table .= '<td style = "text-align:center">CHARGEABLE WEIGHT</td>';
			$table .= '<td style = "text-align:center">FREIGHT CHARGES (Peso)/td>';
			$table .= '<td style = "text-align:center">COMMISSION EARNED (Peso)</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_flow_shipment_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center" class = "col-md-3">ORIGIN</td>';
			$table .= '<td style = "text-align:center" class = "col-md-3">DESTINATION</td>';
			$table .= '<td style = "text-align:center" class = "col-md-6">CHARGEABLE WEIGHT (Kilograms)</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

}