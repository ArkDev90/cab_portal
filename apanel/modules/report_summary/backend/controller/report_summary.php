<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui					= new ui();
		$this->input				= new input();
		$this->report_summary_model	= new report_summary_model();
		$this->session				= new session();
		$this->client_fields  	= array(
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
	}
	

	public function listing() {
		$this->view->load('report_summary/report_summary');
	}

	public function form_51_a() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_51_a', $data);
	}

	public function form_71_a() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_71_a', $data);
	}

	public function form_71_c() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_71_c', $data);
	}

	public function form_51_b() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_51_b', $data);
	}

	public function HAWBS() {
		$data['ui'] = $this->ui;
		$data['airlines'] = $this->report_summary_model->getAirlines();
		$data['show_input'] = true;
		$this->view->load('report_summary/HAWBS', $data);
	}

	public function form_51a_pdf(){
		$report_type = $_GET['report_type'];
		$report_type = str_replace('+', ' ', $report_type);
		$timeline = $_GET['timeline'];
		$timeline = str_replace('+', ' ', $timeline);
		$quarter = $_GET['quarter'];
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$semester = $_GET['semester'];
		$year = $_GET['year'];
		$start_year_cons = $_GET['start_year_cons'];
		$end_year_cons   = $_GET['end_year_cons'];
		$start_date_cons = $_GET['start_date_cons'];
		$start_date_cons = str_replace('+', ' ', $start_date_cons);
		$end_date_cons = $_GET['end_date_cons'];
		$end_date_cons = str_replace('+', ' ', $end_date_cons);
		if (!empty($_GET["filterby"])) {
			$filterby = $_GET['filterby'];
			$filterby = str_replace('+', ' ', $filterby);
		}
		else {
			$filterby = '';
		}
		if (!empty($_GET["filterbySubLF"])) {
			$load_factor = $_GET['filterbySubLF'];
		}
		else {
			$load_factor = '';
		}
		if (!empty($_GET["filterbySubMS"])) {
			$market_share = $_GET['filterbySubMS'];
		}
		else {
			$market_share = '';
		}
		
		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();

		if($report_type == 'Per Airline'){
				
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(335,7,'INTERNATIONAL CARGO TRAFFIC FLOW', 0, 1, 'C');
				if ($timeline == 'Per Year') {
					$pdf->Cell(335,7, ' CY '.$year, 0, 1, 'C');
				}
				else if ($timeline == 'Per Quarter') {
					if($quarter == '1'){$pdf->Cell(335,7, '1st Quarter'.', CY '.$year, 0, 1, 'C');}
					else if($quarter == '2'){$pdf->Cell(335,7, '2nd Quarter'.', CY '.$year, 0, 1, 'C');}
					else if($quarter == '3'){$pdf->Cell(335,7, '3rd Quarter'.', CY '.$year, 0, 1, 'C');}
					else if($quarter == '4'){$pdf->Cell(335,7, '4th Quarter'.', CY '.$year, 0, 1, 'C');}
				}
				else if ($timeline == 'Per Semester') {
					if($semester == '1'){$pdf->Cell(335,7, '1st Semester'.', CY '.$year, 0, 1, 'C');}
					else{$pdf->Cell(335,7, '2nd Semester'.', CY '.$year, 0, 1, 'C');}
				}
				else if ($timeline == 'Consolidated') {
					$pdf->Cell(335,7, $start_date_cons.' '.$start_year_cons.' - '.$end_date_cons.' '.$end_year_cons, 0, 1, 'C');
					
				}
				
				$pdf->Cell(335,7, '', 0, 1, 'C');
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(13,7, '', 0, 0, 'C');
				$pdf->Cell(30,7, '', 1, 0, 'C');
				$pdf->Cell(55,7, 'AIRLINE', 1, 0, 'C'); 
				$pdf->Cell(55,7, 'Incoming', 1, 0, 'C');
				$pdf->Cell(55,7, 'Outgoing', 1, 0, 'C');
				

				if ($load_factor == 'load_factor' && $market_share == 'market_share' ) {
					$pdf->Cell(55,7, 'TOTAL', 1, 0, 'C');
					$pdf->Cell(30,7, 'LF%', 1, 0, 'C');
					$pdf->Cell(30,7, 'Market Share', 1, 1, 'C');
				}
				else if($load_factor == 'load_factor'){
					$pdf->Cell(55,7, 'TOTAL', 1, 0, 'C');
					$pdf->Cell(30,7, 'LF%', 1, 1, 'C');
				}
				else if($market_share == 'market_share'){
					$pdf->Cell(55,7, 'TOTAL', 1, 0, 'C');
					$pdf->Cell(30,7, 'Market Share', 1, 1, 'C');
				}
				else{
					$pdf->Cell(55,7, 'TOTAL', 1, 1, 'C');
				}
				$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
				$count = 0;
				$totalIncoming = 0;
				$totalOutgoing = 0;
				$totalTotal	   = 0;
				$grandPax	= 0;
				
				foreach ($get51A as $row) {
					if($row->incoming != 0 && $row->outgoing != 0){
					$grandPax	= $grandPax + $row->total;
					$seatcap	= $row->seats1 + $row->seats2;
					$mk   = number_format(($row->total/$grandPax) * 100);
					$count ++;
					$pdf->SetFont('Arial','',9);
					$pdf->Cell(13,7, '', 0, 0, 'C');
					$pdf->Cell(30,7, $count, 1, 0, 'C');
					$pdf->Cell(55,7, $row->name, 1,0, 'L');
					$pdf->Cell(55,7, number_format($row->incoming), 1,0, 'R');
					$pdf->Cell(55,7, number_format($row->outgoing), 1,0, 'R');
					
					if ($load_factor == 'load_factor' && $market_share == 'market_share' ) {
						$pdf->Cell(55,7, number_format($row->total), 1,0, 'R');
						$pdf->Cell(30,7, number_format(($row->total/$seatcap) *100).' %', 1, 0, 'R');
						$pdf->Cell(30,7, $mk.' %', 1, 1, 'R');
					}
				
					else if($load_factor == 'load_factor'){
						$pdf->Cell(55,7, number_format($row->total), 1,0, 'R');
						$pdf->Cell(30,7, number_format(($row->total/$seatcap) *100).' %', 1, 1, 'R');
					}
					else if($market_share == 'market_share'){
						$pdf->Cell(55,7, number_format($row->total), 1,0, 'R');
						$pdf->Cell(30,7, $mk.' %', 1, 1, 'R');
					}
					else{
						$pdf->Cell(55,7, number_format($row->total), 1,1, 'R');
					}
					$totalIncoming += $row->incoming;
					$totalOutgoing += $row->outgoing;
					$totalTotal	   += $row->total;
				}
			}
				
				$pdf->setFont('Arial','B',9);
				$pdf->Cell(13,7, '', 0, 0, 'C');
				$pdf->Cell(85,7, 'TOTAL', 1, 0, 'R');
				$pdf->Cell(55,7, number_format($totalIncoming), 1, 0, 'R');
				$pdf->Cell(55,7, number_format($totalOutgoing), 1, 0, 'R');
				if ($load_factor == 'load_factor' && $market_share == 'market_share' ) {
					$pdf->Cell(55,7, number_format($totalTotal), 1, 0, 'R');
					$pdf->Cell(30,7, '', 1, 0, 'R');
					$pdf->Cell(30,7, '', 1, 1, 'R');
				}
				else if($load_factor == 'load_factor'){
					$pdf->Cell(55,7, number_format($totalTotal), 1, 0, 'R');
					$pdf->Cell(30,7, '', 1, 1, 'R');
				}
				else if($market_share == 'market_share'){
					$pdf->Cell(55,7, number_format($totalTotal), 1, 0, 'R');
					$pdf->Cell(30,7, '', 1, 1, 'R');
				}
				else{
					$pdf->Cell(55,7, number_format($totalTotal), 1, 0, 'R');
				}
		}

		else if ($report_type == 'Historical') {
		
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(335,7,'INTERNATIONAL CARGO TRAFFIC FLOW', 0, 1, 'C');
			$get51AH = $this->report_summary_model->get51AH($start_date, $end_date);
			$pdf->Cell(335,7, 'CY '.$start_date.' - '.$end_date, 0, 1, 'C');

			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(60,7, 'AIRLINE', 1, 0, 'C'); 
			for ($a = $start_date; $a <= $end_date; $a++) { 
				$pdf->Cell(20,7, $a, 1, 0, 'C'); 
			}
			$pdf->Cell(1,7, '', 0, 1, 'C'); 
			$pdf->SetFont('Arial','',9);
			if (empty($get51AH)) {
				$pdf->Cell(50,7,"No Record",0,1, 'L');
			}
			foreach ($get51AH as $key => $row) {
				$pdf->Cell(60,7, $row->name, 1,0, 'L');
				for ($a = $start_date; $a <= $end_date; $a++) { 
					$get51AHTotal = $this->report_summary_model->get51AHTotal($a, $row->id);
					$pdf->Cell(20,7, number_format($get51AHTotal->total), 1, 0, 'R');
				}
				$pdf->Cell(1,7, '', 0,1, 'L');
			}
		
		}

		else if ($report_type == 'Per Country'){
			
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(335,7,'INTERNATIONAL CARGO TRAFFIC FLOW', 0, 1, 'C');
			$pdf->Cell(335,7, 'Per Country CY, '.$year, 0, 1, 'C');
			$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(13,7, '', 0, 0, 'C');
			$pdf->Cell(60,7, 'COUNTRY', 1, 0, 'C'); 
			$pdf->Cell(60,7, 'AIRLINE/ROUTE', 1, 0, 'C');
			$pdf->Cell(60,7, 'TOTAL', 1, 1, 'C');
			$grandtotal = 0;
			foreach ($get51A as $key => $row) {
				// $pdf->Cell(335,7, '', 0, 1, 'C');
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(13,7, '', 0, 0, 'C');
				$pdf->Cell(60,7, $row->country, 1, 0, 'C'); 
				$pdf->Cell(60,7, '', 1, 0, 'C');
				$pdf->Cell(60,7, '', 1, 1, 'C');
				$pdf->Cell(13,7, '', 0, 0, 'C');
				$pdf->Cell(60,7, '', 1, 0, 'C');
				$pdf->Cell(60,7, $row->name, 1, 0, 'C');
				$pdf->Cell(60,7, '', 1, 1, 'C'); 
				$pdf->Cell(13,7, '', 0, 0, 'C');
				$pdf->Cell(60,7, '', 1, 0, 'C');
				$pdf->Cell(60,7, $row->destination_from.'/'. $row->destination_to, 1, 0, 'R');
				$pdf->Cell(60,7, number_format($row->total), 1, 1, 'R');

				$grandtotal += $row->total;
			}
			$pdf->SetFont('Arial','B',9);
			
			$pdf->Cell(13,7, '', 0, 0, 'C');
			$pdf->Cell(60,7, '', 1, 0, 'C');
			$pdf->Cell(60,7, '', 1, 0, 'C');
			$pdf->Cell(60,7, '', 1, 1, 'C'); 
			$pdf->Cell(13,7, '', 0, 0, 'C');
			$pdf->Cell(60,7, '', 1, 0, 'C');
			$pdf->Cell(60,7, 'TOTAL', 1, 0, 'R');
			$pdf->Cell(60,7, number_format($grandtotal), 1, 1, 'R');

		}

		else if ($report_type == 'Per RouteSector'){
			
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(335,7,'INTERNATIONAL CARGO TRAFFIC FLOW', 0, 1, 'C');
			$pdf->Cell(335,7, 'SUMMARY PER ROUTE', 0, 1, 'C');
			$pdf->Cell(335,7, 'CY, '.$year, 0, 1, 'C');
			$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(13,7, '', 1, 0, 'C');
			$pdf->Cell(60,7, 'AIRLINE', 1, 0, 'C'); 
			$pdf->Cell(60,7, 'ROUTE', 1, 0, 'C');
			$pdf->Cell(60,7, 'INCOMING', 1, 0, 'C');
			$pdf->Cell(60,7, 'OUTGOING', 1, 0, 'C');
			$pdf->Cell(60,7, 'TOTAL', 1, 1, 'C');
			$totalincoming = 0;
			$totaloutgoing = 0;
			$grandtotal	   = 0;
			$count = 0;
			foreach ($get51A as $key => $row) {
				$count++;
				// $pdf->Cell(335,7, '', 0, 1, 'C');
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(13,7, $count, 1, 0, 'C');
				$pdf->Cell(60,7, $row->name, 1, 0, 'L'); 
				$pdf->Cell(60,7, '', 1, 0, 'L');
				$pdf->Cell(60,7, '', 1, 0, 'L');
				$pdf->Cell(60,7, '', 1, 0, 'L');
				$pdf->Cell(60,7, '', 1, 1, 'C');
				$pdf->Cell(13,7, '', 1, 0, 'C');
				$pdf->Cell(60,7, '', 1, 0, 'C');
				$pdf->Cell(60,7, $row->destination_from.'/'.$row->destination_to, 1, 0, 'C');
				$pdf->Cell(60,7, number_format($row->incoming, 2), 1, 0, 'R'); 
				$pdf->Cell(60,7, number_format($row->outgoing, 2), 1, 0, 'R'); 
				$pdf->Cell(60,7, number_format($row->total, 2), 1, 1, 'R');

				$totalincoming += $row->incoming;
				$totaloutgoing += $row->outgoing;
				$grandtotal	   += $row->total;
			}
			$pdf->Cell(13,7, '', 1, 0, 'C');
			$pdf->Cell(60,7, '', 1, 0, 'C'); 
			$pdf->Cell(60,7, 'GRAND TOTAL', 1, 0, 'R');
			$pdf->Cell(60,7, number_format($totalincoming, 2), 1, 0, 'R');
			$pdf->Cell(60,7, number_format($totaloutgoing, 2), 1, 0, 'R');
			$pdf->Cell(60,7, number_format($grandtotal, 2), 1, 1, 'R');

		}
		else if ($report_type == 'CoTerm 5th Freedom'){
			
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(335,7,'Scheduled International Passenger Traffic Flow', 0, 1, 'C');
			$pdf->Cell(335,7, 'CY, '.$year, 0, 1, 'C');
			$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(13,7, '', 1, 0, 'C');
			$pdf->Cell(60,7, 'AIRLINE', 1, 0, 'C'); 
			$pdf->Cell(50,7, 'POINTS RESERVED', 1, 0, 'C');
			$pdf->Cell(50,7, 'Co-Terminal/5th Freedom', 1, 0, 'C');
			$pdf->Cell(50,7, 'INCOMING', 1, 0, 'C');
			$pdf->Cell(50,7, 'OUTGOING', 1, 0, 'C');
			$pdf->Cell(50,7, 'TOTAL', 1, 1, 'C');
			$totalincoming = 0;
			$totaloutgoing = 0;
			$grandtotal	   = 0;
			$count = 0;
			foreach ($get51A as $key => $row) {
				$count++;
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(13,7, $count, 1, 0, 'C');
				$pdf->Cell(60,7, $row->name, 1, 0, 'L'); 
				$pdf->Cell(50,7, '', 1, 0, 'L');
				$pdf->Cell(50,7, '', 1, 0, 'C');
				$pdf->Cell(50,7, '', 1, 0, 'L');
				$pdf->Cell(50,7, '', 1, 0, 'L');
				$pdf->Cell(50,7, '', 1, 1, 'C');
				$pdf->Cell(13,7, '', 1, 0, 'C');
				$pdf->Cell(60,7, '', 1, 0, 'C');
				$pdf->Cell(50,7, $row->destination_from.'/'.$row->destination_to, 1, 0, 'C');
				$pdf->Cell(50,7, '', 1, 0, 'C');
				$pdf->Cell(50,7, number_format($row->incoming, 2), 1, 0, 'R'); 
				$pdf->Cell(50,7, number_format($row->outgoing, 2), 1, 0, 'R'); 
				$pdf->Cell(50,7, number_format($row->total, 2), 1, 1, 'R');

				$totalincoming += $row->incoming;
				$totaloutgoing += $row->outgoing;
				$grandtotal	   += $row->total;
			}
			$pdf->Cell(13,7, '', 1, 0, 'C');
			$pdf->Cell(60,7, '', 1, 0, 'C'); 
			$pdf->Cell(50,7, 'GRAND TOTAL', 1, 0, 'R');
			$pdf->Cell(50,7, '', 1, 0, 'R');
			$pdf->Cell(50,7, number_format($totalincoming, 2), 1, 0, 'R');
			$pdf->Cell(50,7, number_format($totaloutgoing, 2), 1, 0, 'R');
			$pdf->Cell(50,7, number_format($grandtotal, 2), 1, 1, 'R');

		}
		$pdf->Output();
	}

	public function form_51a_csv() {
		$report_type = $_GET['report_type'];
		$report_type = str_replace('+', ' ', $report_type);
		$timeline = $_GET['timeline'];
		$timeline = str_replace('+', ' ', $timeline);
		$quarter = $_GET['quarter'];
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$semester = $_GET['semester'];
		$year = $_GET['year'];
		$start_year_cons = $_GET['start_year_cons'];
		$end_year_cons   = $_GET['end_year_cons'];
		$start_date_cons = $_GET['start_date_cons'];
		$start_date_cons = str_replace('+', ' ', $start_date_cons);
		$end_date_cons = $_GET['end_date_cons'];
		$end_date_cons = str_replace('+', ' ', $end_date_cons);
		if (!empty($_GET["filterby"])) {
			$filterby = $_GET['filterby'];
			$filterby = str_replace('+', ' ', $filterby);
		}
		else {
			$filterby = '';
		}
		if (!empty($_GET["filterbySubLF"])) {
			$load_factor = $_GET['filterbySubLF'];
		}
		else {
			$load_factor = '';
		}
		if (!empty($_GET["filterbySubMS"])) {
			$market_share = $_GET['filterbySubMS'];
		}
		else {
			$market_share = '';
		}

		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Form51a_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Form51a_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Form51a_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form 51A')
				->setDescription('Summary Report Form 51A')
				->setKeywords('summary report fORM 51-a traffic flow - quarterly report on scheduled international services')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form 51A');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		if ($report_type == 'Per Airline') {
			if ($load_factor == 'load_factor' && $market_share == 'market_share') {
				$sheet->mergeCells('A1:G1');
				$sheet->mergeCells('A2:G2');
			}
			else if ($load_factor == 'load_factor' || $market_share == 'market_share'){
				$sheet->mergeCells('A1:F1');
				$sheet->mergeCells('A2:F2');
			}
			else if ($load_factor != 'load_factor' && $market_share != 'market_share'){
				$sheet->mergeCells('A1:E1');
				$sheet->mergeCells('A2:E2');
			}
		}

		if ($report_type == 'Per Airline') {
			$sheet->getCell('A1')->setValue('INTERNATIONAL CARGO TRAFFIC FLOW');
			$sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			if ($timeline == 'Per Year') {
				$sheet->getCell('A2')->setValue(' CY '.$year);
			}
			else if ($timeline == 'Per Quarter') {
				if($quarter == '1'){
					$sheet->getCell('A2')->setValue('1st Quarter'.', CY '.$year);
				}
				else if($quarter == '2'){
					$sheet->getCell('A2')->setValue('2nd Quarter'.', CY '.$year);
				}
				else if($quarter == '3'){
					$sheet->getCell('A2')->setValue('3rd Quarter'.', CY '.$year);
				}
				else if($quarter == '4'){
					$sheet->getCell('A2')->setValue('4th Quarter'.', CY '.$year);
				}
			}
			else if ($timeline == 'Per Semester') {
				if($semester == '1'){
					$sheet->getCell('A2')->setValue('1st Semester'.', CY '.$year);
				}
				else{
					$sheet->getCell('A2')->setValue('2nd Semester'.', CY '.$year);
				}
			}
			else if ($timeline == 'Consolidated') {
				$sheet->getCell('A2')->setValue($start_date_cons.' '.$start_year_cons.' - '.$end_date_cons.' '.$end_year_cons);
			}
			
			$sheet->getCell('B4')->setValue('AIRLINE');
			$sheet->getCell('C4')->setValue('Incoming');
			$sheet->getCell('D4')->setValue('Outgoing');
			$sheet->getCell('E4')->setValue('TOTAL');
			if ($load_factor == 'load_factor' && $market_share == 'market_share' ) {
				$sheet->getCell('F4')->setValue('LF%');
				$sheet->getCell('G4')->setValue('Market Share');
			}
			else if($load_factor == 'load_factor'){
				$sheet->getCell('F4')->setValue('LF%');
			}
			else if($market_share == 'market_share'){
				$sheet->getCell('F4')->setValue('Market Share');
			}

			$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
			$count = 0;
			$totalIncoming = 0;
			$totalOutgoing = 0;
			$totalTotal = 0;
			$grandPax = 0;
			$cell_row = 5;
			foreach ($get51A as $key => $row) {
				if($row->incoming != 0 && $row->outgoing != 0){
				$grandPax	= $grandPax + $row->total;
				$seatcap	= $row->seats1 + $row->seats2;
				$mk   		= number_format(($row->total/$grandPax) * 100);
				$count ++;
				$sheet->getCell('A'.$cell_row)->setValue($count);
				$sheet->getCell('B'.$cell_row)->setValue($row->name);
				$sheet->getCell('C'.$cell_row)->setValue($row->incoming);
				$sheet->getCell('D'.$cell_row)->setValue($row->outgoing);
				$sheet->getCell('E'.$cell_row)->setValue($row->total);
					
				if ($load_factor == 'load_factor' && $market_share == 'market_share' ) {
					$sheet->getCell('F'.$cell_row)->setValue(number_format(($row->total/$seatcap) *100).' %');
					$sheet->getCell('G'.$cell_row)->setValue($mk.' %');
				}
				else if($load_factor == 'load_factor'){
					$sheet->getCell('F'.$cell_row)->setValue(number_format(($row->total/$seatcap) *100).' %');
				}
				else if($market_share == 'market_share'){
					$sheet->getCell('F'.$cell_row)->setValue($mk.' %');
				}
				$totalIncoming += $row->incoming;
				$totalOutgoing += $row->outgoing;
				$totalTotal	   += $row->total;
				$cell_row++;
			}
		}
			$sheet->mergeCells('A'.$cell_row.':B'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('TOTAL');
			$sheet->getCell('C'.$cell_row)->setValue($totalIncoming);
			$sheet->getCell('D'.$cell_row)->setValue($totalOutgoing);
			$sheet->getCell('E'.$cell_row)->setValue($totalTotal);
		}
		
		else if ($report_type == 'Historical') {
			$sheet->getCell('A1')->setValue('INTERNATIONAL CARGO TRAFFIC FLOW');
			$sheet->getCell('A2')->setValue('CY '.$start_date.' - '.$end_date);
			$sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$get51AH = $this->report_summary_model->get51AH($start_date, $end_date);

			$sheet->getCell('A4')->setValue('AIRLINE');
			$cell_col = 'B';
			for ($a = $start_date; $a <= $end_date; $a++) { 
				$sheet->getCell($cell_col.'4')->setValue($a);
				$cell_col++;
			}
			if (empty($get51AH)) {
				$sheet->getCell('A5')->setValue('No Record');
			}
			$cell_row = 5;
			foreach ($get51AH as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($row->name);
				$cell_col = 'B';
				for ($a = $start_date; $a <= $end_date; $a++) { 
					$get51AHTotal = $this->report_summary_model->get51AHTotal($a, $row->id);
					$sheet->getCell($cell_col.$cell_row)->setValue(number_format($get51AHTotal->total, 2));
					$cell_col++;
				}
				$cell_row++;
			}
			$sheet->mergeCells('A1:'.$cell_col.'1');
			$sheet->mergeCells('A2:'.$cell_col.'2');
		}
		
		else if ($report_type == 'Per Country'){
			$sheet->getCell('A1')->setValue('INTERNATIONAL CARGO TRAFFIC FLOW');
			$sheet->getCell('A2')->setValue('CY '.$start_date.' - '.$end_date);
			$sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
			$sheet->getCell('B4')->setValue('COUNTRY');
			$sheet->getCell('C4')->setValue('AIRLINE/ROUTE');
			$sheet->getCell('D4')->setValue('TOTAL');
			$first_row = 5;
			$second_row = 6;
			$third_row = 7;
			foreach ($get51A as $key => $row) {
				$sheet->getCell('A'.$first_row)->setValue($row->country);
				$sheet->getCell('B'.$second_row)->setValue($row->name);
				$sheet->getCell('B'.$third_row)->setValue($row->destination_from.'/'. $row->destination_to);
				$sheet->getCell('C'.$third_row)->setValue($row->total);
				
				$first_row += 3;
				$second_row += 3;
				$third_row += 3;
			}
			$sheet->mergeCells('A1:C1');
			$sheet->mergeCells('A2:C2');
		}

		else if ($report_type == 'Per RouteSector'){
			$sheet->getCell('A1')->setValue('INTERNATIONAL CARGO TRAFFIC FLOW');
			$sheet->getCell('A2')->setValue('SUMMARY PER ROUTE');
			$sheet->getCell('A3')->setValue('CY, '.$year);
			$sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
			$sheet->getCell('B5')->setValue('AIRLINE');
			$sheet->getCell('C5')->setValue('ROUTE');
			$sheet->getCell('D5')->setValue('INCOMING');
			$sheet->getCell('E5')->setValue('OUTGOING');
			$sheet->getCell('F5')->setValue('TOTAL');
			$totalincoming = 0;
			$totaloutgoing = 0;
			$grandtotal	= 0;
			$count = 0;
			$first_row = 6;
			$second_row = 7;
			foreach ($get51A as $key => $row) {
				$count++;
				$sheet->getCell('A'.$first_row)->setValue($count);
				$sheet->getCell('B'.$first_row)->setValue($row->name);
				$sheet->getCell('C'.$second_row)->setValue($row->destination_from.'/'.$row->destination_to);
				$sheet->getCell('D'.$second_row)->setValue($row->incoming);
				$sheet->getCell('E'.$second_row)->setValue($row->outgoing);
				$sheet->getCell('F'.$second_row)->setValue($row->total);

				$totalincoming += $row->incoming;
				$totaloutgoing += $row->outgoing;
				$grandtotal	   += $row->total;
				$first_row += 2;
				$second_row += 2;
			}
			$sheet->mergeCells('A'.$first_row.':C'.$first_row);
			$sheet->getCell('A'.$first_row)->setValue('GRAND TOTAL');
			$sheet->getCell('D'.$first_row)->setValue($totalincoming);
			$sheet->getCell('E'.$first_row)->setValue($totaloutgoing);
			$sheet->getCell('F'.$first_row)->setValue($grandtotal);

			$sheet->mergeCells('A1:F1');
			$sheet->mergeCells('A2:F2');
			$sheet->mergeCells('A3:F3');
		}

		else if ($report_type == 'CoTerm 5th Freedom'){
			$sheet->getCell('A1')->setValue('Scheduled International Passenger Traffic Flow');
			$sheet->getCell('A2')->setValue('CY, '.$year);
			$sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$get51A = $this->report_summary_model->get51A($report_type, $quarter, $year, $timeline, $semester, $filterby, $load_factor, $market_share, $start_date, $end_date,$start_date_cons,$end_date_cons,$start_year_cons,$end_year_cons);
			$sheet->getCell('B5')->setValue('AIRLINE');
			$sheet->getCell('C5')->setValue('POINTS RESERVED');
			$sheet->getCell('D5')->setValue('Co-Terminal/5th Freedom');
			$sheet->getCell('E5')->setValue('INCOMING');
			$sheet->getCell('F5')->setValue('OUTGOING');
			$sheet->getCell('G5')->setValue('TOTAL');
			$totalincoming = 0;
			$totaloutgoing = 0;
			$grandtotal	   = 0;
			$count = 0;
			$first_row = 6;
			$second_row = 7;
			foreach ($get51A as $key => $row) {
				$count++;
				$sheet->getCell('A'.$first_row)->setValue($count);
				$sheet->getCell('B'.$first_row)->setValue($row->name);
				$sheet->getCell('C'.$second_row)->setValue($row->destination_from.'/'.$row->destination_to);
				$sheet->getCell('D'.$second_row)->setValue('');
				$sheet->getCell('E'.$second_row)->setValue($row->incoming);
				$sheet->getCell('F'.$second_row)->setValue($row->outgoing);
				$sheet->getCell('G'.$second_row)->setValue($row->total);

				$totalincoming += $row->incoming;
				$totaloutgoing += $row->outgoing;
				$grandtotal	   += $row->total;
				$first_row += 2;
				$second_row += 2;
			}
			$sheet->mergeCells('A'.$first_row.':C'.$first_row);
			$sheet->getCell('A'.$first_row)->setValue('GRAND TOTAL');
			$sheet->getCell('D'.$first_row)->setValue('');
			$sheet->getCell('E'.$first_row)->setValue($totalincoming);
			$sheet->getCell('F'.$first_row)->setValue($totaloutgoing);
			$sheet->getCell('G'.$first_row)->setValue($grandtotal);

			$sheet->mergeCells('A1:F1');
			$sheet->mergeCells('A2:F2');
		}

		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');
	}
	
	public function form_51b_pdf() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		$start_year = $_GET['start_year'];
		$end_year = $_GET['end_year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(335,7,'INTERNATIONAL CARGO TRAFFIC FLOW', 0, 1, 'C');
		$pdf->Cell(335,7,'(in Kilograms)', 0, 1, 'C');

		if (!empty($_GET["summary_route"])) {
			$summary_route = $_GET['summary_route'];
			$summary_route = str_replace('+', ' ', $summary_route);
		}
		else {
			$summary_route = '';
		}
		if (!empty($_GET["a_rank_alpha"])) {
			$a_rank_alpha = $_GET['a_rank_alpha'];
			$a_rank_alpha = str_replace('+', ' ', $a_rank_alpha);
		}
		else {
			$a_rank_alpha = '';
		}
		if (!empty($_GET["a_market_share"])) {
			$a_market_share = $_GET['a_market_share'];
			$a_market_share = str_replace('+', ' ', $a_market_share);
		}
		else {
			$a_market_share = '';
		}
		if (!empty($_GET["c_rank_alpha"])) {
			$c_rank_alpha = $_GET['c_rank_alpha'];
			$c_rank_alpha = str_replace('+', ' ', $c_rank_alpha);
		}
		else {
			$c_rank_alpha = '';
		}
		if (!empty($_GET["h_market_share"])) {
			$h_market_share = $_GET['h_market_share'];
			$h_market_share = str_replace('+', ' ', $h_market_share);
		}
		else {
			$h_market_share = '';
		}

		$get51bAC = $this->report_summary_model->get51BAC($report_type, $quarter, $year, $category, $a_rank_alpha, $c_rank_alpha, $start_date, $end_date);
			
		if ($category == 'by Airline') {
			if ($summary_route == 'Summary') {
				if ($report_type == 'Quarterly') {
					$pdf->Cell(335,7, $quarter.' CY '.$year.' Summary', 0, 1, 'C');
				}
				else if ($report_type == 'Consolidated') {
					$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
				}
				else {
					$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
				}

				$pdf->Cell(335,7, '', 0, 1, 'C');
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(30,7, '', 1, 0, 'C');
				$pdf->Cell(75,7, 'AIRLINE', 1, 0, 'C'); 
				$pdf->Cell(35,7, 'POINTS SERVED', 1, 0, 'C');
				$pdf->Cell(55,7, 'Incoming (Kilograms)', 1, 0, 'C');
				$pdf->Cell(55,7, 'Outgoing (Kilograms)', 1, 0, 'C');
				if ($a_market_share == 'Market Share') {
					$pdf->Cell(55,7, 'TOTAL (Kilograms)', 1, 0, 'C');
					$pdf->Cell(30,7, 'MS', 1, 1, 'C');
				}
				else {
					$pdf->Cell(55,7, 'TOTAL (Kilograms)', 1, 1, 'C');
				}
				$pdf->SetFont('Arial','',9);
				if (empty($get51bAC)) {
					if ($a_market_share == 'Market Share') {
						$pdf->Cell(335,7,"No Record",1,1, 'C');
					}
					else {
						$pdf->Cell(305,7,"No Record",1,1, 'C');
					}
				}
				$count = 1;
				$totalcargoRev = 0;
				$totalcargoRevDep = 0;
				$grandtotal = 0;
				$totalmarket_share = 0;
				foreach ($get51bAC as $key => $row) {
					$pdf->Cell(30,7, $count++, 1,0, 'C');
					$pdf->Cell(75,7, $row->name, 1,0, 'L');
					if ($row->routeTo != '') {
						$pdf->Cell(35,7, $row->routeTo.'/'.$row->routeFrom, 1,0, 'L');
					}
					else {
						$pdf->Cell(35,7, '', 1,0, 'L');
					}
					$pdf->Cell(55,7, number_format($row->cargoRev, 2), 1,0, 'R');
					$pdf->Cell(55,7, number_format($row->cargoRevDep, 2), 1,0, 'R');
					if ($a_market_share == 'Market Share') {
						$getTotalWeight = $this->report_summary_model->getTotal51BWeight();
						$market_share = ($row->total / $getTotalWeight->totalchargeableweight) * 100; 
						$pdf->Cell(55,7, number_format($row->total, 2), 1,0, 'R');
						$pdf->Cell(30,7, number_format($market_share, 2), 1,1, 'R');
					}
					else {
						$pdf->Cell(55,7, $row->total, 1,1, 'R');
					}
					$totalcargoRev += $row->cargoRev;
					$totalcargoRevDep += $row->cargoRevDep;
					$grandtotal += $row->total;
					if ($a_market_share == 'Market Share') {
						$totalmarket_share += $market_share;
					}
				}
				$pdf->setFont('Arial','B',9);
				$pdf->Cell(140,7, 'GRAND TOTAL', 1, 0, 'R');
				$pdf->Cell(55,7, number_format($totalcargoRev, 2), 1, 0, 'R');
				$pdf->Cell(55,7, number_format($totalcargoRevDep, 2), 1, 0, 'R');
				$pdf->Cell(55,7, number_format($grandtotal, 2), 1, 0, 'R');
				if ($a_market_share == 'Market Share') {
					$totalmarket_share = $totalmarket_share / ($count - 1);
					$pdf->Cell(30,7, number_format($totalmarket_share, 2), 1, 1, 'R');
				}
			}

			else {
				if ($report_type == 'Quarterly') {
					$pdf->Cell(335,7, $quarter.' CY '.$year.' Per Route', 0, 1, 'C');
				}
				else if ($report_type == 'Consolidated') {
					$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
				}
				else {
					$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
				}

				$pdf->Cell(335,7, '', 0, 1, 'C');
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(30,7, '', 1, 0, 'C');
				$pdf->Cell(45,7, 'AIRLINE', 1, 0, 'C'); 
				$pdf->Cell(45,7, 'COUNTRY', 1, 0, 'C');
				$pdf->Cell(45,7, 'ROUTE', 1, 0, 'C');
				$pdf->Cell(45,7, 'Incoming (Kilograms)', 1, 0, 'C');
				$pdf->Cell(45,7, 'Outgoing (Kilograms)', 1, 0, 'C');
				if ($a_market_share == 'Market Share') {
					$pdf->Cell(45,7, 'TOTAL (Kilograms)', 1, 0, 'C');
					$pdf->Cell(30,7, 'MS', 1, 1, 'C');
				}
				else {
					$pdf->Cell(45,7, 'TOTAL (Kilograms)', 1, 1, 'C');
				}
				$pdf->SetFont('Arial','',9);
				if (empty($get51bAC)) {
					if ($a_market_share == 'Market Share') {
					$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					else {
						$pdf->Cell(300,7,"No Record",1,1, 'C');
					}
				}
				$count = 1;
				$totalcargoRev = 0;
				$totalcargoRevDep = 0;
				$grandtotal = 0;
				$totalms = 0;
				foreach ($get51bAC as $key => $row) {
					$pdf->Cell(30,7, $count++, 1,0, 'C');
					$pdf->Cell(45,7, $row->name, 1,0, 'L');
					$pdf->Cell(45,7, $row->title, 1,0, 'L');
					$pdf->Cell(45,7, $row->routeTo.'/'.$row->routeFrom, 1,0, 'L');
					$pdf->Cell(45,7, number_format($row->cargoRev, 2), 1,0, 'R');
					$pdf->Cell(45,7, number_format($row->cargoRevDep, 2), 1,0, 'R');
					if ($a_market_share == 'Market Share') {
						$pdf->Cell(45,7, number_format($row->total, 2), 1,0, 'R');
						$pdf->Cell(30,7, 'MS', 1,1, 'R');
					}
					else {
						$pdf->Cell(45,7, $row->total, 1,1, 'R');
					}
					$totalcargoRev += $row->cargoRev;
					$totalcargoRevDep += $row->cargoRevDep;
					$grandtotal += $row->total;
					//$totalms += 0;
				}
				$pdf->setFont('Arial','B',9);
				$pdf->Cell(165,7, 'GRAND TOTAL', 1, 0, 'R');
				$pdf->Cell(45,7, number_format($totalcargoRev, 2), 1, 0, 'R');
				$pdf->Cell(45,7, number_format($totalcargoRevDep, 2), 1, 0, 'R');
				$pdf->Cell(45,7, number_format($grandtotal, 2), 1, 0, 'R');
				if ($a_market_share == 'Market Share') {
					$pdf->Cell(30,7, 'MS', 1, 1, 'R');
				}
			}
		}
		else if ($category == 'by Country') {
			if ($report_type == 'Quarterly') {
				$pdf->Cell(335,7, $quarter.' CY '.$year.' Summary', 0, 1, 'C');
			}
			else if ($report_type == 'Consolidated') {
				$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
			}
			else {
				$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
			}

			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(110,7, 'COUNTRY', 1, 0, 'C'); 
			$pdf->Cell(110,7, 'AIRLINE/ROUTE', 1, 0, 'C');
			$pdf->Cell(110,7, 'TOTAL', 1, 1, 'C');

			$pdf->SetFont('Arial','',9);
			if (empty($get51bAC)) {
				$pdf->Cell(330,7,"No Record",1,1, 'C');
			}
			$count = 1;
			$grandtotal = 0;
			foreach ($get51bAC as $key => $row) {
				$pdf->Cell(110,7, $row->country, 1,0, 'L');
				$pdf->Cell(110,7, $row->name.' '.$row->routeTo.'/'.$row->routeFrom, 1,0, 'L');
				$pdf->Cell(110,7, number_format($row->total, 2), 1,1, 'R');
				$grandtotal += $row->total;
			}
			$pdf->setFont('Arial','B',9);
			$pdf->Cell(220,7, 'GRAND TOTAL', 1, 0, 'R');
			$pdf->Cell(110,7, number_format($grandtotal, 2), 1, 0, 'R');
		}

		else if ($category == 'Historical') {
			$get51bH = $this->report_summary_model->get51BH($start_year, $end_year);
			$pdf->Cell(335,7, 'CY '.$start_year.' - '.$end_year, 0, 1, 'C');

			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(60,7, 'AIRLINE', 1, 0, 'C'); 
			for ($a = $start_year; $a <= $end_year; $a++) { 
				$pdf->Cell(20,7, $a, 1, 0, 'C'); 
			}
			if ($h_market_share == 'Market Share') {
				$pdf->Cell(20,7, 'MS', 1, 0, 'C');
			}
			$pdf->Cell(1,7, '', 0, 1, 'C'); 
			$pdf->SetFont('Arial','',9);
			if (empty($get51bH)) {
				$pdf->Cell(50,7,"No Record",0,1, 'L');
			}
			foreach ($get51bH as $key => $row) {
				$pdf->Cell(60,7, $row->name, 1,0, 'L');
				$totalperyear = 0;
				$count = 0;
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$get51bHTotal = $this->report_summary_model->get51BHTotal($a, $row->id);
					$pdf->Cell(20,7, number_format($get51bHTotal->total, 2), 1, 0, 'R');
					if ($get51bHTotal) {
						$count++;
						$totalperyear += $get51bHTotal->total;
					}
					else {
						$count = $count;
						$totalperyear = $totalperyear;
					}
				}
				$totalperyear = $totalperyear / ($count);
				$getTotalWeight = $this->report_summary_model->getTotal51BWeight();
				$market_share = ($totalperyear / $getTotalWeight->totalchargeableweight) * 100;
				if ($h_market_share != '') {
					$pdf->Cell(20,7, number_format($market_share, 2). '%', 1,0, 'R');
				}
				$pdf->Cell(1,7, '', 0,1, 'L');
			}
		}

		$pdf->Output();
	}

	public function form_51b_csv() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		$start_year = $_GET['start_year'];
		$end_year = $_GET['end_year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Form51b_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Form51b_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Form51b_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form 51B')
				->setDescription('Summary Report Form 51B')
				->setKeywords('summary report fORM 51-b monthly international cargo traffic flow')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form 51B');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		if ($category == 'by Airline') {
			$sheet->mergeCells('A1:G1');
			$sheet->mergeCells('A2:G2');
			$sheet->mergeCells('A3:G3');
		}
		else if ($category == 'by Country') {
			$sheet->mergeCells('A1:C1');
			$sheet->mergeCells('A2:C2');
			$sheet->mergeCells('A3:C3');
		}
		else {
			$sheet->mergeCells('A1:N1');
			$sheet->mergeCells('A2:N2');
			$sheet->mergeCells('A3:N3');
		}

		$sheet->getCell('A1')->setValue('INTERNATIONAL CARGO TRAFFIC FLOW');
		$sheet->getCell('A2')->setValue('(in Kilograms)');
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if (!empty($_GET["summary_route"])) {
			$summary_route = $_GET['summary_route'];
			$summary_route = str_replace('+', ' ', $summary_route);
		}
		else {
			$summary_route = '';
		}
		if (!empty($_GET["a_rank_alpha"])) {
			$a_rank_alpha = $_GET['a_rank_alpha'];
			$a_rank_alpha = str_replace('+', ' ', $a_rank_alpha);
		}
		else {
			$a_rank_alpha = '';
		}
		if (!empty($_GET["a_market_share"])) {
			$a_market_share = $_GET['a_market_share'];
			$a_market_share = str_replace('+', ' ', $a_market_share);
		}
		else {
			$a_market_share = '';
		}
		if (!empty($_GET["c_rank_alpha"])) {
			$c_rank_alpha = $_GET['c_rank_alpha'];
			$c_rank_alpha = str_replace('+', ' ', $c_rank_alpha);
		}
		else {
			$c_rank_alpha = '';
		}
		if (!empty($_GET["h_market_share"])) {
			$h_market_share = $_GET['h_market_share'];
			$h_market_share = str_replace('+', ' ', $h_market_share);
		}
		else {
			$h_market_share = '';
		}

		$get51bAC = $this->report_summary_model->get51BAC($report_type, $quarter, $year, $category, $a_rank_alpha, $c_rank_alpha, $start_date, $end_date);
			
		if ($category == 'by Airline') {
			if ($summary_route == 'Summary') {
				if ($report_type == 'Quarterly') {
					$sheet->getCell('A3')->setValue($quarter.' CY '.$year.' Summary');
				}
				else if ($report_type == 'Consolidated') {
					$sheet->getCell('A3')->setValue($start_date.' - '.$end_date.' CY '.$year);
				}
				else {
					$sheet->getCell('A3')->setValue('CY '.$year);
				}
				$sheet->getCell('A5')->setValue('');
				$sheet->getCell('B5')->setValue('AIRLINE');
				$sheet->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('C5')->setValue('POINTS SERVED');
				$sheet->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('D5')->setValue('Incoming (Kilograms)');
				$sheet->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('E5')->setValue('Outgoing (Kilograms)');
				$sheet->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('F5')->setValue('TOTAL (Kilograms)');
				$sheet->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				if ($a_market_share == 'Market Share') {
					$sheet->getCell('G5')->setValue('MS');
					$sheet->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
				if (empty($get51bAC)) {
					if ($a_market_share == 'Market Share') {
						$sheet->mergeCells('A6:G6');
						$sheet->getCell('A6')->setValue('No Record');
					}
					else {
						$sheet->mergeCells('A6:F6');
						$sheet->getCell('A6')->setValue('No Record');
					}
				}
				$count = 1;
				$totalcargoRev = 0;
				$totalcargoRevDep = 0;
				$grandtotal = 0;
				$totalmarket_share = 0; 
				$cell_row = 6;
				foreach ($get51bAC as $key => $row) {
					$sheet->getCell('A'.$cell_row)->setValue($count++);
					$sheet->getCell('B'.$cell_row)->setValue($row->name);
					$sheet->getCell('C'.$cell_row)->setValue($row->routeTo.'/'.$row->routeFrom);
					$sheet->getCell('D'.$cell_row)->setValue(number_format($row->cargoRev, 2));
					$sheet->getCell('E'.$cell_row)->setValue(number_format($row->cargoRevDep, 2));
					$sheet->getCell('F'.$cell_row)->setValue(number_format($row->total, 2));
					if ($a_market_share == 'Market Share') {
						$getTotalWeight = $this->report_summary_model->getTotal51BWeight();
						$market_share = ($row->total / $getTotalWeight->totalchargeableweight) * 100; 
						$sheet->getCell('G'.$cell_row)->setValue(number_format($market_share, 2).'%');
					}
					$cell_row++;
					$totalcargoRev += $row->cargoRev;
					$totalcargoRevDep += $row->cargoRevDep;
					$grandtotal += $row->total;
					if ($a_market_share == 'Market Share') {
						$totalmarket_share += $market_share;
					}
				}
				$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
				$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
				$sheet->getCell('D'.$cell_row)->setValue(number_format($totalcargoRev, 2));
				$sheet->getCell('E'.$cell_row)->setValue(number_format($totalcargoRevDep, 2));
				$sheet->getCell('F'.$cell_row)->setValue(number_format($grandtotal, 2));
				if ($a_market_share == 'Market Share') {
					$totalmarket_share = $totalmarket_share / ($count - 1);
					$sheet->getCell('G'.$cell_row)->setValue(number_format($totalmarket_share, 2).'%');
				}
			}
			else {
				if ($report_type == 'Quarterly') {
					$sheet->getCell('A3')->setValue($quarter.' CY '.$year.' Per Route');
				}
				else if ($report_type == 'Consolidated') {
					$sheet->getCell('A3')->setValue($start_date.' - '.$end_date.' CY '.$year);
				}
				else {
					$sheet->getCell('A3')->setValue('CY '.$year);
				}
				$sheet->getCell('A5')->setValue('');
				$sheet->getCell('B5')->setValue('AIRLINE');
				$sheet->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('C5')->setValue('COUNTRY');
				$sheet->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('D5')->setValue('ROUTE');
				$sheet->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('E5')->setValue('Incoming (Kilograms)');
				$sheet->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('F5')->setValue('Outgoing (Kilograms)');
				$sheet->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('G5')->setValue('TOTAL (Kilograms)');
				$sheet->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				if ($a_market_share == 'Market Share') {
					$sheet->getCell('H5')->setValue('MS');
					$sheet->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
				if (empty($get51bAC)) {
					if ($a_market_share == 'Market Share') {
						$sheet->mergeCells('A6:H6');
						$sheet->getCell('A6')->setValue('No Record');
					}
					else {
						$sheet->mergeCells('A6:G6');
						$sheet->getCell('A6')->setValue('No Record');
					}
				}
				$count = 1;
				$totalcargoRev = 0;
				$totalcargoRevDep = 0;
				$grandtotal = 0;
				$totalms = 0;
				$cell_row = 6;
				foreach ($get51bAC as $key => $row) {
					$sheet->getCell('A'.$cell_row)->setValue($count++);
					$sheet->getCell('B'.$cell_row)->setValue($row->name);
					$sheet->getCell('C'.$cell_row)->setValue($row->title);
					$sheet->getCell('D'.$cell_row)->setValue($row->routeTo.'/'.$row->routeFrom);
					$sheet->getCell('E'.$cell_row)->setValue(number_format($row->cargoRev, 2));
					$sheet->getCell('F'.$cell_row)->setValue(number_format($row->cargoRevDep, 2));
					$sheet->getCell('G'.$cell_row)->setValue(number_format($row->total, 2));
					if ($a_market_share == 'Market Share') {
						$sheet->getCell('H'.$cell_row)->setValue('MS');
					}
					$cell_row++;
					$totalcargoRev += $row->cargoRev;
					$totalcargoRevDep += $row->cargoRevDep;
					$grandtotal += $row->total;
					//$totalms += 0;
				}
				$sheet->mergeCells('A'.$cell_row.':D'.$cell_row);
				$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
				$sheet->getCell('E'.$cell_row)->setValue(number_format($totalcargoRev, 2));
				$sheet->getCell('F'.$cell_row)->setValue(number_format($totalcargoRevDep, 2));
				$sheet->getCell('G'.$cell_row)->setValue(number_format($grandtotal, 2));
				if ($a_market_share == 'Market Share') {
					$sheet->getCell('H'.$cell_row)->setValue('MS');
				}
			}
		}
		else if ($category == 'by Country') {
			if ($report_type == 'Quarterly') {
				$sheet->getCell('A3')->setValue($quarter.' CY '.$year);
			}
			else if ($report_type == 'Consolidated') {
				$sheet->getCell('A3')->setValue($start_date.' - '.$end_date.' CY '.$year);
			}
			else {
				$sheet->getCell('A3')->setValue('CY '.$year);
			}

			$sheet->getCell('A5')->setValue('COUNTRY');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('B5')->setValue('AIRLINE/ROUTE');
			$sheet->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('C5')->setValue('TOTAL');
			$sheet->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			if (empty($get51bAC)) {
				$sheet->mergeCells('A6:C6');
				$sheet->getCell('A6')->setValue('No Record');
			}
			
			$grandtotal = 0;
			$cell_row = 6;
			foreach ($get51bAC as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($row->country);
				$sheet->getCell('B'.$cell_row)->setValue($row->name.' '.$row->routeTo.'/'.$row->routeFrom);
				$sheet->getCell('C'.$cell_row)->setValue(number_format($row->total, 2));

				$cell_row++;
				$grandtotal += $row->total;
			}

			$sheet->mergeCells('A'.$cell_row.':B'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('C'.$cell_row)->setValue(number_format($grandtotal, 2));
		}

		else if ($category == 'Historical') {
			$get51bH = $this->report_summary_model->get51BH($start_year, $end_year);
			$sheet->getCell('A3')->setValue('CY '.$start_year.' - '.$end_year);

			$sheet->getCell('A5')->setValue('AIRLINE');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$title_column = 'B';
			for ($a = $start_year; $a <= $end_year; $a++) { 
				$sheet->getCell($title_column.'5')->setValue($a);
				$sheet->getStyle($title_column.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$title_column++;
			}
			if ($h_market_share == 'Market Share') {
				$sheet->getCell($title_column.'5')->setValue('MS');
				$sheet->getStyle($title_column.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			if (empty($get51bH)) {
				$sheet->getCell('A6')->setValue('No Record');
			}
			$cell_row = 6;
			foreach ($get51bH as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($row->name);
				$data_column = 'B';
				$totalperyear = 0;
				$count = 0;
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$get51bHTotal = $this->report_summary_model->get51BHTotal($a, $row->id);
					$sheet->getCell($data_column.$cell_row)->setValue(number_format($get51bHTotal->total, 2));
					$data_column++;
					if ($get51bHTotal) {
						$count++;
						$totalperyear += $get51bHTotal->total;
					}
					else {
						$count = $count;
						$totalperyear = $totalperyear;
					}
				}
				$totalperyear = $totalperyear / ($count);
				$getTotalWeight = $this->report_summary_model->getTotal51BWeight();
				$market_share = ($totalperyear / $getTotalWeight->totalchargeableweight) * 100;
				if ($h_market_share != '') {
					$sheet->getCell($data_column.$cell_row)->setValue(number_format($market_share, 2). '%');
					$sheet->getStyle($data_column.$cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
				$cell_row++;
			}
		}

		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');
		
	}

	public function form_61_a() {
		$data['airlines'] = $this->report_summary_model->get61aAirlines();
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_61_a', $data);
	}

	public function form_61_b() {
		$data['airlines'] = $this->report_summary_model->getAirlines();
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_61_b', $data);
	}

	public function print_form61a_pdf() {
		$print = new print_form61a_pdf('P', 'mm', array(216,330.2));
		$print->setPreviewTitle(MODULE_NAME)
		->setDocumentDetails($this->input->get())
		// ->setSignatory($company_signatory)
		->drawPDF(MODULE_NAME);
	}

	public function form_61b_pdf() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["passenger_cargo"])) {
			$passenger_cargo = $_GET['passenger_cargo'];
			$passenger_cargo = str_replace('+', ' ', $passenger_cargo);
		}
		else {
			$passenger_cargo = '';
		}
		if (!empty($_GET["rank_alpha"])) {
			$rank_alpha = $_GET['rank_alpha'];
			$rank_alpha = str_replace('+', ' ', $rank_alpha);
		}
		else {
			$rank_alpha = '';
		}
		if (!empty($_GET["airline"])) {
			$airline = $_GET['airline'];
			$airline = str_replace('+', ' ', $airline);
		}
		else {
			$airline = '';
		}

		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(335,7,'NON-SCHEDULED DOMESTIC AERIAL AGRICULTURAL SPRAYING SERVICES', 0, 1, 'C');
		$pdf->Cell(335,7,'NON-SCHEDULED DOMESTIC (CHARTERER)', 0, 1, 'C');
		$pdf->Cell(335,7,'AIR TRANSPORTATION SERVICES', 0, 1, 'C');
		$pdf->Cell(335,7,'TRAFFIC AND OPERATING STATISTICS', 0, 1, 'C');
		if ($report_type == 'Quarterly') {
			$pdf->Cell(335,7, $quarter.' CY '.$year, 0, 1, 'C');
		}
		else if ($report_type == 'Consolidated') {
			$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
		}

		$get61bSummary = $this->report_summary_model->get61BSummary($report_type, $quarter, $year, $start_date, $end_date, $rank_alpha, $passenger_cargo);
		if ($category == 'Summary Report') {
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(150,7, 'AIR TAXI OPERATORS', 1, 0, 'C'); 
			$pdf->Cell(90,7, 'PASSENGERS CARRIED', 1, 0, 'C');
			$pdf->Cell(90,7, 'CARGO CARRIED (Kilograms)', 1, 1, 'C');

			$pdf->SetFont('Arial','',9);
			if (empty($get61bSummary)) {
				$pdf->Cell(330,7,"No Record",1,1, 'C');
			}
			$count = 1;
			$totalpassengers_num = 0;
			$totalcargo_qty = 0;
			foreach ($get61bSummary as $key => $row) {
				$pdf->Cell(20,7, $count++, 1,0, 'C');
				$pdf->Cell(130,7, $row->name, 1,0, 'L');
				$pdf->Cell(90,7, number_format($row->passengers_num, 0), 1,0, 'R');
				$pdf->Cell(90,7, number_format($row->cargo_qty, 2), 1,1, 'R');

				$totalpassengers_num += $row->passengers_num;
				$totalcargo_qty += $row->cargo_qty;
			}
			$pdf->setFont('Arial','B',9);
			$pdf->Cell(150,7, 'GRAND TOTAL', 1, 0, 'C');
			$pdf->Cell(90,7, number_format($totalpassengers_num, 0), 1, 0, 'R');
			$pdf->Cell(90,7, number_format($totalcargo_qty, 2), 1, 0, 'R');
		}

		else if ($category == 'Detailed Summary Report') {
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(100,10, 'Air Taxi Operators', 1, 0, 'C'); 
			$pdf->Cell(50,10, 'Locations', 1, 0, 'C');
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Distance', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, 'Travelled (km)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(40,5, 'Flying Time', 1,0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(20,5, 'Hours', 'BLR',0, 'C');
			$pdf->Cell(20,5, 'Minutes', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 40);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Passengers', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, 'Carried', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Cargo Carried', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, '(Kilograms)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Revenue Derived', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, '(Php)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$pdf->Cell(1,10, '', 0,1, 'C');

			$pdf->SetFont('Arial','',9);
			if (empty($get61bSummary)) {
				$pdf->Cell(330,7,"No Record",1,1, 'C');
			}
			$count = 1;
			$totalpassengers_num = 0;
			$totalcargo_qty = 0;
			$totaldistance = 0;
			$totalhours = 0;
			$totalminutes = 0;
			$totalrevenue = 0;
			foreach ($get61bSummary as $key => $row) {
				$pdf->Cell(20,7, $count++, 1,0, 'C');
				$pdf->Cell(80,7, $row->name, 1,0, 'L');
				$pdf->Cell(50,7, $row->origin.'/'.$row->destination, 1,0, 'L');
				$pdf->Cell(35,7, number_format($row->distance, 2), 1, 0, 'R');
				$pdf->Cell(20,7, number_format($row->hours, 2), 1, 0, 'R');
				$pdf->Cell(20,7, number_format($row->minutes, 2), 1, 0, 'R');
				$pdf->Cell(35,7, number_format($row->passengers_num, 0), 1, 0, 'R');
				$pdf->Cell(35,7, number_format($row->cargo_qty, 2), 1, 0, 'R');
				$pdf->Cell(35,7, number_format($row->revenue, 2), 1, 1, 'R');

				$totalpassengers_num += $row->passengers_num;
				$totalcargo_qty += $row->cargo_qty;
				$totaldistance += $row->distance;
				$totalhours += $row->hours;
				$totalminutes += $row->minutes;
				$totalrevenue += $row->revenue;
			}
			$pdf->setFont('Arial','B',9);
			$pdf->Cell(150,7, 'GRAND TOTAL', 1, 0, 'C');
			$pdf->Cell(35,7, number_format($totaldistance, 2), 1, 0, 'R');
			$pdf->Cell(20,7, number_format($totalhours, 2), 1, 0, 'R');
			$pdf->Cell(20,7, number_format($totalminutes, 2), 1, 0, 'R');
			$pdf->Cell(35,7, number_format($totalpassengers_num, 0), 1, 0, 'R');
			$pdf->Cell(35,7, number_format($totalcargo_qty, 2), 1, 0, 'R');
			$pdf->Cell(35,7, number_format($totalrevenue, 2), 1, 1, 'R');
		}

		else {
			$get61bSummaryPerOperator = $this->report_summary_model->get61BSummaryPerOperator($report_type, $quarter, $year, $start_date, $end_date, $airline);
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,10, '', 1, 0, 'C'); 
			$pdf->Cell(30,10, 'Aircraft Type', 1, 0, 'C'); 
			$pdf->Cell(30,10, 'Aircraft Number', 1, 0, 'C'); 
			$pdf->Cell(35,10, 'Origin', 1, 0, 'C');
			$pdf->Cell(35,10, 'Location', 1, 0, 'C');
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Distance', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, 'Travelled (km)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(40,5, 'Flying Time', 1,0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(20,5, 'Hours', 'BLR',0, 'C');
			$pdf->Cell(20,5, 'Minutes', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 40);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Passengers', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, 'Carried', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Cargo Carried', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, '(Kilograms)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(35,5, 'Revenue Derived', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(35,5, '(Php)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 35);
			$pdf->Cell(1,10, '', 0,1, 'C');

			$pdf->SetFont('Arial','',9);
			if (empty($get61bSummaryPerOperator)) {
				$pdf->Cell(330,7,"No Record",1,1, 'C');
			}
			$count = 1;
			$totalpassengers_num = 0;
			$totalcargo_qty = 0;
			$totaldistance = 0;
			$totalhours = 0;
			$totalminutes = 0;
			$totalrevenue = 0;
			foreach ($get61bSummaryPerOperator as $key => $row) {
				$pdf->Cell(20,7, $count++, 1,0, 'C');
				$pdf->Cell(30,7, $row->aircraft, 1,0, 'L');
				$pdf->Cell(30,7, $row->aircraft_num, 1,0, 'L');
				$pdf->Cell(35,7, $row->origin, 1,0, 'L');
				$pdf->Cell(35,7, $row->destination, 1,0, 'L');
				$pdf->Cell(35,7, number_format($row->distance, 2), 1, 0, 'R');
				$pdf->Cell(20,7, number_format($row->flown_hour, 2), 1, 0, 'R');
				$pdf->Cell(20,7, number_format($row->flown_min, 2), 1, 0, 'R');
				$pdf->Cell(35,7, number_format($row->passengers_num, 0), 1, 0, 'R');
				$pdf->Cell(35,7, number_format($row->cargo_qty, 2), 1, 0, 'R');
				$pdf->Cell(35,7, number_format($row->revenue, 2), 1, 1, 'R');

				$totalpassengers_num += $row->passengers_num;
				$totalcargo_qty += $row->cargo_qty;
				$totaldistance += $row->distance;
				$totalhours += $row->flown_hour;
				$totalminutes += $row->flown_min;
				$totalrevenue += $row->revenue;
			}
			$pdf->setFont('Arial','B',9);
			$pdf->Cell(150,7, 'GRAND TOTAL', 1, 0, 'C');
			$pdf->Cell(35,7, number_format($totaldistance, 2), 1, 0, 'R');
			$pdf->Cell(20,7, number_format($totalhours, 2), 1, 0, 'R');
			$pdf->Cell(20,7, number_format($totalminutes, 2), 1, 0, 'R');
			$pdf->Cell(35,7, number_format($totalpassengers_num, 0), 1, 0, 'R');
			$pdf->Cell(35,7, number_format($totalcargo_qty, 2), 1, 0, 'R');
			$pdf->Cell(35,7, number_format($totalrevenue, 2), 1, 1, 'R');
		}

		$pdf->Output();
	}

	public function form_61b_csv() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["passenger_cargo"])) {
			$passenger_cargo = $_GET['passenger_cargo'];
			$passenger_cargo = str_replace('+', ' ', $passenger_cargo);
		}
		else {
			$passenger_cargo = '';
		}
		if (!empty($_GET["rank_alpha"])) {
			$rank_alpha = $_GET['rank_alpha'];
			$rank_alpha = str_replace('+', ' ', $rank_alpha);
		}
		else {
			$rank_alpha = '';
		}
		if (!empty($_GET["airline"])) {
			$airline = $_GET['airline'];
			$airline = str_replace('+', ' ', $airline);
		}
		else {
			$airline = '';
		}

		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Form61b_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Form61b_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Form61b_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form 61B')
				->setDescription('Summary Report Form 61B')
				->setKeywords('summary report fORM 61-b monthly statement of traffic and operating statistics')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form 61B');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		if ($category == 'Summary Report') {
			$sheet->mergeCells('A1:D1');
			$sheet->mergeCells('A2:D2');
			$sheet->mergeCells('A3:D3');
			$sheet->mergeCells('A4:D4');
			$sheet->mergeCells('A5:D5');
		}
		else if ($category == 'Detailed Summary Report') {
			$sheet->mergeCells('A1:M1');
			$sheet->mergeCells('A2:M2');
			$sheet->mergeCells('A3:M3');
			$sheet->mergeCells('A4:M4');
			$sheet->mergeCells('A5:M5');
		}
		else {
			$sheet->mergeCells('A1:O1');
			$sheet->mergeCells('A2:O2');
			$sheet->mergeCells('A3:O3');
			$sheet->mergeCells('A4:O4');
			$sheet->mergeCells('A5:O5');
		}

		$sheet->getCell('A1')->setValue('NON-SCHEDULED DOMESTIC AERIAL AGRICULTURAL SPRAYING SERVICES');
		$sheet->getCell('A2')->setValue('NON-SCHEDULED DOMESTIC (CHARTERER)');
		$sheet->getCell('A3')->setValue('AIR TRANSPORTATION SERVICES');
		$sheet->getCell('A4')->setValue('TRAFFIC AND OPERATING STATISTICS');
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		if ($report_type == 'Quarterly') {
			$sheet->getCell('A5')->setValue($quarter.' CY '.$year.' Summary');
		}
		else if ($report_type == 'Consolidated') {
			$sheet->getCell('A5')->setValue($start_date.' - '.$end_date.' CY '.$year);
		}
		else {
			$sheet->getCell('A5')->setValue('CY '.$year);
		}

		$get61bSummary = $this->report_summary_model->get61BSummary($report_type, $quarter, $year, $start_date, $end_date, $rank_alpha, $passenger_cargo);
		if ($category == 'Summary Report') {
			$sheet->mergeCells('A7:B7');
			$sheet->getCell('A7')->setValue('AIR TAXI OPERATORS');
			$sheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('C7')->setValue('PASSENGERS CARRIED');
			$sheet->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('D7')->setValue('CARGO CARRIED (Kilograms)');
			$sheet->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if (empty($get61bSummary)) {
				$sheet->getCell('A8')->setValue('AIR TAXI OPERATORS');
			}
			$count = 1;
			$totalpassengers_num = 0;
			$totalcargo_qty = 0;
			$cell_row = 8;
			foreach ($get61bSummary as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($count++);
				$sheet->getCell('B'.$cell_row)->setValue($row->name);
				$sheet->getCell('C'.$cell_row)->setValue(number_format($row->passengers_num, 0));
				$sheet->getCell('D'.$cell_row)->setValue(number_format($row->cargo_qty, 2));

				$totalpassengers_num += $row->passengers_num;
				$totalcargo_qty += $row->cargo_qty;
				$cell_row++;
			}
			$sheet->mergeCells('A'.$cell_row.':B'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('C'.$cell_row)->setValue(number_format($totalpassengers_num, 0));
			$sheet->getCell('D'.$cell_row)->setValue(number_format($totalcargo_qty, 2));
		}

		else if ($category == 'Detailed Summary Report') {
			$sheet->mergeCells('A7:B8');
			$sheet->getCell('A7')->setValue('Air Taxi Operators');
			$sheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('C7:C8');
			$sheet->getCell('C7')->setValue('Locations');
			$sheet->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('D7:E8');
			$sheet->getCell('D7')->setValue('Distance Travelled (km)');
			$sheet->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('F7:G7');
			$sheet->getCell('F7')->setValue('Flying Time');
			$sheet->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('F8')->setValue('Hours');
			$sheet->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('G8')->setValue('Minutes');
			$sheet->getStyle('G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('H7:I8');
			$sheet->getCell('H7')->setValue('Passengers Carried');
			$sheet->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('J7:K8');
			$sheet->getCell('J7')->setValue('Cargo Carried (Kilograms)');
			$sheet->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('L7:M8');
			$sheet->getCell('L7')->setValue('Revenue Derived (Php)');
			$sheet->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if (empty($get61bSummary)) {
				$sheet->getCell('A9')->setValue('No Record)');
			}
			$count = 1;
			$totalpassengers_num = 0;
			$totalcargo_qty = 0;
			$totaldistance = 0;
			$totalhours = 0;
			$totalminutes = 0;
			$totalrevenue = 0;
			$cell_row = 9;
			foreach ($get61bSummary as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($count++);
				$sheet->getCell('B'.$cell_row)->setValue($row->name);
				$sheet->getCell('C'.$cell_row)->setValue($row->origin.'/'.$row->destination);
				$sheet->mergeCells('D'.$cell_row.':E'.$cell_row);
				$sheet->getCell('D'.$cell_row)->setValue(number_format($row->distance, 2));
				$sheet->getCell('F'.$cell_row)->setValue(number_format($row->hours, 2));
				$sheet->getCell('G'.$cell_row)->setValue(number_format($row->minutes, 2));
				$sheet->mergeCells('H'.$cell_row.':I'.$cell_row);
				$sheet->getCell('H'.$cell_row)->setValue(number_format($row->passengers_num, 0));
				$sheet->mergeCells('J'.$cell_row.':K'.$cell_row);
				$sheet->getCell('J'.$cell_row)->setValue(number_format($row->cargo_qty, 2));
				$sheet->mergeCells('L'.$cell_row.':M'.$cell_row);
				$sheet->getCell('L'.$cell_row)->setValue(number_format($row->revenue, 2));

				$totalpassengers_num += $row->passengers_num;
				$totalcargo_qty += $row->cargo_qty;
				$totaldistance += $row->distance;
				$totalhours += $row->hours;
				$totalminutes += $row->minutes;
				$totalrevenue += $row->revenue;
				$cell_row++;
			}

			$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->mergeCells('D'.$cell_row.':E'.$cell_row);
			$sheet->getCell('D'.$cell_row)->setValue(number_format($totaldistance, 2));
			$sheet->getCell('F'.$cell_row)->setValue(number_format($totalhours, 2));
			$sheet->getCell('G'.$cell_row)->setValue(number_format($totalminutes, 2));
			$sheet->mergeCells('H'.$cell_row.':I'.$cell_row);
			$sheet->getCell('H'.$cell_row)->setValue(number_format($totalpassengers_num, 0));
			$sheet->mergeCells('J'.$cell_row.':K'.$cell_row);
			$sheet->getCell('J'.$cell_row)->setValue(number_format($totalcargo_qty, 2));
			$sheet->mergeCells('L'.$cell_row.':M'.$cell_row);
			$sheet->getCell('L'.$cell_row)->setValue(number_format($totalrevenue, 2));
		}

		else {
			$get61bSummaryPerOperator = $this->report_summary_model->get61BSummaryPerOperator($report_type, $quarter, $year, $start_date, $end_date, $airline);
			$sheet->mergeCells('A7:A8');
			$sheet->getCell('A7')->setValue('');
			$sheet->mergeCells('B7:B8');
			$sheet->getCell('B7')->setValue('Aircraft Type');
			$sheet->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('C7:C8');
			$sheet->getCell('C7')->setValue('Aircraft Number');
			$sheet->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('D7:D8');
			$sheet->getCell('D7')->setValue('Origin');
			$sheet->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('E7:E8');
			$sheet->getCell('E7')->setValue('Location');
			$sheet->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('F7:G8');
			$sheet->getCell('F7')->setValue('Distance Travelled (km)');
			$sheet->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('H7:I7');
			$sheet->getCell('H7')->setValue('Flying Time');
			$sheet->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('H8')->setValue('Hours');
			$sheet->getStyle('H8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('I8')->setValue('Minutes');
			$sheet->getStyle('I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('J7:K8');
			$sheet->getCell('J7')->setValue('Passengers Carried');
			$sheet->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('L7:M8');
			$sheet->getCell('L7')->setValue('Cargo Carried (Kilograms)');
			$sheet->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('N7:O8');
			$sheet->getCell('N7')->setValue('Revenue Derived (Php)');
			$sheet->getStyle('N7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if (empty($get61bSummaryPerOperator)) {
				$sheet->getCell('A9')->setValue('No Record');
			}
			$count = 1;
			$totalpassengers_num = 0;
			$totalcargo_qty = 0;
			$totaldistance = 0;
			$totalhours = 0;
			$totalminutes = 0;
			$totalrevenue = 0;
			$cell_row = 9;
			foreach ($get61bSummaryPerOperator as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($count++);
				$sheet->getCell('B'.$cell_row)->setValue($row->aircraft);
				$sheet->getCell('C'.$cell_row)->setValue($row->aircraft_num);
				$sheet->getCell('D'.$cell_row)->setValue($row->origin);
				$sheet->getCell('E'.$cell_row)->setValue($row->destination);
				$sheet->mergeCells('F'.$cell_row.':G'.$cell_row);
				$sheet->getCell('F'.$cell_row)->setValue(number_format($row->distance, 2));
				$sheet->getCell('H'.$cell_row)->setValue(number_format($row->flown_hour, 2));
				$sheet->getCell('I'.$cell_row)->setValue(number_format($row->flown_min, 2));
				$sheet->mergeCells('J'.$cell_row.':K'.$cell_row);
				$sheet->getCell('J'.$cell_row)->setValue(number_format($row->passengers_num, 0));
				$sheet->mergeCells('L'.$cell_row.':M'.$cell_row);
				$sheet->getCell('L'.$cell_row)->setValue(number_format($row->cargo_qty, 2));
				$sheet->mergeCells('N'.$cell_row.':O'.$cell_row);
				$sheet->getCell('N'.$cell_row)->setValue(number_format($row->revenue, 2));

				$totalpassengers_num += $row->passengers_num;
				$totalcargo_qty += $row->cargo_qty;
				$totaldistance += $row->distance;
				$totalhours += $row->flown_hour;
				$totalminutes += $row->flown_min;
				$totalrevenue += $row->revenue;
				$cell_row++;
			}

			$sheet->mergeCells('A'.$cell_row.':E'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->mergeCells('F'.$cell_row.':G'.$cell_row);
			$sheet->getCell('F'.$cell_row)->setValue(number_format($totaldistance, 2));
			$sheet->getCell('H'.$cell_row)->setValue(number_format($totalhours, 2));
			$sheet->getCell('I'.$cell_row)->setValue(number_format($totalminutes, 2));
			$sheet->mergeCells('J'.$cell_row.':K'.$cell_row);
			$sheet->getCell('J'.$cell_row)->setValue(number_format($totalpassengers_num, 0));
			$sheet->mergeCells('L'.$cell_row.':M'.$cell_row);
			$sheet->getCell('L'.$cell_row)->setValue(number_format($totalcargo_qty, 2));
			$sheet->mergeCells('N'.$cell_row.':O'.$cell_row);
			$sheet->getCell('N'.$cell_row)->setValue(number_format($totalrevenue, 2));
		}

		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');
	}

	public function form_71_b() {
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_71_b', $data);
	}

	public function form_71b_pdf() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["rank"])) {
			$rank = $_GET['rank'];
			$rank = str_replace('+', ' ', $rank);
		}
		else {
			$rank = '';
		}
		if (!empty($_GET["rank_category"])) {
			$rank_category = $_GET['rank_category'];
			$rank_category = str_replace('+', ' ', $rank_category);
		}
		else {
			$rank_category = '';
		}

		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);
		if ($rank == 'Top 30') {
			$pdf->Cell(335,7,'TOP 30 DOMESTIC AIRFREIGHT FORWARDERS', 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7,'DOMESTIC AIRFREIGHT FORWARDERS', 0, 1, 'C');
		}
		$pdf->Cell(335,7,'CARGO TRAFFIC FLOW STATISTICS', 0, 1, 'C');
		$pdf->Cell(335,7,'CHARGEABLE WEIGHT IN (Kilograms)', 0, 1, 'C');
		if ($rank == 'By Country') {
			$pdf->Cell(335,7,'by Country', 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7,'', 0, 1, 'C');
		}
		if ($report_type == 'Quarterly') {
			$pdf->Cell(335,7, $quarter.' CY '.$year, 0, 1, 'C');
		}
		else if ($report_type == 'Consolidated') {
			$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
		}
		$pdf->Cell(335,7,'', 0, 1, 'C');
		if ($category == 'Ranking') {
			if ($rank_category == 'Direct Shipment') {
				$market_share = (!empty($_GET['ds_market_share'])) ? $_GET['ds_market_share'] : '';
				$cmarket_share = (!empty($_GET['ds_cmarket_share'])) ? $_GET['ds_cmarket_share'] : '';
				$rank_category_label = 'DIRECT SHIPMENT';
			}
			else if ($rank_category == 'Consolidation') {
				$market_share = (!empty($_GET['c_market_share'])) ? $_GET['c_market_share'] : '';
				$cmarket_share = (!empty($_GET['c_cmarket_share'])) ? $_GET['c_cmarket_share'] : '';
				$rank_category_label = 'CONSOLIDATION';
			}
			else if ($rank_category == 'Breakbulking') {
				$market_share = (!empty($_GET['b_market_share'])) ? $_GET['b_market_share'] : '';
				$cmarket_share = (!empty($_GET['b_cmarket_share'])) ?$_GET['b_cmarket_share'] : '';
				$rank_category_label = 'BREAKBULKING';
			}
			else {
				$market_share = (!empty($_GET['t_market_share'])) ? $_GET['t_market_share'] : '';
				$cmarket_share = (!empty($_GET['t_cmarket_share'])) ? $_GET['t_cmarket_share'] : '';
				$rank_category_label = 'CARGO WT In / Out';
			}
			$get71bRank = $this->report_summary_model->get71BRanked($report_type, $quarter, $year, $start_date, $end_date, $rank_category, $rank);
			if (($rank == 'All') || ($rank == 'Top 30')) {
				if (($market_share == '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(200, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(130, 10, $rank_category_label, 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					foreach ($get71bRank as $key => $row) { 
						$pdf->Cell(200,7, $row->name, 1,0, 'L');
						$pdf->Cell(130,7, $row->weight, 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(90, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(80, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(80, 10, 'Market Share (%)', 1, 0, 'C');
					$pdf->Cell(80, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$market_share = 0;
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(90,7, $row->name, 1,0, 'L');
						$pdf->Cell(80,7, number_format($row->weight, 2), 1,0, 'R');
						$pdf->Cell(80,7, number_format($market_share, 2).'%', 1,0, 'R');
						$pdf->Cell(80,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(130, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(100, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(100, 10, 'Market Share (%)', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
						$pdf->Cell(130,7, $row->name, 1,0, 'L');
						$pdf->Cell(100,7, number_format($row->weight, 2), 1,0, 'R');
						$pdf->Cell(100,7, number_format($market_share, 2).'%', 1,1, 'R');
					}
				}
				else {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(130, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(100, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(100, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(130,7, $row->name, 1,0, 'L');
						$pdf->Cell(100,7, number_format($row->weight, 2), 1,0, 'R');
						$pdf->Cell(100,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
			}
			else {
				if (($market_share == '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(100, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(100, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(130, 10, $rank_category_label, 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					foreach ($get71bRank as $key => $row) {
						$pdf->Cell(100,7, $row->country, 1,0, 'L');
						$pdf->Cell(100,7, $row->name, 1,0, 'L');
						$pdf->Cell(130,7, number_format($row->weight, 2), 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(70, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(70, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(70, 10, $rank_category_label, 1, 1, 'C');
					$pdf->Cell(60, 10, 'Market Share (%)', 1, 0, 'C');
					$pdf->Cell(60, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$market_share = 0;
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(70,7, $row->country, 1,0, 'L');
						$pdf->Cell(70,7, $row->name, 1,0, 'L');
						$pdf->Cell(70,7, number_format($row->weight, 2), 1,0, 'R');
						$pdf->Cell(60,7, number_format($market_share, 2).'%', 1,0, 'R');
						$pdf->Cell(60,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(90, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(90, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(75, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(75, 10, 'Market Share (%)', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
						$pdf->Cell(90,7, $row->country, 1,0, 'L');
						$pdf->Cell(90,7, $row->name, 1,0, 'L');
						$pdf->Cell(75,7, number_format($row->weight, 2), 1,0, 'R');
						$pdf->Cell(75,7, number_format($market_share, 2).'%', 1,1, 'R');
					}
				}
				else {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(90, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(90, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(75, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(75, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71bRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(90,7, $row->country, 1,0, 'L');
						$pdf->Cell(90,7, $row->name, 1,0, 'L');
						$pdf->Cell(75,7, number_format($row->weight, 2), 1,0, 'R');
						$pdf->Cell(75,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
			}
			$pdf->SetFont('Arial','B',9);
			if ($report_type == 'Quarterly') {
				$pdf->Cell(65,7, '', 0, 0, 'C');
				$pdf->Cell(200,7, 'Cargo Statistics for ' .$quarter.' CY '.$year, 'TLR', 1, 'C');
			}
			else if ($report_type == 'Consolidated') {
				$pdf->Cell(65,7, '', 0, 0, 'C');
				$pdf->Cell(200,7, 'Cargo Statistics for ' .$start_date.' - '.$end_date.' CY '.$year, 'TLR', 1, 'C');
			}
			else {
				$pdf->Cell(65,7, '', 0, 0, 'C');
				$pdf->Cell(200,7, 'Cargo Statistics for CY '.$year, 'TLR', 1, 'C');
			}
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(200,5, 'Chargeable Weight in Kilograms', 'LR', 1, 'C');

			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'L', 0, 'C');
			$pdf->Cell(50,5, 'Direct Shipments', 0, 0, 'L');
			$pdf->Cell(85,5, '0.00', 'R', 1, 'L');

			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'L', 0, 'C');
			$pdf->Cell(50,5, 'Consolidations', 0, 0, 'L');
			$pdf->Cell(85,5, '140,779.00', 'R', 1, 'L');

			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'L', 0, 'C');	
			$pdf->Cell(50,5, 'Breakbulking', 0, 0, 'L');
			$pdf->Cell(85,5, '0.00', 'R', 1, 'L');

			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'BL', 0, 'C');
			$pdf->Cell(50,5, 'TOTAL', 'B', 0, 'L');
			$pdf->Cell(85,5, '0.00', 'BR', 1, 'L');
		}
		else {
			$get71bSummary = $this->report_summary_model->get71bSummary($report_type, $quarter, $year, $start_date, $end_date);
			$ds_summary1 = (!empty($_GET["ds_summary1"]))? $_GET['ds_summary1'] : '';
			$ds_summary2 = (!empty($_GET["ds_summary2"]))? $_GET['ds_summary2'] : '';
			$ds_summary3 = (!empty($_GET["ds_summary3"]))? $_GET['ds_summary3'] : '';
			$ds_summary4 = (!empty($_GET["ds_summary4"]))? $_GET['ds_summary4'] : '';

			$c_summary1 = (!empty($_GET["c_summary1"]))? $_GET['c_summary1'] : '';
			$c_summary2 = (!empty($_GET["c_summary2"]))? $_GET['c_summary2'] : '';
			$c_summary3 = (!empty($_GET["c_summary3"]))? $_GET['c_summary3'] : '';
			$c_summary4 = (!empty($_GET["c_summary4"]))? $_GET['c_summary4'] : '';
			$c_summary5 = (!empty($_GET["c_summary5"]))? $_GET['c_summary5'] : '';

			$b_summary1 = (!empty($_GET["b_summary1"]))? $_GET['b_summary1'] : '';
			$b_summary2 = (!empty($_GET["b_summary2"]))? $_GET['b_summary2'] : '';
			$b_summary3 = (!empty($_GET["b_summary3"]))? $_GET['b_summary3'] : '';

			$direct_shipment = (!empty($_GET["direct_shipment"]))? $_GET['direct_shipment'] : '';
			$consolidation = (!empty($_GET["consolidation"]))? $_GET['consolidation'] : '';
			$breakbulking = (!empty($_GET["breakbulking"]))? $_GET['breakbulking'] : '';

			if (($ds_summary1 == '') && ($ds_summary2 == '') && ($ds_summary3 == '') && ($ds_summary4 == '')) {
				$direct_shipment = '';
			}
			if (($c_summary1 == '') && ($c_summary2 == '') && ($c_summary3 == '') && ($c_summary4 == '') && ($c_summary5 == '')) {
				$consolidation = '';
			}
			if (($b_summary1 == '') && ($b_summary2 == '') && ($b_summary3 == '')) {
				$breakbulking = '';
			}
			
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(50,5, '', 'TLR', 0, 'C');
			$dl = 0;
			$cl = 0;
			$bl = 0;
			if ($ds_summary1 != '') {
				$dl = $dl + 25;
			} 
			if ($ds_summary2 != '') {
				$dl = $dl + 25;
			} 
			if ($ds_summary3 != '') {
				$dl = $dl + 25;
			}
			if ($ds_summary4 != '') {
				$dl = $dl + 25;
			}  
			if ($c_summary1 != '') {
				$cl = $cl + 20;
			} 
			if ($c_summary2 != '') {
				$cl = $cl + 20;
			} 
			if ($c_summary3 != '') {
				$cl = $cl + 20;
			}
			if ($c_summary4 != '') {
				$cl = $cl + 20;
			} 
			if ($c_summary5 != '') {
				$cl = $cl + 20;
			} 
			if ($b_summary1 != '') {
				$bl = $bl + 25;
			} 
			if ($b_summary2 != '') {
				$bl = $bl + 25;
			} 
			if ($b_summary3 != '') {
				$bl = $bl + 25;
			}  
			if (($direct_shipment != '') && (($consolidation != '') OR ($breakbulking != ''))){
				$pdf->Cell($dl,5, 'Direct Shipment', 1,0, 'C');
			}
			else if (($direct_shipment != '') && (($consolidation == '') && ($breakbulking == ''))){
				$pdf->Cell($dl,5, 'Direct Shipment', 1,1, 'C');
			}
			else {

			}
			if (($consolidation != '') && ($breakbulking != '')){
				$pdf->Cell($cl,5, 'Consolidation', 1,0, 'C');
			}
			else if (($consolidation != '') && ($breakbulking == '')){
				$pdf->Cell($cl,5, 'Consolidation', 1,1, 'C');
			}
			else {

			}
			if ($breakbulking != ''){
				$pdf->Cell($bl,5, 'Breakbulking', 1,1, 'C');
			}
			else {

			}
			$pdf->Cell(50,10, 'Name of Airfreight Forwarder', 'BLR', 0, 'C');
			if ($ds_summary1 != '') {
				$pdf->Cell(25,10, 'MAWBs', 1, 0, 'C');
			}
			if ($ds_summary2 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Chargeable', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Weight (kg)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if ($ds_summary3 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Freight', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Charges (Php)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if ($ds_summary4 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Commission', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Earned (Php)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if (($consolidation != '') OR ($breakbulking != '')) {
				$pdf->Cell(0.1, 10, '', 0, 0, 'C');
			}
			else if (($consolidation == '') OR ($breakbulking == '')){
				$pdf->Cell(0.1, 10, '', 0, 1, 'C');
			}
			if ($c_summary1 != '') {
				$pdf->Cell(20,10, 'MAWBs', 1, 0, 'C');
			}
			if ($c_summary2 != '') {
				$pdf->Cell(20,10, 'MAWBs', 1, 0, 'C');
			}
			if ($c_summary3 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(20,5, 'Chargeable', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(20,5, 'Weight (kg)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 20);
			}
			if ($c_summary4 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(20,5, 'Freight', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(20,5, 'Charges', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 20);
			}
			if ($c_summary5 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(20,5, 'Gross', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(20,5, 'Revenue', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 20);
			}
			if ($breakbulking != '') {
				$pdf->Cell(0.1, 10, '', 0, 0, 'C');
			}
			else if (($consolidation == '') && ($breakbulking == '')) {
				
			}
			else if (($consolidation != '') && ($breakbulking == '')){
				$pdf->Cell(0.1, 10, '', 0, 1, 'C');
			}
			if ($b_summary1 != '') {
				$pdf->Cell(25,10, 'HAWBs', 1, 0, 'C');
			}
			if ($b_summary2 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Chargeable', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Weight (kg)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if ($b_summary3 != '') {
				$pdf->Cell(25,10, 'Income (Php)', 1, 0, 'C');
			}
			if ($breakbulking != '') {
				$pdf->Cell(0.1, 10, '', 0, 1, 'C');
			}
			$totalnumMawbs1 = 0;
			$totalweight1 = 0;
			$totalfcharge1 = 0;
			$totalcommission = 0;
			$totalnumMawbs2 = 0;
			$totalnumHawbs1 = 0;
			$totalweight2 = 0;
			$totalfcharge2 = 0;
			$totalrevenue = 0;
			$totalnumHawbs2 = 0;
			$totalorgWeight = 0;
			$totalincomeBreak = 0;
			$pdf->SetFont('Arial', '', 9);
			foreach ($get71bSummary as $key => $row) {
				$pdf->Cell(50,7, $row->name, 1,0, 'L');
				if ($ds_summary1 != '') {
					$pdf->Cell(25,7, number_format($row->numMawbs1, 2), 1,0, 'R');
				}
				if ($ds_summary2 != '') {
					$pdf->Cell(25,7, number_format($row->weight1, 2), 1,0, 'R');;
				}
				if ($ds_summary3 != '') {
					$pdf->Cell(25,7, number_format($row->fcharge1, 2), 1,0, 'R');;
				}
				if ($ds_summary4 != '') {
					$pdf->Cell(25,7, number_format($row->commission, 2), 1,0, 'R');;
				}
				if (($consolidation != '') OR ($breakbulking != '')) {
					$pdf->Cell(0.1, 7, '', 0, 0, 'C');
				}
				else if (($consolidation == '') OR ($breakbulking == '')){
					$pdf->Cell(0.1, 7, '', 0, 1, 'C');
				}
				if ($c_summary1 != '') {
					$pdf->Cell(20,7, number_format($row->numMawbs2, 2), 1,0, 'R');
				}
				if ($c_summary2 != '') {
					$pdf->Cell(20,7, number_format($row->numHawbs1, 2), 1,0, 'R');;
				}
				if ($c_summary3 != '') {
					$pdf->Cell(20,7, number_format($row->weight2, 2), 1,0, 'R');;
				}
				if ($c_summary4 != '') {
					$pdf->Cell(20,7, number_format($row->fcharge2, 2), 1,0, 'R');;
				}
				if ($c_summary5 != '') {
					$pdf->Cell(20,7, number_format($row->revenue, 2), 1,0, 'R');;
				}
				if ($breakbulking != '') {
					$pdf->Cell(0.1, 7, '', 0, 0, 'C');
				}
				else if (($consolidation == '') && ($breakbulking == '')) {
					
				}
				else if (($consolidation != '') && ($breakbulking == '')){
					$pdf->Cell(0.1, 7, '', 0, 1, 'C');
				}
				if ($b_summary1 != '') {
					$pdf->Cell(25,7, number_format($row->numHawbs2, 2), 1,0, 'R');
				}
				if ($b_summary2 != '') {
					$pdf->Cell(25,7, number_format($row->orgWeight, 2), 1,0, 'R');;
				}
				if ($b_summary3 != '') {
					$pdf->Cell(25,7, number_format($row->incomeBreak, 2), 1,0, 'R');;
				}
				if ($breakbulking != '') {
					$pdf->Cell(0.1, 7, '', 0, 1, 'C');
				}
				$totalnumMawbs1 += $row->numMawbs1;
				$totalweight1 += $row->weight1;
				$totalfcharge1 += $row->fcharge1;
				$totalcommission += $row->commission;
				$totalnumMawbs2 += $row->numMawbs2;
				$totalnumHawbs1 += $row->numHawbs1;
				$totalweight2 += $row->weight2;
				$totalfcharge2 += $row->fcharge2;
				$totalrevenue += $row->revenue;
				$totalnumHawbs2 += $row->numHawbs2;
				$totalorgWeight += $row->orgWeight;
				$totalincomeBreak += $row->incomeBreak;
			}
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(50,7, 'GRAND TOTAL:', 1,0, 'C');
			if ($ds_summary1 != '') {
				$pdf->Cell(25,7, number_format($totalnumMawbs1, 2), 1,0, 'R');
			}
			if ($ds_summary2 != '') {
				$pdf->Cell(25,7, number_format($totalweight1, 2), 1,0, 'R');;
			}
			if ($ds_summary3 != '') {
				$pdf->Cell(25,7, number_format($totalfcharge1, 2), 1,0, 'R');;
			}
			if ($ds_summary4 != '') {
				$pdf->Cell(25,7, number_format($totalcommission, 2), 1,0, 'R');;
			}
			if ($c_summary1 != '') {
				$pdf->Cell(20,7, number_format($totalnumMawbs2, 2), 1,0, 'R');
			}
			if ($c_summary2 != '') {
				$pdf->Cell(20,7, number_format($totalnumHawbs1, 2), 1,0, 'R');;
			}
			if ($c_summary3 != '') {
				$pdf->Cell(20,7, number_format($totalweight2, 2), 1,0, 'R');;
			}
			if ($c_summary4 != '') {
				$pdf->Cell(20,7, number_format($totalfcharge2, 2), 1,0, 'R');;
			}
			if ($c_summary5 != '') {
				$pdf->Cell(20,7, number_format($totalrevenue, 2), 1,0, 'R');;
			}
			if ($b_summary1 != '') {
				$pdf->Cell(25,7, number_format($totalnumHawbs2, 2), 1,0, 'R');
			}
			if ($b_summary2 != '') {
				$pdf->Cell(25,7, number_format($totalorgWeight, 2), 1,0, 'R');;
			}
			if ($b_summary3 != '') {
				$pdf->Cell(25,7, number_format($totalincomeBreak, 2), 1,0, 'R');;
			}

		}

		$pdf->Output();
	}

	public function form_71b_csv() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["rank"])) {
			$rank = $_GET['rank'];
			$rank = str_replace('+', ' ', $rank);
		}
		else {
			$rank = '';
		}
		if (!empty($_GET["rank_category"])) {
			$rank_category = $_GET['rank_category'];
			$rank_category = str_replace('+', ' ', $rank_category);
		}
		else {
			$rank_category = '';
		}

		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Form71b_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Form71b_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Form71b_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form 71B')
				->setDescription('Summary Report Form 71B')
				->setKeywords('summary report fORM 71-b domestic airfreight forwarder cargo production report')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form 71B');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		if ($category == 'Ranking') {
			$sheet->mergeCells('A1:D1');
			$sheet->mergeCells('A2:D2');
			$sheet->mergeCells('A3:D3');
			$sheet->mergeCells('A4:D4');
			$sheet->mergeCells('A5:D5');
		}
		else {
			$sheet->mergeCells('A1:AC1');
			$sheet->mergeCells('A2:AC2');
			$sheet->mergeCells('A3:AC3');
			$sheet->mergeCells('A4:AC4');
			$sheet->mergeCells('A5:AC5');
		}

		if ($rank == 'Top 30') {
			$sheet->getCell('A1')->setValue('TOP 30 DOMESTIC AIRFREIGHT FORWARDERS');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else {
			$sheet->getCell('A1')->setValue('DOMESTIC AIRFREIGHT FORWARDERS');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		$sheet->getCell('A2')->setValue('CARGO TRAFFIC FLOW STATISTICS');
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getCell('A3')->setValue('CHARGEABLE WEIGHT IN (Kilograms)');
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		if ($rank == 'By Country') {
			$sheet->getCell('A4')->setValue('by Country');
			$sheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		if ($report_type == 'Quarterly') {
			$sheet->getCell('A5')->setValue($quarter.' CY '.$year.' Summary');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if ($report_type == 'Consolidated') {
			$sheet->getCell('A5')->setValue($start_date.' - '.$end_date.' CY '.$year);
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else {
			$sheet->getCell('A5')->setValue('CY '.$year);
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		$sheet->getStyle('A7:D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		if ($category == 'Ranking') {
			if ($rank_category == 'Direct Shipment') {
				$market_share = (!empty($_GET['ds_market_share'])) ? $_GET['ds_market_share'] : '';
				$cmarket_share = (!empty($_GET['ds_cmarket_share'])) ? $_GET['ds_cmarket_share'] : '';
				$rank_category_label = 'DIRECT SHIPMENT';
			}
			else if ($rank_category == 'Consolidation') {
				$market_share = (!empty($_GET['c_market_share'])) ? $_GET['c_market_share'] : '';
				$cmarket_share = (!empty($_GET['c_cmarket_share'])) ? $_GET['c_cmarket_share'] : '';
				$rank_category_label = 'CONSOLIDATION';
			}
			else if ($rank_category == 'Breakbulking') {
				$market_share = (!empty($_GET['b_market_share'])) ? $_GET['b_market_share'] : '';
				$cmarket_share = (!empty($_GET['b_cmarket_share'])) ?$_GET['b_cmarket_share'] : '';
				$rank_category_label = 'BREAKBULKING';
			}
			else {
				$market_share = (!empty($_GET['t_market_share'])) ? $_GET['t_market_share'] : '';
				$cmarket_share = (!empty($_GET['t_cmarket_share'])) ? $_GET['t_cmarket_share'] : '';
				$rank_category_label = 'CARGO WT In / Out';
			}
			$get71bRank = $this->report_summary_model->get71BRanked($report_type, $quarter, $year, $start_date, $end_date, $rank_category, $rank);
			if (($rank == 'All') || ($rank == 'Top 30')) {
				if (($market_share == '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71bRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue($row->weight);
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					$sheet->getCell('C7')->setValue('Market Share (%)');
					$sheet->getCell('D7')->setValue('Cumulative Market Share');
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					$market_share = 0;
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue(number_format($row->weight, 2));
						$sheet->getCell('C'.$cell_row)->setValue(number_format($market_share, 2).'%');
						$sheet->getCell('D'.$cell_row)->setValue(number_format($cum_share, 2).'%');
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					$sheet->getCell('C7')->setValue('Market Share (%)');
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue(number_format($row->weight, 2));
						$sheet->getCell('C'.$cell_row)->setValue(number_format($market_share, 2).'%');
						$cell_row++;
					}
				}
				else {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					$sheet->getCell('C7')->setValue('Cumulative Market Share');
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue(number_format($row->weight, 2));
						$sheet->getCell('C'.$cell_row)->setValue(number_format($cum_share, 2).'%');
						$cell_row++;
					}
				}
			}
			else {
				if (($market_share == '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71bRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue(number_format($row->weight, 2));
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					$sheet->getCell('D7')->setValue('Market Share (%)');
					$sheet->getCell('E7')->setValue('Cumulative Market Share');
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					$market_share = 0;
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;

						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue(number_format($row->weight, 2));
						$sheet->getCell('D'.$cell_row)->setValue(number_format($market_share, 2).'%');
						$sheet->getCell('E'.$cell_row)->setValue(number_format($cum_share, 2).'%');
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					$sheet->getCell('D7')->setValue('Market Share (%)');
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;

						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue(number_format($row->weight, 2));
						$sheet->getCell('D'.$cell_row)->setValue(number_format($market_share, 2).'%');
						$cell_row++;
					}
				}
				else {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					$sheet->getCell('D7')->setValue('Cumulative Market Share');
					if (empty($get71bRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					$cum_share = 0;
					foreach ($get71bRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71BWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;

						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue(number_format($row->weight, 2));
						$sheet->getCell('D'.$cell_row)->setValue(number_format($cum_share, 2).'%');
						$cell_row++;
					}
				}
			}
		}
		else {
			$get71bSummary = $this->report_summary_model->get71bSummary($report_type, $quarter, $year, $start_date, $end_date);
			$ds_summary1 = (!empty($_GET["ds_summary1"]))? $_GET['ds_summary1'] : '';
			$ds_summary2 = (!empty($_GET["ds_summary2"]))? $_GET['ds_summary2'] : '';
			$ds_summary3 = (!empty($_GET["ds_summary3"]))? $_GET['ds_summary3'] : '';
			$ds_summary4 = (!empty($_GET["ds_summary4"]))? $_GET['ds_summary4'] : '';

			$c_summary1 = (!empty($_GET["c_summary1"]))? $_GET['c_summary1'] : '';
			$c_summary2 = (!empty($_GET["c_summary2"]))? $_GET['c_summary2'] : '';
			$c_summary3 = (!empty($_GET["c_summary3"]))? $_GET['c_summary3'] : '';
			$c_summary4 = (!empty($_GET["c_summary4"]))? $_GET['c_summary4'] : '';
			$c_summary5 = (!empty($_GET["c_summary5"]))? $_GET['c_summary5'] : '';

			$b_summary1 = (!empty($_GET["b_summary1"]))? $_GET['b_summary1'] : '';
			$b_summary2 = (!empty($_GET["b_summary2"]))? $_GET['b_summary2'] : '';
			$b_summary3 = (!empty($_GET["b_summary3"]))? $_GET['b_summary3'] : '';

			$sheet->mergeCells('A7:C8');
			$sheet->getCell('A7')->setValue('NAME OF AIRFREIGHT FORWARDER');
			$sheet->getStyle('A7:AC8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('D7:M7');
			$sheet->getCell('D7')->setValue('Direct Shipment');
			$sheet->getCell('D8')->setValue('MAWBs');
			$sheet->mergeCells('E8:G8');
			$sheet->getCell('E8')->setValue('Chargeable Weight (kg)');
			$sheet->mergeCells('H8:J8');
			$sheet->getCell('H8')->setValue('Airline Freight Charges (Php)');
			$sheet->mergeCells('K8:M8');
			$sheet->getCell('K8')->setValue('Commission Earned (Php)');
			$sheet->mergeCells('N7:X7');
			$sheet->getCell('N7')->setValue('Consolidation');
			$sheet->getCell('N8')->setValue('MAWBs');
			$sheet->getCell('O8')->setValue('HAWBs');
			$sheet->mergeCells('P8:R8');
			$sheet->getCell('P8')->setValue('Chargeable Weight (kg)');
			$sheet->mergeCells('S8:U8');
			$sheet->getCell('S8')->setValue('Airline Freight Charges (Php)');
			$sheet->mergeCells('V8:X8');
			$sheet->getCell('V8')->setValue('Gross Consolidated Revenue (Php)');
			$sheet->mergeCells('Y7:AC7');
			$sheet->getCell('Y7')->setValue('Breakbulking');
			$sheet->getCell('Y8')->setValue('HAWBS');
			$sheet->mergeCells('Z8:AB8');
			$sheet->getCell('Z8')->setValue('Chargeable Weight (kg)');
			$sheet->getCell('AC8')->setValue('Income (Php)');

			$totalnumMawbs1 = 0;
			$totalweight1 = 0;
			$totalfcharge1 = 0;
			$totalcommission = 0;
			$totalnumMawbs2 = 0;
			$totalnumHawbs1 = 0;
			$totalweight2 = 0;
			$totalfcharge2 = 0;
			$totalrevenue = 0;
			$totalnumHawbs2 = 0;
			$totalorgWeight = 0;
			$totalincomeBreak = 0;
			$cell_row = 9;

			foreach ($get71bSummary as $key => $row) {
				$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
				$sheet->getCell('A'.$cell_row)->setValue($row->name);
				$sheet->getCell('D'.$cell_row)->setValue(number_format($row->numMawbs1, 2));
				$sheet->mergeCells('E'.$cell_row.':G'.$cell_row);
				$sheet->getCell('E'.$cell_row)->setValue(number_format($row->weight1, 2));
				$sheet->mergeCells('H'.$cell_row.':J'.$cell_row);
				$sheet->getCell('H'.$cell_row)->setValue(number_format($row->fcharge1, 2));
				$sheet->mergeCells('K'.$cell_row.':M'.$cell_row);
				$sheet->getCell('K'.$cell_row)->setValue(number_format($row->commission, 2));
				$sheet->getCell('N'.$cell_row)->setValue(number_format($row->numMawbs2, 2));
				$sheet->getCell('O'.$cell_row)->setValue(number_format($row->numHawbs1, 2));
				$sheet->mergeCells('P'.$cell_row.':R'.$cell_row);
				$sheet->getCell('P'.$cell_row)->setValue(number_format($row->weight2, 2));
				$sheet->mergeCells('S'.$cell_row.':U'.$cell_row);
				$sheet->getCell('S'.$cell_row)->setValue(number_format($row->fcharge2, 2));
				$sheet->mergeCells('V'.$cell_row.':X'.$cell_row);
				$sheet->getCell('V'.$cell_row)->setValue(number_format($row->revenue, 2));
				$sheet->getCell('Y'.$cell_row)->setValue(number_format($row->numHawbs2, 2));
				$sheet->mergeCells('Z'.$cell_row.':AB'.$cell_row);
				$sheet->getCell('Z'.$cell_row)->setValue(number_format($row->orgWeight, 2));
				$sheet->getCell('AC'.$cell_row)->setValue(number_format($row->incomeBreak, 2));

				$totalnumMawbs1 += $row->numMawbs1;
				$totalweight1 += $row->weight1;
				$totalfcharge1 += $row->fcharge1;
				$totalcommission += $row->commission;
				$totalnumMawbs2 += $row->numMawbs2;
				$totalnumHawbs1 += $row->numHawbs1;
				$totalweight2 += $row->weight2;
				$totalfcharge2 += $row->fcharge2;
				$totalrevenue += $row->revenue;
				$totalnumHawbs2 += $row->numHawbs2;
				$totalorgWeight += $row->orgWeight;
				$totalincomeBreak += $row->incomeBreak;
				$cell_row++;
			}
			$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('D'.$cell_row)->setValue(number_format($totalnumMawbs1, 2));
			$sheet->mergeCells('E'.$cell_row.':G'.$cell_row);
			$sheet->getCell('E'.$cell_row)->setValue(number_format($totalweight1, 2));
			$sheet->mergeCells('H'.$cell_row.':J'.$cell_row);
			$sheet->getCell('H'.$cell_row)->setValue(number_format($totalfcharge1, 2));
			$sheet->mergeCells('K'.$cell_row.':M'.$cell_row);
			$sheet->getCell('K'.$cell_row)->setValue(number_format($totalcommission, 2));
			$sheet->getCell('N'.$cell_row)->setValue(number_format($totalnumMawbs2, 2));
			$sheet->getCell('O'.$cell_row)->setValue(number_format($totalnumHawbs1, 2));
			$sheet->mergeCells('P'.$cell_row.':R'.$cell_row);
			$sheet->getCell('P'.$cell_row)->setValue(number_format($totalweight2, 2));
			$sheet->mergeCells('S'.$cell_row.':U'.$cell_row);
			$sheet->getCell('S'.$cell_row)->setValue(number_format($totalfcharge2, 2));
			$sheet->mergeCells('V'.$cell_row.':X'.$cell_row);
			$sheet->getCell('V'.$cell_row)->setValue(number_format($totalrevenue, 2));
			$sheet->getCell('Y'.$cell_row)->setValue(number_format($totalnumHawbs2, 2));
			$sheet->mergeCells('Z'.$cell_row.':AB'.$cell_row);
			$sheet->getCell('Z'.$cell_row)->setValue(number_format($totalorgWeight, 2));
			$sheet->getCell('AC'.$cell_row)->setValue(number_format($totalincomeBreak, 2));

			$sheet->getStyle('D9:AC'.$cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}

		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');
	}

	public function form_t1_a() {
		$data['airlines'] = $this->report_summary_model->getAirlines();
		$data['ui'] = $this->ui;
		$data['show_input'] = true;
		$this->view->load('report_summary/form_t1_a', $data);
	}

	public function form_t1a_pdf() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		$start_year = $_GET['start_year'];
		$end_year = $_GET['end_year'];
		$category = (!empty($_GET["category"]))? $_GET['category'] : '';
		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		if ($category == 'AirlineSummary') {
			$pdf->SetFont('Arial','',12);
			$airline = $_GET['airline'];
			$getAirline = $this->report_summary_model->getAirline($airline);
			$pdf->Cell(335,7,$getAirline->name, 0, 1, 'L');
		}
		$pdf->SetFont('Arial','B',12);
		if (($category == 'byAirline') || ($category == 'AirlineSummary')){
			if ($category == 'byAirline') {
				$pdf->Cell(335,7,'Domestic Scheduled Passenger Traffic By Airlines', 0, 1, 'C');
			}
			else {
				$pdf->Cell(335,7,'Domestic Scheduled Passenger Traffic', 0, 1, 'C');
			}
			if ($report_type == 'Quarterly') {
				$pdf->Cell(335,7, $quarter.' CY '.$year, 0, 1, 'C');
			}
			else if ($report_type == 'Consolidated') {
				$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
			}
			else {
				$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
			}
		}
		else if ($category == 'Historical') {
			$pdf->Cell(335,7,'Domestic Scheduled Passenger Traffic', 0, 1, 'C');
		}

		$pdf->SetFont('Arial', 'B', 8);
		if ($category == 'byAirline') {
			$pdf->Cell(330, 7, '', 0, 1, 'C');
			$getTotal = $this->report_summary_model->getT1ATotalCargoSeatPass($report_type, $quarter, $year, $start_date, $end_date);
			$getT1AbyAirline = $this->report_summary_model->getT1AbyAirline($report_type, $quarter, $year, $start_date, $end_date);
			
			$a_load_factor = (!empty($_GET["a_load_factor"]))? $_GET['a_load_factor'] : '';
			$a_market_share = (!empty($_GET["a_market_share"]))? $_GET['a_market_share'] : '';
			
			$pdf->Cell(90, 7, 'Airlines', 1, 0, 'C');
			$pdf->Cell(40, 7, 'Passenger', 1, 0, 'C');
			$pdf->Cell(40, 7, 'Seats', 1, 0, 'C');
			if ($a_load_factor != '') {
				$pdf->Cell(40, 7, 'Load Factor (%)', 1, 0, 'C');
			}
			if ($a_market_share != '') {
				$pdf->Cell(40, 7, 'Market Share', 1, 0, 'C');
				$pdf->Cell(40, 7, 'Cargo', 1, 0, 'C');
				$pdf->Cell(40, 7, 'Market Share', 1, 1, 'C');
			}
			else {
				$pdf->Cell(40, 7, 'Cargo', 1, 1, 'C');
			}
			
			$pdf->SetFont('Arial', '', 9);
			if (empty($getT1AbyAirline)) {
				$pdf->Cell(330,7,"No Record",0,1, 'L');
			}
			foreach ($getT1AbyAirline as $key => $row) {
				$pdf->Cell(90,7, $row->name, 1,0, 'L');
				$pdf->Cell(40,7, number_format($row->passenger, 2), 1,0, 'R');
				$pdf->Cell(40,7, number_format($row->seats, 2), 1,0, 'R');
				if ($a_load_factor != '') {
					if (!empty($row->passenger) AND !empty($row->seats)) {
						$load_factor	= ($row->passenger/$row->seats) * 100;
						$pdf->Cell(40,7, number_format($load_factor, 2), 1,0, 'R');
					}
					else {
						$pdf->Cell(40,7, '0', 1,0, 'R');
					}
				}
				if ($a_market_share != '') {
					$passenger_market_share = (!empty($getTotal->totalpassenger)) ? $row->passenger / $getTotal->totalpassenger * 100 : 0;
					$pdf->Cell(40,7, number_format($passenger_market_share, 2), 1,0, 'R');	
					$pdf->Cell(40,7, number_format($row->cargo, 2), 1,0, 'R');
					$cargo_market_share = (!empty($getTotal->totalcargo)) ? $row->cargo / $getTotal->totalcargo * 100 : 0;
					$pdf->Cell(40,7, number_format($cargo_market_share, 2), 1,1, 'R');
				}
				else {
					$pdf->Cell(40,7, number_format($row->cargo, 2), 1,1, 'R');
				}
			}
		}

		else if ($category == 'Historical') {
			$h_passenger = (!empty($_GET["h_passenger"]))? $_GET['h_passenger'] : '';
			$h_cargo = (!empty($_GET["h_cargo"]))? $_GET['h_cargo'] : '';
			$h_load_factor = (!empty($_GET["h_load_factor"]))? $_GET['h_load_factor'] : '';
			$h_market_share = (!empty($_GET["h_market_share"]))? $_GET['h_market_share'] : '';
			
			$getT1AH = $this->report_summary_model->getT1AH($start_year, $end_year);
			$pdf->Cell(335,7, 'CY '.$start_year.' - '.$end_year, 0, 1, 'C');

			$pdf->Cell(335,7, '', 0, 1, 'C');

			if ($h_passenger != '') {
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(60,7, 'AIRLINE', 1, 0, 'C'); 
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$pdf->Cell(20,7, $a, 1, 0, 'C'); 
				}
				$pdf->Cell(1,7, '', 0, 1, 'C'); 
				$pdf->SetFont('Arial','',9);
				if (empty($getT1AH)) {
					$pdf->Cell(50,7,"No Record",0,1, 'L');
				}
				foreach ($getT1AH as $key => $row) {
					$pdf->Cell(60,7, $row->name, 1,0, 'L');
					for ($a = $start_year; $a <= $end_year; $a++) { 
						$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
						$pdf->Cell(20,7, number_format($getT1AHTotal->passenger, 2), 1, 0, 'R');
					}
					$pdf->Cell(1,7, '', 0, 1, 'C');
					if ($h_market_share != '') {
						$pdf->SetFont('Arial', 'B', 9);
						$pdf->Cell(60,7, 'Market Share', 1,0, 'R');
						$pdf->SetFont('Arial', '', 9);
						for ($a = $start_year; $a <= $end_year; $a++) { 
							$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
							$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
							$passenger_market_share = (!empty($getGrandTotal->totalpassenger)) ? $getT1AHTotal->passenger / $getGrandTotal->totalpassenger * 100 : 0;
							$pdf->Cell(20,7, number_format($passenger_market_share, 2).'%', 1,0, 'R');
						}
						$pdf->Cell(1,7, '', 0, 1, 'C');
					}
					if ($h_load_factor != '') {
						$pdf->SetFont('Arial', 'B', 9);
						$pdf->Cell(60,7, 'Load Factor', 1,0, 'R');
						$pdf->SetFont('Arial', '', 9);
						for ($a = $start_year; $a <= $end_year; $a++) {
							$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
							if (!empty($getT1AHTotal->passenger) AND !empty($getT1AHTotal->seats)) {
								$load_factor = ($getT1AHTotal->passenger/$getT1AHTotal->seats) * 100;
							}
							else {
								$load_factor = 0;
							}
							$pdf->Cell(20,7, number_format($load_factor, 2).'%', 1,0, 'R');
						}
						$pdf->Cell(1,7, '', 0, 1, 'C');
					}
				}
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(60,7, 'TOTAL', 1,0, 'R');
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
					$pdf->Cell(20,7, number_format($getGrandTotal->totalpassenger, 2), 1,0, 'R');
				}
				$pdf->Cell(1,7, '', 0, 1, 'C');
			}

			$pdf->Cell(335,7, '', 0, 1, 'C');

			if ($h_cargo != '') {
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(60,7, 'AIRLINE', 1, 0, 'C'); 
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$pdf->Cell(20,7, $a, 1, 0, 'C'); 
				}
				$pdf->Cell(1,7, '', 0, 1, 'C'); 
				$pdf->SetFont('Arial','',9);
				if (empty($getT1AH)) {
					$pdf->Cell(50,7,"No Record",0,1, 'L');
				}
				foreach ($getT1AH as $key => $row) {
					$pdf->Cell(60,7, $row->name, 1,0, 'L');
					for ($a = $start_year; $a <= $end_year; $a++) { 
						$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
						$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
						$pdf->Cell(20,7, number_format($getT1AHTotal->cargo, 2), 1, 0, 'R');
					}
					$pdf->Cell(1,7, '', 0, 1, 'C');
					if ($h_market_share != '') {
						$pdf->SetFont('Arial', 'B', 9);
						$pdf->Cell(60,7, 'Market Share', 1,0, 'R');
						$pdf->SetFont('Arial', '', 9);
						for ($a = $start_year; $a <= $end_year; $a++) { 
							$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
							$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
							$cargo_market_share = (!empty($getGrandTotal->totalcargo)) ? $getT1AHTotal->cargo / $getGrandTotal->totalcargo * 100 : 0;
							$pdf->Cell(20,7, number_format($cargo_market_share, 2).'%', 1,0, 'R');
						}
						$pdf->Cell(1,7, '', 0, 1, 'C');
					}
				}
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(60,7, 'TOTAL', 1,0, 'R');
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
					$pdf->Cell(20,7, number_format($getGrandTotal->totalcargo, 2), 1,0, 'R');
				}
				$pdf->Cell(1,7, '', 0, 1, 'C');
			}
		}

		else if ($category == 'AirlineSummary') {
			$pdf->Cell(330,7, '', 0, 1, 'C');
			$airline = $_GET['airline'];
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(5,7, '#', 1,0, 'C');
			$pdf->Cell(40,7, 'SECTOR', 1,0, 'C');
			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$pdf->Cell(20,7, 'January', 1,0, 'C');
					$pdf->Cell(20,7, 'February', 1,0, 'C');
					$pdf->Cell(20,7, 'March', 1,0, 'C');
				}
				else if ($quarter == "2nd Quarter") {
					$pdf->Cell(20,7, 'April', 1,0, 'C');
					$pdf->Cell(20,7, 'May', 1,0, 'C');
					$pdf->Cell(20,7, 'June', 1,0, 'C');
				}
				else if ($quarter == "3rd Quarter") {
					$pdf->Cell(20,7, 'July', 1,0, 'C');
					$pdf->Cell(20,7, 'August', 1,0, 'C');
					$pdf->Cell(20,7, 'September', 1,0, 'C');
				}
				else {
					$pdf->Cell(20,7, 'October', 1,0, 'C');
					$pdf->Cell(20,7, 'November', 1,0, 'C');
					$pdf->Cell(20,7, 'December', 1,0, 'C');
				}
			}
			else if ($report_type == 'Consolidated') {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$pdf->Cell(20,7, 'January', 1,0, 'C');
					$pdf->Cell(20,7, 'February', 1,0, 'C');
					$pdf->Cell(20,7, 'March', 1,0, 'C');
					$pdf->Cell(20,7, 'April', 1,0, 'C');
					$pdf->Cell(20,7, 'May', 1,0, 'C');
					$pdf->Cell(20,7, 'June', 1,0, 'C');
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$pdf->Cell(20,7, 'January', 1,0, 'C');
					$pdf->Cell(20,7, 'February', 1,0, 'C');
					$pdf->Cell(20,7, 'March', 1,0, 'C');
					$pdf->Cell(20,7, 'April', 1,0, 'C');
					$pdf->Cell(20,7, 'May', 1,0, 'C');
					$pdf->Cell(20,7, 'June', 1,0, 'C');
					$pdf->Cell(20,7, 'July', 1,0, 'C');
					$pdf->Cell(20,7, 'August', 1,0, 'C');
					$pdf->Cell(20,7, 'September', 1,0, 'C');
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$pdf->Cell(20,7, 'January', 1,0, 'C');
					$pdf->Cell(20,7, 'February', 1,0, 'C');
					$pdf->Cell(20,7, 'March', 1,0, 'C');
					$pdf->Cell(20,7, 'April', 1,0, 'C');
					$pdf->Cell(20,7, 'May', 1,0, 'C');
					$pdf->Cell(20,7, 'June', 1,0, 'C');
					$pdf->Cell(20,7, 'July', 1,0, 'C');
					$pdf->Cell(20,7, 'August', 1,0, 'C');
					$pdf->Cell(20,7, 'September', 1,0, 'C');
					$pdf->Cell(20,7, 'October', 1,0, 'C');
					$pdf->Cell(20,7, 'November', 1,0, 'C');
					$pdf->Cell(20,7, 'December', 1,0, 'C');
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$pdf->Cell(20,7, 'April', 1,0, 'C');
					$pdf->Cell(20,7, 'May', 1,0, 'C');
					$pdf->Cell(20,7, 'June', 1,0, 'C');
					$pdf->Cell(20,7, 'July', 1,0, 'C');
					$pdf->Cell(20,7, 'August', 1,0, 'C');
					$pdf->Cell(20,7, 'September', 1,0, 'C');
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$pdf->Cell(20,7, 'April', 1,0, 'C');
					$pdf->Cell(20,7, 'May', 1,0, 'C');
					$pdf->Cell(20,7, 'June', 1,0, 'C');
					$pdf->Cell(20,7, 'July', 1,0, 'C');
					$pdf->Cell(20,7, 'August', 1,0, 'C');
					$pdf->Cell(20,7, 'September', 1,0, 'C');
					$pdf->Cell(20,7, 'October', 1,0, 'C');
					$pdf->Cell(20,7, 'November', 1,0, 'C');
					$pdf->Cell(20,7, 'December', 1,0, 'C');
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$pdf->Cell(20,7, 'July', 1,0, 'C');
					$pdf->Cell(20,7, 'August', 1,0, 'C');
					$pdf->Cell(20,7, 'September', 1,0, 'C');
					$pdf->Cell(20,7, 'October', 1,0, 'C');
					$pdf->Cell(20,7, 'November', 1,0, 'C');
					$pdf->Cell(20,7, 'December', 1,0, 'C');
				}
				else {
					$pdf->Cell(20,7, 'October', 1,0, 'C');
					$pdf->Cell(20,7, 'November', 1,0, 'C');
					$pdf->Cell(20,7, 'December', 1,0, 'C');
				}
			}
			else {
				$pdf->Cell(20,7, 'January', 1,0, 'C');
				$pdf->Cell(20,7, 'February', 1,0, 'C');
				$pdf->Cell(20,7, 'March', 1,0, 'C');
				$pdf->Cell(20,7, 'April', 1,0, 'C');
				$pdf->Cell(20,7, 'May', 1,0, 'C');
				$pdf->Cell(20,7, 'June', 1,0, 'C');
				$pdf->Cell(20,7, 'July', 1,0, 'C');
				$pdf->Cell(20,7, 'August', 1,0, 'C');
				$pdf->Cell(20,7, 'September', 1,0, 'C');
				$pdf->Cell(20,7, 'October', 1,0, 'C');
				$pdf->Cell(20,7, 'November', 1,0, 'C');
				$pdf->Cell(20,7, 'December', 1,0, 'C');
			}
			$pdf->Cell(30,7, 'TOTAL', 1,1, 'C');
			$pdf->SetFont('Arial', '', 8);
			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$start = 1;
					$end = 3;
				}
				else if ($quarter == "2nd Quarter") {
					$start = 4;
					$end = 6;
				}
				else if ($quarter == "3rd Quarter") {
					$start = 7;
					$end = 9;
				}
				else {
					$start = 10;
					$end = 12;
				}
				$getSector = $this->report_summary_model->getSector($report_type, $quarter, $year, $start_date, $end_date, $airline);
				$count = 1;
				foreach ($getSector as $key => $row) {
					$pdf->Cell(5,5, '', 'TLR',0, 'C');
					$pdf->Cell(40,5, $row->sector.' - '.$row->sector_d.' v.v.', 1,0, 'L');
					for ($month = $start; $month <= $end; $month++) {
						$pdf->Cell(20,5, '', 1,0, 'R');
					}
					$pdf->Cell(30,5, '', 1,1, 'R');
					$pdf->Cell(5,5, $count++, 'LR',0, 'C');
					$pdf->Cell(40,5, 'Passenger', 1,0, 'C');
					$totalpassenger = 0;
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->passenger, 0), 1,0, 'R');
							$passenger = $getT1APerAirline->passenger;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$passenger = 0;
						}
						$totalpassenger += $passenger;
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalpassenger, 0), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(5,5, '', 'LR',0, 'C');
					$pdf->Cell(40,5, 'Seats', 1,0, 'C');
					$totalseats = 0;
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->seats, 0), 1,0, 'R');
							$seats = $getT1APerAirline->seats;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$seats = 0;
						}
						$totalseats += $seats;	
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalseats, 0), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(5,5, '', 'BLR',0, 'C');
					$pdf->Cell(40,5, 'Cargo', 1,0, 'C');
					$totalcargo = 0;
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->cargo, 2), 1,0, 'R');
							$cargo = $getT1APerAirline->cargo;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$cargo = 0;
						}
						$totalcargo += $cargo;	
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalcargo, 2), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
				}
			}
			else if ($report_type == 'Yearly') {
				$getSector = $this->report_summary_model->getSector($report_type, $quarter, $year, $start_date, $end_date, $airline);
				$count = 1;
				foreach ($getSector as $key => $row) {
					$pdf->Cell(5,5, '', 'TLR',0, 'C');
					$pdf->Cell(40,5, $row->sector.' - '.$row->sector_d.' v.v.', 1,0, 'L');
					for ($month = 1; $month <= 12; $month++) {
						$pdf->Cell(20,5, '', 1,0, 'R');
					}
					$pdf->Cell(30,5, '', 1,1, 'R');
					$pdf->Cell(5,5, $count++, 'LR',0, 'C');
					$pdf->Cell(40,5, 'Passenger', 1,0, 'C');
					$totalpassenger = 0;
					for ($month = 1; $month <= 12; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->passenger, 0), 1,0, 'R');
							$passenger = $getT1APerAirline->passenger;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$passenger = 0;
						}
						$totalpassenger += $passenger;
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalpassenger, 0), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(5,5, '', 'LR',0, 'C');
					$pdf->Cell(40,5, 'Seats', 1,0, 'C');
					$totalseats = 0;
					for ($month = 1; $month <= 12; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->seats, 0), 1,0, 'R');
							$seats = $getT1APerAirline->seats;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$seats = 0;
						}	
						$totalseats += $seats;
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalseats, 0), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(5,5, '', 'BLR',0, 'C');
					$pdf->Cell(40,5, 'Cargo', 1,0, 'C');
					$totalcargo = 0;
					for ($month = 1; $month <= 12; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->cargo, 2), 1,0, 'R');
							$cargo = $getT1APerAirline->cargo;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$cargo = 0;
						}	
						$totalcargo += $cargo;
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalcargo, 2), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
				}
			}
			else {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$start = 1;
					$end = 6;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$start = 1;
					$end = 9;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$start = 1;
					$end = 12;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$start = 4;
					$end = 9;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$start = 4;
					$end = 12;
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$start = 7;
					$end = 12;
				}
				else {
					$start = 10;
					$end = 12;
				}
				$getSector = $this->report_summary_model->getSector($report_type, $quarter, $year, $start_date, $end_date, $airline);
				$count = 1;
				foreach ($getSector as $key => $row) {
					$pdf->Cell(5,5, '', 'TLR',0, 'C');
					$pdf->Cell(40,5, $row->sector.' - '.$row->sector_d.' v.v.', 1,0, 'L');
					for ($month = $start; $month <= $end; $month++) {
						$pdf->Cell(20,5, '', 1,0, 'R');
					}
					$pdf->Cell(30,5, '', 1,1, 'R');
					$pdf->Cell(5,5, $count++, 'LR',0, 'C');
					$pdf->Cell(40,5, 'Passenger', 1,0, 'C');
					$totalpassenger = 0;
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->passenger, 0), 1,0, 'R');
							$passenger = $getT1APerAirline->passenger;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$passenger = 0;
						}	
						$totalpassenger += $passenger;
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalpassenger, 0), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(5,5, '', 'LR',0, 'C');
					$pdf->Cell(40,5, 'Seats', 1,0, 'C');
					$totalseats = 0;
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->seats, 0), 1,0, 'R');
							$seats = $getT1APerAirline->seats;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$seats = 0;
						}
						$totalseats += $seats;
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalseats, 0), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(5,5, '', 'BLR',0, 'C');
					$pdf->Cell(40,5, 'Cargo', 1,0, 'C');
					$totalcargo = 0;
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$pdf->Cell(20,5, number_format($getT1APerAirline->cargo, 2), 1,0, 'R');
							$cargo = $getT1APerAirline->cargo;
						}
						else {
							$pdf->Cell(20,5, '0', 1,0, 'R');
							$cargo = 0;
						}
						$totalcargo += $cargo;
					}
					$pdf->SetFont('Arial', 'B', 8);
					$pdf->Cell(30,5, number_format($totalcargo, 2), 1,1, 'R');
					$pdf->SetFont('Arial', '', 8);
				}
			}
			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$start = 1;
					$end = 3;
					$cell_len = 130;
				}
				else if ($quarter == "2nd Quarter") {
					$start = 4;
					$end = 6;
					$cell_len = 130;
				}
				else if ($quarter == "3rd Quarter") {
					$start = 7;
					$end = 9;
					$cell_len = 130;
				}
				else {
					$start = 10;
					$end = 12;
					$cell_len = 130;
				}
			}
			else if ($report_type == 'Consolidated') {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$start = 1;
					$end = 6;
					$cell_len = 190;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$start = 1;
					$end = 9;
					$cell_len = 250;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$start = 1;
					$end = 12;
					$cell_len = 310;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$start = 4;
					$end = 9;
					$cell_len = 190;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$start = 4;
					$end = 12;
					$cell_len = 250;
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$start = 7;
					$end = 12;
					$cell_len = 190;
				}
				else {
					$start = 10;
					$end = 12;
					$cell_len = 130;
				}
			}
			else {
				$start = 1;
				$end = 12;
				$cell_len = 310;
			}
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(5,5, '', 'TLR',0, 'C');
			$pdf->Cell($cell_len,5, 'TOTAL', 1,1, 'L');
			$pdf->Cell(5,5, '', 'LR',0, 'C');
			$pdf->Cell(40,5, 'Passenger', 1,0, 'C');
			$totalpassenger = 0;
			for ($month = $start; $month <= $end; $month++) {
				$getT1ATotalperAirline = $this->report_summary_model->getT1ATotalperAirline($report_type, $year, $month, $airline);
				if ($getT1ATotalperAirline) {
					$pdf->Cell(20,5, number_format($getT1ATotalperAirline->passenger, 0), 1,0, 'R');
					$passenger = $getT1ATotalperAirline->passenger;
				}
				else {
					$pdf->Cell(20,5, '0', 1,0, 'R');
					$passenger = 0;
				}	
				$totalpassenger += $passenger;
			}
			$pdf->Cell(30,5, number_format($totalpassenger, 0), 1,1, 'R');
			$pdf->Cell(5,5, '', 'LR',0, 'C');
			$pdf->Cell(40,5, 'Seats', 1,0, 'C');
			$totalseats = 0;
			for ($month = $start; $month <= $end; $month++) {
				$getT1ATotalperAirline = $this->report_summary_model->getT1ATotalperAirline($report_type, $year, $month, $airline);
				if ($getT1ATotalperAirline) {
					$pdf->Cell(20,5, number_format($getT1ATotalperAirline->seats, 0), 1,0, 'R');
					$seats = $getT1ATotalperAirline->seats;
				}
				else {
					$pdf->Cell(20,5, '0', 1,0, 'R');
					$seats = 0;
				}
				$totalseats += $seats;
			}
			$pdf->Cell(30,5, number_format($totalseats, 0), 1,1, 'R');
			$pdf->Cell(5,5, '', 'BLR',0, 'C');
			$pdf->Cell(40,5, 'Cargo', 1,0, 'C');
			$totalcargo = 0;
			for ($month = $start; $month <= $end; $month++) {
				$getT1ATotalperAirline = $this->report_summary_model->getT1ATotalperAirline($report_type, $year, $month, $airline);
				if ($getT1ATotalperAirline) {
					$pdf->Cell(20,5, number_format($getT1ATotalperAirline->cargo, 2), 1,0, 'R');
					$cargo = $getT1ATotalperAirline->cargo;
				}
				else {
					$pdf->Cell(20,5, '0', 1,0, 'R');
					$cargo = 0;
				}
				$totalcargo += $cargo;
			}
			$pdf->Cell(30,5, number_format($totalcargo, 2), 1,1, 'R');
		}
		else if ($category == 'bySector') {
			$pdf->SetFont('Arial', 'B', 11);
			$pdf->Cell(192,5, 'Report FormT1A by Sector: Not Available in PDF', 0,1, 'L');
		}

		$pdf->Output();
	}

	public function form_t1a_csv() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		$start_year = $_GET['start_year'];
		$end_year = $_GET['end_year'];
		$category = (!empty($_GET["category"]))? $_GET['category'] : '';

		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Formt1a_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Formt1a_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Formt1a_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form T1A')
				->setDescription('Summary Report Form T1A')
				->setKeywords('summary report fORM t1-a domestic sector load report')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form T1A');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		if ($category == 'AirlineSummary') {
			$airline = $_GET['airline'];
			$getAirline = $this->report_summary_model->getAirline($airline);
			$sheet->getCell('A1')->setValue($getAirline->name);
			$sheet->mergeCells('A1:B1');
		}
		if (($category == 'byAirline') || ($category == 'AirlineSummary') || ($category == 'bySector')){
			if ($category == 'byAirline') {
				$sheet->getCell('A2')->setValue('Domestic Scheduled Passenger Traffic By Airlines');
				$sheet->mergeCells('A2:J2');
			}
			else if ($category == 'AirlineSummary'){
				$sheet->getCell('A2')->setValue('Domestic Scheduled Passenger Traffic');
			}
			else {
				$sheet->getCell('A2')->setValue('Domestic Scheduled Passenger Traffic');
			}
			if ($report_type == 'Quarterly') {
				$sheet->getCell('A3')->setValue($quarter.' CY '.$year);
				$sheet->mergeCells('A3:J3');
			}
			else if ($report_type == 'Consolidated') {
				$sheet->getCell('A3')->setValue($start_date.' - '.$end_date.' CY '.$year);
				$sheet->mergeCells('A3:J3');
			}
			else {
				$sheet->getCell('A3')->setValue('CY '.$year);
				$sheet->mergeCells('A3:J3');
			}
		}
		else if ($category == 'Historical') {
			$sheet->getCell('A2')->setValue('Domestic Scheduled Passenger Traffic');
			$sheet->mergeCells('A2:M2');
		}

		$sheet->getStyle('A2:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if ($category == 'byAirline') {
			$getTotal = $this->report_summary_model->getT1ATotalCargoSeatPass($report_type, $quarter, $year, $start_date, $end_date);
			$getT1AbyAirline = $this->report_summary_model->getT1AbyAirline($report_type, $quarter, $year, $start_date, $end_date);
			
			$a_load_factor = (!empty($_GET["a_load_factor"]))? $_GET['a_load_factor'] : '';
			$a_market_share = (!empty($_GET["a_market_share"]))? $_GET['a_market_share'] : '';
			
			$sheet->mergeCells('A5:D5');
			$sheet->getCell('A5')->setValue('Airlines');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('E5')->setValue('Passenger');
			$sheet->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('F5')->setValue('Seats');
			$sheet->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			if ($a_load_factor != '') {
				$sheet->getCell('G5')->setValue('Load Factor (%)');
			$sheet->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			if ($a_market_share != '') {
				$sheet->getCell('H5')->setValue('Market Share)');
			$sheet->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('I5')->setValue('Cargo');
			$sheet->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->getCell('J5')->setValue('Market Share');
			$sheet->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			else {
				$sheet->getCell('I5')->setValue('Cargo'); 
			}
			
			if (empty($getT1AbyAirline)) {
				$sheet->getCell('A6')->setValue('No Record');
			}
			$cell_row = 6;
			foreach ($getT1AbyAirline as $key => $row) {
				$sheet->mergeCells('A'.$cell_row.':D'.$cell_row);
				$sheet->getCell('A'.$cell_row)->setValue($row->name);
				$sheet->getCell('E'.$cell_row)->setValue(number_format($row->passenger, 0));
				$sheet->getCell('F'.$cell_row)->setValue(number_format($row->seats, 0));
				if ($a_load_factor != '') {
					if (!empty($row->passenger) AND !empty($row->seats)) {
						$load_factor = ($row->passenger/$row->seats) * 100;
						$sheet->getCell('G'.$cell_row)->setValue(number_format($load_factor, 2));
					}
					else {
						$sheet->getCell('G'.$cell_row)->setValue('');
					}
				}
				if ($a_market_share != '') {
					$passenger_market_share = (!empty($getTotal->totalpassenger)) ? $row->passenger / $getTotal->totalpassenger * 100 : 0;
					$sheet->getCell('H'.$cell_row)->setValue(number_format($passenger_market_share, 2));	
					$sheet->getCell('I'.$cell_row)->setValue(number_format($row->cargo, 2));
					$cargo_market_share = (!empty($getTotal->totalcargo)) ? $row->cargo / $getTotal->totalcargo * 100 : 0;
					$sheet->getCell('J'.$cell_row)->setValue(number_format($cargo_market_share, 2));
				}
				else {
					$sheet->getCell('I'.$cell_row)->setValue('');
				}
				$cell_row++;
			}
		}
		else if ($category == 'Historical') {
			$h_passenger = (!empty($_GET["h_passenger"]))? $_GET['h_passenger'] : '';
			$h_cargo = (!empty($_GET["h_cargo"]))? $_GET['h_cargo'] : '';
			$h_load_factor = (!empty($_GET["h_load_factor"]))? $_GET['h_load_factor'] : '';
			$h_market_share = (!empty($_GET["h_market_share"]))? $_GET['h_market_share'] : '';
			
			$getT1AH = $this->report_summary_model->getT1AH($start_year, $end_year);
			$sheet->getCell('A3')->setValue('CY '.$start_year.' - '.$end_year);
			$sheet->mergeCells('A3:M3');

			if ($h_passenger != '') {
				$sheet->getCell('A5')->setValue('AIRLINE');
				$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$cell_col = 'B';
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$sheet->getCell($cell_col.'5')->setValue($a);
					$cell_col++;
				}
				if (empty($getT1AH)) {
					$sheet->getCell('A6')->setValue('No Record');
				}
				$a_row = 6;
				$ms_row = 7;
				$lf_row = 8;
				foreach ($getT1AH as $key => $row) {
					$sheet->getCell('A'.$a_row)->setValue($row->name);
					$cell_col = 'B';
					for ($a = $start_year; $a <= $end_year; $a++) { 
						$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
						$sheet->getCell($cell_col.$a_row)->setValue(number_format($getT1AHTotal->passenger, 2));
						$sheet->getStyle($cell_col.$a_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$cell_col++;
					}
					if ($h_market_share != '') {
						$sheet->getCell('A'.$ms_row)->setValue('Market Share');
						$cell_col = 'B';
						for ($a = $start_year; $a <= $end_year; $a++) { 
							$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
							$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
							$passenger_market_share = (!empty($getGrandTotal->totalpassenger)) ? $getT1AHTotal->passenger / $getGrandTotal->totalpassenger * 100 : 0;
							$sheet->getCell($cell_col.$ms_row)->setValue(number_format($passenger_market_share, 2));
							$sheet->getStyle($cell_col.$ms_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$cell_col++;
						}
					}
					if ($h_load_factor != '') {
						$sheet->getCell('A'.$lf_row)->setValue('Load Factor');
						$cell_col = 'B';
						for ($a = $start_year; $a <= $end_year; $a++) {
							$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
							if (!empty($getT1AHTotal->passenger) AND !empty($getT1AHTotal->seats)) {
								$load_factor = ($getT1AHTotal->passenger/$getT1AHTotal->seats) * 100;
							}
							else {
								$load_factor = 0;
							}
							$sheet->getCell($cell_col.$lf_row)->setValue(number_format($load_factor, 2));
							$sheet->getStyle($cell_col.$lf_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$cell_col++;
						}
					}
					$a_row = $a_row + 3;
					$ms_row = $ms_row + 3;
					$lf_row = $lf_row + 3;
				}
				$sheet->getCell('A'.$a_row)->setValue('TOTAL');
				$cell_col = 'B';
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
					$sheet->getCell($cell_col.$a_row)->setValue(number_format($getGrandTotal->totalpassenger, 2));
					$cell_col++;
				}
			}

			if ($h_passenger != '') {
				$cell_row = $a_row + 2;
				$a_row = $a_row + 3;
				$ms_row = $ms_row + 3;
				$lf_row = $lf_row + 3;
			}
			else {
				$cell_row = 5;
				$a_row = 6;
				$ms_row = 7;
				$lf_row = 8;
			}

			if ($h_cargo != '') {
				$sheet->getCell('A'.$cell_row)->setValue('AIRLINE');
				$sheet->getStyle('A'.$cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$cell_col = 'B';
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$sheet->getCell($cell_col.$cell_row)->setValue($a);
					$cell_col++;
				}
				if (empty($getT1AH)) {
					$sheet->getCell('A'.$a_row)->setValue('No Record');
				}
				foreach ($getT1AH as $key => $row) {
					$sheet->getCell('A'.$a_row)->setValue($row->name);
					$cell_col = 'B';
					for ($a = $start_year; $a <= $end_year; $a++) { 
						$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
						$sheet->getCell($cell_col.$a_row)->setValue(number_format($getT1AHTotal->cargo, 2));
						$sheet->getStyle($cell_col.$a_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$cell_col++;
					}
					if ($h_market_share != '') {
						$sheet->getCell('A'.$ms_row)->setValue('Market Share');
						$cell_col = 'B';
						for ($a = $start_year; $a <= $end_year; $a++) { 
							$getT1AHTotal = $this->report_summary_model->getT1AHTotal($a, $row->id);
							$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
							$cargo_market_share = (!empty($getGrandTotal->totalcargo)) ? $getT1AHTotal->cargo / $getGrandTotal->totalcargo * 100 : 0;
							$sheet->getCell($cell_col.$ms_row)->setValue(number_format($cargo_market_share, 2));
							$sheet->getStyle($cell_col.$ms_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$cell_col++;
						}
					}
					$a_row = $a_row + 2;
					$ms_row = $ms_row + 2;
					$lf_row = $lf_row + 2;
				}
				$sheet->getCell('A'.$a_row)->setValue('TOTAL');
				$cell_col = 'B';
				for ($a = $start_year; $a <= $end_year; $a++) { 
					$getGrandTotal = $this->report_summary_model->getT1AHistTotalCargoSeatPass($a);
					$sheet->getCell($cell_col.$a_row)->setValue(number_format($getGrandTotal->totalcargo, 2));
					$cell_col++;
				}
			}
		}
		else if ($category == 'AirlineSummary') {
			$airline = $_GET['airline'];
			$sheet->getCell('A5')->setValue('#');
			$sheet->getCell('B5')->setValue('SECTOR');
			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$sheet->getCell('C5')->setValue('January');
					$sheet->getCell('D5')->setValue('February');
					$sheet->getCell('E5')->setValue('March');
					$total_col = 'F5';
					$sheet->mergeCells('A3:F3');
					$sheet->mergeCells('A2:F2');
				}
				else if ($quarter == "2nd Quarter") {
					$sheet->getCell('C5')->setValue('April');
					$sheet->getCell('D5')->setValue('May');
					$sheet->getCell('E5')->setValue('June');
					$total_col = 'F5';
					$sheet->mergeCells('A3:F3');
					$sheet->mergeCells('A2:F2');
				}
				else if ($quarter == "3rd Quarter") {
					$sheet->getCell('C5')->setValue('July');
					$sheet->getCell('D5')->setValue('August');
					$sheet->getCell('E5')->setValue('September');
					$total_col = 'F5';
					$sheet->mergeCells('A3:F3');
					$sheet->mergeCells('A2:F2');
				}
				else {
					$sheet->getCell('C5')->setValue('October');
					$sheet->getCell('D5')->setValue('November');
					$sheet->getCell('E5')->setValue('December');
					$total_col = 'F5';
					$sheet->mergeCells('A3:F3');
					$sheet->mergeCells('A2:F2');
				}
			}
			else if ($report_type == 'Consolidated') {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$sheet->getCell('C5')->setValue('January');
					$sheet->getCell('D5')->setValue('February');
					$sheet->getCell('E5')->setValue('March');
					$sheet->getCell('F5')->setValue('April');
					$sheet->getCell('G5')->setValue('May');
					$sheet->getCell('H5')->setValue('June');
					$total_col = 'I5';
					$sheet->mergeCells('A3:I3');
					$sheet->mergeCells('A2:I2');
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$sheet->getCell('C5')->setValue('January');
					$sheet->getCell('D5')->setValue('February');
					$sheet->getCell('E5')->setValue('March');
					$sheet->getCell('F5')->setValue('April');
					$sheet->getCell('G5')->setValue('May');
					$sheet->getCell('H5')->setValue('June');
					$sheet->getCell('I5')->setValue('July');
					$sheet->getCell('J5')->setValue('August');
					$sheet->getCell('K5')->setValue('September');
					$total_col = 'L5';
					$sheet->mergeCells('A3:L3');
					$sheet->mergeCells('A2:L2');
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$sheet->getCell('C5')->setValue('January');
					$sheet->getCell('D5')->setValue('February');
					$sheet->getCell('E5')->setValue('March');
					$sheet->getCell('F5')->setValue('April');
					$sheet->getCell('G5')->setValue('May');
					$sheet->getCell('H5')->setValue('June');
					$sheet->getCell('I5')->setValue('July');
					$sheet->getCell('J5')->setValue('August');
					$sheet->getCell('K5')->setValue('September');
					$sheet->getCell('L5')->setValue('October');
					$sheet->getCell('M5')->setValue('November');
					$sheet->getCell('N5')->setValue('December');
					$total_col = 'O5';
					$sheet->mergeCells('A3:O3');
					$sheet->mergeCells('A2:O2');
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$sheet->getCell('C5')->setValue('April');
					$sheet->getCell('D5')->setValue('May');
					$sheet->getCell('E5')->setValue('June');
					$sheet->getCell('F5')->setValue('July');
					$sheet->getCell('G5')->setValue('August');
					$sheet->getCell('H5')->setValue('September');
					$total_col = 'I5';
					$sheet->mergeCells('A3:I3');
					$sheet->mergeCells('A2:I2');
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$sheet->getCell('C5')->setValue('April');
					$sheet->getCell('D5')->setValue('May');
					$sheet->getCell('E5')->setValue('June');
					$sheet->getCell('F5')->setValue('July');
					$sheet->getCell('G5')->setValue('August');
					$sheet->getCell('H5')->setValue('September');
					$sheet->getCell('I5')->setValue('October');
					$sheet->getCell('J5')->setValue('November');
					$sheet->getCell('K5')->setValue('December');
					$total_col = 'L5';
					$sheet->mergeCells('A3:L3');
					$sheet->mergeCells('A2:L2');
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$sheet->getCell('C5')->setValue('July');
					$sheet->getCell('D5')->setValue('August');
					$sheet->getCell('E5')->setValue('September');
					$sheet->getCell('F5')->setValue('October');
					$sheet->getCell('G5')->setValue('November');
					$sheet->getCell('H5')->setValue('December');
					$total_col = 'I5';
					$sheet->mergeCells('A3:I3');
					$sheet->mergeCells('A2:I2');
				}
				else {
					$sheet->getCell('C5')->setValue('October');
					$sheet->getCell('D5')->setValue('November');
					$sheet->getCell('E5')->setValue('December');
					$total_col = 'F5';
					$sheet->mergeCells('A3:F3');
					$sheet->mergeCells('A2:F2');
				}
			}
			else {
				$sheet->getCell('C5')->setValue('January');
				$sheet->getCell('D5')->setValue('February');
				$sheet->getCell('E5')->setValue('March');
				$sheet->getCell('F5')->setValue('April');
				$sheet->getCell('G5')->setValue('May');
				$sheet->getCell('H5')->setValue('June');
				$sheet->getCell('I5')->setValue('July');
				$sheet->getCell('J5')->setValue('August');
				$sheet->getCell('K5')->setValue('September');
				$sheet->getCell('L5')->setValue('October');
				$sheet->getCell('M5')->setValue('November');
				$sheet->getCell('N5')->setValue('December');
				$total_col = 'O5';
				$sheet->mergeCells('A3:O3');
				$sheet->mergeCells('A2:O2');
			}
			$sheet->getStyle('A5:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$sheet->getCell($total_col)->setValue('TOTAL');
			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$start = 1;
					$end = 3;
				}
				else if ($quarter == "2nd Quarter") {
					$start = 4;
					$end = 6;
				}
				else if ($quarter == "3rd Quarter") {
					$start = 7;
					$end = 9;
				}
				else {
					$start = 10;
					$end = 12;
				}
				$getSector = $this->report_summary_model->getSector($report_type, $quarter, $year, $start_date, $end_date, $airline);
				$count = 1;
				$sector_row = 6;
				$pass_row = 7;
				$seats_row = 8;
				$cargo_row = 9;
				foreach ($getSector as $key => $row) {
					$sheet->getCell('B'.$sector_row)->setValue($row->sector.' - '.$row->sector_d.' v.v.');
					$sheet->mergeCells('A'.$sector_row.':A'.$cargo_row);
					$sheet->getCell('A'.$pass_row)->setValue($count++);
					$sheet->getCell('B'.$pass_row)->setValue('Passenger');
					$sheet->getStyle('B'.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalpassenger = 0;
					$cell_col = 'C';
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$pass_row)->setValue(number_format($getT1APerAirline->passenger, 0));
							$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$passenger = $getT1APerAirline->passenger;
						}
						else {
							$sheet->getCell($cell_col.$pass_row)->setValue('0');
							$passenger = 0;
						}
						$totalpassenger += $passenger;
						$cell_col++;
					}
					$sheet->getCell($cell_col.$pass_row)->setValue(number_format($totalpassenger, 0));
					$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$sheet->getCell('B'.$seats_row)->setValue('Seats');
					$sheet->getStyle('B'.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalseats = 0;
					$cell_col = 'C';
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$seats_row)->setValue(number_format($getT1APerAirline->seats, 0));
							$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$seats = $getT1APerAirline->seats;
						}
						else {
							$sheet->getCell($cell_col.$seats_row)->setValue('0');
							$seats = 0;
						}
						$totalseats += $seats;	
						$cell_col++;
					}
					$sheet->getCell($cell_col.$seats_row)->setValue(number_format($totalseats, 0));
					$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$sheet->getCell('B'.$cargo_row)->setValue('Cargo');
					$sheet->getStyle('B'.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalcargo = 0;
					$cell_col = 'C';
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($getT1APerAirline->cargo, 2));
							$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$cargo = $getT1APerAirline->cargo;
						}
						else {
							$sheet->getCell($cell_col.$cargo_row)->setValue('0.00');
							$cargo = 0;
						}
						$totalcargo += $cargo;	
						$cell_col++;
					}
					$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($totalcargo, 2));
					$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$sector_row = $sector_row + 4;
					$pass_row = $pass_row + 4;
					$seats_row = $seats_row + 4;
					$cargo_row = $cargo_row + 4;
				}
			}
			else if ($report_type == 'Yearly') {
				$getSector = $this->report_summary_model->getSector($report_type, $quarter, $year, $start_date, $end_date, $airline);
				$count = 1;
				$sector_row = 6;
				$pass_row = 7;
				$seats_row = 8;
				$cargo_row = 9;
				foreach ($getSector as $key => $row) {
					$sheet->getCell('B'.$sector_row)->setValue($row->sector.' - '.$row->sector_d.' v.v.');
					$sheet->mergeCells('A'.$sector_row.':A'.$cargo_row);
					$sheet->getCell('A'.$pass_row)->setValue($count++);
					$sheet->getCell('B'.$pass_row)->setValue('Passenger');
					$sheet->getStyle('B'.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalpassenger = 0;
					$cell_col = 'C';
					for ($month = 1; $month <= 12; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {				
							$sheet->getCell($cell_col.$pass_row)->setValue(number_format($getT1APerAirline->passenger, 0));
							$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$passenger = $getT1APerAirline->passenger;
						}
						else {
							$sheet->getCell($cell_col.$pass_row)->setValue('0');
							$passenger = 0;
						}
						$totalpassenger += $passenger;
						$cell_col++;
					}
					$sheet->getCell($cell_col.$pass_row)->setValue(number_format($totalpassenger, 0));
					$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$sheet->getCell('B'.$seats_row)->setValue('Seats');
					$sheet->getStyle('B'.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalseats = 0;
					$cell_col = 'C';
					for ($month = 1; $month <= 12; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$seats_row)->setValue(number_format($getT1APerAirline->seats, 0));
							$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$seats = $getT1APerAirline->seats;
						}
						else {
							$sheet->getCell($cell_col.$seats_row)->setValue('0');
							$seats = 0;
						}
						$totalseats += $seats;	
						$cell_col++;
					}
					$sheet->getCell($cell_col.$seats_row)->setValue(number_format($totalseats, 0));
					$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$sheet->getCell('B'.$cargo_row)->setValue('Cargo');
					$sheet->getStyle('B'.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalcargo = 0;
					$cell_col = 'C';
					for ($month = 1; $month <= 12; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($getT1APerAirline->cargo, 2));
							$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$cargo = $getT1APerAirline->cargo;
						}
						else {
							$sheet->getCell($cell_col.$cargo_row)->setValue('0.00');
							$cargo = 0;
						}
						$totalcargo += $cargo;	
						$cell_col++;
					}
					$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($totalcargo, 2));
					$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$sector_row = $sector_row + 4;
					$pass_row = $pass_row + 4;
					$seats_row = $seats_row + 4;
					$cargo_row = $cargo_row + 4;
				}
			}
			else {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$start = 1;
					$end = 6;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$start = 1;
					$end = 9;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$start = 1;
					$end = 12;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$start = 4;
					$end = 9;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$start = 4;
					$end = 12;
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$start = 7;
					$end = 12;
				}
				else {
					$start = 10;
					$end = 12;
				}
				$getSector = $this->report_summary_model->getSector($report_type, $quarter, $year, $start_date, $end_date, $airline);
				$count = 1;
				$sector_row = 6;
				$pass_row = 7;
				$seats_row = 8;
				$cargo_row = 9;
				foreach ($getSector as $key => $row) {
					$sheet->getCell('B'.$sector_row)->setValue($row->sector.' - '.$row->sector_d.' v.v.');
					$sheet->mergeCells('A'.$sector_row.':A'.$cargo_row);
					$sheet->getCell('A'.$pass_row)->setValue($count++);
					$sheet->getCell('B'.$pass_row)->setValue('Passenger');
					$sheet->getStyle('B'.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalpassenger = 0;
					$cell_col = 'C';
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$pass_row)->setValue(number_format($getT1APerAirline->passenger, 0));
							$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$passenger = $getT1APerAirline->passenger;
						}
						else {
							$sheet->getCell($cell_col.$pass_row)->setValue('0');
							$passenger = 0;
						}
						$totalpassenger += $passenger;
						$cell_col++;
					}
					$sheet->getCell($cell_col.$pass_row)->setValue(number_format($totalpassenger, 0));
					$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$sheet->getCell('B'.$seats_row)->setValue('Seats');
					$sheet->getStyle('B'.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalseats = 0;
					$cell_col = 'C';
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$seats_row)->setValue(number_format($getT1APerAirline->seats, 0));
							$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$seats = $getT1APerAirline->seats;
						}
						else {
							$sheet->getCell($cell_col.$seats_row)->setValue('0');
							$seats = 0;
						}
						$totalseats += $seats;	
						$cell_col++;
					}
					$sheet->getCell($cell_col.$seats_row)->setValue(number_format($totalseats, 0));
					$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					
					$sheet->getCell('B'.$cargo_row)->setValue('Cargo');
					$sheet->getStyle('B'.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$totalcargo = 0;
					$cell_col = 'C';
					for ($month = $start; $month <= $end; $month++) {
						$getT1APerAirline = $this->report_summary_model->getT1AperAirline($report_type, $year, $month, $airline, $row->sector, $row->sector_d);
						if ($getT1APerAirline) {
							$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($getT1APerAirline->cargo, 2));
							$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$cargo = $getT1APerAirline->cargo;
						}
						else {
							$sheet->getCell($cell_col.$cargo_row)->setValue('0.00');
							$cargo = 0;
						}
						$totalcargo += $cargo;	
						$cell_col++;
					}
					$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($totalcargo, 2));
					$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$sector_row = $sector_row + 4;
					$pass_row = $pass_row + 4;
					$seats_row = $seats_row + 4;
					$cargo_row = $cargo_row + 4;
				}
			}
			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$start = 1;
					$end = 3;
				}
				else if ($quarter == "2nd Quarter") {
					$start = 4;
					$end = 6;
				}
				else if ($quarter == "3rd Quarter") {
					$start = 7;
					$end = 9;
				}
				else {
					$start = 10;
					$end = 12;
				}
			}
			else if ($report_type == 'Consolidated') {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$start = 1;
					$end = 6;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$start = 1;
					$end = 9;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$start = 1;
					$end = 12;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$start = 4;
					$end = 9;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$start = 4;
					$end = 12;
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$start = 7;
					$end = 12;
				}
				else {
					$start = 10;
					$end = 12;
				}
			}
			else {
				$start = 1;
				$end = 12;
			}
			$sheet->getCell('B'.$sector_row)->setValue('TOTAL');
			$sheet->mergeCells('A'.$sector_row.':A'.$cargo_row);
			$sheet->getCell('B'.$pass_row)->setValue('Passenger');
			$sheet->getStyle('B'.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$totalpassenger = 0;
			$cell_col = 'C';
			for ($month = $start; $month <= $end; $month++) {
				$getT1ATotalperAirline = $this->report_summary_model->getT1ATotalperAirline($report_type, $year, $month, $airline);
				if ($getT1ATotalperAirline) {
					$sheet->getCell($cell_col.$pass_row)->setValue(number_format($getT1ATotalperAirline->passenger, 0));
					$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$passenger = $getT1ATotalperAirline->passenger;
				}
				else {
					$sheet->getCell($cell_col.$pass_row)->setValue('0');
					$passenger = 0;
				}
				$totalpassenger += $passenger;
				$cell_col++;
			}
			$sheet->getCell($cell_col.$pass_row)->setValue(number_format($totalpassenger, 0));
			$sheet->getStyle($cell_col.$pass_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			$sheet->getCell('B'.$seats_row)->setValue('Seats');
			$sheet->getStyle('B'.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$totalseats = 0;
			$cell_col = 'C';
			for ($month = $start; $month <= $end; $month++) {
				$getT1ATotalperAirline = $this->report_summary_model->getT1ATotalperAirline($report_type, $year, $month, $airline);
				if ($getT1ATotalperAirline) {
					$sheet->getCell($cell_col.$seats_row)->setValue(number_format($getT1ATotalperAirline->seats, 0));
					$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$seats = $getT1ATotalperAirline->seats;
				}
				else {
					$sheet->getCell($cell_col.$seats_row)->setValue('0');
					$seats = 0;
				}
				$totalseats += $seats;	
				$cell_col++;
			}
			$sheet->getCell($cell_col.$seats_row)->setValue(number_format($totalseats, 0));
			$sheet->getStyle($cell_col.$seats_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			$sheet->getCell('B'.$cargo_row)->setValue('Cargo');
			$sheet->getStyle('B'.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$totalcargo = 0;
			$cell_col = 'C';
			for ($month = $start; $month <= $end; $month++) {
				$getT1ATotalperAirline = $this->report_summary_model->getT1ATotalperAirline($report_type, $year, $month, $airline);
				if ($getT1ATotalperAirline) {
					$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($getT1ATotalperAirline->cargo, 2));
					$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$cargo = $getT1ATotalperAirline->cargo;
				}
				else {
					$sheet->getCell($cell_col.$cargo_row)->setValue('0.00');
					$cargo = 0;
				}
				$totalcargo += $cargo;	
				$cell_col++;
			}
			$sheet->getCell($cell_col.$cargo_row)->setValue(number_format($totalcargo, 2));
			$sheet->getStyle($cell_col.$cargo_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
	
		else {
			$result = $this->report_summary_model->getT1ASector($report_type, $quarter, $year, $start_date, $end_date);
			$sheet->mergeCells('A5:A7');
			$sheet->getCell('A5')->setValue('Routes');
			$sector_row = 8;
			$airline = '';
			foreach ($result as $key => $row) {
				$sector_col = 'A';
				foreach ($row as $key2 => $row2) {
					if ($key == 0 && $key2 != 'sector') {
						$data = explode('|', $key2);
						if ($airline != $data[0]) {
							$sector_col2 = $sector_col;
							$sector_col2++;
							$sector_col2++;
							$sheet->mergeCells($sector_col.'5:'.$sector_col2.'6');
							$sheet->getCell($sector_col.'5')->setValue($data[0]);
							$sheet->getStyle($sector_col.'5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$airline = $data[0];
						}
						$sheet->getCell($sector_col.'7')->setValue($data[1]);
						$sheet->getStyle($sector_col.'7:'.$sector_col2.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					}
					$sheet->getCell($sector_col.$sector_row)->setValue($row2);
					$sector_col++;
				}
				$sector_row++;
			}
		}

		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				if (($category == 'Historical') || ($category == 'byAirline') || ($category == 'AirlineSummary')) {
					$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
				}
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');
	}

	public function form_61a_pdf() {
		
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["rank_alpha"])) {
			$rank_alpha = $_GET['rank_alpha'];
			$rank_alpha = str_replace('+', ' ', $rank_alpha);
		}
		else {
			$rank_alpha = '';
		}
		if (!empty($_GET["airline"])) {
			$airline = $_GET['airline'];
			$airline = str_replace('+', ' ', $airline);
		}
		else {
			$airline = '';
		}

		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(335,7,'NON-SCHEDULED DOMESTIC AERIAL AGRICULTURAL SPRAYING SERVICES', 0, 1, 'C');
		$pdf->Cell(335,7,'TRAFFIC AND OPERATING STATISTICS', 0, 1, 'C');
		if ($report_type == 'Quarterly') {
			$pdf->Cell(335,7, $quarter.' CY '.$year, 0, 1, 'C');
		}
		else if ($report_type == 'Consolidated') {
			$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
		}

		$get61aSummary = $this->report_summary_model->get61ASummary($report_type, $quarter, $year, $start_date, $end_date, $rank_alpha);
		if ($category == 'Summary Report') {
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(80,7, 'NAME OF OPERATORS', 1, 0, 'C'); 
			$pdf->Cell(80,7, 'LOCATION', 1, 0, 'C');
			$pdf->Cell(80,7, 'TOTAL AREA TREATED', 1, 0, 'C');
			$pdf->Cell(80,7, 'QUANTITY(Liters)', 1, 1, 'C');

			$pdf->SetFont('Arial','',9);
			if (empty($get61aSummary)) {
				$pdf->Cell(340,7,"No Record",1,1, 'C');
			}
			$count = 1;
			$totalareaTreated = 0;
			$totalqLiters = 0;
			foreach ($get61aSummary as $key => $row) {
				$pdf->Cell(10,7, $count++, 1,0, 'C');
				$pdf->Cell(70,7, $row->aircraft, 1,0, 'L');
				$pdf->Cell(80,7, $row->location, 1,0, 'L');
				$pdf->Cell(80,7, number_format($row->areaTreated, 2), 1,0, 'R');
				$pdf->Cell(80,7, number_format($row->qLiters, 2), 1,1, 'R');

				$totalareaTreated += $row->areaTreated;
				$totalqLiters += $row->qLiters;
			}
			$pdf->setFont('Arial','B',9);
			$pdf->Cell(80,7, 'GRAND TOTAL', 1, 0, 'C');
			$pdf->Cell(80,7, '', 1,0, 'L');
			$pdf->Cell(80,7, number_format($totalareaTreated, 2), 1, 0, 'R');
			$pdf->Cell(80,7, number_format($totalqLiters, 2), 1, 0, 'R');
		}
		else if ($category == 'Detailed Summary Report') {
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(70,10, 'Name of Operators', 1, 0, 'C'); 
			$pdf->Cell(70,10, 'Location', 1, 0, 'C');
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(50,5, 'Total Area Treated', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(50,5, '(Hectares)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 50);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(50,5, 'Quantity', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(50,5, '(Liters)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 50);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(50,5, 'Revenue Derived', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(50,5, '(Php)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 50);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(50,5, 'Flying Time', 1,0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(25,5, 'Hours', 'BLR',0, 'C');
			$pdf->Cell(25,5, 'Minutes', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 50);
			$pdf->Cell(1,10, '', 0,1, 'C');

			$pdf->SetFont('Arial','',9);
			if (empty($get61aSummary)) {
				$pdf->Cell(340,7,"No Record",1,1, 'C');
			}
			$count = 1;
			$totalareaTreated = 0;
			$totalqLiters = 0;
			$totaldistance = 0;
			$totalhours = 0;
			$totalminutes = 0;
			$totalrevenue = 0;
			foreach ($get61aSummary as $key => $row) {
				$pdf->Cell(10,7, $count++, 1,0, 'C');
				$pdf->Cell(60,7, $row->aircraft, 1,0, 'L');
				$pdf->Cell(70,7, $row->location, 1,0, 'L');				
				$pdf->Cell(50,7, number_format($row->areaTreated, 2), 1, 0, 'R');
				$pdf->Cell(50,7, number_format($row->qLiters, 2), 1, 0, 'R');
				$pdf->Cell(50,7, number_format($row->revenue, 2), 1, 0, 'R');
				$pdf->Cell(25,7, number_format($row->hours), 1, 0, 'R');
				$pdf->Cell(25,7, number_format($row->minutes), 1, 1, 'R');

				$totalareaTreated += $row->areaTreated;
				$totalqLiters += $row->qLiters;
				$totaldistance += $row->distance;
				$totalhours += $row->hours;
				$totalminutes += $row->minutes;
				$totalrevenue += $row->revenue;
			}
			$pdf->setFont('Arial','B',9);
			$pdf->Cell(140,7, 'GRAND TOTAL', 1, 0, 'C');
			$pdf->Cell(50,7, number_format($totalareaTreated, 2), 1, 0, 'R');
			$pdf->Cell(50,7, number_format($totalqLiters, 2), 1, 0, 'R');
			$pdf->Cell(50,7, number_format($totalrevenue, 2), 1, 0, 'R');
			$pdf->Cell(25,7, number_format($totalhours), 1, 0, 'R');
			$pdf->Cell(25,7, number_format($totalminutes), 1, 1, 'R');
			
		}
		else{
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(30,10, '', 1, 0, 'C'); 
			$pdf->Cell(50,10, 'AIRCRAFT TYPE', 1, 0, 'C'); 
			$pdf->Cell(50,10, 'AIRCRAFT NUMBER', 1, 0, 'C'); 
			$pdf->Cell(50,10, 'Location', 1, 0, 'C');
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(40,5, 'Total Area Treated', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(40,5, '(Hectares)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 40);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(40,5, 'Quantity', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(40,5, '(Liters)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 40);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(40,5, 'Revenue Derived', 'TLR',0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(40,5, '(Php)', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 40);
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$pdf->Cell(40,5, 'Flying Time', 1,0, 'C');
			$pdf->SetY($y + 5);
			$pdf->SetX($x);
			$pdf->Cell(20,5, 'Hours', 'BLR',0, 'C');
			$pdf->Cell(20,5, 'Minutes', 'BLR',0, 'C');
			$pdf->SetY($y);
			$pdf->SetX($x + 40);
			$pdf->Cell(1,10, '', 0,1, 'C');

			$pdf->SetFont('Arial','',9);
			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$start = 1;
					$end = 3;
				}
				else if ($quarter == "2nd Quarter") {
					$start = 4;
					$end = 6;
				}
				else if ($quarter == "3rd Quarter") {
					$start = 7;
					$end = 9;
				}
				else {
					$start = 10;
					$end = 12;
				}
			}
			else if ($report_type == 'Consolidated') {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$start = 1;
					$end = 6;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$start = 1;
					$end = 9;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$start = 1;
					$end = 12;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$start = 4;
					$end = 9;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$start = 4;
					$end = 12;
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$start = 7;
					$end = 12;
				}
				else {
					$start = 10;
					$end = 12;
				}
			}
			else {
				$start = 1;
				$end = 12;
			}
			$totalareaTreated = 0;
			$totalqLiters = 0;
			$totalrevenue = 0;
			$totalhours = 0;
			$totalminutes = 0;
			for ($a = $start; $a <= $end; $a++) {
				if ($a == '1') {
					$month = 'January';
				}
				else if ($a == '2') {
					$month = 'February';
				}
				else if ($a == '3') {
					$month = 'March';
				}
				else if ($a == '4') {
					$month = 'April';
				}
				else if ($a == '5') {
					$month = 'May';
				}
				else if ($a == '6') {
					$month = 'June';
				}
				else if ($a == '7') {
					$month = 'July';
				}
				else if ($a == '8') {
					$month = 'August';
				}
				else if ($a == '9') {
					$month = 'September';
				}
				else if ($a == '10') {
					$month = 'October';
				}
				else if ($a == '11') {
					$month = 'November';
				}
				else {
					$month = 'December';
				}

				$get61ASummaryPerOperator = $this->report_summary_model->get61aSummaryPerOperator($report_type, $quarter, $year, $start_date, $end_date, $airline, $a);
				
				if ($get61ASummaryPerOperator) {
					$pdf->Cell(30,7, $month, 1,0, 'C');
					$pdf->Cell(50,7, $get61ASummaryPerOperator->aircraft, 1,0, 'L');
					$pdf->Cell(50,7, $get61ASummaryPerOperator->aircraft_num, 1,0, 'L');
					$pdf->Cell(50,7, $get61ASummaryPerOperator->location, 1,0, 'L');	
					$pdf->Cell(40,7, number_format($get61ASummaryPerOperator->areaTreated, 2), 1, 0, 'R');
					$pdf->Cell(40,7, number_format($get61ASummaryPerOperator->qLiters, 2), 1, 0, 'R');
					$pdf->Cell(40,7, number_format($get61ASummaryPerOperator->revenue, 2), 1, 0, 'R');
					$pdf->Cell(20,7, number_format($get61ASummaryPerOperator->hours), 1, 0, 'R');
					$pdf->Cell(20,7, number_format($get61ASummaryPerOperator->minutes), 1, 1, 'R');

					$totalareaTreated += $get61ASummaryPerOperator->areaTreated;
					$totalqLiters += $get61ASummaryPerOperator->qLiters;
					$totalrevenue += $get61ASummaryPerOperator->revenue;
					$totalhours += $get61ASummaryPerOperator->hours;
					$totalminutes += $get61ASummaryPerOperator->minutes;
				}
			}
			$pdf->setFont('Arial','B',9);
			$pdf->Cell(30,7, 'GRAND TOTAL', 1, 0, 'C');
			$pdf->Cell(50,7, '', 1, 0, 'C');
			$pdf->Cell(50,7, '', 1, 0, 'C');
			$pdf->Cell(50,7, '', 1, 0, 'C');
			$pdf->Cell(40,7, number_format($totalareaTreated, 2), 1, 0, 'R');
			$pdf->Cell(40,7, number_format($totalqLiters, 2), 1, 0, 'R');
			$pdf->Cell(40,7, number_format($totalrevenue, 2), 1, 0, 'R');
			$pdf->Cell(20,7, number_format($totalhours), 1, 0, 'R');
			$pdf->Cell(20,7, number_format($totalminutes), 1, 1, 'R');
		}
		$pdf->Output();
	}

	public function form_61a_csv() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["rank_alpha"])) {
			$rank_alpha = $_GET['rank_alpha'];
			$rank_alpha = str_replace('+', ' ', $rank_alpha);
		}
		else {
			$rank_alpha = '';
		}
		if (!empty($_GET["airline"])) {
			$airline = $_GET['airline'];
			$airline = str_replace('+', ' ', $airline);
		}
		else {
			$airline = '';
		}

		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Form61a_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Form61a_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Form61a_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form 61A')
				->setDescription('Summary Report Form 61A')
				->setKeywords('summary report fORM 61-a Monthly Statement of Traffic and Operating Statistics (Agricultural Aviation)')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form 61A');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		if ($category == 'Summary Report') {
			$sheet->mergeCells('A1:E1');
			$sheet->mergeCells('A2:E2');
			$sheet->mergeCells('A3:E3');
			$sheet->mergeCells('A4:E4');
		}
		else if ($category == 'Detailed Summary Report') {
			$sheet->mergeCells('A1:H1');
			$sheet->mergeCells('A2:H2');
			$sheet->mergeCells('A3:H3');
			$sheet->mergeCells('A4:H4');
		}
		else {
			$sheet->mergeCells('A1:I1');
			$sheet->mergeCells('A2:I2');
			$sheet->mergeCells('A3:I3');
			$sheet->mergeCells('A4:I4');
		}

		$sheet->getCell('A2')->setValue('NON-SCHEDULED DOMESTIC AERIAL AGRICULTURAL SPRAYING SERVICES');
		$sheet->getCell('A3')->setValue('TRAFFIC AND OPERATING STATISTICS');
		$sheet->getStyle('A2:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		if ($report_type == 'Quarterly') {
			$sheet->getCell('A4')->setValue($quarter.' CY '.$year.' Summary');
		}
		else if ($report_type == 'Consolidated') {
			$sheet->getCell('A4')->setValue($start_date.' - '.$end_date.' CY '.$year);
		}
		else {
			$sheet->getCell('A4')->setValue('CY '.$year);
		}

		$get61aSummary = $this->report_summary_model->get61ASummary($report_type, $quarter, $year, $start_date, $end_date, $rank_alpha);
		if ($category == 'Summary Report') {
			$sheet->mergeCells('A5:B5');
			$sheet->getCell('A5')->setValue('Name of Operators ');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('C5')->setValue('Location');
			$sheet->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('D5')->setValue('Total Area Treated (Hectares)');
			$sheet->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('E5')->setValue('Quantity (Liters)');
			$sheet->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if (empty($get61aSummary)) {
				$sheet->getCell('A6')->setValue('No Record Found');
			}
			$count = 1;
			$totalareaTreated = 0;
			$totalqLiters = 0;
			$cell_row = 6;
			foreach ($get61aSummary as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($count++);
				$sheet->getCell('B'.$cell_row)->setValue($row->aircraft);
				$sheet->getCell('C'.$cell_row)->setValue($row->location);
				$sheet->getCell('D'.$cell_row)->setValue(number_format($row->areaTreated, 2));
				$sheet->getCell('E'.$cell_row)->setValue(number_format($row->qLiters, 2));

				$totalareaTreated += $row->areaTreated;
				$totalqLiters += $row->qLiters;
				$cell_row++;
			}
			$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('D'.$cell_row)->setValue(number_format($totalareaTreated, 2));
			$sheet->getCell('E'.$cell_row)->setValue(number_format($totalqLiters, 2));
		}

		else if ($category == 'Detailed Summary Report') {
			$sheet->mergeCells('A5:B6');
			$sheet->getCell('A5')->setValue('Name of Operators');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('C5:C6');
			$sheet->getCell('C5')->setValue('Location');
			$sheet->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('D5:D6');
			$sheet->getCell('D5')->setValue('Total Area Treated (Hectares)');
			$sheet->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('E5:E6');
			$sheet->getCell('E5')->setValue('Quantity (Liters)');
			$sheet->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('F5:F6');
			$sheet->getCell('F5')->setValue('Revenue Derived (Php)');
			$sheet->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('G5:H5');
			$sheet->getCell('G5')->setValue('Flying Time');
			$sheet->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('G6')->setValue('Hours');
			$sheet->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('H6')->setValue('Minutes');
			$sheet->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if (empty($get61aSummary)) {
				$sheet->getCell('A7')->setValue('No Record)');
			}
			$count = 1;
			$totalareaTreated = 0;
			$totalqLiters = 0;
			$totalrevenue = 0;
			$totalhours = 0;
			$totalminutes = 0;
			$cell_row = 7;
			foreach ($get61aSummary as $key => $row) {
				$sheet->getCell('A'.$cell_row)->setValue($count++);
				$sheet->getCell('B'.$cell_row)->setValue($row->aircraft);
				$sheet->getCell('C'.$cell_row)->setValue($row->location);
				$sheet->getCell('D'.$cell_row)->setValue(number_format($row->areaTreated, 2));
				$sheet->getCell('E'.$cell_row)->setValue(number_format($row->qLiters, 2));
				$sheet->getCell('F'.$cell_row)->setValue(number_format($row->revenue, 2));
				$sheet->getCell('G'.$cell_row)->setValue(number_format($row->hours, 0));
				$sheet->getCell('H'.$cell_row)->setValue(number_format($row->minutes, 2));

				$totalareaTreated += $row->areaTreated;
				$totalqLiters += $row->qLiters;
				$totalrevenue += $row->revenue;
				$totalhours += $row->hours;
				$totalminutes += $row->minutes;
				$cell_row++;
			}

			$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('D'.$cell_row)->setValue(number_format($totalareaTreated, 2));
			$sheet->getCell('E'.$cell_row)->setValue(number_format($totalqLiters, 2));
			$sheet->getCell('F'.$cell_row)->setValue(number_format($totalrevenue, 2));
			$sheet->getCell('G'.$cell_row)->setValue(number_format($totalhours, 0));
			$sheet->getCell('H'.$cell_row)->setValue(number_format($totalminutes, 2));
		}

		else {
			$getAirline = $this->report_summary_model->getAirline($airline);
			$sheet->getCell('A1')->setValue($getAirline->name);
			$sheet->mergeCells('A7:A8');
			$sheet->getCell('A7')->setValue('');
			$sheet->mergeCells('B7:B8');
			$sheet->getCell('B7')->setValue('Aircraft Type');
			$sheet->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('C7:C8');
			$sheet->getCell('C7')->setValue('Aircraft Number');
			$sheet->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('D7:D8');
			$sheet->getCell('D7')->setValue('Locations');
			$sheet->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('E7:E8');
			$sheet->getCell('E7')->setValue('Total Area Treated (Hectares)');
			$sheet->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('F7:F8');
			$sheet->getCell('F7')->setValue('Quantity (Liters)');
			$sheet->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('G7:H7');
			$sheet->getCell('G7')->setValue('Flying Time');
			$sheet->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('G8')->setValue('Hours');
			$sheet->getStyle('G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getCell('H8')->setValue('Minutes');
			$sheet->getStyle('H8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('I7:I8');
			$sheet->getCell('I7')->setValue('Revenue Derived (Php)');
			$sheet->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			if ($report_type == 'Quarterly') {
				if ($quarter == "1st Quarter") {
					$start = 1;
					$end = 3;
				}
				else if ($quarter == "2nd Quarter") {
					$start = 4;
					$end = 6;
				}
				else if ($quarter == "3rd Quarter") {
					$start = 7;
					$end = 9;
				}
				else {
					$start = 10;
					$end = 12;
				}
			}
			else if ($report_type == 'Consolidated') {
				if (($start_date == '1st Quarter') && ($end_date == '2nd Quarter')) {
					$start = 1;
					$end = 6;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '3rd Quarter')) {
					$start = 1;
					$end = 9;
				}
				else if (($start_date == '1st Quarter') && ($end_date == '4th Quarter')) {
					$start = 1;
					$end = 12;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '3rd Quarter')) {
					$start = 4;
					$end = 9;
				}
				else if (($start_date == '2nd Quarter') && ($end_date == '4th Quarter')) {
					$start = 4;
					$end = 12;
				}
				else if (($start_date == '3rd Quarter') &&($end_date == '4th Quarter')) {
					$start = 7;
					$end = 12;
				}
				else {
					$start = 10;
					$end = 12;
				}
			}
			else {
				$start = 1;
				$end = 12;
			}
			$cell_row = 9;
			$totalareaTreated = 0;
			$totalqLiters = 0;
			$totalrevenue = 0;
			$totalhours = 0;
			$totalminutes = 0;
			for ($a = $start; $a <= $end; $a++) {
				if ($a == '1') {
					$month = 'January';
				}
				else if ($a == '2') {
					$month = 'February';
				}
				else if ($a == '3') {
					$month = 'March';
				}
				else if ($a == '4') {
					$month = 'April';
				}
				else if ($a == '5') {
					$month = 'May';
				}
				else if ($a == '6') {
					$month = 'June';
				}
				else if ($a == '7') {
					$month = 'July';
				}
				else if ($a == '8') {
					$month = 'August';
				}
				else if ($a == '9') {
					$month = 'September';
				}
				else if ($a == '10') {
					$month = 'October';
				}
				else if ($a == '11') {
					$month = 'November';
				}
				else {
					$month = 'December';
				}

				$get61ASummaryPerOperator = $this->report_summary_model->get61aSummaryPerOperator($report_type, $quarter, $year, $start_date, $end_date, $airline, $a);
				
				if ($get61ASummaryPerOperator) {
					$sheet->getCell('A'.$cell_row)->setValue($month);
					$sheet->getCell('B'.$cell_row)->setValue($get61ASummaryPerOperator->title);
					$sheet->getCell('C'.$cell_row)->setValue($get61ASummaryPerOperator->aircraft_num);
					$sheet->getCell('D'.$cell_row)->setValue($get61ASummaryPerOperator->location);
					$sheet->getCell('E'.$cell_row)->setValue($get61ASummaryPerOperator->areaTreated);
					$sheet->getCell('F'.$cell_row)->setValue($get61ASummaryPerOperator->qLiters);
					$sheet->getCell('G'.$cell_row)->setValue($get61ASummaryPerOperator->hours);
					$sheet->getCell('H'.$cell_row)->setValue($get61ASummaryPerOperator->minutes);
					$sheet->getCell('I'.$cell_row)->setValue($get61ASummaryPerOperator->revenue);

					$totalareaTreated += $get61ASummaryPerOperator->areaTreated;
					$totalqLiters += $get61ASummaryPerOperator->qLiters;
					$totalrevenue += $get61ASummaryPerOperator->revenue;
					$totalhours += $get61ASummaryPerOperator->hours;
					$totalminutes += $get61ASummaryPerOperator->minutes;
					$cell_row++;
				}
			}
			$sheet->mergeCells('A'.$cell_row.':D'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('E'.$cell_row)->setValue($totalareaTreated);
			$sheet->getCell('F'.$cell_row)->setValue($totalqLiters);
			$sheet->getCell('G'.$cell_row)->setValue($totalrevenue);
			$sheet->getCell('H'.$cell_row)->setValue($totalhours);
			$sheet->getCell('I'.$cell_row)->setValue($totalminutes);
		}

		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');
	}

	public function form_71a_pdf() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["rank"])) {
			$rank = $_GET['rank'];
			$rank = str_replace('+', ' ', $rank);
		}
		else {
			$rank = '';
		}
		if (!empty($_GET["rank_category"])) {
			$rank_category = $_GET['rank_category'];
			$rank_category = str_replace('+', ' ', $rank_category);
		}
		else {
			$rank_category = '';
		}

		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);
		if ($rank == 'Top 30') {
			$pdf->Cell(335,7,'TOP 30 INTERNATIONAL AIRFREIGHT FORWARDERS', 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7,'INTERNATIONAL AIRFREIGHT FORWARDERS', 0, 1, 'C');
		}
		$pdf->Cell(335,7,'CARGO TRAFFIC FLOW STATISTICS', 0, 1, 'C');
		$pdf->Cell(335,7,'CHARGEABLE WEIGHT IN (Kilograms)', 0, 1, 'C');
		if ($rank == 'By Country') {
			$pdf->Cell(335,7,'by Country', 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7,'', 0, 1, 'C');
		}
		if ($report_type == 'Quarterly') {
			$pdf->Cell(335,7, $quarter.' CY '.$year, 0, 1, 'C');
		}
		else if ($report_type == 'Consolidated') {
			$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
		}
		else {
			$pdf->Cell(335,7, 'CY '.$year, 0, 1, 'C');
		}
		$pdf->Cell(335,7,'', 0, 1, 'C');
		if ($category == 'Ranking') {
			if ($rank_category == 'Direct Shipment') {
				$market_share = (!empty($_GET['ds_market_share'])) ? $_GET['ds_market_share'] : '';
				$cmarket_share = (!empty($_GET['ds_cmarket_share'])) ? $_GET['ds_cmarket_share'] : '';
				$rank_category_label = 'DIRECT SHIPMENT';
			}
			else if ($rank_category == 'Consolidation') {
				$market_share = (!empty($_GET['c_market_share'])) ? $_GET['c_market_share'] : '';
				$cmarket_share = (!empty($_GET['c_cmarket_share'])) ? $_GET['c_cmarket_share'] : '';
				$rank_category_label = 'CONSOLIDATION';
			}
			else if ($rank_category == 'Breakbulking') {
				$market_share = (!empty($_GET['b_market_share'])) ? $_GET['b_market_share'] : '';
				$cmarket_share = (!empty($_GET['b_cmarket_share'])) ?$_GET['b_cmarket_share'] : '';
				$rank_category_label = 'BREAKBULKING';
			}
			else {
				$market_share = (!empty($_GET['t_market_share'])) ? $_GET['t_market_share'] : '';
				$cmarket_share = (!empty($_GET['t_cmarket_share'])) ? $_GET['t_cmarket_share'] : '';
				$rank_category_label = 'CARGO WT In / Out';
			}
			$get71aRank = $this->report_summary_model->get71ARanked($report_type, $quarter, $year, $start_date, $end_date, $rank_category, $rank);
			if (($rank == 'All') || ($rank == 'Top 30')) {
				if (($market_share == '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(200, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(130, 10, $rank_category_label, 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					foreach ($get71aRank as $key => $row) {
						$pdf->Cell(200,7, $row->name, 1,0, 'L');
						$pdf->Cell(130,7, $row->weight, 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(90, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(80, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(80, 10, 'Market Share (%)', 1, 0, 'C');
					$pdf->Cell(80, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$market_share = 0;
					$cum_share = 0;
					foreach ($get71aRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71AWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(90,7, $row->name, 1,0, 'L');
						$pdf->Cell(80,7, number_format($row->weight, 2), 1,0, 'R');
						$pdf->Cell(80,7, number_format($market_share, 2).'%', 1,0, 'R');
						$pdf->Cell(80,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(130, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(100, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(100, 10, 'Market Share (%)', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$market_share = 0;
					$cum_share = 0;
					foreach ($get71aRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71AWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(130,7, $row->name, 1,0, 'L');
						$pdf->Cell(100,7, $row->weight, 1,0, 'R');
						$pdf->Cell(100,7, number_format($market_share, 2).'%', 1,1, 'R');
					}
				}
				else {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(130, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(100, 10, $rank_category_label, 1, 0, 'C');
					$pdf->Cell(100, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$market_share  	= 0;
                    $cum_share		= 0;
					foreach ($get71aRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71AWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(130,7, $row->name, 1,0, 'L');
						$pdf->Cell(100,7, $row->weight, 1,0, 'R');
						$pdf->Cell(100,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
			}
			else {
				if (($market_share == '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(100, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(100, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(130, 10, 'DIRECT SHIPMENT', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					foreach ($get71aRank as $key => $row) {
						$pdf->Cell(100,7, $row->country, 1,0, 'L');
						$pdf->Cell(100,7, $row->name, 1,0, 'L');
						$pdf->Cell(130,7, $row->weight, 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(70, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(70, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(70, 10, 'DIRECT SHIPMENT', 1, 1, 'C');
					$pdf->Cell(60, 10, 'Market Share (%)', 1, 0, 'C');
					$pdf->Cell(60, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$market_share  	= 0;
                    $cum_share		= 0;
					foreach ($get71aRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71AWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
                        $cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(70,7, $row->country, 1,0, 'L');
						$pdf->Cell(70,7, $row->name, 1,0, 'L');
						$pdf->Cell(70,7, $row->weight, 1,0, 'R');
						$pdf->Cell(60,7, number_format($market_share, 2).'%', 1,0, 'R');
						$pdf->Cell(60,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(90, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(90, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(75, 10, 'DIRECT SHIPMENT', 1, 0, 'C');
					$pdf->Cell(75, 10, 'Market Share (%)', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$market_share  	= 0;
					foreach ($get71aRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71AWeight($rank_category);
						$market_share  = (!empty($TotalWeight)) ? ($row->weight / $TotalWeight->weight) * 100 : 0;
						$pdf->Cell(90,7, $row->country, 1,0, 'L');
						$pdf->Cell(90,7, $row->name, 1,0, 'L');
						$pdf->Cell(75,7, $row->weight, 1,0, 'R');
						$pdf->Cell(75,7, number_format($market_share, 2).'%', 1,1, 'R');
					}
				}
				else {
					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(90, 10, 'COUNTRY', 1, 0, 'C');
					$pdf->Cell(90, 10, 'AIRFREIGHT FORWARDERS', 1, 0, 'C');
					$pdf->Cell(75, 10, 'DIRECT SHIPMENT', 1, 0, 'C');
					$pdf->Cell(75, 10, 'Cumulative Market Share', 1, 1, 'C');
					$pdf->SetFont('Arial','',9);
					if (empty($get71aRank)) {
						$pdf->Cell(330,7,"No Record",1,1, 'C');
					}
					$cum_share = 0;
					foreach ($get71aRank as $key => $row) {
						$TotalWeight = $this->report_summary_model->getTotal71AWeight($rank_category);
						$cum_share = (!empty($TotalWeight))? $cum_share + $market_share : $cum_share + 0;
						$pdf->Cell(90,7, $row->country, 1,0, 'L');
						$pdf->Cell(90,7, $row->name, 1,0, 'L');
						$pdf->Cell(75,7, $row->weight, 1,0, 'R');
						$pdf->Cell(75,7, number_format($cum_share, 2).'%', 1,1, 'R');
					}
				}
			}
			$pdf->SetFont('Arial','B',9);
			if ($report_type == 'Quarterly') {
				$pdf->Cell(65,7, '', 0, 0, 'C');
				$pdf->Cell(200,7, 'Cargo Statistics for ' .$quarter.' CY '.$year, 'TLR', 1, 'C');
			}
			else if ($report_type == 'Consolidated') {
				$pdf->Cell(65,7, '', 0, 0, 'C');
				$pdf->Cell(200,7, 'Cargo Statistics for ' .$start_date.' - '.$end_date.' CY '.$year, 'TLR', 1, 'C');
			}
			else {
				$pdf->Cell(65,7, '', 0, 0, 'C');
				$pdf->Cell(200,7, 'Cargo Statistics for CY '.$year, 'TLR', 1, 'C');
			}
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(200,5, 'Chargeable Weight in Kilograms', 'LR', 1, 'C');

			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'L', 0, 'C');
			$pdf->Cell(50,5, 'Direct Shipments', 0, 0, 'L');
			$pdf->Cell(85,5, '0.00', 'R', 1, 'L');

			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'L', 0, 'C');
			$pdf->Cell(50,5, 'Consolidations', 0, 0, 'L');
			$pdf->Cell(85,5, '140,779.00', 'R', 1, 'L');

			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'L', 0, 'C');	
			$pdf->Cell(50,5, 'Breakbulking', 0, 0, 'L');
			$pdf->Cell(85,5, '0.00', 'R', 1, 'L');

			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(65,5, '', 0, 0, 'C');
			$pdf->Cell(65,5, '', 'BL', 0, 'C');
			$pdf->Cell(50,5, 'TOTAL', 'B', 0, 'L');
			$pdf->Cell(85,5, '0.00', 'BR', 1, 'L');
		}
		else {
			$get71aSummary = $this->report_summary_model->get71aSummary($report_type, $quarter, $year, $start_date, $end_date);
			$ds_summary1 = (!empty($_GET["ds_summary1"]))? $_GET['ds_summary1'] : '';
			$ds_summary2 = (!empty($_GET["ds_summary2"]))? $_GET['ds_summary2'] : '';
			$ds_summary3 = (!empty($_GET["ds_summary3"]))? $_GET['ds_summary3'] : '';
			$ds_summary4 = (!empty($_GET["ds_summary4"]))? $_GET['ds_summary4'] : '';

			$c_summary1 = (!empty($_GET["c_summary1"]))? $_GET['c_summary1'] : '';
			$c_summary2 = (!empty($_GET["c_summary2"]))? $_GET['c_summary2'] : '';
			$c_summary3 = (!empty($_GET["c_summary3"]))? $_GET['c_summary3'] : '';
			$c_summary4 = (!empty($_GET["c_summary4"]))? $_GET['c_summary4'] : '';
			$c_summary5 = (!empty($_GET["c_summary5"]))? $_GET['c_summary5'] : '';

			$b_summary1 = (!empty($_GET["b_summary1"]))? $_GET['b_summary1'] : '';
			$b_summary2 = (!empty($_GET["b_summary2"]))? $_GET['b_summary2'] : '';
			$b_summary3 = (!empty($_GET["b_summary3"]))? $_GET['b_summary3'] : '';

			$direct_shipment = (!empty($_GET["direct_shipment"]))? $_GET['direct_shipment'] : '';
			$consolidation = (!empty($_GET["consolidation"]))? $_GET['consolidation'] : '';
			$breakbulking = (!empty($_GET["breakbulking"]))? $_GET['breakbulking'] : '';

			if (($ds_summary1 == '') && ($ds_summary2 == '') && ($ds_summary3 == '') && ($ds_summary4 == '')) {
				$direct_shipment = '';
			}
			if (($c_summary1 == '') && ($c_summary2 == '') && ($c_summary3 == '') && ($c_summary4 == '') && ($c_summary5 == '')) {
				$consolidation = '';
			}
			if (($b_summary1 == '') && ($b_summary2 == '') && ($b_summary3 == '')) {
				$breakbulking = '';
			}
			
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(50,5, '', 'TLR', 0, 'C');
			$dl = 0;
			$cl = 0;
			$bl = 0;
			if ($ds_summary1 != '') {
				$dl = $dl + 25;
			} 
			if ($ds_summary2 != '') {
				$dl = $dl + 25;
			} 
			if ($ds_summary3 != '') {
				$dl = $dl + 25;
			}
			if ($ds_summary4 != '') {
				$dl = $dl + 25;
			}  
			if ($c_summary1 != '') {
				$cl = $cl + 20;
			} 
			if ($c_summary2 != '') {
				$cl = $cl + 20;
			} 
			if ($c_summary3 != '') {
				$cl = $cl + 20;
			}
			if ($c_summary4 != '') {
				$cl = $cl + 20;
			} 
			if ($c_summary5 != '') {
				$cl = $cl + 20;
			} 
			if ($b_summary1 != '') {
				$bl = $bl + 25;
			} 
			if ($b_summary2 != '') {
				$bl = $bl + 25;
			} 
			if ($b_summary3 != '') {
				$bl = $bl + 25;
			}  
			if (($direct_shipment != '') && (($consolidation != '') OR ($breakbulking != ''))){
				$pdf->Cell($dl,5, 'Direct Shipment', 1,0, 'C');
			}
			else if (($direct_shipment != '') && (($consolidation == '') && ($breakbulking == ''))){
				$pdf->Cell($dl,5, 'Direct Shipment', 1,1, 'C');
			}
			else {

			}
			if (($consolidation != '') && ($breakbulking != '')){
				$pdf->Cell($cl,5, 'Consolidation', 1,0, 'C');
			}
			else if (($consolidation != '') && ($breakbulking == '')){
				$pdf->Cell($cl,5, 'Consolidation', 1,1, 'C');
			}
			else {

			}
			if ($breakbulking != ''){
				$pdf->Cell($bl,5, 'Breakbulking', 1,1, 'C');
			}
			else {

			}
			$pdf->Cell(50,10, 'Name of Airfreight Forwarder', 'BLR', 0, 'C');
			if ($ds_summary1 != '') {
				$pdf->Cell(25,10, 'MAWBs', 1, 0, 'C');
			}
			if ($ds_summary2 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Chargeable', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Weight (kg)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if ($ds_summary3 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Freight', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Charges (Php)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if ($ds_summary4 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Commission', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Earned (Php)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if (($consolidation != '') OR ($breakbulking != '')) {
				$pdf->Cell(0.1, 10, '', 0, 0, 'C');
			}
			else if (($consolidation == '') OR ($breakbulking == '')){
				$pdf->Cell(0.1, 10, '', 0, 1, 'C');
			}
			if ($c_summary1 != '') {
				$pdf->Cell(20,10, 'MAWBs', 1, 0, 'C');
			}
			if ($c_summary2 != '') {
				$pdf->Cell(20,10, 'MAWBs', 1, 0, 'C');
			}
			if ($c_summary3 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(20,5, 'Chargeable', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(20,5, 'Weight (kg)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 20);
			}
			if ($c_summary4 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(20,5, 'Freight', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(20,5, 'Charges', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 20);
			}
			if ($c_summary5 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(20,5, 'Gross', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(20,5, 'Revenue', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 20);
			}
			if ($breakbulking != '') {
				$pdf->Cell(0.1, 10, '', 0, 0, 'C');
			}
			else if (($consolidation == '') && ($breakbulking == '')) {
				
			}
			else if (($consolidation != '') && ($breakbulking == '')){
				$pdf->Cell(0.1, 10, '', 0, 1, 'C');
			}
			if ($b_summary1 != '') {
				$pdf->Cell(25,10, 'HAWBs', 1, 0, 'C');
			}
			if ($b_summary2 != '') {
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->Cell(25,5, 'Chargeable', 'TLR',0, 'C');
				$pdf->SetY($y + 5);
				$pdf->SetX($x);
				$pdf->Cell(25,5, 'Weight (kg)', 'BLR',0, 'C');
				$pdf->SetY($y);
				$pdf->SetX($x + 25);
			}
			if ($b_summary3 != '') {
				$pdf->Cell(25,10, 'Income (Php)', 1, 0, 'C');
			}
			if ($breakbulking != '') {
				$pdf->Cell(0.1, 10, '', 0, 1, 'C');
			}
			$totalnumMawbs1 = 0;
			$totalweight1 = 0;
			$totalfcharge1 = 0;
			$totalcommission = 0;
			$totalnumMawbs2 = 0;
			$totalnumHawbs1 = 0;
			$totalweight2 = 0;
			$totalfcharge2 = 0;
			$totalrevenue = 0;
			$totalnumHawbs2 = 0;
			$totalorgWeight = 0;
			$totalincomeBreak = 0;
			$pdf->SetFont('Arial', '', 9);
			foreach ($get71aSummary as $key => $row) {
				$pdf->Cell(50,7, $row->name, 1,0, 'L');
				if ($ds_summary1 != '') {
					$pdf->Cell(25,7, number_format($row->numMawbs1, 2), 1,0, 'R');
				}
				if ($ds_summary2 != '') {
					$pdf->Cell(25,7, number_format($row->weight1, 2), 1,0, 'R');;
				}
				if ($ds_summary3 != '') {
					$pdf->Cell(25,7, number_format($row->fcharge1, 2), 1,0, 'R');;
				}
				if ($ds_summary4 != '') {
					$pdf->Cell(25,7, number_format($row->commission, 2), 1,0, 'R');;
				}
				if (($consolidation != '') OR ($breakbulking != '')) {
					$pdf->Cell(0.1, 7, '', 0, 0, 'C');
				}
				else if (($consolidation == '') OR ($breakbulking == '')){
					$pdf->Cell(0.1, 7, '', 0, 1, 'C');
				}
				if ($c_summary1 != '') {
					$pdf->Cell(20,7, number_format($row->numMawbs2, 2), 1,0, 'R');
				}
				if ($c_summary2 != '') {
					$pdf->Cell(20,7, number_format($row->numHawbs1, 2), 1,0, 'R');;
				}
				if ($c_summary3 != '') {
					$pdf->Cell(20,7, number_format($row->weight2, 2), 1,0, 'R');;
				}
				if ($c_summary4 != '') {
					$pdf->Cell(20,7, number_format($row->fcharge2, 2), 1,0, 'R');;
				}
				if ($c_summary5 != '') {
					$pdf->Cell(20,7, number_format($row->revenue, 2), 1,0, 'R');;
				}
				if ($breakbulking != '') {
					$pdf->Cell(0.1, 7, '', 0, 0, 'C');
				}
				else if (($consolidation == '') && ($breakbulking == '')) {
					
				}
				else if (($consolidation != '') && ($breakbulking == '')){
					$pdf->Cell(0.1, 7, '', 0, 1, 'C');
				}
				if ($b_summary1 != '') {
					$pdf->Cell(25,7, number_format($row->numHawbs2, 2), 1,0, 'R');
				}
				if ($b_summary2 != '') {
					$pdf->Cell(25,7, number_format($row->orgWeight, 2), 1,0, 'R');;
				}
				if ($b_summary3 != '') {
					$pdf->Cell(25,7, number_format($row->incomeBreak, 2), 1,0, 'R');;
				}
				if ($breakbulking != '') {
					$pdf->Cell(0.1, 7, '', 0, 1, 'C');
				}
				$totalnumMawbs1 += $row->numMawbs1;
				$totalweight1 += $row->weight1;
				$totalfcharge1 += $row->fcharge1;
				$totalcommission += $row->commission;
				$totalnumMawbs2 += $row->numMawbs2;
				$totalnumHawbs1 += $row->numHawbs1;
				$totalweight2 += $row->weight2;
				$totalfcharge2 += $row->fcharge2;
				$totalrevenue += $row->revenue;
				$totalnumHawbs2 += $row->numHawbs2;
				$totalorgWeight += $row->orgWeight;
				$totalincomeBreak += $row->incomeBreak;
			}
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(50,7, 'GRAND TOTAL:', 1,0, 'C');
			if ($ds_summary1 != '') {
				$pdf->Cell(25,7, number_format($totalnumMawbs1, 2), 1,0, 'R');
			}
			if ($ds_summary2 != '') {
				$pdf->Cell(25,7, number_format($totalweight1, 2), 1,0, 'R');;
			}
			if ($ds_summary3 != '') {
				$pdf->Cell(25,7, number_format($totalfcharge1, 2), 1,0, 'R');;
			}
			if ($ds_summary4 != '') {
				$pdf->Cell(25,7, number_format($totalcommission, 2), 1,0, 'R');;
			}
			if ($c_summary1 != '') {
				$pdf->Cell(20,7, number_format($totalnumMawbs2, 2), 1,0, 'R');
			}
			if ($c_summary2 != '') {
				$pdf->Cell(20,7, number_format($totalnumHawbs1, 2), 1,0, 'R');;
			}
			if ($c_summary3 != '') {
				$pdf->Cell(20,7, number_format($totalweight2, 2), 1,0, 'R');;
			}
			if ($c_summary4 != '') {
				$pdf->Cell(20,7, number_format($totalfcharge2, 2), 1,0, 'R');;
			}
			if ($c_summary5 != '') {
				$pdf->Cell(20,7, number_format($totalrevenue, 2), 1,0, 'R');;
			}
			if ($b_summary1 != '') {
				$pdf->Cell(25,7, number_format($totalnumHawbs2, 2), 1,0, 'R');
			}
			if ($b_summary2 != '') {
				$pdf->Cell(25,7, number_format($totalorgWeight, 2), 1,0, 'R');;
			}
			if ($b_summary3 != '') {
				$pdf->Cell(25,7, number_format($totalincomeBreak, 2), 1,0, 'R');;
			}

		}

		$pdf->Output();
	}

	public function form_71a_csv() {
		$report_type = $_GET['report_type'];
		$quarter = $_GET['quarter'];
		$quarter = str_replace('+', ' ', $quarter);
		$start_date = $_GET['start_date'];
		$start_date = str_replace('+', ' ', $start_date);
		$end_date = $_GET['end_date'];
		$end_date = str_replace('+', ' ', $end_date);
		$year = $_GET['year'];
		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}
		if (!empty($_GET["rank"])) {
			$rank = $_GET['rank'];
			$rank = str_replace('+', ' ', $rank);
		}
		else {
			$rank = '';
		}
		if (!empty($_GET["rank_category"])) {
			$rank_category = $_GET['rank_category'];
			$rank_category = str_replace('+', ' ', $rank_category);
		}
		else {
			$rank_category = '';
		}

		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Form71a_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Form71a_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Form71a_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form 71A')
				->setDescription('Summary Report Form 71A')
				->setKeywords('summary report fORM 71-a international airfreight forwarder cargo production report')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form 71A');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		if ($category == 'Ranking') {
			$sheet->mergeCells('A1:D1');
			$sheet->mergeCells('A2:D2');
			$sheet->mergeCells('A3:D3');
			$sheet->mergeCells('A4:D4');
			$sheet->mergeCells('A5:D5');
		}
		else {
			$sheet->mergeCells('A1:AC1');
			$sheet->mergeCells('A2:AC2');
			$sheet->mergeCells('A3:AC3');
			$sheet->mergeCells('A4:AC4');
			$sheet->mergeCells('A5:AC5');
		}

		if ($rank == 'Top 30') {
			$sheet->getCell('A1')->setValue('TOP 30 INTERNATIONAL AIRFREIGHT FORWARDERS');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else {
			$sheet->getCell('A1')->setValue('INTERNATIONAL AIRFREIGHT FORWARDERS');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		$sheet->getCell('A2')->setValue('CARGO TRAFFIC FLOW STATISTICS');
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getCell('A3')->setValue('CHARGEABLE WEIGHT IN (Kilograms)');
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		if ($rank == 'By Country') {
			$sheet->getCell('A4')->setValue('by Country');
			$sheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		if ($report_type == 'Quarterly') {
			$sheet->getCell('A5')->setValue($quarter.' CY '.$year.' Summary');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if ($report_type == 'Consolidated') {
			$sheet->getCell('A5')->setValue($start_date.' - '.$end_date.' CY '.$year);
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else {
			$sheet->getCell('A5')->setValue('CY '.$year);
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		$sheet->getStyle('A7:D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		if ($category == 'Ranking') {
			if ($rank_category == 'Direct Shipment') {
				$market_share = (!empty($_GET['ds_market_share'])) ? $_GET['ds_market_share'] : '';
				$cmarket_share = (!empty($_GET['ds_cmarket_share'])) ? $_GET['ds_cmarket_share'] : '';
				$rank_category_label = 'DIRECT SHIPMENT';
			}
			else if ($rank_category == 'Consolidation') {
				$market_share = (!empty($_GET['c_market_share'])) ? $_GET['c_market_share'] : '';
				$cmarket_share = (!empty($_GET['c_cmarket_share'])) ? $_GET['c_cmarket_share'] : '';
				$rank_category_label = 'CONSOLIDATION';
			}
			else if ($rank_category == 'Breakbulking') {
				$market_share = (!empty($_GET['b_market_share'])) ? $_GET['b_market_share'] : '';
				$cmarket_share = (!empty($_GET['b_cmarket_share'])) ?$_GET['b_cmarket_share'] : '';
				$rank_category_label = 'BREAKBULKING';
			}
			else {
				$market_share = (!empty($_GET['t_market_share'])) ? $_GET['t_market_share'] : '';
				$cmarket_share = (!empty($_GET['t_cmarket_share'])) ? $_GET['t_cmarket_share'] : '';
				$rank_category_label = 'CARGO WT In / Out';
			}
			$get71aRank = $this->report_summary_model->get71ARanked($report_type, $quarter, $year, $start_date, $end_date, $rank_category, $rank);
			if (($rank == 'All') || ($rank == 'Top 30')) {
				if (($market_share == '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue($row->weight);
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					$sheet->getCell('C7')->setValue('Market Share (%)');
					$sheet->getCell('D7')->setValue('Cumulative Market Share');
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue($row->weight);
						$sheet->getCell('C'.$cell_row)->setValue('Market Share');
						$sheet->getCell('D'.$cell_row)->setValue('Cumulative Market Share');
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					$sheet->getCell('C7')->setValue('Market Share (%)');
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue($row->weight);
						$sheet->getCell('C'.$cell_row)->setValue('Market Share');
						$cell_row++;
					}
				}
				else {
					$sheet->getCell('A7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('B7')->setValue($rank_category_label);
					$sheet->getCell('C7')->setValue('Cumulative Market Share');
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->name);
						$sheet->getCell('B'.$cell_row)->setValue($row->weight);
						$sheet->getCell('C'.$cell_row)->setValue('Cumulative Market Share');
						$cell_row++;
					}
				}
			}
			else {
				if (($market_share == '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue($row->weight);
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share != '')) {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					$sheet->getCell('D7')->setValue('Market Share (%)');
					$sheet->getCell('E7')->setValue('Cumulative Market Share');
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue($row->weight);
						$sheet->getCell('D'.$cell_row)->setValue('Market Share');
						$sheet->getCell('E'.$cell_row)->setValue('Cumulative Market Share');
						$cell_row++;
					}
				}
				else if (($market_share != '') && ($cmarket_share == '')) {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					$sheet->getCell('D7')->setValue('Market Share (%)');
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue($row->weight);
						$sheet->getCell('D'.$cell_row)->setValue('Market Share');
						$cell_row++;
					}
				}
				else {
					$sheet->getCell('A7')->setValue('COUNTRY');
					$sheet->getCell('B7')->setValue('AIRFREIGHT FORWARDERS');
					$sheet->getCell('C7')->setValue('DIRECT SHIPMENT');
					$sheet->getCell('D7')->setValue('Cumulative Market Share');
					if (empty($get71aRank)) {
						$sheet->getCell('A8')->setValue('No Record');
					}
					$cell_row = 8;
					foreach ($get71aRank as $key => $row) {
						$sheet->getCell('A'.$cell_row)->setValue($row->country);
						$sheet->getCell('B'.$cell_row)->setValue($row->name);
						$sheet->getCell('C'.$cell_row)->setValue($row->weight);
						$sheet->getCell('D'.$cell_row)->setValue('Cumulative Market Share');
						$cell_row++;
					}
				}
			}
		}
		else {
			$get71aSummary = $this->report_summary_model->get71aSummary($report_type, $quarter, $year, $start_date, $end_date);
			$ds_summary1 = (!empty($_GET["ds_summary1"]))? $_GET['ds_summary1'] : '';
			$ds_summary2 = (!empty($_GET["ds_summary2"]))? $_GET['ds_summary2'] : '';
			$ds_summary3 = (!empty($_GET["ds_summary3"]))? $_GET['ds_summary3'] : '';
			$ds_summary4 = (!empty($_GET["ds_summary4"]))? $_GET['ds_summary4'] : '';

			$c_summary1 = (!empty($_GET["c_summary1"]))? $_GET['c_summary1'] : '';
			$c_summary2 = (!empty($_GET["c_summary2"]))? $_GET['c_summary2'] : '';
			$c_summary3 = (!empty($_GET["c_summary3"]))? $_GET['c_summary3'] : '';
			$c_summary4 = (!empty($_GET["c_summary4"]))? $_GET['c_summary4'] : '';
			$c_summary5 = (!empty($_GET["c_summary5"]))? $_GET['c_summary5'] : '';

			$b_summary1 = (!empty($_GET["b_summary1"]))? $_GET['b_summary1'] : '';
			$b_summary2 = (!empty($_GET["b_summary2"]))? $_GET['b_summary2'] : '';
			$b_summary3 = (!empty($_GET["b_summary3"]))? $_GET['b_summary3'] : '';

			$sheet->mergeCells('A7:C8');
			$sheet->getCell('A7')->setValue('NAME OF AIRFREIGHT FORWARDER');
			$sheet->getStyle('A7:AC8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('D7:M7');
			$sheet->getCell('D7')->setValue('Direct Shipment');
			$sheet->getCell('D8')->setValue('MAWBs');
			$sheet->mergeCells('E8:G8');
			$sheet->getCell('E8')->setValue('Chargeable Weight (kg)');
			$sheet->mergeCells('H8:J8');
			$sheet->getCell('H8')->setValue('Airline Freight Charges (Php)');
			$sheet->mergeCells('K8:M8');
			$sheet->getCell('K8')->setValue('Commission Earned (Php)');
			$sheet->mergeCells('N7:X7');
			$sheet->getCell('N7')->setValue('Consolidation');
			$sheet->getCell('N8')->setValue('MAWBs');
			$sheet->getCell('O8')->setValue('HAWBs');
			$sheet->mergeCells('P8:R8');
			$sheet->getCell('P8')->setValue('Chargeable Weight (kg)');
			$sheet->mergeCells('S8:U8');
			$sheet->getCell('S8')->setValue('Airline Freight Charges (Php)');
			$sheet->mergeCells('V8:X8');
			$sheet->getCell('V8')->setValue('Gross Consolidated Revenue (Php)');
			$sheet->mergeCells('Y7:AC7');
			$sheet->getCell('Y7')->setValue('Breakbulking');
			$sheet->getCell('Y8')->setValue('HAWBS');
			$sheet->mergeCells('Z8:AB8');
			$sheet->getCell('Z8')->setValue('Chargeable Weight (kg)');
			$sheet->getCell('AC8')->setValue('Income (Php)');

			$totalnumMawbs1 = 0;
			$totalweight1 = 0;
			$totalfcharge1 = 0;
			$totalcommission = 0;
			$totalnumMawbs2 = 0;
			$totalnumHawbs1 = 0;
			$totalweight2 = 0;
			$totalfcharge2 = 0;
			$totalrevenue = 0;
			$totalnumHawbs2 = 0;
			$totalorgWeight = 0;
			$totalincomeBreak = 0;
			$cell_row = 9;

			foreach ($get71aSummary as $key => $row) {
				$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
				$sheet->getCell('A'.$cell_row)->setValue($row->name);
				$sheet->getCell('D'.$cell_row)->setValue(number_format($row->numMawbs1, 2));
				$sheet->mergeCells('E'.$cell_row.':G'.$cell_row);
				$sheet->getCell('E'.$cell_row)->setValue(number_format($row->weight1, 2));
				$sheet->mergeCells('H'.$cell_row.':J'.$cell_row);
				$sheet->getCell('H'.$cell_row)->setValue(number_format($row->fcharge1, 2));
				$sheet->mergeCells('K'.$cell_row.':M'.$cell_row);
				$sheet->getCell('K'.$cell_row)->setValue(number_format($row->commission, 2));
				$sheet->getCell('N'.$cell_row)->setValue(number_format($row->numMawbs2, 2));
				$sheet->getCell('O'.$cell_row)->setValue(number_format($row->numHawbs1, 2));
				$sheet->mergeCells('P'.$cell_row.':R'.$cell_row);
				$sheet->getCell('P'.$cell_row)->setValue(number_format($row->weight2, 2));
				$sheet->mergeCells('S'.$cell_row.':U'.$cell_row);
				$sheet->getCell('S'.$cell_row)->setValue(number_format($row->fcharge2, 2));
				$sheet->mergeCells('V'.$cell_row.':X'.$cell_row);
				$sheet->getCell('V'.$cell_row)->setValue(number_format($row->revenue, 2));
				$sheet->getCell('Y'.$cell_row)->setValue(number_format($row->numHawbs2, 2));
				$sheet->mergeCells('Z'.$cell_row.':AB'.$cell_row);
				$sheet->getCell('Z'.$cell_row)->setValue(number_format($row->orgWeight, 2));
				$sheet->getCell('AC'.$cell_row)->setValue(number_format($row->incomeBreak, 2));

				$totalnumMawbs1 += $row->numMawbs1;
				$totalweight1 += $row->weight1;
				$totalfcharge1 += $row->fcharge1;
				$totalcommission += $row->commission;
				$totalnumMawbs2 += $row->numMawbs2;
				$totalnumHawbs1 += $row->numHawbs1;
				$totalweight2 += $row->weight2;
				$totalfcharge2 += $row->fcharge2;
				$totalrevenue += $row->revenue;
				$totalnumHawbs2 += $row->numHawbs2;
				$totalorgWeight += $row->orgWeight;
				$totalincomeBreak += $row->incomeBreak;
				$cell_row++;
			}
			$sheet->mergeCells('A'.$cell_row.':C'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('D'.$cell_row)->setValue(number_format($totalnumMawbs1, 2));
			$sheet->mergeCells('E'.$cell_row.':G'.$cell_row);
			$sheet->getCell('E'.$cell_row)->setValue(number_format($totalweight1, 2));
			$sheet->mergeCells('H'.$cell_row.':J'.$cell_row);
			$sheet->getCell('H'.$cell_row)->setValue(number_format($totalfcharge1, 2));
			$sheet->mergeCells('K'.$cell_row.':M'.$cell_row);
			$sheet->getCell('K'.$cell_row)->setValue(number_format($totalcommission, 2));
			$sheet->getCell('N'.$cell_row)->setValue(number_format($totalnumMawbs2, 2));
			$sheet->getCell('O'.$cell_row)->setValue(number_format($totalnumHawbs1, 2));
			$sheet->mergeCells('P'.$cell_row.':R'.$cell_row);
			$sheet->getCell('P'.$cell_row)->setValue(number_format($totalweight2, 2));
			$sheet->mergeCells('S'.$cell_row.':U'.$cell_row);
			$sheet->getCell('S'.$cell_row)->setValue(number_format($totalfcharge2, 2));
			$sheet->mergeCells('V'.$cell_row.':X'.$cell_row);
			$sheet->getCell('V'.$cell_row)->setValue(number_format($totalrevenue, 2));
			$sheet->getCell('Y'.$cell_row)->setValue(number_format($totalnumHawbs2, 2));
			$sheet->mergeCells('Z'.$cell_row.':AB'.$cell_row);
			$sheet->getCell('Z'.$cell_row)->setValue(number_format($totalorgWeight, 2));
			$sheet->getCell('AC'.$cell_row)->setValue(number_format($totalincomeBreak, 2));

			$sheet->getStyle('D9:AC'.$cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}

		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');
	}

	public function form_71c_pdf(){
		$report_type = $_GET['report_type'];
		$quarter	 = $_GET['quarter'];
		$quarter 	 = str_replace('+', ' ', $quarter);
		$start_date  = $_GET['start_date'];
		$start_date  = str_replace('+', ' ', $start_date);
		$end_date	 = $_GET['end_date'];
		$end_date 	 = str_replace('+', ' ', $end_date);
		$year		 = $_GET['year'];

		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(335,7,'CARGO SALES AGENTS', 0, 1, 'C');
		$pdf->Cell(335,7,'CHARGEABLE WEIGHT (In Kilograms)', 0, 1, 'C');

		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}

		if (!empty($_GET["filterBy"])) {
			$filterBy = $_GET['filterBy'];
			$filterBy = str_replace('+', ' ', $filterBy);
		}
		else {
			$filterBy = '';
		}

		if (!empty($_GET["c_filter"])) {
			$c_filter = $_GET['c_filter'];
			$c_filter = str_replace('+', ' ', $c_filter);
		}
		else {
			$c_filter = '';
		}

		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(335,7,'CARGO SALES AGENTS', 0, 1, 'C');
		$pdf->Cell(335,7,'CHARGEABLE WEIGHT (In Kilograms)', 0, 1, 'C');
		if($category == 'byCountry'){
			$pdf->Cell(335,7,'by Country', 0, 1, 'C');
		}		
		if($report_type == 'Quarterly'){
			if($quarter == '1'){$pdf->Cell(335,7, '1st Quarter'.', CY '.$year, 0, 1, 'C');}
			else if($quarter == '2'){$pdf->Cell(335,7, '2nd Quarter'.', CY '.$year, 0, 1, 'C');}
			else if($quarter == '3'){$pdf->Cell(335,7, '3rd Quarter'.', CY '.$year, 0, 1, 'C');}
			else if($quarter == '4'){$pdf->Cell(335,7, '4th Quarter'.', CY '.$year, 0, 1, 'C');}
			$pdf->Cell(335,7,$quarter.' CY '.$year, 0, 1, 'C');
		}
		else if($report_type == 'Yearly'){
			$pdf->Cell(335,7,'CY '.$year, 0, 1, 'C');
		}
		else if ($report_type == 'Consolidated') {
			$pdf->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
		}
		if($category == 'summaryreport'){
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,7, '', 0, 0, 'C');
			$pdf->Cell(150,7, 'CARGO SALES AGENT', 1, 0, 'C'); 
			$pdf->Cell(150,7, 'CHARGEABLE WEIGHT', 1, 1, 'C');

			$get71C = $this->report_summary_model->get71cSummary($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date);
			$count = 0;
			$totalweight = 0;
			foreach ($get71C as $key => $row) {
				$count ++;
				$pdf->Cell(20,7, '', 0, 0, 'C');
				$pdf->Cell(20,7, $count, 1, 0, 'C'); 
				$pdf->Cell(130,7, $row->name, 1, 0, 'C');
				$pdf->Cell(150,7, $row->weight, 1, 1, 'R');
				$totalweight += $row->weight;
			}
			
			$pdf->Cell(20,7, '', 0, 0, 'C');
			$pdf->Cell(20,7, '', 1, 0, 'C'); 
			$pdf->Cell(130,7, 'TOTAL', 1, 0, 'C');
			$pdf->Cell(150,7, number_format($totalweight, 2), 1, 1, 'R');
		}

		else {
			$get71Cd = $this->report_summary_model->get71cSummaryDomestic($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date);

			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(20,7, 'DOMESTIC', 0, 1, 'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(65,7, 'REGION', 1, 0, 'C');
			$pdf->Cell(65,7, 'PART', 1, 0, 'C');
			$pdf->Cell(65,7, 'COUNTRY', 1, 0, 'C');
			$pdf->Cell(75,7, 'CARGO SALES AGENT', 1, 0, 'C');
			$pdf->Cell(65,7, 'CHARGEABLE WEIGHT', 1, 1, 'C');

			$totalweight = 0;
			foreach ($get71Cd as $key => $row) {
				$pdf->Cell(65,7, $row->title, 1, 0, 'C');
				$pdf->Cell(65,7, $row->part, 1, 0, 'C');
				$pdf->Cell(65,7, 'Philippines', 1, 0, 'C');
				$pdf->Cell(75,7, $row->name, 1, 0, 'C');
				$pdf->Cell(65,7, $row->weight, 1, 1, 'R');
				$totalweight += $row->weight;
			}
			
			$pdf->Cell(65,7, '', 1, 0, 'C');
			$pdf->Cell(65,7, '', 1, 0, 'C');
			$pdf->Cell(65,7, '', 1, 0, 'C');
			$pdf->Cell(75,7, 'TOTAL', 1, 0, 'C');
			$pdf->Cell(65,7, number_format($totalweight, 2), 1, 1, 'R');

			$pdf->Cell(20,7, '', 0, 1, 'L');

			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(20,7, 'INTERNATIONAL', 0, 1, 'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(83,7, 'PART', 1, 0, 'C');
			$pdf->Cell(83,7, 'COUNTRY', 1, 0, 'C');
			$pdf->Cell(85,7, 'CARGO SALES AGENT', 1, 0, 'C');
			$pdf->Cell(84,7, 'CHARGEABLE WEIGHT', 1, 1, 'C');
			$get71Ci = $this->report_summary_model->get71cSummaryInternational($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date);
			$totalweight1 = 0;
			foreach ($get71Ci as $key => $row) {
				$pdf->Cell(83,7, $row->title, 1, 0, 'C');
				$pdf->Cell(83,7, $row->part, 1, 0, 'C');
				$pdf->Cell(85,7, $row->name, 1, 0, 'C');
				$pdf->Cell(84,7, $row->weight, 1, 1, 'R');
				$totalweight1 += $row->weight;
			}

			$pdf->Cell(83,7, '', 1, 0, 'C');
			$pdf->Cell(83,7, '', 1, 0, 'C');
			$pdf->Cell(85,7, 'TOTAL', 1, 0, 'C');
			$pdf->Cell(84,7, number_format($totalweight1, 2), 1, 1, 'R');
		}		

		$pdf->Output();
	}

	public function form_71c_csv(){
		$report_type = $_GET['report_type'];
		$quarter	 = $_GET['quarter'];
		$quarter 	 = str_replace('+', ' ', $quarter);
		$start_date  = $_GET['start_date'];
		$start_date  = str_replace('+', ' ', $start_date);
		$end_date	 = $_GET['end_date'];
		$end_date 	 = str_replace('+', ' ', $end_date);
		$year		 = $_GET['year'];

		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(335,7,'CARGO SALES AGENTS', 0, 1, 'C');
		$pdf->Cell(335,7,'CHARGEABLE WEIGHT (In Kilograms)', 0, 1, 'C');

		if (!empty($_GET["category"])) {
			$category = $_GET['category'];
			$category = str_replace('+', ' ', $category);
		}
		else {
			$category = '';
		}

		if (!empty($_GET["filterBy"])) {
			$filterBy = $_GET['filterBy'];
			$filterBy = str_replace('+', ' ', $filterBy);
		}
		else {
			$filterBy = '';
		}

		if (!empty($_GET["c_filter"])) {
			$c_filter = $_GET['c_filter'];
			$c_filter = str_replace('+', ' ', $c_filter);
		}
		else {
			$c_filter = '';
		}

		if ($report_type == 'Quarterly') {
			$filename = 'Summary_Report_Form71c_'.$quarter.'_'.$year;
		}
		else if ($report_type == 'Consolidated') {
			$filename = 'Summary_Report_Form71c_'.$start_date.'-'.$end_date.'_'.$year;
		}
		else {
			$filename = 'Summary_Report_Form71c_'.$year;
		}

		$excel = new PHPExcel();
		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Summary Report Form 71C')
				->setDescription('Summary Report Form 71C')
				->setKeywords('summary report fORM 71-c Cargo Sales Agency Report')
				->setCategory('summary report');

		$excel->getActiveSheet()->setTitle('Summary Report Form 71C');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();
		$sheet->mergeCells('A1:K1');
		$sheet->mergeCells('A2:K2');
		$sheet->mergeCells('A3:K3');
		$sheet->mergeCells('A4:K4');
		$sheet->mergeCells('A5:F5');
		$sheet->mergeCells('G5:K5');


		$sheet->getCell('A1')->setValue('CARGO SALES AGENTS');
		$sheet->getCell('A2')->setValue('CHARGEABLE WEIGHT (In Kilograms)');
		if($category == 'byCountry'){
			$sheet->getCell('A4')->setValue('by Country');
			$sheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
		}
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if ($report_type == 'Quarterly') {
			$sheet->getCell('A3')->setValue($quarter.' CY '.$year.' Summary');
			$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else if ($report_type == 'Consolidated') {
			$sheet->getCell('A3')->setValue($start_date.' - '.$end_date.' CY '.$year);
			$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else {
			$sheet->getCell('A3')->setValue('CY '.$year);
			$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		if ($category == 'summaryreport') {
			$sheet->getCell('A5')->setValue('CARGO SALES AGENTS');
			$sheet->getCell('G5')->setValue('CHARGEABLE WEIGHT');
			$sheet->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$get71C = $this->report_summary_model->get71cSummary($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date);
			if ($category == 'summaryreport') {
				$count = 1;
				$totalweight = 0;
				$cell_row = 6;
				foreach ($get71C as $key => $row) {
					
					$sheet->mergeCells('B'.$cell_row.':F'.$cell_row);
					$sheet->mergeCells('G'.$cell_row.':K'.$cell_row);
					$sheet->getCell('A'.$cell_row)->setValue($count++);
					$sheet->getCell('B'.$cell_row)->setValue($row->name);
					$sheet->getCell('G'.$cell_row)->setValue(number_format($row->weight, 0));
	
					$totalweight += $row->weight;
					$cell_row++;
				}
				$sheet->mergeCells('A'.$cell_row.':F'.$cell_row);
				$sheet->mergeCells('G'.$cell_row.':K'.$cell_row);
				$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
				$sheet->getCell('G'.$cell_row)->setValue(number_format($totalweight, 0));
				$sheet->getStyle('A'.$cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
			}
		}
		else{
			$get71Cd = $this->report_summary_model->get71cSummaryDomestic($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date);			
			$sheet->mergeCells('A6:K6');
			$sheet->mergeCells('A7:B7');
			$sheet->mergeCells('C7:D7');
			$sheet->mergeCells('E7:F7');
			$sheet->mergeCells('G7:I7');
			$sheet->mergeCells('J7:K7');
			$sheet->getCell('A6')->setValue('DOMESTIC');
			$sheet->getCell('A7')->setValue('REGION');
			$sheet->getCell('C7')->setValue('PART');
			$sheet->getCell('E7')->setValue('COUNTRY');
			$sheet->getCell('G7')->setValue('CARGO SALES AGENT');
			$sheet->getCell('J7')->setValue('CHARGEABLE WEIGHT');
			$sheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$sheet->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$sheet->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$sheet->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$sheet->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	

			$totalweight = 0;
			$cell_row = 8;
			foreach ($get71Cd as $key => $row) {
				$sheet->mergeCells('A'.$cell_row.':B'.$cell_row);
				$sheet->mergeCells('C'.$cell_row.':D'.$cell_row);
				$sheet->mergeCells('E'.$cell_row.':F'.$cell_row);
				$sheet->mergeCells('G'.$cell_row.':I'.$cell_row);
				$sheet->mergeCells('J'.$cell_row.':K'.$cell_row);

				$sheet->getCell('A'.$cell_row)->setValue($row->title);
				$sheet->getCell('C'.$cell_row)->setValue($row->part);
				$sheet->getCell('E'.$cell_row)->setValue('Philippines');
				$sheet->getCell('G'.$cell_row)->setValue($row->name);
				$sheet->getCell('J'.$cell_row)->setValue(number_format($row->weight, 2));

				$totalweight += $row->weight;
				$cell_row++;
			}
			
			$sheet->mergeCells('A'.$cell_row.':I'.$cell_row);
			$sheet->mergeCells('J'.$cell_row.':K'.$cell_row);
			$sheet->getCell('A'.$cell_row)->setValue('GRAND TOTAL');
			$sheet->getCell('J'.$cell_row)->setValue(number_format($totalweight, 2));
			$sheet->getStyle('A'.$cell_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
			
			
			$space = $cell_row + 1;
			$cell  = $space + 1;
			$cell1 = $cell + 1;
			$cell2 = $cell1 + 1;
			$cell3 = $cell2 + 1;
			$sheet->mergeCells('A'.$space.':K'.$space);
			$sheet->mergeCells('A'.$cell.':K'.$cell);
			$sheet->getCell('A'.$cell)->setValue('INTERNATIONAL');
			$sheet->mergeCells('A'.$cell1.':B'.$cell1);
			$sheet->mergeCells('C'.$cell1.':E'.$cell1);
			$sheet->mergeCells('F'.$cell1.':H'.$cell1);
			$sheet->mergeCells('I'.$cell1.':K'.$cell1);
			$sheet->getCell('A'.$cell1)->setValue('PART');
			$sheet->getCell('C'.$cell1)->setValue('COUNTRY');
			$sheet->getCell('F'.$cell1)->setValue('CARGO SALES AGENT');
			$sheet->getCell('I'.$cell1)->setValue('CHARGEABLE WEIGHT');
			$sheet->getStyle('A'.$cell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$sheet->getStyle('C'.$cell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$sheet->getStyle('F'.$cell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			$sheet->getStyle('I'.$cell1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$sheet->mergeCells('A'.$cell2.':B'.$cell2);
			$sheet->mergeCells('C'.$cell2.':E'.$cell2);
			$sheet->mergeCells('F'.$cell2.':H'.$cell2);
			$sheet->mergeCells('I'.$cell2.':K'.$cell2);	

			$totalweight1 = 0;
			$get71Ci = $this->report_summary_model->get71cSummaryInternational($report_type, $category, $filterBy, $c_filter, $quarter, $year, $start_date, $end_date);			
			
			foreach ($get71Ci as $key => $row) {
			$sheet->getCell('A'.$cell2)->setValue($row->title);
			$sheet->getCell('C'.$cell2)->setValue($row->part);
			$sheet->getCell('F'.$cell2)->setValue($row->name);
			$sheet->getCell('I'.$cell2)->setValue(number_format($row->weight,2));
			$sheet->mergeCells('A'.$cell3.':H'.$cell3);
			$sheet->mergeCells('I'.$cell3.':K'.$cell3);
			$totalweight1 += $row->weight;
			}
			$sheet->getCell('A'.$cell3)->setValue('GRAND TOTAL');
			$sheet->getCell('I'.$cell3)->setValue(number_format($totalweight1, 2));
			$sheet->getStyle('A'.$cell3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
		}


		foreach ($excel->getAllSheets() as $sheet) {
			for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($sheet->getHighestDataColumn()); $col++) {
				$sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
			}
		}

		$filename.= '.xlsx';

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

		$writer->save('php://output');


	}
	
	public function ajax($task) {
		$ajax = $this->{$task}();
		if ($ajax) {
			header('Content-type: application/json');
			echo json_encode($ajax);
		}
	}

	private function ajax_view_hawbs() {
		$client_id	= $this->input->post('client_id');
		$from_month	= $this->input->post('from_month');
		$from_year 	= $this->input->post('from_year');
		$to_month	= $this->input->post('to_month');
		$to_year	= $this->input->post('to_year');
		$inter_fee	= $this->input->post('inter_fee');
		$dom_fee	= $this->input->post('dom_fee');
		$filter 	= $this->input->post('filter');

		if($filter == '2'){
			$filthy = $dom_fee;
		}else{
			$filthy = $inter_fee;
		}
		
		$pagination = $this->report_summary_model->getHAWBS($client_id, $filter, $from_month, $from_year, $to_month, $to_year);

		$table = '';
		if (empty($pagination)) {
			$table = '<tr><td colspan="3" class="text-center"><b>No Records Found</b></td></tr>';
		}
		$total = 0;
		$totalf = 0;
		$totalfee = 0;
		foreach ($pagination as $key => $row) {
			if($row->numHawbs1 + $row->numHawbs2 >0){
				$month = '';
				if($row->report_month == '01'){$month = 'January';}
				else if($row->report_month == '02'){$month = 'February';}
				else if($row->report_month == '03'){$month = 'March';}
				else if($row->report_month == '04'){$month = 'April';}
				else if($row->report_month == '05'){$month = 'May';}
				else if($row->report_month == '06'){$month = 'June';}
				else if($row->report_month == '07'){$month = 'July';}
				else if($row->report_month == '08'){$month = 'August';}
				else if($row->report_month == '09'){$month = 'September';}
				else if($row->report_month == '10'){$month = 'October';}
				else if($row->report_month == '11'){$month = 'November';}
				else if($row->report_month == '12'){$month = 'December';}
				$numHawbs = $row->numHawbs1 + $row->numHawbs2;
				$totalfee = $numHawbs*$filthy;
				$table .= '<tr>';
				$table .= '<td align="center">'. $month. ' '. $row->year .'</td>';
				$table .= '<td align="center">'. number_format($numHawbs, 0) .'</td>';
				$table .= '<td align="center">'. number_format($totalfee, 2) .'</td>';
				
				$table .= '</tr>';

				$total += $numHawbs;
				$totalf += $totalfee;
			}
			else {
				$total += 0;
				$totalf += 0;
			}
		}
			$table .= '<tr style="background-color: #d9edf7;">';
			$table .= '<td><b>Total</b></td>';
			$table .= '<td align="center">'.number_format($total, 0).'</td>';
			$table .= '<td align="center">'.number_format($totalf, 2).'</td>';				
			$table .= '</tr>';
	
	

	return array('table' => $table);
}
	

	public function HAWBS_pdf() {
		$client_id	= $this->input->get('client');
		$from_month	= $this->input->get('from_month');
		$from_year 	= $this->input->get('from_year');
		$to_month	= $this->input->get('to_month');
		$to_year	= $this->input->get('to_year');
		$inter_fee	= $this->input->get('inter_fee');
		$dom_fee	= $this->input->get('dom_fee');
		$filter 	= $this->input->get('filter');
	
		$pdf = new fpdf('L', 'mm', 'Legal');
		$pdf->AddPage();

		$pdf->SetFont("Arial", "B", "11");
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(240,7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 1, 'C');
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(240,7, 'CLIENT INFORMATION', 0, 1, 'C');
		
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(240,0.1, "", 1,1, 'C');
		$pdf->Cell(240,5, "", 0,1, 'C');	

		$get = $this->report_summary_model->getClientInfo($this->client_fields, $client_id);

		$get->name = str_replace('&quot;','"',$get->name);
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(20,5, 'Client Name:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->name.' ['.$get->code.']', 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(60,7, '', 0, 0, 'C'); 
		$pdf->Cell(32,5, 'Telephone Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->telno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(20,5, 'Address:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->address, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(60,7, '', 0, 0, 'C'); 
		$pdf->Cell(32,5, 'Fax Number:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->faxno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(20,5, 'Country:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->country, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(60,7, '', 0, 0, 'C'); 
		$pdf->Cell(32,5, 'Contact Person:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cperson, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(20,5, 'Tin No:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->tin_no, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(60,7, '', 0, 0, 'C'); 		
		$pdf->Cell(32,5, 'Contact Details:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "9");
		$pdf->Cell(48,5, $get->mobno, 0, 1, 'L');

		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(50,7, '', 0, 0, 'C'); 
		$pdf->Cell(20,5, 'Email:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(80,5, $get->email, 0, 0, 'L');
		
		$pdf->SetFont("Arial", "B", "9");
		$pdf->Cell(60,7, '', 0, 0, 'C'); 
		$pdf->Cell(32,5, 'Designation:', 0, 0, 'L');
		$pdf->SetFont("Arial", "", "8");
		$pdf->Cell(48,5, $get->cp_designation, 0, 1, 'L');

		$pagination = $this->report_summary_model->getHAWBS($client_id, $filter, $from_month, $from_year, $to_month, $to_year);

		if($filter == '2'){
			$filthy = $dom_fee;
			$filter = 'Domestic';
		}else{
			$filthy = $inter_fee;
			$filter = 'International';
		}

		$pdf->Cell(192,5,"",0,1, 'C');
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(335,7,"Report Summary : Summary of Hawbs ($filter)", 0, 1, 'C');

		
			$pdf->Cell(335,7, '', 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(50,7, '', 0, 0, 'C'); 
			$pdf->Cell(80,7, '', 1, 0, 'C'); 
			$pdf->Cell(80,7, 'No. of HAWBS', 1, 0, 'C');
			$pdf->Cell(80,7, 'Total Fee', 1, 1, 'C');
			
			$pdf->SetFont('Arial','',9);
			if (empty($pagination)) {
				$pdf->Cell(50,7, '', 0, 0, 'C'); 
				$pdf->Cell(240,7,"No Record",1,1, 'C');
			}
			$total = 0;
			$totalf = 0;
			$totalfee = 0;
			foreach ($pagination as $key => $row) {
				if($row->numHawbs1 + $row->numHawbs2 >0){
					$month = '';
					if($row->report_month == '01'){$month = 'January';}
					else if($row->report_month == '02'){$month = 'February';}
					else if($row->report_month == '03'){$month = 'March';}
					else if($row->report_month == '04'){$month = 'April';}
					else if($row->report_month == '05'){$month = 'May';}
					else if($row->report_month == '06'){$month = 'June';}
					else if($row->report_month == '07'){$month = 'July';}
					else if($row->report_month == '08'){$month = 'August';}
					else if($row->report_month == '09'){$month = 'September';}
					else if($row->report_month == '10'){$month = 'October';}
					else if($row->report_month == '11'){$month = 'November';}
					else if($row->report_month == '12'){$month = 'December';}
					$numHawbs = $row->numHawbs1 + $row->numHawbs2;
					$totalfee = $numHawbs*$filthy;

				$pdf->Cell(50,7, '', 0, 0, 'C'); 
				$pdf->Cell(80,7, $month.' '. $row->year, 1,0, 'L');
				$pdf->Cell(80,7, number_format($numHawbs, 0), 1,0, 'C');
				$pdf->Cell(80,7, number_format($totalfee, 2), 1,1, 'R');
				$total += $numHawbs;
				$totalf += $totalfee;
				}else{
					$total += 0;
					$totalf += 0;
				}
		}
				$pdf->Cell(50,7, '', 0, 0, 'C'); 
				$pdf->Cell(80,7, 'TOTAL ', 1,0, 'L');
				$pdf->Cell(80,7, number_format($total, 0), 1,0, 'C');
				$pdf->Cell(80,7, number_format($totalf, 2), 1,1, 'R');
		
		
		$pdf->Output();
	}

	/**START OF MULTICELL TABLE FUNCTION**/
	private function setWidths($w) {
		//Set the array of column widths
		$this->widths = $w;
	}

	private function setAligns($a) {
		//Set the array of column alignments
		$this->aligns = $a;
	}

	private function row($data, $type = 'accounts') {
		//Calculate the height of the row
		$nb = 0;
		if ($type == 'accounts') {
			$col_index = array('accountname', 'debit', 'credit');
		} else if ($type == 'payments') {
			$col_index = array('chequenumber', 'chequedate', 'accountname', 'chequeamount');
		} else if ($type == 'cheque') {
			$col_index = array('accountname', 'chequenumber', 'chequedate', 'chequeamount');
		} else if ($type == 'applied_payment'){
			$col_index = array('voucherno', 'si_no', 'amount', 'discount');
		}
		foreach ($this->widths as $index => $width) {
			$nb = max($nb, $this->NbLines($width, $data->{$col_index[$index]}));
		}
		$h = 5 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		foreach ($this->widths as $index => $width) {
			$w = $width;
			$a = isset($this->aligns[$index]) ? $this->aligns[$index] : 'L';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h);
			//Print the text
			$this->MultiCell($w, 5, $data->{$col_index[$index]}, 0, $a);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	private function CheckPageBreak($h) {
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h>$this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
		}
	}

	private function NbLines($w, $txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0) {
			$w = $this->w - $this->rMargin - $this->x;
		}
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 && $s[$nb - 1] == "\n") {
			$nb--;
		}
		$sep	= -1;
		$i		= 0;
		$j		= 0;
		$l		= 0;
		$nl		= 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep	= -1;
				$j		= $i;
				$l		= 0;
				$nl++;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
			}
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j) {
						$i++;
					}
				} else {
					$i=$sep+1;
				}
				$sep	= -1;
				$j		= $i;
				$l		= 0;
				$nl++;
			} else {
				$i++;
			}
		}
		return $nl;
	}
}
