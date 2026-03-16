<?php
	/* 
		some customize settings here
		*********************
	*/

	// image positioning variables
	$x=0; $y=0; $w=0; $h=0;

	//include border
	$border = 0; //1=enable 0=disable

	$font_family = 'helvetica';

	function f_config($font,$style,$size = 8)
	{
		return array(
					'font' => $font,
					'style' => $style,
					'size' => $size
				);
	}

	function rnd($num = 0.00)
	{	
		return number_format((float)$num,2,'.',',');
	}

	// pdf file naming
	$filename = $contract['contract_no']."prefer";

	if($contract['revision'] > 0)
	{
		// rev contract no
		$filename .= "Rev".$contract['revision']."prefer";
	}

	// fonts
	$b1 = f_config($font_family,'b',11);
	$b2 = f_config($font_family,'b',10);
	$b3 = f_config($font_family,'b',9);
	$b4 = f_config($font_family,'b',8);

	$bu1 = f_config($font_family,'bu',11);
	$bu2 = f_config($font_family,'bu',10);
	$bu3 = f_config($font_family,'bu',9);
	$bu4 = f_config($font_family,'bu',8);

	$bi3 = f_config($font_family,'bi',9);
	$bi4 = f_config($font_family,'bi',8);

	$n1 = f_config($font_family,'',10);
	$nu1 = f_config($font_family,'U',10);
	$nu2 = f_config($font_family,'U',9);

	if(count($details) < 9)
	{
		$n2 = f_config($font_family,'',9);
		$n3 = f_config($font_family,'',8);
		$n4 = f_config($font_family,'',7);

	}
	else
	{
		$n2 = f_config($font_family,'',8);
		$n3 = f_config($font_family,'',7);
		$n4 = f_config($font_family,'',6);
	}

	$i1 = f_config($font_family,'i',11);
	$i2 = f_config($font_family,'i',10);
	$i3 = f_config($font_family,'i',9);
	$i4 = f_config($font_family,'i',8);
	
	$peso_sign = "&#x20b1;";
	$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	/*
	*******************************
	*/
	

// for contract printing
tcpdf();

CLASS MY_PDF extends TCPDF{

	// Page Header
	public function Header() {

		// Logo
		$x=10;$y=4;$w=500;$h=18;
		$this->Image(base_url("css/images/jlr_logo_2016.png"), $x, $y, $w, $h, 'PNG', '', '', false, 300, '', false, false, 0,'L', false, false);

		$this->SetFont('helvetica','b',12);
		$this->Ln(25);
		$this->MultiCell(200, 5, 'CONTRACT AGREEMENT', 0, 'C', 0, 0, '', '', true);
	}

	// Page footer
	public function Footer() {

		// Position at 15 mm from bottom
		$this->SetY(-10);

		// Set font
		$this->SetFont('calibs', 'I', 8);
		// $this->MultiCell(200, 51, 'CONTRACT AGREEMENT', 0, 'C', 0, 0, '', '', true);
	
		// Footer
		//set footer image
		$x=0;$y=310;$w=220;$h=220;
		$this->Image(base_url("css/images/cntr_footer.png"), $x, $y, $w, $h, 'PNG', '', '', true, 300, '', false, false, 1,'L', false, false);
	}
}

$width = 216;
$height = 340;
$page_layout = array($width,$height);

$pdf = new MY_PDF('P', PDF_UNIT,$page_layout, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);

$title = $filename;

$pdf->SetTitle($title);

// disable header line
// $pdf->SetPrintHeader(false);

// disable footer line
// $pdf->SetPrintFooter(true);

// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// $pdf->SetDefaultMonospacedFont('helvetica');
// // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(-10);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_HEADER, PDF_MARGIN_RIGHT,TRUE);
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// $pdf->SetFont('helvetica', '', 9);
// $pdf->setFontSubsetting(false);

$pdf->AddPage();
ob_start();
    // we can have any view part here like HTML, PHP etc

	$pdf->Ln(20);

	// client name
	$pdf->SetFont($b1['font'],$b1['style'],$b1['size']);
	$pdf->Ln(10);
	$pdf->MultiCell(120, 5, $contract['client_name'], $border, 'L', 0, 0, '', '', true);

	// date
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->MultiCell(30, 5, 'Date: ', $border, 'L', 0, 0, '', '', true);
	$pdf->MultiCell(30, 5, date('F d, Y',strtotime($contract['doc_date'])), $border, 'L', 0, 1, '', '', true);

	// client address
	$pdf->MultiCell(120, 5, $contract['client_address'], $border, 'L', 0, 0, '', '', true);

	// contract no.
	$pdf->MultiCell(30, 5, 'Contract no.: ', $border, 'L', 0, 0, '', '', true);

	// check if contract is revised 
	if($contract['revision'] > 0)
	{
		// rev contract no
		$pdf->MultiCell(30, 5, $contract['contract_no']."Rev".$contract['revision'], $border, 'L', 0, 1, '', '', true); 
	}
	else
	{
		// non rev contract no
		$pdf->MultiCell(25, 5, $contract['contract_no'], $border, 'L', 0, 1, '', '', true);
	}

	//client contact
	$pdf->MultiCell(120, 5, "Tel. No.: ".$contract['client_contct_no'], $border, 'L', 0, 0, '', '', true);

	// sales
	$pdf->MultiCell(30, 5, 'Sales: ', $border, 'L', 0, 0, '', '', true);
	$pdf->SetFont($nu2['font'],$nu2['style'],$nu2['size']);
	$pdf->MultiCell(0, 5,trim($sales_name), $border, 'L', 0, 1, '', '', true);

	// sales contacts
	
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->MultiCell(150, 5,'', $border, 'L', 0, 0, '', '', true); //blank space
	$pdf->SetFont($nu2['font'],$nu2['style'],$nu2['size']);
	$pdf->MultiCell(25, 5, $contract['sales_contct_no1'], $border, 'L', 0, 1, '', '', true);
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->MultiCell(150, 5,'', $border, 'L', 0, 0, '', '', true); //blank space
	$pdf->SetFont($nu2['font'],$nu2['style'],$nu2['size']);
	$pdf->MultiCell(25, 5, $contract['sales_contct_no2'], $border, 'L', 0, 1, '', '', true);

	$pdf->Ln(2);

	// client rep name
	$pdf->SetFont($b1['font'],$b1['style'],$b1['size']);
	$pdf->MultiCell(180, 3,trim($contract['client_rep_prefix']." ".$contract['client_rep']), $border, 'L', 0, 1, '', '', true);
	$pdf->SetFont($i3['font'],$i3['style'],$i3['size']); 
	$pdf->MultiCell(180, 5,$contract['client_rep_position'], $border, 'L', 0, 0, '', '', true); 
	
	$pdf->Ln(7);

	// $pdf->MultiCell(20, 3,'', $border, 'L', 0, 0, '', '', true); 
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	
    $content = ob_get_contents();
	ob_end_clean();

	// //header content html format
	$html = '<span style="text-align: justify;">'.$tab.'<b>JLR CONSTRUCTION AND AGGREGATES INC.</b>
	hereinafter referred to as the FIRST PARTY proposes to furnish to <b>'.$contract['client_name'].',</b>hereinafter referred to as the SECOND PARTY, all labor, materials, equipment
	and supervision to do and perform at the prices stipulated the work described as follows:</span>';

	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->writeHTML($html,true,0,true,true);

	$pdf->Ln(5);

	// project
	$pdf->MultiCell(18, 5,'Project:', $border, 'L', 0, 0, '', '', true); 
	$pdf->SetFont($bu1['font'],$bu1['style'],$bu1['size']);
	$pdf->MultiCell(100, 5,$contract['project_name'], $border, 'L', 0, 0, '', '', true);

	// est volume
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->MultiCell(32, 5,'Estimated Volume:', $border, 'L', 0, 0, '', '', true);
	$pdf->SetFont($bu2['font'],$bu2['style'],$bu2['size']);
	$pdf->MultiCell(40, 5,$contract['est_vol'], $border, 'L', 0, 1, '', '', true);

	// project location
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->MultiCell(18, 5,'Location:', $border, 'L', 0, 0, '', '', true); 
	$pdf->SetFont($nu1['font'],$nu1['style'],$nu1['size']);
	$pdf->MultiCell(100, 5,$contract['project_loc'], $border, 'L', 0, 0, '', '', true);

	// Project Duration
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->MultiCell(32, 5,'Project Duration:', $border, 'L', 0, 0, '', '', true);
	$pdf->SetFont($nu1['font'],$nu1['style'],$nu1['size']);

	//format duration
	$txt = date('M',strtotime($contract['from_duration'])).".-".
		   date('M. Y',strtotime($contract['to_duration']));
	$pdf->MultiCell(40, 5,$txt, $border, 'L', 0, 1, '', '', true);

	
	$pdf->SetFont('freesans',$n2['style'],$n2['size']);
	
	//another html entry for table formating of contract details
	$tbl_header = '';
	$tbl_details = '';
	$with_pickup = false;


	switch ($contract['contract_type']) {
		case 'Cement Supplied':

			foreach ($details as $key) 
			{
				if($key->deliv_price !== $key->pickup_price && $key->pickup_price != 0 )
				{
					$with_pickup = true;
					break;
				}
			}

			switch ($with_pickup) 
			{
				case true:
					$tbl_header	= '
					<thead>
						<tr>
							<th rowspan="2" width="70" >Indicative <br> Cement Supply Cement Factor</th>
							<th rowspan="2" width="50">Strength (psi)</th>
							<th rowspan="2" width="60" >Max. size of Aggregates (inch)</th>
							<th rowspan="2" width="50" >Slump (inch)</th>
							<th rowspan="2" width="50" >Curing Days</th>
							<th width="100" colspan="2">Batch Cost per m³</th>
							<th rowspan="2" width="140">Remarks</th>
						</tr>
						<tr>
							<th width="50" align="center">Delivery</th>
							<th width="50" align="center">Pick-up</th>
						</tr>
					</thead>';

					break;
				
				default:
					$tbl_header	= '
					<thead>
						<tr>
							<th width="80" >Indicative <br> Cement Supply Cement Factor</th>
							<th width="50" >Strength (psi)</th>
							<th width="60" >Max. size of Aggregates (inch)</th>
							<th width="50" >Slump (inch)</th>
							<th width="50" >Curing Days</th>
							<th width="60" >Batch Cost per m³</th>
							<th width="150" style="vertical-align:middle;">Remarks</th>
						</tr>
					</thead>';
					break;
			}
			
			foreach ($details as $key) 
			{
				if($with_pickup)
				{
					$tbl_details = $tbl_details	.'
					<tr>
					<td width="70" align="center">'.round($key->cement_supp,2).'</td>
					<td width="50" align="center">'.str_replace('fx','flex',$key->psi_strength).'</td>
					<td width="60" align="center">'.$key->size_of_agg.'</td>
					<td width="50" align="center">'.$key->slump.'</td>
					<td width="50" align="center">'.$key->curing_days.'</td>
					<td width="50" align="center">'.$peso_sign.rnd($key->deliv_price).'</td>
					<td width="50" align="center">'.$peso_sign.rnd($key->pickup_price).'</td>
					<td width="140" align="center">'.$key->remarks.'</td>
					</tr>';
				}
				else
				{
					$tbl_details = $tbl_details	.'
					<tr>
					<td width="80" align="center">'.round($key->cement_supp,2).'</td>
					<td width="50" align="center">'.str_replace('fx','flex',$key->psi_strength).'</td>
					<td width="60" align="center">'.$key->size_of_agg.'</td>
					<td width="50" align="center">'.$key->slump.'</td>
					<td width="50" align="center">'.$key->curing_days.'</td>
					<td width="60" align="center">'.$peso_sign.rnd($key->deliv_price).'</td>
					<td width="150" align="center">'.$key->remarks.'</td>
					</tr>';
				}
			}		
			break; //end of cement supplied
				
		case 'Pick-Up':

			foreach ($details as $key) 
			{
				if($key->deliv_price !== $key->pickup_price)
				{
					$with_pickup = true;
					break;
				}
			}

			switch ($with_pickup) 
			{
				case true:
					$tbl_header	= '
					<thead>
						<tr>
							<th rowspan="2" width="50" align="center">Strength (psi)</th>
							<th rowspan="2" width="60" align="center">Max. size of Aggregates (inch)</th>
							<th rowspan="2" width="50" align="center">Slump (inch)</th>
							<th rowspan="2" width="50" align="center">Curing Days</th>
							<th width="120" align="center" colspan="2">Unit price per m³</th>
							<th rowspan="2" width="180" align="center">Remarks</th>
						</tr>
						<tr>
							<th width="60" align="center">Delivery</th>
							<th width="60" align="center">Pick-up</th>
						</tr>
					</thead>';

					break;
				
				default:
					$tbl_header	= '
					<thead>
						<tr>
							<th width="50" align="center">Strength (psi)</th>
							<th width="60" align="center">Max. size of Aggregates (inch)</th>
							<th width="50" align="center">Slump (inch)</th>
							<th width="50" align="center">Curing Days</th>
							<th width="100" align="center">Pick-up price per m³</th>
							<th width="183" align="center">Remarks</th>
						</tr>
					</thead>';
					break;
			}
			
			foreach ($details as $key) 
			{
				if($with_pickup)
				{
					$tbl_details = $tbl_details	.'
					<tr>
					<td width="50" align="center">'.str_replace('fx','flex',$key->psi_strength).'</td>
					<td width="60" align="center">'.$key->size_of_agg.'</td>
					<td width="50" align="center">'.$key->slump.'</td>
					<td width="50" align="center">'.$key->curing_days.'</td>
					<td width="60" align="center">'.$peso_sign.rnd($key->deliv_price).'</td>
					<td width="60" align="center">'.$peso_sign.rnd($key->pickup_price).'</td>
					<td width="180" align="center">'.$key->remarks.'</td>
					</tr>';
				}
				else
				{
					$tbl_details = $tbl_details	.'
					<tr>
					<td width="50" align="center">'.str_replace('fx','flex',$key->psi_strength).'</td>
					<td width="60" align="center">'.$key->size_of_agg.'</td>
					<td width="50" align="center">'.$key->slump.'</td>
					<td width="50" align="center">'.$key->curing_days.'</td>
					<td width="100" align="center">'.$peso_sign.rnd($key->pickup_price).'</td>
					<td width="183" align="center">'.$key->remarks.'</td>
					</tr>';
				}
			}	
			break; //end of PICK-UP
		default:
			$tbl_header	= '
			<thead>
				<tr>
					<th width="50" align="center">Strength (psi)</th>
					<th width="60" align="center">Max. size of Aggregates (inch)</th>
					<th width="50" align="center">Slump (inch)</th>
					<th width="50" align="center">Curing Days</th>
					<th width="100" align="center">Unit price per m³</th>
					<th width="183" align="center">Remarks</th>
				</tr>
			</thead>';
			foreach ($details as $key) 
			{
				$tbl_details = $tbl_details	.'
				<tr>
				<td width="50" align="center">'.str_replace('fx','flex',$key->psi_strength).'</td>
				<td width="60" align="center">'.$key->size_of_agg.'</td>
				<td width="50" align="center">'.$key->slump.'</td>
				<td width="50" align="center">'.$key->curing_days.'</td>
				<td width="100" align="center">'.$peso_sign.rnd($key->deliv_price).'</td>
				<td width="183" align="center">'.$key->remarks.'</td>
				</tr>';
			}
					
			break;
	}

	$html ='<table border="1" cellpadding="2" align="center">'.$tbl_header.'<tbody>'.$tbl_details.'</tbody></table>'; 
	
	$pdf->writeHTML($html,true,false,true,true);	
	
	// Terms Description
	$pdf->SetFont($b3['font'],$b3['style'],$b3['size']);
	$pdf->MultiCell(180, 5,'Terms of Payment: '. $contract['terms'], $border, 'L', 0, 1, '', '', true);
	// $pdf->MultiCell(75, 5,'Price is subject to change with prior notice.', $border, 'R', 0, 1, '', '', true);


	$pdf->SetFont($n3['font'],$n3['style'],$n3['size']);

	// Conditions
	$html = '<ul>';
	foreach ($conditions as $key) {
		$child_list = '';
		$sample_prod = '';
		foreach ($child_conditions as $child_key) 
		{
			if($key->cd_id === $child_key->parent)
			{
				$child_list = $child_list.'<ul>
					<li>'.$child_key->condition_desc.'</li>
				</ul>';
			}
		}

		if ($key->cd_id == 16) {
			$sample_prod = '<li>Sample Procedure - '.$contract['sample_proc'].'</li>';
		}

		$html=$html.
			$sample_prod.
			'<li>'.$key->condition_desc.$child_list.'</li>';
	}

	// $html = $html.'</ul>';
	// $pdf->writeHTML($html,true,false,true,false);	
	// $pdf->SetFont('freesans',$n3['style'],$n3['size']);

	// PUMP CHARGES ////////////////////////////////////
	if (count($pump_charges) > 0) 
	{	
		$pump_list = '';
		foreach($pumps as $pump)
		{
			$pump_charge_list = '';
			$charge_list = '';
			foreach($pump_charges as $pump_charge)
			{
				if ($pump->pump_id == $pump_charge->pump_id) 
				{
					foreach($charges as $charge)
					{
						if($pump_charge->charge_id == $charge->charge_id)
						{
							$chargeVal = '';
							if ($charge->unit === 'peso') 
							{
								$chargeVal = $peso_sign.' '.number_format($pump_charge->value,2,'.',',').$pump_charge->additional_desc;	
							}
							else
							{
								$chargeVal = round($pump_charge->value).'m³ '.$pump_charge->additional_desc;	
							}

							$charge_list .= '<li>'.$charge->charge_desc.' = '.$chargeVal.'</li>';
						}
					}
				}
				$pump_charge_list = '<ul>'.$charge_list.'</ul>';
			}

			$pump_list .= '<li> Concrete Pump:'.$pump->pump_desc.$pump_charge_list.'</li>';
		}
		$html .= $pump_list;
	}
	$html = $html.'</ul>';
	$pdf->SetFont('freesans',$n3['style'],$n3['size']);

	$pdf->writeHTML($html,true,false,true,false);	
	$pdf->Ln(2);

	// END OF PUMP CHARGES /////////////////////////////


	// $pdf->Ln(2);
	// Additional Conditions
	if ($contract['additional_info'] !== null && trim($contract['additional_info']) !== '') 
	{
		
		$pdf->SetFont($b4['font'],$b4['style'],$b4['size']);
		$pdf->MultiCell(180, 5,'Additional Conditions', $border, 'L', 0, 1, '', '', true);

		// addition cond
		$pdf->SetFont($n2['font'],$n2['style'],$n2['size']);
		$html = '<ul><li>'.$contract['additional_info'].'</li></ul>';
		$pdf->writeHTML($html,true,false,true,false);	
		$pdf->Ln(3);
	}

	// finers
	$pdf->SetFont($n4['font'],$n4['style'],$n4['size']);

	$txt ='<span style="text-align:justify;">'.$tab.'This proposal is subject to the terms and conditions stated herein and on the reverse side hereof which are incorporated as an integral part of the Contract Proposal and Agreement.</span>';

	// $pdf->MultiCell(5, 5,'', $border, 'L', 0, 0, '', '', true);
	$pdf->writeHTML($txt, true, false, true, false, '');
	// $pdf->MultiCell(180, 5,$txt, $border, 'L', 0, 1, '', '', true);

	$txt ='<span style="text-align:justify;">'.$tab.'This proposal will formally serve as a Contract Agreement upon acceptance verified by signature of an authorized representative of the SECOND PARTY and return of a signed copy to the FIRST PARTY.</span>';

	$pdf->Ln(1);
	$pdf->writeHTML($txt, true, false, true, false, '');
	// $pdf->MultiCell(180, 5,$txt, $border, 'L', 0, 1, '', '', true);

	$txt ='<span style="text-align:justify;">'.$tab.'The contract price above stipulated shall remain firm for the period of the proposal and the life of the accepted Contract Agreement, except as stated in Condition no. 2 of the reverse side hereof.</span>';

	$pdf->Ln(1);
	$pdf->writeHTML($txt, true, false, true, false, '');
	// $pdf->MultiCell(180, 5,$txt, $border, 'L', 0, 1, '', '', true);


	$txt ='<span style="text-align:justify;">'.$tab.'No terms or conditions shall be valid and binding except those stipulated herein and/or the reverse side hereof. No modification, amendments, assignments of transfer of this contract or any of the stipulated herein contained shall be valid and binding unless agreed to in writing between the PARTIES herein.</span>';

    $pdf->Ln(1);
	$pdf->writeHTML($txt, true, false, true, false, '');
	// $pdf->MultiCell(180, 5,$txt, $border, '', 0, 1, '', '', true);


	// Signatories
	$pdf->Ln(3);

	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	$pdf->MultiCell(180, 5,'CONFORME:', $border, 'L', 0, 1, '', '', true);
	$pdf->Ln(2);
	// client name
	$pdf->SetFont($b3['font'],$b3['style'],$b3['size']);
	$pdf->MultiCell(100, 5,$contract['client_name'], $border, 'L', 0, 0, '', '', true);
	

	$pdf->MultiCell(90, 5,'JLR CONSTRUCTION AND AGGREGATES INC.', $border, 'L', 0, 1, '', '', true);


	$pdf->SetFont($n3['font'],$n3['style'],$n3['size']);
	$pdf->MultiCell(100, 4,'SECOND PARTY', $border, 'L', 0, 0, '', '', true);

	$pdf->MultiCell(90, 4,'FIRST PARTY', $border, 'L', 0, 1, '', '', true);
	
	// BY:
	$pdf->MultiCell(100, 4,'By:', $border, 'L', 0, 0, '', '', true);
	$pdf->MultiCell(90, 4,'By:', $border, 'L', 0, 1, '', '', true);

	$pdf->Ln(2);

	// check if str1 is greate than the str2 
	function check_length($str1,$str2)
	{
		return strlen($str1) > strlen($str2);
	}

	// client name
	if(check_length($contract['client_sign_by'],$contract['client_sign_position']))
	{
		$pdf->SetFont($bu4['font'],$bu4['style'],$bu4['size']);
	}
	else
	{
		$pdf->SetFont($b4['font'],$b4['style'],$b4['size']);
	}

	$pdf->MultiCell(100, 3,strtoupper($contract['client_sign_by']), $border, 'L', 0, 0, '', '', true);
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);

	// sales name
	$pdf->SetFont($bu4['font'],$bu4['style'],$bu4['size']);
	$pdf->MultiCell(70, 3,trim(strtoupper($sales_name)), $border, 'L', 0, 1, '', '', true);

	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	// $pdf->MultiCell(10, 3,'', $border, 'L', 0, 0, '', '', true);

	// $pdf->SetFont($b4['font'],$b4['style'],$b4['size']);
	// client position
	if($contract['client_sign_by'] == '' || $contract['client_sign_by'] == null)
	{
		$pdf->SetFont($n2['font'],'O',$n2['size']);
		$pdf->MultiCell(70, 3,'Authorized Signature Over Printed Name', $border, 'L', 0, 0, '', '', true);
	}
	else
	{
		if(check_length($contract['client_sign_by'],$contract['client_sign_position']))
		{
			$pdf->SetFont($n2['font'],$n2['style'],$n2['size']);
		}
		else
		{
			$pdf->SetFont($n2['font'],'O',$n2['size']);
		}
		$pdf->MultiCell(100, 3,$contract['client_sign_position'], $border, 'L', 0, 0, '', '', true);
	}

	// sales position
	$pdf->SetFont($n2['font'],$n2['style'],$n2['size']);

	$pdf->SetFont($n2['font'],$n2['style'],$n2['size']);
	$pdf->MultiCell(70, 3,$sales_position, $border, 'L', 0, 1, '', '', true);

	$pdf->Ln(5);

	$pdf->SetFont($n2['font'],$n2['style'],$n2['size']);
	$pdf->MultiCell(90, 3,'___________________', $border, 'L', 0, 1, '', '', true);
	$pdf->MultiCell(35, 3,'Date', $border, 'L', 0, 0, '', '', true);
	$pdf->writeHTML($content, true, false, true, false, '');

$pdf->Output($filename.'.pdf', 'I');


 ?>

