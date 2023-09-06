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
		$this->view->load('form_t1a/form_t1a_list', $data);
	}

	public function view() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('form_t1a/report_viewer', $data);
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

	private function ajax_first_list() {
		$table = '';   
			$table .= '<tr>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '<td style = "text-align:center"></td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

	private function ajax_codeshared_list() {
		$table = '';   
			$table .= '<tr style = "background-color:#d9edf7; color:#003366; font-weight:bold">';
			$table .= '<td style = "text-align:center">Marketing Airline</td>';
			$table .= '<td style = "text-align:center">Sector</td>';
			$table .= '<td style = "text-align:center">Distance [Kilometers]</td>';
			$table .= '<td style = "text-align:center">Available Seat-KMS Offered</td>';
			$table .= '<td style = "text-align:center">Available Seats</td>';
			$table .= '<td style = "text-align:center">Revenue Passengers</td>';
			$table .= '<td style = "text-align:center">Non-Revenue Passengers</td>';
			$table .= '<td style = "text-align:center">Passenger Load Factor</td>';
			$table .= '<td style = "text-align:center">Cargo [Kilograms]</td>';
			$table .= '</tr>';
		return array('table' => $table);
	}

}