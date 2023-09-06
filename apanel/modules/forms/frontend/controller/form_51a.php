<?php
class controller extends wc_controller {
	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->forms_model		= new forms_model();
		$this->session			= new session();
		$this->fields 			= array(
			'id',
			'client_id',
			'report_quarter',
			'year',
			'status'
		);
		$this->fields1 			= array(
			'id',
			'form51a_id',
			'aircraft',
			'destination_from',
			'destination_to',
			'first',
			'business',
			'economy',
			'extra',
			'quarter_month1',
			'quarter_month2',
			'quarter_month3',
			'quarter_month1_d',
			'quarter_month2_d',
			'quarter_month3_d',
			'nflight_month1',
			'nflight_month2',
			'nflight_month3',
			'nflight_month1_d',
			'nflight_month2_d',
			'nflight_month3_d',
			'foctraffic_month1',
			'foctraffic_month2',
			'foctraffic_month3',
			'foctraffic_month1_d',
			'foctraffic_month2_d',
			'foctraffic_month3_d',
			'codeshared',
			'cs_ptraffic1',
			'cs_ptraffic2',
			'cs_ptraffic3',
			'cs_ptraffic1_d',
			'cs_ptraffic2_d',
			'cs_ptraffic3_d',
			'cs_nflight1',
			'cs_nflight2',
			'cs_nflight3',
			'cs_nflight1_d',
			'cs_nflight2_d',
			'cs_nflight3_d'


		);
		$this->data = array();
		
	}

	public function listing() {
		$this->view->title = 'Form51a';
		$this->view->title 		= 'Create Form51a';
		$data['ajax_task']		= 'ajax_create';
		$data['ajax_post']		= '';
		$data['ui'] = $this->ui;
		$this->view->load('form_51a', $data);
	}

	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	public function create() {
		$data['domestic_list']  = $this->forms_model->getDomesticList('');
		$data['international_list'] = $this->forms_model->getInternationalList('');
		$session = new session();
		$login = $session->get('login');
		$client_id = $login['client_id'];
		$this->view->title = 'Create Form51a';
		$data['ajax_task']		= 'ajax_add';
		$data['ajax_post']		= '';
		$data['ui'] = $this->ui;
		$this->view->load('form_51_a_create', $data);
	}

	public function draft() {
		$this->view->title = 'Form51a Draft';
		$data['ui'] = $this->ui;
		$this->view->load('form_51_a_draft', $data);
	}

	public function ajax_list()
	{
		$pagination = $this->forms_model->getForm51a($this->fields);
	
		$table = '';
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			if($row->report_quarter == 'quarter_1')
			{
				$rq = '1st Quarter';
			
			$table .= '<tr>';
			$table .= '<td align="center">'. $row->id .'</td>';
			$table .= '<td align="center">'. $rq .'</td>';
			$table .= '<td align="center">'. $row->year .'</td>';
			$table .= '<td align="center">'. date("M j, Y",strtotime($row->entereddate)) .'</td>';
			$table .= '<td align="center">'. $row->enteredby .'</td>';
			$table .= '<td align="center">'. $row->status .'</td>';
			
			$table .= '</tr>';
			}
			else if($row->report_quarter == 'quarter_2')
			{
				$rq = '2nd Quarter';
			
			$table .= '<tr>';
			$table .= '<td align="center">'. $row->id .'</td>';
			$table .= '<td align="center">'. $rq .'</td>';
			$table .= '<td align="center">'. $row->year .'</td>';
			$table .= '<td align="center">'. date("M j, Y",strtotime($row->entereddate)) .'</td>';
			$table .= '<td align="center">'. $row->enteredby .'</td>';
			$table .= '<td align="center">'. $row->status .'</td>';
			
			$table .= '</tr>';
			}
			else if($row->report_quarter == 'quarter_3')
			{
				$rq = '3rd Quarter';
			
			$table .= '<tr>';
			$table .= '<td align="center">'. $row->id .'</td>';
			$table .= '<td align="center">'. $rq .'</td>';
			$table .= '<td align="center">'. $row->year .'</td>';
			$table .= '<td align="center">'. date("M j, Y",strtotime($row->entereddate)) .'</td>';
			$table .= '<td align="center">'. $row->enteredby .'</td>';
			$table .= '<td align="center">'. $row->status .'</td>';
			
			$table .= '</tr>';
			}
			else
			{
				$rq = '4th Quarter';
			
			$table .= '<tr>';
			$table .= '<td align="center">'. $row->id .'</td>';
			$table .= '<td align="center">'. $rq .'</td>';
			$table .= '<td align="center">'. $row->year .'</td>';
			$table .= '<td align="center">'. date("M j, Y",strtotime($row->entereddate)) .'</td>';
			$table .= '<td align="center">'. $row->enteredby .'</td>';
			$table .= '<td align="center">'. $row->status .'</td>';
			
			$table .= '</tr>';
			}
		}
		
		

		$pagination->table = $table;
		return $pagination;
	}
	public function ajax_draft_list()
	{
		$pagination = $this->forms_model->getForm51a($this->fields);
	
		$table = '';
		if (empty($pagination->result)) {
			$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
		}
		foreach ($pagination->result as $key => $row) {
			if($row->report_quarter == 'quarter_1')
			{
				$rq = '1st Quarter(Jan,Feb,Mar)';
			
			$table .= '<tr>';
			$table .= '<td class="col-md-3">'. $rq .' '.$row->year .'</td>';
			$table .= '<td class="col-md-4">'. '<a href="'.MODULE_URL.$row->id.'">SUBMIT</a> | <a href="'.MODULE_URL.'edit/'.$row->id.'">EDIT</a> | <a href="'.MODULE_URL.$row->id.'">DELETE</a>' .'</td>';
			
			$table .= '</tr>';
			}
			else if($row->report_quarter == 'quarter_2')
			{
				$rq = '2nd Quarter(Apr,May,Jun)';
				
				$table .= '<tr>';
				$table .= '<td class="col-md-3">'. $rq .' '.$row->year .'</td>';
				$table .= '<td class="col-md-4">'. '<a href="'.MODULE_URL.$row->id.'">SUBMIT</a> | <a href="'.MODULE_URL.'edit/'.$row->id.'">EDIT</a> | <a href="'.MODULE_URL.$row->id.'">DELETE</a>' .'</td>';
				$table .= '</tr>';
			}
			else if($row->report_quarter == 'quarter_2')
			{
				$rq = '3rd Quarter(Jul,Aug,Sep)';
				
				$table .= '<tr>';
				$table .= '<td class="col-md-3">'. $rq .' '.$row->year .'</td>';
				$table .= '<td class="col-md-4">'. '<a href="'.MODULE_URL.$row->id.'">SUBMIT</a> | <a href="'.MODULE_URL.'edit/'.$row->id.'">EDIT</a> | <a href="'.MODULE_URL.$row->id.'">DELETE</a>' .'</td>';
				$table .= '</tr>';
			}
			else{
				$rq = '4th Quarter(Oct,Nov,Dec)';
				
				$table .= '<tr>';
				$table .= '<td class="col-md-3">'. $rq .' '.$row->year .'</td>';
				$table .= '<td class="col-md-4">'. '<a href="'.MODULE_URL.$row->id.'">SUBMIT</a> | <a href="'.MODULE_URL.'edit/'.$row->id.'">EDIT</a> | <a href="'.MODULE_URL.$row->id.'">DELETE</a>' .'</td>';
				$table .= '</tr>';
			}
		}
	

		$pagination->table = $table;
		return $pagination;
	}

	public function ajax_create(){
		$session 				= new session();
		$login 					= $session->get('login');
		$client_id 				= $login['client_id'];
		$data = $this->input->post($this->fields);
		$data['client_id'] = $client_id;
		$result = $this->forms_model->AddForm51a($data,$client_id);
		return array(
			'redirect'	=> MODULE_URL.'create/',
			'success'	=> $result
		);
	}

	public function ajax_add(){
		$data = $this->input->post($this->fields1);
		// var_dump($_POST);
		// exit();
		$result = $this->forms_model->AddEntries($data);
		return array(
			'redirect'	=> MODULE_URL.'create',
			'success'	=> $result
		);
	}

	private function ajax_table1_list() {
		$pagination = $this->forms_model->getForm51a_direct($this->fields1);
		
			$table = '';
			if (empty($pagination->result)) {
				$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
			}
			foreach ($pagination->result as $key => $row) {
				$seats = $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3 + $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d +
						 $row->nflight_month1 + $row->nflight_month2 + $row->nflight_month3 + $row->nflight_month1_d + $row->nflight_month2_d + $row->nflight_month3_d +
						 $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				$quartersubtotal 	= $row->quarter_month1 + $row->quarter_month2 + $row->quarter_month3;
				$quartersubtotal_d  = $row->quarter_month1_d + $row->quarter_month2_d + $row->quarter_month3_d;
				$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
				$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				$table .= '<tr class="table_subtitle" style="font-size: 9px;" height="18px">
				<td width="2%" rowspan="2" class="table_line1_left"><input onclick="checkAllFields(1);" id="checkAll" type="checkbox"></td>
				<td rowspan="2" width="8%" align="center" class="table_line1_left"><b>Aircraft</b>
				</td>
				<td align="center" rowspan="2" class="table_line1_left"><b>Route</b></td>
				
				<td width="" rowspan="2" align="center" class="table_line1_left"><b>Seats Offered</b></td>
				<td width="36%" colspan="4" align="center" class="table_line1_left"><b>Revenue Passenger Traffic</b></td>
				<td align="center" class="table_line1_left"><b>FOC Traffic</b></td>
				<td align="center" rowspan="2" class="table_line1_left"><b>Route</b></td>
		
				<td width="" rowspan="2" align="center" class="table_line1_left"><b>Seats Offered</b></td>
				<td width="36%" colspan="4" align="center" class="table_line1_left"><b>Revenue Passenger Traffic</b></td>
				<td align="center" class="table_line1_left"><b>FOC Traffic</b></td>
				<td align="center" class="table_line1_left"><b>TOTAL</b></td>
				<td align="center" class="table_line1_left"><b>LF</b></td>
				<td width="5%" rowspan="2" align="center" class="table_line1_left_right"><b>EDIT</b></td>
			</tr>	
		
			<tr class="table_subtitle" style="font-size: 9px;" height="18px">
				
				<td width="9%" align="center" class="table_line1_left" id="r_m1"><b>APR</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m2"><b>MAY</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m3"><b>JUN</b></td>
				<td width="9%" align="center" class="table_line1_left"><b>Sub-Total</b></td>
				<td align="center" class="table_line1_left"><b>Sub Total</b></td>
				
				
				<td width="9%" align="center" class="table_line1_left" id="r_m1d"><b>APR</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m2d"><b>MAY</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m3d"><b>JUN</b></td>
				<td width="9%" align="center" class="table_line1_left"><b>Sub-Total</b></td>
				<td align="center" class="table_line1_left"><b>Sub Total</b></td>
				<td align="center" class="table_line1_left"><b>Rev. Traffic</b></td>
				<td align="center" class="table_line1_left"><b>%</b></td>
			</tr>';

				$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
				$table .= '<td align="center">'. '<input type="checkbox">' .'</td>';
				$table .= '<td align="center">'. $row->aircraft .'</td>';
				$table .= '<td align="center">'. $row->destination_from .' - '. $row->destination_to. '</td>';
				$table .= '<td align="center">'. $seats .'</td>';
				$table .= '<td align="center">'. $row->quarter_month1 .'</td>';
				$table .= '<td align="center">'. $row->quarter_month2.'</td>';
				$table .= '<td align="center">'. $row->quarter_month3 .'</td>';
				$table .= '<td align="center">'. $quartersubtotal .'</td>';
				$table .= '<td align="center">'. $focsubtotal .'</td>';
				$table .= '<td align="center">'. $row->destination_to .' - '. $row->destination_from. '</td>';
				$table .= '<td align="center">'. $seats .'</td>';
				$table .= '<td align="center">'. $row->quarter_month1_d .'</td>';
				$table .= '<td align="center">'. $row->quarter_month2_d .'</td>';
				$table .= '<td align="center">'. $row->quarter_month3_d .'</td>';
				$table .= '<td align="center">'. $quartersubtotal_d .'</td>';
				$table .= '<td align="center">'. $focsubtotal_d .'</td>';
				$table .= '<td align="center">'. $row->aircraft .'</td>';
				$table .= '<td align="center">'. $row->aircraft .'</td>';
				$table .= '<td align="center">'. '<a href="" style="color:#4587C9">Edit</a>' .'</td>';
				
				$table .= '</tr>';
				
				

				
				$table .= '</tr>';
			}
	
			$pagination->table = $table;
			return $pagination;
	}

	private function ajax_table2_list() {
		$pagination = $this->forms_model->getForm51a_direct($this->fields1);
		
			$table = '';
			if (empty($pagination->result)) {
				$table = '<tr><td colspan="9" class="text-center"><b>No Records Found</b></td></tr>';
			}
			foreach ($pagination->result as $key => $row) {
				$seats = $row->cs_ptraffic1 + $row->cs_ptraffic2 + $row->cs_ptraffic3 + $row->cs_ptraffic1_d + $row->cs_ptraffic2_d + $row->cs_ptraffic3_d +
						 $row->cs_nflight1 + $row->cs_nflight2 + $row->cs_nflight3 + $row->cs_nflight1_d + $row->cs_nflight2_d + $row->cs_nflight3_d +
						 $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3 + $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				$quartersubtotal 	= $row->cs_ptraffic1 + $row->cs_ptraffic2 + $row->cs_ptraffic3;
				$quartersubtotal_d  = $row->cs_ptraffic1_d + $row->cs_ptraffic2_d + $row->cs_ptraffic3_d;
				$focsubtotal		= $row->foctraffic_month1 + $row->foctraffic_month2 + $row->foctraffic_month3;
				$focsubtotal_d		= $row->foctraffic_month1_d + $row->foctraffic_month2_d + $row->foctraffic_month3_d;
				
				$table .= '<tr class="table_subtitle" style="font-size: 9px;" height="18px">
				<td width="2%" rowspan="2" class="table_line1_left"><input onclick="checkAllFields(1);" id="checkAll" type="checkbox"></td>
				<td rowspan="2" width="8%" align="center" class="table_line1_left"><b>Aircraft</b>
				</td>
				<td align="center" rowspan="2" class="table_line1_left"><b>Route</b></td>
				
				<td width="" rowspan="2" align="center" class="table_line1_left"><b>Seats Offered</b></td>
				<td width="36%" colspan="4" align="center" class="table_line1_left"><b>Revenue Passenger Traffic</b></td>
				<td align="center" class="table_line1_left"><b>FOC Traffic</b></td>
				<td align="center" rowspan="2" class="table_line1_left"><b>Route</b></td>

				<td width="" rowspan="2" align="center" class="table_line1_left"><b>Seats Offered</b></td>
				<td width="36%" colspan="4" align="center" class="table_line1_left"><b>Revenue Passenger Traffic</b></td>
				<td align="center" class="table_line1_left"><b>FOC Traffic</b></td>
				<td align="center" class="table_line1_left"><b>TOTAL</b></td>
				<td align="center" class="table_line1_left"><b>LF</b></td>
				<td width="5%" rowspan="2" align="center" class="table_line1_left_right"><b>EDIT</b></td>
			</tr>	

			<tr class="table_subtitle" style="font-size: 9px;" height="18px">
				
				<td width="9%" align="center" class="table_line1_left" id="r_m1"><b>APR</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m2"><b>MAY</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m3"><b>JUN</b></td>
				<td width="9%" align="center" class="table_line1_left"><b>Sub-Total</b></td>
				<td align="center" class="table_line1_left"><b>Sub Total</b></td>
				
				
				<td width="9%" align="center" class="table_line1_left" id="r_m1d"><b>APR</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m2d"><b>MAY</b></td>
				<td width="9%" align="center" class="table_line1_left" id="r_m3d"><b>JUN</b></td>
				<td width="9%" align="center" class="table_line1_left"><b>Sub-Total</b></td>
				<td align="center" class="table_line1_left"><b>Sub Total</b></td>
				<td align="center" class="table_line1_left"><b>Rev. Traffic</b></td>
				<td align="center" class="table_line1_left"><b>%</b></td>
			</tr>';

				$table .= '<tr height="18px" style="font-size:9px;" class="table_subtitle">';
				$table .= '<td align="center">'. '<input type="checkbox">' .'</td>';
				$table .= '<td align="center">'. $row->aircraft .'</td>';
				$table .= '<td align="center">'. $row->destination_from .' - '. $row->destination_to. '</td>';
				$table .= '<td align="center">'. $seats .'</td>';
				$table .= '<td align="center">'. $row->cs_ptraffic1 .'</td>';
				$table .= '<td align="center">'. $row->cs_ptraffic2.'</td>';
				$table .= '<td align="center">'. $row->cs_ptraffic3 .'</td>';
				$table .= '<td align="center">'. $quartersubtotal .'</td>';
				$table .= '<td align="center">'. $focsubtotal .'</td>';
				$table .= '<td align="center">'. $row->destination_to .' - '. $row->destination_from. '</td>';
				$table .= '<td align="center">'. $seats .'</td>';
				$table .= '<td align="center">'. $row->cs_ptraffic1_d .'</td>';
				$table .= '<td align="center">'. $row->cs_ptraffic2_d .'</td>';
				$table .= '<td align="center">'. $row->cs_ptraffic3_d .'</td>';
				$table .= '<td align="center">'. $quartersubtotal_d .'</td>';
				$table .= '<td align="center">'. $focsubtotal_d .'</td>';
				$table .= '<td align="center">'. $row->aircraft .'</td>';
				$table .= '<td align="center">'. $row->aircraft .'</td>';
				$table .= '<td align="center">'. '<a href="" style="color:#4587C9">Edit</a>' .'</td>';
				
				$table .= '</tr>';
						
				

				
				$table .= '</tr>';
			}
	
			$pagination->table = $table;
			return $pagination;
	}


}