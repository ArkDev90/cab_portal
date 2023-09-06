<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->ui				= new ui();
		$this->input			= new input();
		$this->session			= new session();
		$this->stakeholder		= new stakeholder_model();
	}

	public function listing() {
		$this->view->title		= 'Monitoring of Stakeholders';
		$data['ui']				= $this->ui;
		$data['report_list']	= $this->stakeholder->getAirTypeDropdown();
		$data['nature_list']	= $this->stakeholder->getNatureDropdown();
		$data['nature_json']	= json_encode($this->stakeholder->getNatureData());
		$data['month_list']		= $this->getMonthDropdown();
		$data['quarter_list']	= $this->getQuarterDropdown();
		$data['year_list']		= $this->getYearDropdown();
		$this->view->load('stakeholders', $data);
	}

	public function csv_notice($report_id, $report_type, $period, $year) {
		extract($this->get_notice($report_id, $report_type, $period, $year));
		$filename = 'monitoring_notice_' . $main_title;
		$excel = new PHPExcel();

		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($filename)
				->setSubject('Stakeholder Notice')
				->setDescription('Notice')
				->setKeywords('monitoring of stakeholder notice')
				->setCategory('notice file');

		$excel->getActiveSheet()->setTitle('Stakeholder Notice');
		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();

		$counter	= 1;
		$cell_row	= 7;
 
		if (empty($result)) {
			$sheet->getCell('A' . $cell_row)->setValue('No Result Found');
			$sheet->mergeCells('A' . $cell_row . ':C' . $cell_row);
			$sheet->getStyle('A' . $cell_row . ':' . 'C' . $cell_row)->applyFromArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
				)
			);
		}

		if ( ! empty($result)) {
			foreach ($result as $row) {
				$reportdate		= date_parse_from_format('Y-m-d', $row->report_date);
				$date			= DateTime::createFromFormat('!m', $reportdate['month']);
				$report_month	= $date->format('F');
				if ($report_id == '11') {
					$report_month = 'Quarter ' . ceil($reportdate['month'] / 3);
				}
				$report_year  = $reportdate['year'];

				$sheet->getStyle('A' . $cell_row . ':' . 'C' . $cell_row)->applyFromArray(
					array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('rgb' => '000000')
							)
						)
					)
				);

				$sheet->getCell('A' . $cell_row)->setValue($counter);
				$sheet->getCell('B' . $cell_row)->setValue(stripslashes($row->name));

				if (strtolower($report_type) == 'late') {
					$sheet->getCell('C' . $cell_row)->setValue( $report_month . ' ' . $report_year);
				}

				if (strtolower($report_type) == 'unsubmitted') {
					$sheet->getCell('C' . $cell_row)->setValue( $report_month . ' ' . $report_year );
				}

				$counter++;
				$cell_row++;
			}
		}

		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');
		$sheet->getCell('A1')->setValue($header);
		$sheet->getCell('A2')->setValue($report_title);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->mergeCells('A4:C4');
		$sheet->getCell('A4')->setValue('as of ' . $month_name . ' ' . $year);

		$sheet->getStyle('A6:C6')->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			)
		);

		$sheet->getCell('A6')->setValue('#');
		$sheet->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getCell('B6')->setValue('Name of Stakeholder');
		$sheet->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getCell('C6')->setValue('Period Covered (' . ucwords($report_type) . ')');
		$sheet->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

	public function srs_notice($report_id, $report_type, $period, $year) {
		extract($this->get_notice($report_id, $report_type, $period, $year));

		$pdf = new fpdf('P', 'mm', 'Letter');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(true, 10);
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(196, 7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(196, 7, $header, 0, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(196, 7, $report_title, 0, 0, 'C');
		$pdf->Ln(10);

		$column_width = array(16, 130, 50);
		$table_header = array('#', 'Name of Stakeholder', 'Period Covered (' . ucwords($report_type) . ')');

		for ($x = 0; $x < count($column_width); $x++) {
			$pdf->Cell($column_width[$x], 7, $table_header[$x], 1);
		}

		$pdf->Ln();

		$pdf->SetFont('Arial', '', 13);

		if (empty($result)) {
			$pdf->Cell(196, 7, 'No Result Found', 1, 0, 'C');
		}

		foreach ($result as $key => $row) {
			$pdf->Cell($column_width[0], 7, ($key + 1), 1);
			$pdf->Cell($column_width[1], 7, $row->name, 1);

			$reportdate		= date_parse_from_format('Y-m-d', $row->report_date);
			$date			= DateTime::createFromFormat('!m', $reportdate['month']);
			$report_month	= $date->format('F');
			if ($report_id == '11') {
				$report_month = 'Quarter ' . ceil($reportdate['month'] / 3);
			}
			$report_year  = $reportdate['year'];

			$pdf->Cell($column_width[2], 7, $report_month . ' ' . $report_year, 1, 0, 'R');
			$pdf->Ln();
		}

		$pdf->Output();
	}

	public function csv_checklist($report_id, $year) {
		extract($this->get_checklist($report_id, $year));

		$excel = new PHPExcel();

		$excel->getProperties()
				->setCreator('CAB')
				->setLastModifiedBy('CAB')
				->setTitle($main_title)
				->setSubject('Stakeholder Checklist')
				->setDescription('Checklist')
				->setKeywords('monitoring of stakeholder checklist')
				->setCategory('checklist file');
		$excel->getActiveSheet()->setTitle('Stakeholder Checklist');

		$excel->setActiveSheetIndex(0);
		$sheet = $excel->getActiveSheet();
		if ($report_id == '11') {
			$sheet->mergeCells('A1:C1')
				->setCellValue('D1', '')
				->setCellValue('E1', 'Date:')
				->setCellValue('F1', date('M d'))
				->setCellValue('G1', date('Y'))
				->setCellValue('A2', '')
				->setCellValue('B2', '')
				->setCellValue('C2', '')
				->setCellValue('D2', '')
				->setCellValue('E2', 'Expired')
				->setCellValue('F2', 'Permits:')
				->setCellValue('G2', $tot_expiry);
		} else {
			$sheet->mergeCells('A1:C1')
				->setCellValue('D1', '')
				->setCellValue('E1', '')
				->setCellValue('F1', '')
				->setCellValue('G1', '')
				->setCellValue('H1', '')
				->setCellValue('I1', '')
				->setCellValue('J1', '')
				->setCellValue('K1', '')
				->setCellValue('L1', '')
				->setCellValue('M1', 'Date:')
				->setCellValue('N1', date('M d'))
				->setCellValue('O1', date('Y'))
				->setCellValue('A2', '')
				->setCellValue('B2', '')
				->setCellValue('C2', '')
				->setCellValue('D2', '')
				->setCellValue('E2', '')
				->setCellValue('F2', '')
				->setCellValue('G2', '')
				->setCellValue('H2', '')
				->setCellValue('I2', '')
				->setCellValue('J2', '')
				->setCellValue('K2', '')
				->setCellValue('L2', '')
				->setCellValue('M2', 'Expired')
				->setCellValue('N2', 'Permits:')
				->setCellValue('O2', $tot_expiry);
		}

		$sheet->getCell('A1')->setValue($main_title);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if ($report_id == '11') {
			$sheet->setCellValue('A3', '')
				->setCellValue('B3', '')
				->setCellValue('C3', '')
				->setCellValue('D3', '')
				->setCellValue('E3', 'CY')
				->setCellValue('F3', $year)
				->setCellValue('G3', '');
		} else {
			$sheet->setCellValue('A3', '')
				->setCellValue('B3', '')
				->setCellValue('C3', '')
				->setCellValue('D3', '')
				->setCellValue('E3', '')
				->setCellValue('F3', '')
				->setCellValue('G3', '')
				->setCellValue('H3', '')
				->setCellValue('I3', 'CY')
				->setCellValue('J3', $year)
				->setCellValue('K3', '')
				->setCellValue('L3', '')
				->setCellValue('M3', '')
				->setCellValue('N3', '')
				->setCellValue('O3', '');
		}

		if ($report_id == '11') {
			$sheet->setCellValue('A4', '')
				->setCellValue('B4', '')
				->setCellValue('C4', '')
				->setCellValue('D4', '')
				->setCellValue('E4', '(REPORT')
				->setCellValue('F4', $report_title .')')
				->setCellValue('G4', '');
		} else {
			$sheet->setCellValue('A4', '')
				->setCellValue('B4', '')
				->setCellValue('C4', '')
				->setCellValue('D4', '')
				->setCellValue('E4', '')
				->setCellValue('F4', '')
				->setCellValue('G4', '')
				->setCellValue('H4', '')
				->setCellValue('I4', '(REPORT')
				->setCellValue('J4', $report_title .')')
				->setCellValue('K4', '')
				->setCellValue('L4', '')
				->setCellValue('M4', '')
				->setCellValue('N4', '')
				->setCellValue('O4', '');
		}
		if ($report_id == '11') {
			$sheet->setCellValue('A5', '#')
				->setCellValue('B5', 'NAME OF STAKEHOLDER')
				->setCellValue('C5', 'Permit Expiry')
				->setCellValue('D5', 'Quarter 1')
				->setCellValue('E5', 'Quarter 2')
				->setCellValue('F5', 'Quarter 3')
				->setCellValue('G5', 'Quarter 4');
		} else {
			$sheet->setCellValue('A5', '#')
				->setCellValue('B5', 'NAME OF STAKEHOLDER')
				->setCellValue('C5', 'Permit Expiry')
				->setCellValue('D5', 'January')
				->setCellValue('E5', 'February')
				->setCellValue('F5', 'March')
				->setCellValue('G5', 'April')
				->setCellValue('H5', 'May')
				->setCellValue('I5', 'June')
				->setCellValue('J5', 'July')
				->setCellValue('K5', 'August')
				->setCellValue('L5', 'September')
				->setCellValue('M5', 'October')
				->setCellValue('N5', 'November')
				->setCellValue('O5', 'December');
		}



		$border_style = array('borders' => array(
				'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb' => '000000')
							)
				)
			);

		$cellCounter = 5;

		$total_reports = array();

		if ($result) {
			foreach ($result as $report) {
				if ($report->month == 'January' || $report->month == 'Quarter 1') {
					$cellCounter++;
					$sheet->setCellValue('A'.$cellCounter, $cellCounter - 5);
					$sheet->setCellValue("B".$cellCounter, $report->name);
					$sheet->getStyle("A".$cellCounter)->applyFromArray($border_style);
					$sheet->getStyle("B".$cellCounter)->applyFromArray($border_style);
			
					$expiration_date = ($report->expiration != 'not set') ? date('d-M-y',strtotime($report->expdate)) : 'Not Set';
					if ($report->expiration == 'expired') {
						$sheet->setCellValue("C".$cellCounter, $expiration_date);
						$sheet->getStyle("C".$cellCounter)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'90EE90')));
						$sheet->getStyle("C".$cellCounter)->applyFromArray($border_style);
					} else {
						$sheet->setCellValue("C".$cellCounter, $expiration_date);
						$sheet->getStyle("C".$cellCounter)->applyFromArray($border_style);
					}
				}
				$approveddate = ($report->approveddate) ? date('d-M-y',strtotime($report->approveddate)) : '';
				if ($report_id == '11') {
					$report->month_num = $report->month_num / 3;
				}
				$column_letter = chr(67 + $report->month_num);
				if ( ! isset($total_reports[$column_letter])) {
					$total_reports[$column_letter] = array(
						'late'		=> 0,
						'submitted'	=> 0,
						'none'		=> 0
					);
				}
				$total_reports[$column_letter][$report->status]++;
				if ($report->status == 'submitted') {
					$sheet->setCellValue($column_letter . $cellCounter, $approveddate);
					$sheet->getStyle($column_letter . $cellCounter)->applyFromArray($border_style);
				} else if ($report->status == 'late') {
					$sheet->setCellValue($column_letter . $cellCounter, $approveddate);
					$sheet->getStyle($column_letter . $cellCounter)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
					$sheet->getStyle($column_letter . $cellCounter)->applyFromArray($border_style);
				} else {
					$sheet->setCellValue($column_letter . $cellCounter, $approveddate);
					$sheet->getStyle($column_letter . $cellCounter)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
					$sheet->getStyle($column_letter . $cellCounter)->applyFromArray($border_style);
				}
			}
		} else {
			if ($report_id == '11') {
				$sheet->setCellValue('A6', '')
						->setCellValue('B6', '')
						->setCellValue('C6', '')
						->setCellValue('D6', 'No')
						->setCellValue('E6', 'Records')
						->setCellValue('F6', 'Found')
						->setCellValue('G6', '');
			} else {
				$sheet->setCellValue('A6', '')
						->setCellValue('B6', '')
						->setCellValue('C6', '')
						->setCellValue('D6', '')
						->setCellValue('E6', '')
						->setCellValue('F6', '')
						->setCellValue('G6', '')
						->setCellValue('H6', '')
						->setCellValue('I6', 'No')
						->setCellValue('J6', 'Records')
						->setCellValue('K6', 'Found')
						->setCellValue('L6', '')
						->setCellValue('M6', '')
						->setCellValue('N6', '')
						->setCellValue('O6', '');
			}
		}

		$cellCounter += 2;
		$legend_row = $cellCounter;
		$legend_row2 = $legend_row + 1;
		$legend_row3 = $legend_row2 + 1;

		$sheet->mergeCells('A'.$legend_row.":C".$legend_row);
		$sheet->mergeCells('A'.$legend_row2.":C".$legend_row2);
		$sheet->mergeCells('A'.$legend_row3.":C".$legend_row3);

		$sheet->setCellValue('A'.$legend_row, 'Reports received on-time')
				->setCellValue('D'.$legend_row, $total_reports['D']['submitted'])
				->setCellValue('E'.$legend_row, $total_reports['E']['submitted'])
				->setCellValue('F'.$legend_row, $total_reports['F']['submitted'])
				->setCellValue('G'.$legend_row, $total_reports['G']['submitted']);

		if ($report_id != '1') {
			$sheet->setCellValue('H'.$legend_row, $total_reports['H']['submitted'])
					->setCellValue('I'.$legend_row, $total_reports['I']['submitted'])
					->setCellValue('J'.$legend_row, $total_reports['J']['submitted'])
					->setCellValue('K'.$legend_row, $total_reports['K']['submitted'])
					->setCellValue('L'.$legend_row, $total_reports['L']['submitted'])
					->setCellValue('M'.$legend_row, $total_reports['M']['submitted'])
					->setCellValue('N'.$legend_row, $total_reports['N']['submitted'])
					->setCellValue('O'.$legend_row, $total_reports['O']['submitted']);
		}

		$sheet->setCellValue('A'.$legend_row2, 'Reports received after deadline')
				->setCellValue('D'.$legend_row2, $total_reports['D']['late'])
				->setCellValue('E'.$legend_row2, $total_reports['E']['late'])
				->setCellValue('F'.$legend_row2, $total_reports['F']['late'])
				->setCellValue('G'.$legend_row2, $total_reports['G']['late']);

		if ($report_id != '1') {
			$sheet->setCellValue('H'.$legend_row2, $total_reports['H']['late'])
					->setCellValue('I'.$legend_row2, $total_reports['I']['late'])
					->setCellValue('J'.$legend_row2, $total_reports['J']['late'])
					->setCellValue('K'.$legend_row2, $total_reports['K']['late'])
					->setCellValue('L'.$legend_row2, $total_reports['L']['late'])
					->setCellValue('M'.$legend_row2, $total_reports['M']['late'])
					->setCellValue('N'.$legend_row2, $total_reports['N']['late'])
					->setCellValue('O'.$legend_row2, $total_reports['O']['late']);
		}


		$sheet->setCellValue('A'.$legend_row3, 'Number reports unsubmitted')
				->setCellValue('D'.$legend_row3, $total_reports['D']['none'])
				->setCellValue('E'.$legend_row3, $total_reports['E']['none'])
				->setCellValue('F'.$legend_row3, $total_reports['F']['none'])
				->setCellValue('G'.$legend_row3, $total_reports['G']['none']);

		if ($report_id != '1') {
			$sheet->setCellValue('H'.$legend_row3, $total_reports['H']['none'])
					->setCellValue('I'.$legend_row3, $total_reports['I']['none'])
					->setCellValue('J'.$legend_row3, $total_reports['J']['none'])
					->setCellValue('K'.$legend_row3, $total_reports['K']['none'])
					->setCellValue('L'.$legend_row3, $total_reports['L']['none'])
					->setCellValue('M'.$legend_row3, $total_reports['M']['none'])
					->setCellValue('N'.$legend_row3, $total_reports['N']['none'])
					->setCellValue('O'.$legend_row3, $total_reports['O']['none']);
		}

		$sheet->getStyle('D'.$legend_row)->applyFromArray($border_style);
		$sheet->getStyle('E'.$legend_row)->applyFromArray($border_style);
		$sheet->getStyle('F'.$legend_row)->applyFromArray($border_style);
		$sheet->getStyle('G'.$legend_row)->applyFromArray($border_style);

		if ($report_id != '1') {
			$sheet->getStyle('H'.$legend_row)->applyFromArray($border_style);
			$sheet->getStyle('I'.$legend_row)->applyFromArray($border_style);
			$sheet->getStyle('J'.$legend_row)->applyFromArray($border_style);
			$sheet->getStyle('K'.$legend_row)->applyFromArray($border_style);
			$sheet->getStyle('L'.$legend_row)->applyFromArray($border_style);
			$sheet->getStyle('M'.$legend_row)->applyFromArray($border_style);
			$sheet->getStyle('N'.$legend_row)->applyFromArray($border_style);
			$sheet->getStyle('O'.$legend_row)->applyFromArray($border_style);
		}


		$sheet->getStyle('D'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
		$sheet->getStyle('D'.$legend_row2)->applyFromArray($border_style);

		$sheet->getStyle('E'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
		$sheet->getStyle('E'.$legend_row2)->applyFromArray($border_style);

		$sheet->getStyle('F'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
		$sheet->getStyle('F'.$legend_row2)->applyFromArray($border_style);

		$sheet->getStyle('G'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
		$sheet->getStyle('G'.$legend_row2)->applyFromArray($border_style);

		if ($report_id != '1') {
			$sheet->getStyle('H'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('H'.$legend_row2)->applyFromArray($border_style);

			$sheet->getStyle('I'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('I'.$legend_row2)->applyFromArray($border_style);

			$sheet->getStyle('J'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('J'.$legend_row2)->applyFromArray($border_style);

			$sheet->getStyle('K'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('K'.$legend_row2)->applyFromArray($border_style);

			$sheet->getStyle('L'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('L'.$legend_row2)->applyFromArray($border_style);

			$sheet->getStyle('M'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('M'.$legend_row2)->applyFromArray($border_style);

			$sheet->getStyle('N'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('N'.$legend_row2)->applyFromArray($border_style);

			$sheet->getStyle('O'.$legend_row2)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'F08080')));
			$sheet->getStyle('O'.$legend_row2)->applyFromArray($border_style);
		}

		$sheet->getStyle('D'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
		$sheet->getStyle('D'.$legend_row3)->applyFromArray($border_style);

		$sheet->getStyle('E'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
		$sheet->getStyle('E'.$legend_row3)->applyFromArray($border_style);

		$sheet->getStyle('F'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
		$sheet->getStyle('F'.$legend_row3)->applyFromArray($border_style);

		$sheet->getStyle('G'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
		$sheet->getStyle('G'.$legend_row3)->applyFromArray($border_style);

		if ($report_id != '1') {
			$sheet->getStyle('H'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('H'.$legend_row3)->applyFromArray($border_style);

			$sheet->getStyle('I'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('I'.$legend_row3)->applyFromArray($border_style);

			$sheet->getStyle('J'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('J'.$legend_row3)->applyFromArray($border_style);

			$sheet->getStyle('K'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('K'.$legend_row3)->applyFromArray($border_style);

			$sheet->getStyle('L'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('L'.$legend_row3)->applyFromArray($border_style);

			$sheet->getStyle('M'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('M'.$legend_row3)->applyFromArray($border_style);

			$sheet->getStyle('N'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('N'.$legend_row3)->applyFromArray($border_style);

			$sheet->getStyle('O'.$legend_row3)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' =>'FFFF00')));
			$sheet->getStyle('O'.$legend_row3)->applyFromArray($border_style);
		}

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$main_title\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		flush();

		if ($report_id == '11') {
			$sheet->getStyle("A5:G5")->applyFromArray($border_style);
		} else {
			$sheet->getStyle("A5:O5")->applyFromArray($border_style);
		}

		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function srs_checklist($report_id, $year) {
		extract($this->get_checklist($report_id, $year));

		$pdf = new fpdf('L', 'mm');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(true, 10);
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(297, 7, 'CIVIL AERONAUTICS BOARD PHILIPPINES', 0, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(297, 7, $header, 0, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 13);
		$pdf->Cell(297, 5, $report_title, 0, 0, 'C');
		$pdf->Ln(10);

		$column_width = array(9, 95, 17);
		$table_header = array('#', 'Name of Stakeholder', 'Expiration');

		$period_width = 13;
		$period_header = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

		if ($report_id == '11') {
			$column_width = array(9, 131, 17);
			$period_width = 30;
			$period_header = array('Quarter 1', 'Quarter 2', 'Quarter 3', 'Quarter 4');
		}
	
		$pdf->SetFont('Arial', 'B', 8);
		for ($x = 0; $x < count($column_width); $x++) {
			$pdf->Cell($column_width[$x], 5, $table_header[$x], 1);
		}
		for ($x = 0; $x < count($period_header); $x++) {
			$pdf->Cell($period_width, 5, $period_header[$x], 1, 0, 'C');
		}

		if (empty($result)) {
			$pdf->Ln();
			$pdf->Cell(297, 5, 'No Result Found', 1, 0, 'C');
		}

		$count = 0;

		$pdf->SetFont('Arial', '', 7);

		$report_types = array(
			'submitted'	=> 0,
			'late'		=> 0,
			'none'		=> 0
		);

		foreach ($result as $key => $row) {
			if ($row->month == 'January' || $row->month == 'Quarter 1') {
				$pdf->Ln();
				$count++;
				$pdf->Cell($column_width[0], 5, $count, 1);
				$pdf->Cell($column_width[1], 5, $row->name, 1);
				$expiration_date = ($row->expiration != 'not set') ? date('d-M-y',strtotime($row->expdate)) : 'Not Set';
				$pdf->Cell($column_width[2], 5, $expiration_date, 1, 0, 'C');
			}

			$approveddate = ($row->approveddate) ? date('d-M-y',strtotime($row->approveddate)) : '';
			if ($report_id == '11') {
				$row->month_num = $row->month_num / 3;
			}
			$column_letter = chr(67 + $row->month_num);
			if ( ! isset($total_reports[$column_letter])) {
				$total_reports[$column_letter] = $report_types;
			}
			$total_reports[$column_letter][$row->status]++;
			if ($row->status == 'submitted') {
				$pdf->SetFillColor(255,255,255);
			} else if ($row->status == 'late') {
				$pdf->SetFillColor(240,128,128);
			} else {
				$pdf->SetFillColor(255,255,0);
			}
			$pdf->Cell($period_width, 5, $approveddate, 1, 0, 'C', true);
		}

		$full_offset = 0;

		foreach ($column_width as $width) {
			$full_offset += $width;
		}

		$report_type_labels = array(
			'Reports received on-time',
			'Reports received after deadline',
			'Number reports unsubmitted'
		);
		$report_types = array(
			'submitted',
			'late',
			'none'
		);

		foreach ($report_type_labels as $index => $type) {
			$pdf->Ln();
			$pdf->Cell($full_offset, 5, $type, 0, 0, 'R');

			if ($index == 0) {
				$pdf->SetFillColor(255,255,255);
			} else if ($index == 1) {
				$pdf->SetFillColor(240,128,128);
			} else {
				$pdf->SetFillColor(255,255,0);
			}

			foreach ($period_header as $key => $period) {
				$column_letter = chr(67 + $key + 1);
				$pdf->Cell($period_width, 5, $total_reports[$column_letter][$report_types[$index]], 1, 0, 'C', true);
			}
		}

		$pdf->Output();
	}

	private function get_notice($report_id, $report_type, $period, $year) {
		$data					= array();
		$data['report_title']	= $this->stakeholder->getReportTitle($report_id);
		$data['header']			= "LIST OF STAKEHOLDERS WITH " . strtoupper($report_type) . " REPORTS";
		$data['main_title']		= "REF NUMBER: $report_id-$report_type-$period-$year";
		$date					= DateTime::createFromFormat('!m', $period);
		$data['month_name']		= $date->format('F'); 

		$report_filter	= $year . '-' . $period . '-01';

		$report_date	= 'sr.report_date';
		if ($report_id == '11') {
			$report_date = "(CASE WHEN sr.report_date = 'quarter_1' THEN CONCAT(sr.year, '-03-01') WHEN sr.report_date = 'quarter_2' THEN CONCAT(sr.year, '-06-01') WHEN report_date = 'quarter_3' THEN CONCAT(sr.year, '-09-01') WHEN sr.report_date = 'quarter_4' THEN CONCAT(sr.year, '-12-01') END)";
		}

		if (strtolower($report_type) == "late") {
			$data['result'] = $this->stakeholder->getLateReports($report_id, $report_date, $report_filter);
		} else {
			$month_query = $this->getMonthQuery($period, $year, $report_id);
			$data['result'] = $this->stakeholder->getUnsubmittedReports($report_id, $report_date, $month_query);
		}

		return $data;
	}

	private function get_checklist($report_id, $year) {
		$data					= array();
		$data['report_title']	= $this->stakeholder->getReportTitle($report_id);
		$data['header']			= 'STAKEHOLDER MONITORING CHECKLIST';
		$data['main_title']		= 'Stakeholder Checklist - ' . $data['report_title'];
		
		$months  = array("January","February","March","April","May","June","July","August","September", "October","November","December");
		$report_date = 'report_date';
		$report_type = 'MONTH';
		if ($report_id == '11') {
			$months = array('2' => 'Quarter 1', '5' => 'Quarter 2', '8' => 'Quarter 3', '11' => 'Quarter 4');
			$report_date = "(CASE WHEN report_date = 'quarter_1' THEN CONCAT(rs.year, '-03-01') WHEN report_date = 'quarter_2' THEN CONCAT(rs.year, '-06-01') WHEN report_date = 'quarter_3' THEN CONCAT(rs.year, '-09-01') WHEN report_date = 'quarter_4' THEN CONCAT(rs.year, '-12-01') END)";
			$report_type = 'QUARTER';
		}

		$month_query = array();
		
		foreach ($months as $key => $month) {
			$month_num = $key + 1;
			$month_query[] = "SELECT {$month_num} month_num, '{$month}' month";
		}
		
		$month_query = implode(" UNION ", $month_query);

		$data['result']		= $this->stakeholder->getReportCheckList($report_id, $year, $month_query, $report_date);
		$data['tot_expiry']	= $this->stakeholder->getCheckListExpirationCount($report_id, $year, $month_query, $report_date);

		return $data;
	}

	private function getMonthQuery($period, $year, $report_id) {
		$month_query	= array();
		$start_year		= 2010;

		$year	= ($year > date('Y')) ? date('Y') : $year;
		$period	= ($period > 12) ? 12 : $period;
		
		for ($y = $start_year; $y <= $year; $y++) {
			for ($x = 1; $x <= 12; $x++) {
				if ($report_id == '11') {
					$x += 2;
				}
				$month_query[] = "SELECT $x month, $y year";
				if ($y == $year && $x == $period) {
					break;
				}
			}
		}

		return implode(' UNION ', $month_query);
	}

	private function getYearDropdown() {
		$year_list = array();

		for ($year = 2010; $year <= date("Y"); $year++) {
			$year_list[] = (object) array(
				'ind' => $year,
				'val' => $year
			);
		}

		return $year_list;
	}

	private function getMonthDropdown() {
		$month_list = array();

		for ($month = 1; $month <= 12; $month++) {
			$date_obj		= DateTime::createFromFormat('!m', $month);
			$month_name		= $date_obj->format('F');
			$month_list[]	= (object) array(
				'ind' => $month,
				'val' => $month_name
			);
		}

		return $month_list;
	}

	private function getQuarterDropdown() {
		$quarter_list = array();

		for ($quarter = 3; $quarter <= 12; $quarter += 3) {
			$quarter_list[]	= (object) array(
				'ind' => $quarter,
				'val' => 'Quarter ' . ceil($quarter / 3)
			);
		}

		return $quarter_list;
	}

}