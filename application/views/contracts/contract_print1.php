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
	$filename = $contract['contract_no'];

	if($contract['revision'] > 0)
	{
		// rev contract no
		$filename .= "Rev".$contract['revision'];
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

	$nu1 = f_config($font_family,'U',10);
	$nu2 = f_config($font_family,'U',9);
	
	$n1 = f_config($font_family,'',10);
	$n2 = f_config($font_family,'',9);
	$n3 = f_config($font_family,'',8);
	$n4 = f_config($font_family,'',7);

	/*if(count($details) < 7)
	{
		$n1 = f_config($font_family,'',10);
		$n2 = f_config($font_family,'',9);
		$n4 = f_config($font_family,'',7);
	}
	else
	{
		$n1 = f_config($font_family,'',9);
		$n2 = f_config($font_family,'',8);
		$n4 = f_config($font_family,'',6);

		if (count($details) > 7) 
		{
			$n3 = f_config($font_family,'',7);
		}
	}*/

	$i1 = f_config($font_family,'i',11);
	$i2 = f_config($font_family,'i',10);
	$i3 = f_config($font_family,'i',9);
	$i4 = f_config($font_family,'i',8);
	
	$peso_sign = "&#x20b1;";
	$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	/*
	*********************************************
	*/
	

// for contract printing
tcpdf();

CLASS MY_PDF extends TCPDF{

	var $border = 0;
	var $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	// Page Header
	public function Header() {

		// Logo
		$x=10;$y=4;$w=500;$h=18;
		$this->Image(base_url("css/images/jlr_logo_2016.png"), $x, $y, $w, $h, 'PNG', '', '', false, 300, '', false, false, 0,'L', false, false);
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
		// $x=0;$y=315;$w=220;$h=220; //for legal size
		/*$x=0;$y=253;$w=220;$h=220;
		$this->Image(base_url("css/images/cntr_footer.png"), $x, $y, $w, $h, 'PNG', '', '', true, 300, '', false, false, 1,'L', false, false);*/
	}

	public function MyFooter($details_size)
	{
		$x=0;$y=253;$w=220;$h=220;
		
		if($details_size > 5)
		{
			$y=304;
		}
		$this->SetAutoPageBreak(TRUE, 0);
		$this->Image(base_url("css/images/cntr_footer.png"), $x, $y, $w, $h, 'PNG', '', '', true, 300, '', false, false, 1,'L', false, false);
	}

	public function electronicSign()
	{
		$x=0;$y=253;$w=220;$h=220;
		
		if($details_size > 5)
		{
			$y=304;
		}
		$this->SetAutoPageBreak(TRUE, 0);
		$this->Image(base_url("css/images/cntr_footer.png"), $x, $y, $w, $h, 'PNG', '', '', true, 300, '', false, false, 1,'L', false, false);
	}

	public function NewPage()
	{
		$this->AddPage();
		$this->Ln(20);
	}
	
	// check if str1 is greate than the str2 
	function check_length($str1,$str2)
	{
		return strlen($str1) > strlen($str2);
	}
	 
	function Signatories($data)
	{
		////////////////////////////////////////SIGNATORIES////////////////////////////////////////
		$this->Ln(4);

		//Conforme
		$this->SetFont('helvetica','',10);
		$this->MultiCell(180, 5,'CONFORME:', $this->border, 'L', 0, 1, '', '', true);
		$this->Ln(2);

		// client name
		$this->SetFont('helvetica','b',9);
		$this->MultiCell(100, 5,$data['client_name'], $this->border, 'L', 0, 1, '', '', true);
		
		//JLR
		// $this->MultiCell(90, 5,'JLR CONSTRUCTION AND AGGREGATES INC.', $this->border, 'L', 0, 1, '', '', true);

		//Second Party
		$this->SetFont('helvetica','',8);
		$this->MultiCell(100, 4,'SECOND PARTY', $this->border, 'L', 0, 1, '', '', true);

		//First Party
		// $this->MultiCell(90, 4,'FIRST PARTY', $this->border, 'L', 0, 1, '', '', true);
		
		// BY:
		$this->MultiCell(100, 4,'By:', $this->border, 'L', 0, 1, '', '', true);
		// $this->MultiCell(90, 4,'By:', $this->border, 'L', 0, 1, '', '', true);

		$this->Ln(2);

		// client name
		if($this->check_length($data['client_sign_by'],$data['client_sign_position']))
		{
			//if client name length is greater than the length of client position
			$this->SetFont('helvetica','bu',8);
		}
		else
		{
			//if client position length is greater than the length of client name
			$this->SetFont('helvetica','b',8);
		}

		//Client Sign By
		$this->MultiCell(100, 3,strtoupper($data['client_sign_by']), $this->border, 'L', 0, 1, '', '', true);
		$this->SetFont('helvetica','',10);

		// sales name
		$this->SetFont('helvetica','bu',8);
		// $this->MultiCell(70, 3,/*trim(strtoupper($data['sales_name']))*/'JUDITH C. BELANDRES',$this->border, 'L', 0, 1, '', '', true);

		$this->SetFont('helvetica','',10);
		
		if($data['client_sign_by'] == '' || $data['client_sign_by'] == null)
		{
			//if client position is empty
			$this->SetFont('helvetica','O',9);
			$this->MultiCell(70, 3,'Authorized Signature Over Printed Name', $this->border, 'L', 0, 1, '', '', true);
		}
		else
		{

			if($this->check_length($data['client_sign_by'],$data['client_sign_position']))
			{
				//if client name length is greater than the length of client position
				$this->SetFont('helvetica','',9);
			}
			else
			{
				//if client position is greater than the length of client name
				$this->SetFont('helvetica','O',9);
			}
			$this->MultiCell(100, 3,$data['client_sign_position'],$this->border, 'L', 0, 1, '', '', true);
		}

		// sales position
		$this->SetFont('helvetica','',9);
		// $this->MultiCell(70, 3,/*$data['sales_position']*/'Sales Manager',$this->border, 'L', 0, 1, '', '', true);

		$this->Ln(3);

		$this->SetFont('helvetica','',9);
		$this->MultiCell(90, 1,'___________________',$this->border, 'L', 0, 1, '', '', true);
		$this->MultiCell(35, 1,'Date',$this->border, 'L', 0, 0, '', '', true);
	}

	function finers()
	{
		//////////////////////////////////////FINERS////////////////////////////////////////////////

		$this->SetFont('helvetica','',8);

		$txt ='<span style="text-align:justify;">'.$this->tab.'This proposal is subject to the terms and conditions stated herein and on the reverse side hereof which are incorporated as an integral part of the Contract Proposal and Agreement.</span>';

		$this->writeHTML($txt, true, false, true, false, '');

		$txt ='<span style="text-align:justify;">'.$this->tab.'This proposal will formally serve as a Contract Agreement upon acceptance verified by signature of an authorized representative of the SECOND PARTY and return of a signed copy to the FIRST PARTY.</span>';

		$this->Ln(1);
		$this->writeHTML($txt, true, false, true, false, '');

		$txt ='<span style="text-align:justify;">'.$this->tab.'The contract price above stipulated shall remain firm for the period of the proposal and the life of the accepted Contract Agreement, except as stated in Condition no. 2 of the reverse side hereof.</span>';

		$this->Ln(1);
		$this->writeHTML($txt, true, false, true, false, '');

		$txt ='<span style="text-align:justify;">'.$this->tab.'No terms or conditions shall be valid and binding except those stipulated herein and/or the reverse side hereof. No modification, amendments, assignments of transfer of this contract or any of the stipulated herein contained shall be valid and binding unless agreed to in writing between the PARTIES herein.</span>';

	    $this->Ln(1);
		$this->writeHTML($txt, true, false, true, false, '');
	}
}

#letter
$width 	= 215.9;
$height = 279.4;

#if details greater than 5
if (count($details) > 5) 
{
	#legal size
	$width = 215.9;
	$height = 330.9;
}
$page_layout = array($width,$height);

$contract['sales_name'] = $sales_name;
$contract['sales_position'] = $sales_position;

$pdf = new MY_PDF('P', PDF_UNIT,$page_layout, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);

$title = $filename;

$pdf->SetTitle($title);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_HEADER, PDF_MARGIN_RIGHT,TRUE);

$pdf->SetPrintHeader($contract['is_approved']);

$pdf->NewPage();


/*ob_start();*/
    // we can have any view part here like HTML, PHP etc
	$pdf->SetFont('helvetica','b',12);
	$pdf->MultiCell(200, 5, 'CONTRACT AGREEMENT', 0, 'C', 0, 0, '', '', true);

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

	// client rep name
	$pdf->SetFont($b1['font'],$b1['style'],$b1['size']);
	$pdf->MultiCell(150, 3,trim($contract['client_rep_prefix']." ".$contract['client_rep']), $border, 'L', 0, 0, '', '', true);

	$pdf->SetFont($nu2['font'],$nu2['style'],$nu2['size']);
	$pdf->MultiCell(25, 5, $contract['sales_contct_no2'], $border, 'L', 0, 1, '', '', true);

	// client position
	$pdf->SetFont($i3['font'],$i3['style'],$i3['size']); 
	$pdf->MultiCell(180, 5,$contract['client_rep_position'], $border, 'L', 0, 0, '', '', true); 
	
	$pdf->Ln(7);
 
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);
	
    /*$content = ob_get_contents();
	ob_end_clean();*/

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

	if (count($details)>10)
	{
		$pdf->SetFont('freesans',$n2['style'],$n2['size']);
	}
	else
	{
		$pdf->SetFont('freesans',$n1['style'],$n1['size']);
	}
	
	//another html entry for table formating of contract details
	$tbl_header = '';
	$tbl_details = '';
	$with_pickup = false;

	// //////////////////////////Contract details ///////////////////////////////////////////
	switch ($contract['contract_type']) 
	{
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
						<tr>
							<th rowspan="2" width="80" >Indicative <br> Cement Supply Cement Factor</th>
							<th rowspan="2" width="50">Strength <br> (psi)</th>
							<th rowspan="2" width="60" >Max. size of Aggregates <br> (inch)</th>
							<th rowspan="2" width="50" >Slump <br> (inch)</th>
							<th rowspan="2" width="50" >Curing Days</th>
							<th width="120" colspan="2">Batch Cost <br>/m³</th>
							<th rowspan="2" width="100">Remarks</th>
						</tr>
						<tr>
							<th width="60" align="center">Delivered</th>
							<th width="60" align="center">Pick-up</th>
						</tr>';

					break;
				
				default:
					$tbl_header	= '
						<tr>
							<th width="80" >Indicative <br> Cement Supply Cement Factor</th>
							<th width="50" >Strength <br>(psi)</th>
							<th width="60" >Max. size of Aggregates <br>(inch)</th>
							<th width="50" >Slump <br>(inch)</th>
							<th width="50" >Curing <br> Days</th>
							<th width="60" >Batch Cost /m³</th>
							<th width="100" style="vertical-align:middle;">Remarks</th>
						</tr>';
					break;
			}
			
			foreach ($details as $key) 
			{
				if($with_pickup)
				{
					$tbl_details = $tbl_details	.'
					<tr>
					<td width="80" align="center">'.round($key->cement_supp,2).'</td>
					<td width="50" align="center">'.str_replace('fx','flex',$key->psi_strength).'</td>
					<td width="60" align="center">'.$key->size_of_agg.'</td>
					<td width="50" align="center">'.$key->slump.'</td>
					<td width="50" align="center">'.$key->curing_days.'</td>
					<td width="60" align="center">'.$peso_sign.rnd($key->deliv_price).'</td>
					<td width="60" align="center">'.$peso_sign.rnd($key->pickup_price).'</td>
					<td width="100" align="center">'.$key->remarks.'</td>
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
					<td width="100" align="center">'.$key->remarks.'</td>
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
						<tr>
							<th rowspan="2" width="50" align="center">Strength <br>(psi)</th>
							<th rowspan="2" width="60" align="center">Max. size of Aggregates <br>(inch)</th>
							<th rowspan="2" width="50" align="center">Slump <br>(inch)</th>
							<th rowspan="2" width="50" align="center">Curing <br>Days</th>
							<th width="120" align="center" colspan="2">Unit Price<br>/m³</th>
							<th rowspan="2" width="100" align="center">Remarks</th>
						</tr>
						<tr>
							<th width="60" align="center">Delivered</th>
							<th width="60" align="center">Pick-up</th>
						</tr>';

					break;
				
				default:
					$tbl_header	= '
						<tr>
							<th width="50" align="center">Strength (psi)</th>
							<th width="60" align="center">Max. size of Aggregates (inch)</th>
							<th width="50" align="center">Slump (inch)</th>
							<th width="50" align="center">Curing Days</th>
							<th width="70" align="center">Pick-up Price<br>/m³</th>
							<th width="100" align="center">Remarks</th>
						</tr>';
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
					<td width="100" align="center">'.$key->remarks.'</td>
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
					<td width="70" align="center">'.$peso_sign.rnd($key->pickup_price).'</td>
					<td width="100" align="center">'.$key->remarks.'</td>
					</tr>';
				}
			}	
			break; //end of PICK-UP
		default:
			$tbl_header	= '
			<thead>
				<tr>
					<th width="50" align="center">Strength <br> (psi)</th>
					<th width="60" align="center">Max. size of Aggregates <br> (inch)</th>
					<th width="50" align="center">Slump <br> (inch)</th>
					<th width="50" align="center">Curing <br> Days</th>
					<th width="70" align="center">Unit Price<br>/m³</th>
					<th width="100" align="center">Remarks</th>
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
				<td width="70" align="center">'.$peso_sign.rnd($key->deliv_price).'</td>
				<td width="100" align="center">'.$key->remarks.'</td>
				</tr>';
			}
					
			break;
	}

	$html = '<table border="1" cellpadding="2" align="center"><thead>'.$tbl_header.'</thead><tbody>'.$tbl_details.'</tbody></table>';
	$html .= '<span style="font-size:10px;font-weight:bold;">Price may change when cement and fuel price increases.</span><br>';
	$html .= '<span style="font-size:10px;font-weight:bold;">Terms of Payment: '. $contract['terms'].'.</span>';
	$pdf->writeHTML($html,true,false,true,false);

	//////////////////////////////End of Contract Details//////////////////////////////////	
	// Price may change when cement and fuel price will increase;
	$pdf->Ln(1);
	// Conditions
	$pdf->SetFont($n1['font'],$n1['style'],$n1['size']);

	$html = '<ul>';
	foreach ($conditions as $key) {
		$child_list = '';
		$sample_prod = '';
		$condition = '';
		foreach ($child_conditions as $child_key) 
		{
			if($key->cd_id === $child_key->parent)
			{
				$child_list = $child_list.'<ul>
					<li>'.$child_key->condition_desc.'</li>
				</ul>';
			}
		}
		
		if ($key->cd_id == 5) 
		{
			$condition = '<li><u>Sampling Procedure:</u> '.$contract['sample_proc'].'</li>';
		}
		else
		{
			$condition = '<li>'.$key->condition_desc.$child_list.'</li>';
		}

		$html.= $condition;
			
	}

	$html = $html.'</ul>';
	$pdf->writeHTML($html,true,false,true,false);	
	$pdf->Ln(1);

	// Additional Conditions
	$has_preferred = 0;
	$content = '';
	foreach ($add_conditions as $row) 
	{
		$has_preferred = $row->has_preferred;
		$content = $row->additional_condition;
	}
	if ($content !== '') 
	{
		
		$pdf->SetFont($b3['font'],$b3['style'],$b3['size']);
		$pdf->MultiCell(180, 2,'Additional Conditions', $border, 'L', 0, 1, '', '', true);

		
		// addition cond
		$pdf->SetFont($n2['font'],$n2['style'],$n2['size']);
		$html = '<ul>';
		if ($has_preferred == 1) $html .= '<li>JLR Construction and Aggregates Inc. is the first preferred concrete suppliers.</li>';
		$html .= '<li>'.$content.'</li>';
		$html .= '</ul>';
		$pdf->writeHTML($html,true,false,true,false);	
		$pdf->Ln(2);
	}

	$pdf->finers();
	$pdf->Signatories($contract);
	/**
		PUMP CHARGES HERE
	**/
	if (count($pump_charges) > 0) 
	{
		// $pdf->
		// #new page
		if($contract['is_approved'])
		{
			$pdf->MyFooter(count($details));
		}

		$pdf->SetPrintHeader(false);
		$pdf->AddPage();
		/*
			Pump Header
		*/
		$pdf->Ln(10);
		$pdf->SetFont('freesans',$b1['style'],15);
		$pdf->MultiCell(180, 3,'Concrete Pump Charges', $border, 'C', 0, 1, '', '', true);
		$pdf->Ln(5);

		$pdf->SetFont('freesans',$n2['style'],$n2['size']);

		#set table header
		$pump_header = '';
		$arr_pump = array();
		
		foreach ($pumps as $pump) 
		{
			foreach ($pump_charges as $pump_charge) 
			{
		 		if ($pump->pump_id === $pump_charge->pump_id) 
		 		{
		 			$pump_header .= '<th>'.$pump->pump_desc.'</th>';
		 			array_push($arr_pump, $pump);
		 			break;
		 		}
		 	}
		} 

		$tbl_header = '<tr padding="10" align="center" style="font-size:11px;"><th><b>Putzmeister Concrete Pump</b></th>'.$pump_header.'</tr>';

		#set table content
		$tbl_details 	= '';
		$td_pump		= '';
		$td_charge 		= '';

		foreach ($particulars as $p) 
		{
			foreach ($pump_charges as $pc) 
			{
				if ($p->charge_id === $pc->charge_id) 
				{
					$td_charge = $p->charge_desc;

					foreach ($arr_pump as $pp) 
					{
						$pump_value = 'none';
						foreach ($pump_charges as $pc2) 
						{
							if (($pc2->pump_id === $pp->pump_id) && ($pc2->charge_id === $p->charge_id)) 
							{
								switch ($p->unit) 
								{
									case 'peso':
										$pump_value = peso($pc2->value).' '.$pc2->additional_desc;
										break;

									case 'cubic':
										$pump_value = round($pc2->value).'m³ '.$pc2->additional_desc;
										break;

									case 'pcs':
										$pump_value = pcs($pc2->value).$pc2->additional_desc;
										break;

									default:
										$pump_value =trim(((int)$pc2->value == 0? '':round($pc2->value)).' '.$pc2->additional_desc);
										break;
								}
								
								break;
							}
						}
						$td_pump .= '<td>'.$pump_value.'</td>';
					}

					$tbl_details .= '<tr><td>'.$td_charge.'</td>'.$td_pump.'</tr>';

					#if highrise
					if (strpos($p->charge_desc,'Floor Level Surcharge') !== FALSE) 
					{
						$count_value=0;

						foreach ($floor_surcharge as $value) {
							$count_value += count($value);
						}

						$count_value = $count_value / count($arr_pump);

						for ($i=0; $i < round($count_value); $i++) 
						{ 
							$pump_value = '';
							foreach ($arr_pump as $p) 
							{
								$amt = '';
								$desc = '';

								if (array_key_exists($i,$floor_surcharge[$p->pump_id])) 
								{
									$amt = $floor_surcharge[$p->pump_id][$i][0];
									$desc = $floor_surcharge[$p->pump_id][$i][1];
								}
								
								$pump_value .='<td>'.($amt != ''?peso($amt):'').'</td>';
							}

							$tbl_details .= '<tr><td align="center">'.$desc.'</td>'.$pump_value.'</tr>';
						}
					}

					$td_pump = '';
					break;
				}
			}
		}
		#MERGE ROW THAT HAVE THE SAME VALUE
		
		$tbl = '<table border="1" cellpadding="3" align="left">'.$tbl_header.$tbl_details.'</table>';
		$pdf->writeHTML($tbl,true,false,true,false);

		$pdf->Signatories($contract);
	}else{
		if($contract['is_approved'])
		{
			$pdf->MyFooter(count($details));
		}	
	} 
	//END OF PUMP CHARGES
	
	$pdf->Output($filename.'.pdf', 'I');
 ?>

