<?php

class FunctionList {

	// User Set
	function isWebAdmin($userlvl){
		if($userlvl==1){
			return true;
		}
		else{ return false;}
	}

	function isAdmin($userlvl){
		if($userlvl<=5){
			return true;
		}
		else{ return false;}
	}

	function isCVR($userlvl){
		if(//$userlvl==1
		$userlvl==150||$userlvl==100
		){
			return true;
		}
		else{ return false;}
	}

	function isUser($userlvl){
		if($userlvl>6){
			return true;
		}
		else{ return false;}
	}

	function isVP($userlvl){
		if($userlvl==150 || $userlvl==151 || $userlvl==110 || $userlvl==70){
			return true;
		}
		else{ return false;}
	}

	function isHR($userlvl){
		if(	$userlvl>=10 AND $userlvl<20){
				return true;
			}
		else{ return false;}
	}

	function isHRStaff($userlvl){
		if(	$userlvl==10){
				return true;
			}
		else{ return false;}
	}

	function isPurchasing($userlvl){
		if(	$userlvl==22){
				return true;
			}
		else{ return false;}
	}
	function isAccounting($userlvl){
		if(	($userlvl>=20 AND $userlvl<40)){	return true;	}
		else{ return false;}
	}
	function isSSDiv($userlvl){
		if(	($userlvl>=10 AND $userlvl<=20) OR
			($userlvl>=30 AND $userlvl<40) OR
			$userlvl==22 OR
			$userlvl==110)
			{	return true;	}
		else{ return false;		}
	}
	function isSMD($userlvl){
		if(	$userlvl>=40 AND $userlvl<50)
			{	return true;	}
		else{ return false;		}
	}
	function isRMD($userlvl){

	}
	function isOperations($userlvl){
	}
	function isQAadmin($userlvl){
		if($userlvl>=80 AND $userlvl<=86)
			{	return true;	}
		else{ return false;		}
	}
	function isManagement($userlvl){
		if(	$userlvl==10 OR
			$userlvl==12 OR
			$userlvl==30 OR
			$userlvl==31 OR
			$userlvl==40 OR
			$userlvl==41 OR
			$userlvl==60 OR
			$userlvl==70 OR
			$userlvl==80 OR
			$userlvl==100 OR
			$userlvl==110 OR
			$userlvl==150 OR
			$userlvl==151){
				return true;
			}
		else{ return false;}
	}
	function useSMD($userlvl){
		if(	$userlvl>=40 AND $userlvl<50)
			{	return true;	}
		else{ return false;		}
	}
	function useRMCD($userlvl){
		if(	$userlvl>=70 AND $userlvl<90)
			{	return true;	}
		elseif($userlvl>=40 AND $userlvl<50)
			{	return true;	}
		else{ return false;		}
	}
	function useRMD($userlvl){
		if(	($userlvl>=60 AND $userlvl<71) OR
			$userlvl==20 OR
			$userlvl==987
			)
			{	return true;	}
		else{ return false;		}
	}
	function useQAD($userlvl){
		if(	$userlvl>=100 AND $userlvl<110)
			{	return true;	}
		else{ return false;		}
	}
	function isDEU($userlvl){
		if( $userlvl==20 OR
			$userlvl==60 OR
			$userlvl==61 OR
			$userlvl==62 OR
			$userlvl==63 OR
			$userlvl==70 OR
			$userlvl==72 OR
			$userlvl==90 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}
	function isDEUViewer($userlvl){
		if( $userlvl==20 OR
			$userlvl==70 OR
			$userlvl==60 OR
			$userlvl==90 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}
	function isDEUEditor($userlvl){
		if( $userlvl==61 OR
			$userlvl==62 OR
			$userlvl==63 OR
			$userlvl==72 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}
	function isAMS($userlvl){
		if(	$userlvl==61 OR
			$userlvl==72 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}

	// DPS User Area
	function isDPS($userlvl){
		if(	$userlvl==12 OR
			$userlvl==22 OR
			$userlvl==33 OR
			$userlvl==40 OR
			$userlvl==41 OR
			$userlvl==42 OR
			$userlvl==44 OR
			$userlvl==45 OR
			$userlvl==47 OR
			$userlvl==30 OR
			$userlvl==31 OR
			$userlvl==71 OR
			$userlvl==75 OR
			$userlvl==81 OR
			$userlvl==82 OR
			$userlvl==76 OR
			$userlvl==110 OR
			$userlvl==80 OR
			$userlvl==10 OR
			$userlvl==150 OR
			$userlvl==151 OR
			$userlvl==76 OR
			$userlvl==70 OR
			$userlvl==71 OR
			$userlvl==90 OR
			$userlvl==72 OR
			$userlvl==61 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}
	function isDPSEditor($userlvl){
		if(	$userlvl==42 OR
			$userlvl==40 OR
			$userlvl==41 OR
			$userlvl==45 OR
			$userlvl==47 OR
			$userlvl==30 OR
			$userlvl==31 OR
			$userlvl==33 OR
			$userlvl==71 OR
			$userlvl==70 OR
			$userlvl==81 OR
			$userlvl==82 OR
			$userlvl==90 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}
	function viewDPS($userlvl){
		if(	$userlvl==76 OR
			$userlvl==44 OR
			//$userlvl==47 OR
			$userlvl==12 OR
			$userlvl==60 OR
			$userlvl==110 OR
			$userlvl==80 OR
			$userlvl==10 OR
			$userlvl==150 OR
			$userlvl==151 OR
			$userlvl==75 OR
			$userlvl==72 OR
			$userlvl==61 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}
	function isDPSCoordinator($userlvl){
		if($userlvl==42 OR
		   $userlvl==45){
			return true;
		}
		else{ return false;}
	}
	function isDPSacctg($userlvl){
		if($userlvl==30 OR
		   $userlvl==31 OR
		   $userlvl==33){
			return true;
		}
		else{ return false;}
	}
	function isDPSsmd($userlvl){
		if($userlvl==40 OR
		   $userlvl==41){
			return true;
		}
		else{ return false;}
	}
	function isDPSqc($userlvl){
		if($userlvl==81 OR
		   $userlvl==82 OR
		   $userlvl==70){
			return true;
		}
		else{ return false;}
	}
	function isDPSps($userlvl){
		if($userlvl==71 OR
		   $userlvl==72 OR
		   $userlvl==70){
			return true;
		}
		else{ return false;}
	}

	function isDPSmanagers($userlvl){
		if($userlvl==70 OR
		   $userlvl==90  ){
			return true;
		}
		else{ return false;}
	}


	// end of DPS User Area

	function isDOU($userlvl){
		if(	//$userlvl==45 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}
	function isCSMS($userlvl){
		if(	$userlvl==81 OR
			$userlvl==82 OR
			$userlvl==84 OR
			$userlvl==987){
				return true;
			}
		else{ return false;}
	}

	// END of User Set

	/* -------------------------------------------------
	|	User set for the Online Leave v2
	|	Added by Ralph Ceriaco : April 27, 2015
	|	Leave viewer userlvl = 500
	*/

	function isLeaveViewer($userlvl){
		if($userlvl!=500){
			return true;
		}
		else{ return false;}
	}

	function isLeaveSup($userid){
		if($userid==224 OR
		   $userid==167 OR
		   $userid==126 OR
		   $userid==219 OR
		   // $userid==179 OR
		   $userid==27 OR
		   $userid==69 OR
		   $userid==138 OR
		   $userid==142 OR
		   $userid==31){
			return true;
		}
		else{ return false;}
	}

	function isLeaveMngr($userid){
		if($userid==51 OR
		   $userid==129 OR
		   $userid==20 OR
		   $userid==135 OR
		   $userid==217 OR
		   $userid==159 OR
		   $userid==239 OR
		   $userid==84){
			return true;
		}
		else{ return false;}
	}
	function isFIDCollection($userid){
		if($userid==33){
			return true;
		}
		else{ return false;}
	}

	function isSMDCoordinator($userid){
		if($userid==600){
			return true;
		}
		else{ return false;}
	}

	function isRMCMangerSMDView($userid){
		if($userid==71){
			return true;
		}
		else{ return false;}
	}

	function isViewMobile($userlvl){
		if(//$userlvl==1
		$userlvl==150||$userlvl==100
		){
			return true;
		}
		else{ return false;}
	}


	function convertDate($date){
		$day = substr($date,3,5);
		$month = substr($date,0,2);
		$year = substr($date,6,11);
		$cDate = '$year-$month-$day';
		return $cDate;
	}

	function getTimeArrays(){
		$time =  array( '' => '',
						'0000' => '0000','0030' => '0030',
						'0100' => '0100','0130' => '0130',
						'0200' => '0200','0230' => '0230',
						'0300' => '0300','0330' => '0330',
						'0400' => '0400','0430' => '0430',
						'0500' => '0500','0530' => '0530',
						'0600' => '0600','0630' => '0630',
						'0700' => '0700','0730' => '0730','0745' => '0745',
						'0800' => '0800','0830' => '0830','0845' => '0845',
						'0900' => '0900','0930' => '0930','0945' => '0945',
						'1000' => '1000','1030' => '1030','1045' => '1045',
						'1100' => '1100','1130' => '1130','1145' => '1145',
						'1200' => '1200','1230' => '1230','1245' => '1245',
						'1300' => '1300','1330' => '1330','1345' => '1345',
						'1400' => '1400','1430' => '1430','1445' => '1445',
						'1500' => '1500','1530' => '1530','1545' => '1545',
						'1600' => '1600','1630' => '1630','1645' => '1645',
						'1700' => '1700','1730' => '1730','1745' => '1745',
						'1800' => '1800','1830' => '1830',
						'1900' => '1900','1930' => '1930',
						'2000' => '2000','2030' => '2030',
						'2100' => '2100','2130' => '2130',
						'2200' => '2200','2230' => '2230',
						'2300' => '2300','2330' => '2330');
		return $time;
	}

	function getDPSTimeArrays(){
		$time =  array( '' => '',
						'0000' => '0000','0030' => '0030',
						'0100' => '0100','0130' => '0130',
						'0200' => '0200','0230' => '0230',
						'0300' => '0300','0330' => '0330',
						'0400' => '0400','0430' => '0430',
						'0500' => '0500','0530' => '0530',
						'0600' => '0600','0630' => '0630',
						'0700' => '0700','0730' => '0730','0745' => '0745',
						'0800' => '0800','0830' => '0830','0845' => '0845',
						'0900' => '0900','0930' => '0930','0945' => '0945',
						'1000' => '1000','1030' => '1030','1045' => '1045',
						'1100' => '1100','1130' => '1130','1145' => '1145',
						'1200' => '1200','1230' => '1230','1245' => '1245',
						'1300' => '1300','1330' => '1330','1345' => '1345',
						'1400' => '1400','1430' => '1430','1445' => '1445',
						'1500' => '1500','1530' => '1530','1545' => '1545',
						'1600' => '1600','1630' => '1630','1645' => '1645',
						'1700' => '1700','1730' => '1730','1745' => '1745',
						'1800' => '1800','1830' => '1830',
						'1900' => '1900','1930' => '1930',
						'2000' => '2000','2030' => '2030',
						'2100' => '2100','2130' => '2130',
						'2200' => '2200','2230' => '2230',
						'2300' => '2300','2330' => '2330',
						'APCA - AM' => 'APCA - AM','APCA - PM' => 'APCA - PM');
		return $time;
	}

	function isHoliday($date){

		$date2 = date("m-d",$date);
		$date3 = "$date2";
		switch ($date3){
			case "1-1":
			case "1-2":
			case "2-22":
			case "3-17":
			case "3-26":
			case "4-1":
			case "4-2":
			case "4-9":
			case "5-3":
			case "5-10":
			case "6-14":
			case "8-6":
			case "8-21":
			case "8-22":
			case "8-30":
			case "9-9":
			case "10-15":
			case "11-1":
			case "11-2":
			case "11-29":
			case "12-19":
			case "12-24":
			case "12-25":
			case "12-27":
			case "12-31":
			return true;
			break;
			default:
			return false;
			break;

		}
	}

	function convertNtilde($string){
		$text = str_replace("Ñ", "&Ntilde;", $string);
		$text = str_replace("ñ", "&ntilde;", $text);
		return $text;
	}

	function checkTime($testtime,$checktime,$type){

		$t1 = strtotime($testtime);
		$t2 = strtotime($checktime);
		switch($type) {
			case "=" :
				if($t1==$t2){ return true;}
				else{return false;}
				break;
			case ">=" :
				if($t1>=$t2){ return true;}
				else{return false;}
				break;
			case "<=" :
				if($t1<=$t2){ return true;}
				else{return false;}
				break;
			case ">" :
				if($t1>$t2){ return true;}
				else{return false;}
				break;
			case "<" :
				if($t1<$t2){ return true;}
				else{return false;}
				break;
			case "adv" :
				$t2 = $t2 + 129600;
				$lol = date("H:i:s Y-m-d",$t2);
				print $lol;
				if($t1<$t2){ return true;}
				else{return false;}
				break;
			default:
				return false;
				break;
		}
	}

	function convertVol($value){
		if(empty($value)){
			return '';
		}
		else{
			$cVal = number_format($value,1);
			return $cVal;
		}
	}

	function setCSS($type='',$property=''){
		return $type.'="'.$property.'"';
	}

	function error_message($message=''){
		$error['message'] = $message;
		$error['view'] = 'templates/nA_view';
		return $error;
	}

	function radioGroup($name='',$value='',$select='',$id='',$attrib=''){
		$n = $select;
		$radio= '';
		$fldname = str_replace(' ', '_', $name);
		if(isset($_SESSION[$fldname])) $n = $_SESSION[$fldname];
		if(isset($_POST[$fldname])) $n = $_POST[$fldname];
		foreach($value as $radVal){
			$cndtn = ($n == $radVal)? TRUE : '';
			$dataarray = array('name' =>	$fldname, 'id' =>	$id, 'value' =>	$radVal);
			$radio .= form_radio($dataarray,'',$cndtn)." $radVal<br/>";
		}
		echo $radio;
	}

	function getDesignStatus(){
		$status =  array( '' => '',
						'Okay' => 'Okay',
						'Cancelled' => 'Cancelled',
						'Insert' => 'Insert',
						'Re-Sched' => 'Re-Sched',
						'Pending' => 'Pending',
						'For Confirmation' => 'For Confirmation');
		return $status;
	}

	function getAccountingRem(){
		$remarks =  array( '' => '',
						'HOLD-NC' => 'HOLD-NC',
						'HOLD-OA' => 'HOLD-OA',
						'HOLD-NP' => 'HOLD-NP',
						'7D' => '7D',
						'15D' => '15D',
                        '20D' => '20D',
						'30D' => '30D',
						'45D' => '45D',
						'60D' => '60D',
						'90D' => '90D',
						'DBP' => 'DBP',
						'PAP' => 'PAP',
						'FBP' => 'FBP-PAID',
						'PDC' => '50%DP-50%PDC',
						'APPROVED' => 'APPROVED',
						'DISAPPROVE' => 'DISAPPROVE',
						'CEMENT-DEFICIT/LOCK' => 'CEMENT-DEFICIT/LOCK',
						'HOLD-RC' => 'HOLD-RC',
						);
		return $remarks;
	}

	function getServiceEngr(){
		$list =  array( 'NONE' => 'NONE',
						'B01' => 'B01',
						'B02' => 'B02',
						'B03' => 'B03',
					    'B04' => 'B04',
					    'B05' => 'B05',
					    'B06' => 'B06',
					    'B07' => 'B07',
					    'B08' => 'B08',
					    'B09' => 'B09',
					    'B10' => 'B10',
					    'B11' => 'B11',
					    'B12' => 'B12',
					    'B14' => 'B14',
                        'B15' => 'B15',
                        'B16' => 'B16'
						);
		return $list;
	}

	function bold_fcode($fcode){
		if($fcode != ''){
			//$tmp = explode(" ",$fcode);
			//$fcode = "<strong>" . $tmp['0'] . "</strong> " . $tmp['1'];
            $fcode = "<strong>" . $fcode . "</strong> ";
		}else{
			$fcode = '';
		}

		return $fcode;
	}

	function convert_Big_Ntilde($string)
    {
    	return str_replace('Ñ','&Ntilde',$string);

    }


    function watermarkImage ($SourceFile, $WaterMarkText,$WaterMarkText2, $WaterMarkText3, $DestinationFile)
	{
	   list($width, $height) = getimagesize($SourceFile);
	   $image_p = imagecreatetruecolor($width, $height);
	   $image = imagecreatefromjpeg($SourceFile);
	   imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
	   $red = imagecolorallocate($image_p, 255, 0, 0);
	   //$black = imagecolorallocate($image_p, 0, 0, 0);
	   $font = './arial.ttf';
	   $font_size = 6;

	   imagettftext($image_p, $font_size, 0, 10, 15, $red, $font, $WaterMarkText);
	   imagettftext($image_p, $font_size, 0, 10, 25, $red, $font, $WaterMarkText2);
	   imagettftext($image_p, $font_size, 0, 10, 35, $red, $font, $WaterMarkText3);

	   if ($DestinationFile<>'') {
	      imagejpeg ($image_p, $DestinationFile, 100);
	   } else {
	      header('Content-Type: image/jpeg');
	      imagejpeg($image_p, null, 100);
	   };
	   imagedestroy($image);
	   imagedestroy($image_p);
	}

	function resizeImage($filename,$dest,$n_width,$n_height)
	{

		// The file
		//$filename = 'test.jpg';
		//$percent = 10;

		// Content type
		header('Content-Type: image/jpeg');

		//var_dump($filename);exit();

		// Get new dimensions
		list($width, $height) = getimagesize($filename);

		//var_dump($height);exit();
		$new_width = $n_width;
		$new_height = $n_height;

		// Resample
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = @imagecreatefromjpeg($filename);
		imagecopyresampled($image_p,$image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		// Output
		imagejpeg($image_p, $dest, 100);
	}

	function getMonthList(){
		$months =  array('January' => 'January',
						'February' => 'February',
						'March' => 'March',
						'April' => 'April',
						'May' => 'May',
						'June' => 'June',
						'July' => 'July',
						'August' => 'August',
						'September' => 'September',
						'October' => 'October',
						'November' => 'November',
						'December' => 'December'
						);
		return $months;
	}

	function getYearList(){
		$months =  array('2010' => '2010',
						'2011' => '2011',
						'2012' => '2012',
						'2013' => '2013',
						'2014' => '2014',
						'2015' => '2015'
						);
		return $months;
	}




}
?>
