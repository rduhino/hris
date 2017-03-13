<?php



require('fpdf/pdf.php');

$dir = "images/";



	//----------Display PDF

	$pdf=new PDF('P', 'Letter');


	$number = strtoupper($_POST['number']);
	$alias = $_POST['nickname'];
	$name = $_POST['fullname'];
	$title = $_POST['title'];
	$address = $_POST['address'];
	$contact = $_POST['contact'];
	$tin = $_POST['tin'];
	$sss = $_POST['sss'];
	$emergency_name = $_POST['emergency_name'];
	$emergency_number = $_POST['emergency_number'];



	//FRONT
	$pdf->AddPage();
	//background
	$pdf->Image('images/FrontEmpty.jpg', 0, 0, 58, 90);
	//title
	$pdf->SetFont('Arial','B',15);
	$title = strtoupper($title);
	/*
	$tlength = $pdf->GetStringWidth($title);
	$pdf->Text(10,10, $tlength);
	if($tlength > 60)
	{
		$pdf->SetFont('Arial','B',15);
	}
	*/
	$pdf->SetTextColor(255,255,255);
	$pdf->RotatedText(14,82,$title,90);
	//id picture
	if($picture)
	{
		$pdf->Image($picture, 16, 24, 30, 42);

	}
	//id alias
	$alias = strtoupper($alias);
	$pdf->SetFont('Arial','B',15);
	$pdf->SetTextColor(221,252,126);
	$alias_len = $pdf->GetStringWidth($alias);
	$xpos = 16 + ((30-$alias_len) / 2);
	if($xpos < 17) $xpos = 17;
	$pdf->Text($xpos, 72, $alias);
	//id number
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Text(38, 82, $number);
	$pdf->setXY(0,0);
	$pdf->Code128(15, 83, $number, 42, 10);


	//BACK
	$pdf->AddPage();

	//background
	$pdf->Image('images/BackEmpty.jpg', 0, 0, 58, 90);

	//personal details
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','B',7);
	$pdf->Text(3, 14.5, 'Full Name:');
	$pdf->Text(3, 18, 'Address:');
	$pdf->Text(3, 25, 'Contact no:');
	$pdf->Text(3, 28.5, 'TIN:');
	$pdf->Text(3, 32, 'SSS:');
	//values
	$name = ucwords($name);
	$address = ucwords($address);
	$pdf->SetFont('Arial','',7);
	$pdf->Text(18, 14.5, $name);
	$pdf->SetXY(17, 16);
	$pdf->MultiCell(39, 3, $address, 0, 'L');
	$pdf->SetXY(0, 0);
	$pdf->Text(18, 25, $contact);
	$pdf->Text(18, 28.5, $tin);
	$pdf->Text(18, 32, $sss);
	//signature
	if($signature)
	{
		$pdf->Image($signature, 10, 34, 30, 7);

	}
	//emergency details
	$emergency_name = ucwords($emergency_name);
	$pdf->Text(10, 47, $emergency_name);
	$pdf->Text(10, 51, $emergency_number);

	$pdf->Output();

}




?>
