<?php
class print_form61a_pdf extends fpdf {

	public $font_size		= '';
	public $companyinfo		= array();
    public $documentinfo	= array();
    public $col_index 		= array();
	public $totalinfo		= array();
	public $widths			= '';
	public $aligns			= '';
	public $document_type	= '';
	public $vendor			= '';
	public $payments		= '';
	public $businessline	= '';
	public $signatory		= '';


	public function __construct($orientation = 'l', $unit = 'mm', $size = 'Legal') {
		parent::__construct($orientation, $unit, $size);
        $this->db = new db();
        $this->report_summary_model	= new report_summary_model();
		$this->setMargins(8, 8);
	}

	public function setPreviewTitle($title) {
		$this->SetTitle('CAB - '.$title, true);
		return $this;
	}

	public function setDocumentDetails($documentinfo) {
		$this->documentinfo = $documentinfo;
		return $this;
	}

	public function drawPDF($filename = 'print_preview') {
		$this->drawDocumentDetails();
		$this->Output($filename . '.pdf', 'I');
	}
	
	private function drawDocumentDetails() {
		$this->AddPage('L');
		// $this->Image(BASE_URL.'modules/reports_module/backend/view/bir/forms/2551Q-1.jpg',0,0,216,330.2);
		
		$documentInfo = $this->documentinfo;
		if($documentInfo){
            $this->SetTextColor(0,0,0);
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
    
            // $pdf = new fpdf('L', 'mm', 'Legal');
            $this->SetFont('Arial','',12);
            $this->Cell(335,7,'NON-SCHEDULED DOMESTIC AERIAL AGRICULTURAL SPRAYING SERVICES', 0, 1, 'C');
            $this->Cell(335,7,'TRAFFIC AND OPERATING STATISTICS', 0, 1, 'C');
            if ($report_type == 'Quarterly') {
                $this->Cell(335,7, $quarter.' CY '.$year, 0, 1, 'C');
            }
            else if ($report_type == 'Consolidated') {
                $this->Cell(335,7, $start_date.' - '.$end_date.' CY '.$year, 0, 1, 'C');
            }
            else {
                $this->Cell(335,7, 'CY '.$year, 0, 1, 'C');
            }
    
            $get61aSummary = $this->report_summary_model->get61ASummary($report_type, $quarter, $year, $start_date, $end_date, $rank_alpha);
            if ($category == 'Summary Report') {
                $this->Cell(335,7, '', 0, 1, 'C');
                $this->SetFont('Arial','B',9);
                $this->Cell(80,7, 'NAME OF OPERATORS', 1, 0, 'C'); 
                $this->Cell(80,7, 'LOCATION', 1, 0, 'C');
                $this->Cell(80,7, 'TOTAL AREA TREATED', 1, 0, 'C');
                $this->Cell(80,7, 'QUANTITY(Liters)', 1, 1, 'C');
    
                $this->SetFont('Arial','',9);
                if (empty($get61aSummary)) {
                    $this->Cell(320,7,"No Record",1,1, 'C');
                }

                $this->setWidths(array(70, 80, 80, 80));
                $this->setAligns(array('L', 'L', 'R','R'));

                $count = 1;
                $totalareaTreated = 0;
                $totalqLiters = 0;
                foreach ($get61aSummary as $key => $row) {
                    $this->Cell(10,5.5, $count++, 0, 0, 'C');
                    // $row->aircraft = $row->aircraft;
                    // $row->location = $row->location;
                    // $row->areaTreated = number_format($row->areaTreated, 2);
                    // $row->qLiters = number_format($row->qLiters, 2);
                    $this->row($row,'Summary Report');
                    // var_dump($row)
                    
                    // $this->Cell(10,7, $count++, 1,0, 'C');
                    // $this->Cell(70,7, $row->aircraft, 1,0, 'L');
                    // $this->Cell(80,7, $row->location, 1,0, 'L');
                    // $this->Cell(80,7, number_format($row->areaTreated, 2), 1,0, 'R');
                    // $this->Cell(80,7, number_format($row->qLiters, 2), 1,1, 'R');
    
                    $totalareaTreated += $row->areaTreated;
                    $totalqLiters += $row->qLiters;
                    
                }

                // $data[0] = $row->areaTreated;
                // $data[1] = $row->qLiters;
                // $data[2] = $row->location;
                // $data[3] = $row->aircraft;
                // $this->row($data);

              

                $this->setFont('Arial','B',9);
                $this->Cell(80,7, 'GRAND TOTAL', 1, 0, 'C');
                $this->Cell(80,7, '', 1,0, 'L');
                $this->Cell(80,7, number_format($totalareaTreated, 2), 1, 0, 'R');
                $this->Cell(80,7, number_format($totalqLiters, 2), 1, 0, 'R');
            }
            else if ($category == 'Detailed Summary Report') {
                $this->Cell(335,7, '', 0, 1, 'C');
                $this->SetFont('Arial','B',9);
                $this->Cell(60,10, 'Name of Operators', 1, 0, 'C'); 
                $this->Cell(60,10, 'Location', 1, 0, 'C');
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(50,5, 'Total Area Treated', 'TLR',0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(50,5, '(Hectares)', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 50);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(50,5, 'Quantity', 'TLR',0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(50,5, '(Liters)', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 50);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(50,5, 'Revenue Derived', 'TLR',0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(50,5, '(Php)', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 50);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(50,5, 'Flying Time', 1,0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(25,5, 'Hours', 'BLR',0, 'C');
                $this->Cell(25,5, 'Minutes', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 50);
                $this->Cell(1,10, '', 0,1, 'C');
    
                $this->SetFont('Arial','',9);
                if (empty($get61aSummary)) {
                    $this->Cell(340,7,"No Record",1,1, 'C');
                }

                $this->setWidths(array(50, 60, 50, 50,50,25,25));
                $this->setAligns(array('L', 'L', 'R','R','R','R','R'));

                $count = 1;
                $totalareaTreated = 0;
                $totalqLiters = 0;
                $totaldistance = 0;
                $totalhours = 0;
                $totalminutes = 0;
                $totalrevenue = 0;
                foreach ($get61aSummary as $key => $row) {
                    $this->Cell(10,5.5, $count++, 0, 0, 'C');
                    // $row->aircraft = $row->aircraft;
                    // $row->location = $row->location;
                    // $row->areaTreated = number_format($row->areaTreated, 2);
                    // $row->qLiters = number_format($row->qLiters, 2);
                    $this->row($row,'Detailed Summary Report');
                    // var_dump($row)
                    
                    // $this->Cell(10,7, $count++, 1,0, 'C');
                    // $this->Cell(70,7, $row->aircraft, 1,0, 'L');
                    // $this->Cell(80,7, $row->location, 1,0, 'L');
                    // $this->Cell(80,7, number_format($row->areaTreated, 2), 1,0, 'R');
                    // $this->Cell(80,7, number_format($row->qLiters, 2), 1,1, 'R');
    
                    $totalareaTreated += $row->areaTreated;
                    $totalqLiters += $row->qLiters;
                    $totaldistance += $row->distance;
                    $totalhours += $row->hours;
                    $totalminutes += $row->minutes;
                    $totalrevenue += $row->revenue;
                    
                }
                // foreach ($get61aSummary as $key => $row) {
                //     // $pdf->Cell(10,7, $count++, 1,0, 'C');
                //     // $pdf->Cell(60,7, $row->aircraft, 1,0, 'L');
                //     // $pdf->Cell(70,7, $row->location, 1,0, 'L');				
                //     // $pdf->Cell(50,7, number_format($row->areaTreated, 2), 1, 0, 'R');
                //     // $pdf->Cell(50,7, number_format($row->qLiters, 2), 1, 0, 'R');
                //     // $pdf->Cell(50,7, number_format($row->revenue, 2), 1, 0, 'R');
                //     // $pdf->Cell(25,7, number_format($row->hours), 1, 0, 'R');
                //     // $pdf->Cell(25,7, number_format($row->minutes), 1, 1, 'R');
                //     $this->row($row,'Detailed Summary Report');
                //     $totalareaTreated += $row->areaTreated;
                //     $totalqLiters += $row->qLiters;
                //     $totaldistance += $row->distance;
                //     $totalhours += $row->hours;
                //     $totalminutes += $row->minutes;
                //     $totalrevenue += $row->revenue;
                // }
                $this->setFont('Arial','B',9);
                $this->Cell(120,7, 'GRAND TOTAL', 1, 0, 'C');
                $this->Cell(50,7, number_format($totalareaTreated, 2), 1, 0, 'R');
                $this->Cell(50,7, number_format($totalqLiters, 2), 1, 0, 'R');
                $this->Cell(50,7, number_format($totalrevenue, 2), 1, 0, 'R');
                $this->Cell(25,7, number_format($totalhours), 1, 0, 'R');
                $this->Cell(25,7, number_format($totalminutes), 1, 1, 'R');
                
            }
            else{
                $this->Cell(335,7, '', 0, 1, 'C');
                $this->SetFont('Arial','B',9);
                $this->Cell(25,10, '', 1, 0, 'C'); 
                $this->Cell(45,10, 'AIRCRAFT TYPE', 1, 0, 'C'); 
                $this->Cell(45,10, 'AIRCRAFT NUMBER', 1, 0, 'C'); 
                $this->Cell(45,10, 'Location', 1, 0, 'C');
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(40,5, 'Total Area Treated', 'TLR',0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(40,5, '(Hectares)', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 40);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(35,5, 'Quantity', 'TLR',0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(35,5, '(Liters)', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 35);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(40,5, 'Flying Time', 1,0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(20,5, 'Hours', 'BLR',0, 'C');
                $this->Cell(20,5, 'Minutes', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 40);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Cell(40,5, 'Revenue Derived', 'TLR',0, 'C');
                $this->SetY($y + 5);
                $this->SetX($x);
                $this->Cell(40,5, '(Php)', 'BLR',0, 'C');
                $this->SetY($y);
                $this->SetX($x + 40);
                
                $this->Cell(1,10, '', 0,1, 'C');
    
                $this->SetFont('Arial','',9);
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

                    $this->setWidths(array(45, 45, 45, 40,35,20,20,40));
                    $this->setAligns(array('L', 'L', 'L','R','R','R','R','R'));
    
                    $get61ASummaryPerOperator = $this->report_summary_model->get61aSummaryPerOperator($report_type, $quarter, $year, $start_date, $end_date, $airline, $a);
                    
                    if ($get61ASummaryPerOperator) {
                        $this->Cell(25,7, $month, 0,0, 'C');
                        // $this->Cell(50,7, $get61ASummaryPerOperator->aircraft, 1,0, 'L');
                        // $this->Cell(50,7, $get61ASummaryPerOperator->aircraft_num, 1,0, 'L');
                        // $this->Cell(50,7, $get61ASummaryPerOperator->location, 1,0, 'L');	
                        // $this->Cell(40,7, number_format($get61ASummaryPerOperator->areaTreated, 2), 1, 0, 'R');
                        // $this->Cell(40,7, number_format($get61ASummaryPerOperator->qLiters, 2), 1, 0, 'R');
                        // $this->Cell(40,7, number_format($get61ASummaryPerOperator->revenue, 2), 1, 0, 'R');
                        // $this->Cell(20,7, number_format($get61ASummaryPerOperator->hours), 1, 0, 'R');
                        // $this->Cell(20,7, number_format($get61ASummaryPerOperator->minutes), 1, 1, 'R');

                        $this->row($get61ASummaryPerOperator,'Summary per Operator');
                        
    
                        $totalareaTreated += $get61ASummaryPerOperator->areaTreated;
                        $totalqLiters += $get61ASummaryPerOperator->qLiters;
                        $totalrevenue += $get61ASummaryPerOperator->revenue;
                        $totalhours += $get61ASummaryPerOperator->hours;
                        $totalminutes += $get61ASummaryPerOperator->minutes;
                    }
                }
                $this->setFont('Arial','B',9);
                $this->Cell(25,7, 'GRAND TOTAL', 1, 0, 'C');
                $this->Cell(45,7, '', 1, 0, 'C');
                $this->Cell(45,7, '', 1, 0, 'C');
                $this->Cell(45,7, '', 1, 0, 'C');
                $this->Cell(40,7, number_format($totalareaTreated, 2), 1, 0, 'R');
                $this->Cell(35,7, number_format($totalqLiters, 2), 1, 0, 'R');
                $this->Cell(20,7, number_format($totalhours), 1, 0, 'R');
                $this->Cell(20,7, number_format($totalminutes), 1, 0, 'R');
                $this->Cell(40,7, number_format($totalrevenue, 2), 1, 1, 'R');
            }
            $this->Output();
        }
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

	private function row($data, $category) {
		//Calculate the height of the row
        $nb = 0;
        if($category == 'Summary Report'){
            $col_index = array('aircraft', 'location', 'areaTreated','qLiters');
        }else if($category == 'Detailed Summary Report'){
            $col_index = array('aircraft', 'location', 'areaTreated','qLiters','revenue','hours','minutes');
        }else{
            $col_index = array('aircraft', 'aircraft_num', 'location', 'areaTreated','qLiters','hours','minutes','revenue');
        }

		foreach ($this->widths as $index => $width) {
            $nb = max($nb, $this->NbLines($width, $data->{$col_index[$index]}));
		}

		$h = 5.5 * $nb;
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
			// if( $this->outline == 'yes' ){
			// 	$this->Rect($x, $y, $w, $h);
			// }
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
