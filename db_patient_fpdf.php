<?php
session_start();
require("fpdf/fpdf.php");
require('check-session.php');

class PDF extends FPDF
{
	protected $B = 0;
	protected $I = 0;
	protected $U = 0;
	protected $HREF = '';

	function WriteHTML($html)
	{
		// HTML parser
		$html = str_replace("\n",' ',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(5,$e);
			}
			else
			{
				// Tag
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
						// Extract attributes
						$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}

	function OpenTag($tag, $attr)
	{
		// Opening tag
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
	}

	function CloseTag($tag)
	{
		// Closing tag
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
		// Modify style and select corresponding font
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
		// Put a hyperlink
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
	
	function myreasonCell($w,$h,$x,$t){
		$height=$h/3;
		$first = $height+2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>40){
			$txt = str_split($t,40);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0]);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1]);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,'L',0);
		}
	}
	
	function mydrCell($w,$h,$x,$t){
		$height=$h/3;
		$first = $height+2;
		$second = $height+$height+$height+3;
		$len = strlen($t);
		if($len>35){
			$txt = str_split($t,35);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0]);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1]);
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,'L',0);
		}
	}
	
	//page header
	function Header(){
		$this->SetFont("Arial","",8);
		$this->Cell(0,10,"Health Insider Medical Examination Report",0,0,"C");
		$this->Ln();
	}
	//Page footer
	function Footer(){
		//Position at 1.5cm from bottom
		$this->SetY(-15);
		//Arial 8
		$this->SetFont("Arial","",8);
		//Hospital name
		$this->Cell(0,10,"Health Insider",0,0,"C");
		//Arial italic 8
		$this->SetFont("Arial","I",8);
		//Page number
		$this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,"R");
		
		/*if($this->isFinished){
			$oldypos= $this->getY();
			$this->SetY($oldypos-75);
			$text = '<b>  <u>Terms and Conditions</u></b><br><b>  For New Applicants:</b><br>  1. The Medical Examination may be done in Singapore by any registered General Practitioner (GP).
			 Applicants who are in their <br>      home countries/places of residence may have their Medical Examination and HIV test done in their home countries/places of<br>      residence at any
			medical clinic licensed to carry out such tests. If HIV testing is done in Singapore, it may be carried out with<br>      either rapid or ELISA tests.<br><b>  For Renewal Applicants:</b>
			<br>  1. The Medical Examination MUST be done in Singapore by any registered GP. HIV testing may be done with either rapid or<br>      ELISA tests.<br><b>  Notes for All:</b>
			<br>  1. This Medical Examination Report is to be completed by a registered doctor and returned to the examinee. The original copy of<br>      the laboratory report for HIV and 
			the X-ray report must be attached to this Medical Examination Report only if the medical<br>      examination and testing is carried out overseas.<br>  2. The laboratory report for HIV and 
			the X-ray report submitted to the Immigration & Checkpoints Authority should be within<br>      THREE MONTHS from the date of the issue of the reports.';
			$this->SetFont("Arial","",9);
			$ypos = $this->getY();
			$this->Rect(10,$ypos,187,75);
			$this-> WriteHTML($text);
		}*/
	}
	
}

$pdf = new PDF();
//header
$pdf->AddPage();
//footer page
$pdf->AliasNbPages();

//logo
$pdf->Image("images/logo.png",15,20,30);
//Set font format and font-size
$pdf->SetFont("Arial","",11);
//Hospital name
//$pdf->Ln(20);
$pdf->Cell(0,5,"Health Insider",0,1,"R");
$pdf->Ln(1);
$pdf->Cell(0,5,"Jalan Universiti,",0,1,"R");
$pdf->Ln(1);
$pdf->Cell(0,5,"50603 Kuala Lumpur,",0,1,"R");
$pdf->Ln(1);
$pdf->Cell(0,5,"Wilayah Persekutuan Kuala Lumpur.",0,1,"R");
//date
$pdf-> Ln(1);
$date = date("Y-m-d");
$pdf->Cell(0,4,"Date: ".$date,0,1,"R"); 
//line break
$pdf->Ln();
//set font format and font size
$pdf->SetFont("Arial","B",13);
//Title
$pdf->Cell(176,10,"MEDICAL EXAMINATION REPORT",0,2,"C");
//line break
$pdf->Ln(3);
$pdf->SetLineWidth(1);
$pdf->Line(10,62,200,62);
$pdf->SetLineWidth(0.2);

//Patient Basic Information
$pdf->SetFont("Arial","BU",11);
$pdf->Cell(80,8,"Patient Personal Information",0,1,"L");

//patientID
$pdf->Ln(3);
$patient_id = mysqli_query($conn, "SELECT PATIENT_ID FROM users WHERE USER_ID = '$user_check'") or die("database error:".mysqli_error($conn));
$patient_id = mysqli_fetch_row($patient_id);
$patient_id = $patient_id[0];
$pdf->SetFont("Arial","B",10);
$pdf->Cell(25,5,"ID: ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(50,5,$patient_id,1,1,"L");
$pdf->Ln(3);
//patientName
$namesql = "SELECT PATIENT_NAME FROM patient WHERE PATIENT_ID = '$patient_id'";
$patient_name = mysqli_query($conn, $namesql) or die("database error:".mysqli_error($conn));
$patient_name = mysqli_fetch_row($patient_name);
$patient_name = $patient_name[0];
$pdf->SetFont("Arial","B",10);
$pdf->Cell(25,5,"Name: ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(50,5,$patient_name,1,1,"L");
//PatientNRIC
$icsql = "SELECT NRIC FROM patient WHERE PATIENT_ID = '$patient_id'";
$ic = mysqli_query($conn, $icsql) or die("database error:".mysqli_error($conn));
$ic = mysqli_fetch_row($ic);
$ic = $ic[0];
$pdf->SetXY(100,84);
$pdf->SetFont("Arial","B",0);
$pdf->Cell(25,5,"NRIC: ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(50,5,$ic,1,1,"L");
$pdf->Ln(3);
//patientDOB
$dobsql = "SELECT DOB FROM patient where PATIENT_ID = '$patient_id'";
$dob = mysqli_query($conn, $dobsql) or die("database error:".mysqli_error($conn));
$dob = mysqli_fetch_row($dob);
$dob = $dob[0];
$pdf->SetFont("Arial","B",10);
$pdf->Cell(25,5,"Date of Birth: ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(50,5,$dob,1,1,"L");
//Patient Gender
$gendersql = "SELECT GENDER FROM patient WHERE PATIENT_ID = '$patient_id'";
$gender = mysqli_query($conn, $gendersql) or die("database error:".mysqli_error($conn));
$gender = mysqli_fetch_row($gender);
$gender = $gender[0]=="1"?"Male":"Female";
$pdf->SetXY(100,92);
$pdf->SetFont("Arial","B",10);
$pdf->Cell(25,5,"Gender: ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(50,5,$gender,1,1,"L");
$pdf->Ln(3);
//PatientAddress
$addrsql = "SELECT ADDR FROM patient WHERE PATIENT_ID = '$patient_id'";
$addr = mysqli_query($conn, $addrsql) or die("database error:".mysqli_error($conn));
$addr = mysqli_fetch_row($addr);
$addr = $addr[0];
$pdf->SetFont("Arial","B",10);
$pdf->Cell(25,5,"Address: ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(140,5,$addr,1,1,"L");
$pdf->Ln(3);

//Patient Medical Information
$pdf->Ln();
$pdf->SetFont("Arial","BU",11);
$pdf->Cell(80,5,"Patient Medical Information",0,1,"L");
$pdf->Ln(4);

//Patient height
$heightsql = "SELECT HEIGHT FROM patient WHERE PATIENT_ID = '$patient_id'";
$height = mysqli_query($conn, $heightsql) or die("database error:".mysqli_error($conn));
$height = mysqli_fetch_row($height);
$height = !empty($height[0])?$height[0]:'0';
$pdf->SetFont("Arial","B",10);
$pdf->Cell(60,5,"Height(cm): ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(40,5,$height,1,1,"L");
$pdf->Ln(3);
//Patient weight
$weightsql = "SELECT WEIGHT FROM patient WHERE PATIENT_ID = '$patient_id'";
$weight = mysqli_query($conn, $weightsql) or die("database error:".mysqli_error($conn));
$weight = mysqli_fetch_row($weight);
$weight = !empty($weight[0])?$weight[0]:'0';
$pdf->SetFont("Arial","B",10);
$pdf->Cell(60,5,"Weight(kg): ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(40,5,$weight,1,1,"L");
$pdf->Ln(3);
//Patient BMI
if(!empty($height)||!empty($weight)){
	$heightinm = $height/100;
	$height2 = $heightinm*$heightinm;
	$bmi =  $weight/$height2;
}else{
	$bmi = 0;
}

$pdf->SetFont("Arial","B",10);
$pdf->Cell(60,5,"BMI: ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(40,5,round($bmi,1),1,1,"L");
$pdf->Ln(3);
//Patient LDC
$ldcsql = "SELECT LDC FROM patient WHERE PATIENT_ID = '$patient_id'";
$ldc = mysqli_query($conn, $ldcsql) or die("database error:".mysqli_error($conn));
$ldc = mysqli_fetch_row($ldc);
$ldc = !empty($ldc[0])?$ldc[0]:'0';
$pdf->SetFont("Arial","B",10);
$pdf->Cell(60,5,"LDL Colesterol level(mg/dL): ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(40,5,$ldc,1,1,"L");
$pdf->Ln(3);
//Patient Systolic level
$syssql = "SELECT SYSTOLIC FROM patient WHERE PATIENT_ID = '$patient_id'";
$sys = mysqli_query($conn, $syssql) or die("database error:".mysqli_error($conn));
$sys = mysqli_fetch_row($sys);
$sys = $sys[0];
$diasql = "SELECT DIASTOLIC FROM patient WHERE PATIENT_ID = '$patient_id'";
$dia = mysqli_query($conn, $diasql) or die("database error:".mysqli_error($conn));
$dia = mysqli_fetch_row($dia);
$dia= $dia[0];
$blood = !empty($sys&&$dia)?$sys."/".$dia:'0';
$pdf->SetFont("Arial","B",10);
$pdf->Cell(60,5,"Blood pressure(mmHg): ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(40,5,$blood,1,1,"L");
$pdf->Ln(3);
//Patient heart rate
$heartsql = "SELECT HEART_RATE FROM patient WHERE PATIENT_ID = '$patient_id'";
$heart = mysqli_query($conn, $heartsql) or die("database error:".mysqli_error($conn));
$heart = mysqli_fetch_row($heart);
$heart = !empty($heart[0]) ? $heart[0] : '0' ;
$pdf->SetFont("Arial","B",10);
$pdf->Cell(60,5,"Heart rate per minute (beats): ",0,0,"L");
$pdf->SetFont("Arial","",10);
$pdf->Cell(40,5,$heart,1,1,"L");
$pdf->Ln();
//bmichart
$Yposition=$pdf->GetY();
$pdf->Rect(10,$Yposition,43,40);
$bmichart = '<b>BMI Categories:</b>
			 <br>Underweight: less than 18.5
			 <br>Normal weight: 18.5-24.9
			 <br>Overweight: 25-29.9
			 <br>Obesity: more than 30';
$pdf->SetFont('Arial','',9);
$pdf->WriteHTML($bmichart);
//LDLchart
$pdf->Rect(53,$Yposition,48,40);
$pdf->setXY(53,$Yposition);
$LDLchart = '<b>LDL Cholesterol level:</b>
			<br>                                                 Normal: less than 100mg/dL
			<br>                                                 Acceptable: 100-129mg/dL
			<br>                                                 Borderline high: 130-159mg/dL
			<br>                                                 High: 160-189mg/dL
			<br>                                                 Very high: more than 190mg/dL';
$pdf->WriteHTML($LDLchart);
//Blood pressure chart
$pdf->Rect(101,$Yposition,48,40);
$pdf->SetXY(102,$Yposition);
$pdf->WriteHTML('<b>Blood Pressure level:</b>');
$pdf->SetXY(102,$Yposition+5);
$pdf->WriteHTML('Low: less than 90/60mmHg');
$pdf->SetXY(102,$Yposition+10);
$pdf->WriteHTML('Ideal: 90/60-120/80mmHg');
$pdf->SetXY(102,$Yposition+15);
$pdf->WriteHTML('Pre-high: 120/80-140/90mmHg');
$pdf->SetXY(102,$Yposition+20);
$pdf->WriteHTML('High: more than 140/90mmHg');
//Heart rate chart
$pdf->Rect(149,$Yposition,48,40);
$pdf->SetXY(150,$Yposition);
$pdf->WriteHTML('<b>Normal Heart Rate:</b>');
$pdf->SetXY(150,$Yposition+5);
$pdf->WriteHTML('Neonate(<28 days): 100-205');
$pdf->SetXY(150,$Yposition+10);
$pdf->WriteHTML('1 month-1 year: 100-190');
$pdf->SetXY(150,$Yposition+15);
$pdf->WriteHTML('1-2 years: 98-140');
$pdf->SetXY(150,$Yposition+20);
$pdf->WriteHTML('3-5 years: 80-120');
$pdf->SetXY(150,$Yposition+25);
$pdf->WriteHTML('6-11 years: 75-118');
$pdf->SetXY(150,$Yposition+30);
$pdf->WriteHTML('12 years-adult: 60-100');
$pdf->SetXY(150,$Yposition+35);
$pdf->WriteHTML('Athlete: 40-60');

//Patient Medical History
$pdf->Ln(13);
$pdf->SetFont("Arial","BU",11);
$pdf->Cell(80,10,"Patient Medical History",0,1,"L");
//table column
$pdf->SetFont('Arial','B',11);
$pdf->Cell(10,8,'ID',1,0);
$pdf->Cell(23,8,'Date',1,0);
$pdf->Cell(20,8,'Time',1,0);
$pdf->Cell(70,8,'Reason',1,0);
$pdf->Cell(65,8,'Doctor In Charge',1,0);

//Appointment table
$pdf->Ln();
$appidsql = "SELECT * FROM patient_history WHERE PATIENT_ID = '$patient_id'";
$appid = mysqli_query($conn, $appidsql) or die("database error:".mysqli_error($conn));
$pdf->SetFont("Arial","",10);
$i=0;
while($data=mysqli_fetch_array($appid)){
	$drid = $data['DOCTOR_ID'];
	$drnamesql = "SELECT DOCTOR_NAME FROM doctor WHERE DOCTOR_ID = '$drid'";
	$drname = mysqli_query($conn, $drnamesql) or die("database error:".mysqli_error($conn));
	$drname = mysqli_fetch_row($drname);
	$drname = $drname[0];
	$h=5;
	if(strlen($data['PATIENT_HISTORY'])>40 and strlen($data['PATIENT_HISTORY'])<=80 or strlen($drname)>15){
		$h = 10;
	}
	elseif(strlen($data['PATIENT_HISTORY'])>80){
		$h = 15;
	}
	$pdf->Cell(10,$h,$i,1,0);
	$i++;
	$pdf->Cell(23,$h,$data['DATE'],1,0);
	$pdf->Cell(20,$h,$data['TIME'],1,0);
	$x = $pdf->GetX();
	$pdf->myreasonCell(70,$h,$x,$data['PATIENT_HISTORY']);
	$x = $pdf->GetX();
	$pdf->mydrCell(65,$h,$x,$drname);
	$pdf->Ln();
}
//$pdf->isFinished = true;

$position = $pdf->GetY();
$height = $pdf->GetPageHeight();
if($height-$position<90){
	$pdf->AddPage();
}
else{
	$pdf->Ln(10);
}
$text = '<b>  <u>Terms and Conditions</u></b><br><b>  For New Applicants:</b><br>  1. The Medical Examination may be done in Singapore by any registered General Practitioner (GP).
			 Applicants who are in their <br>      home countries/places of residence may have their Medical Examination and HIV test done in their home countries/places of<br>      residence at any
			medical clinic licensed to carry out such tests. If HIV testing is done in Singapore, it may be carried out with<br>      either rapid or ELISA tests.<br><b>  For Renewal Applicants:</b>
			<br>  1. The Medical Examination MUST be done in Singapore by any registered GP. HIV testing may be done with either rapid or<br>      ELISA tests.<br><b>  Notes for All:</b>
			<br>  1. This Medical Examination Report is to be completed by a registered doctor and returned to the examinee. The original copy of<br>      the laboratory report for HIV and 
			the X-ray report must be attached to this Medical Examination Report only if the medical<br>      examination and testing is carried out overseas.<br>  2. The laboratory report for HIV and 
			the X-ray report submitted to the Immigration & Checkpoints Authority should be within<br>      THREE MONTHS from the date of the issue of the reports.';
$pdf->SetFont("Arial","",9);
$ypos = $pdf->getY();
$pdf->Rect(10,$ypos,187,75);
$pdf-> WriteHTML($text);
$pdf->Ln();
$pdf->WriteHTML('This information is computer generated. No signature required.'); 

$pdf->Output();
?>