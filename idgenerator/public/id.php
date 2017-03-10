<?php


require('fpdf/pdf.php');

$employees_file = 'db/employees.txt';
$dir = "images/";

$json = file_get_contents($employees_file);
$array = json_decode($json, true);
$pdf = new PDF('P', 'mm', 'Legal');

$y = 10;
$pdf->AddPage();

foreach($array as $key => $row)
{
	$image_base = str_replace('-','',$row['number']);
	$picture = strtolower($dir.$image_base.'.jpg');
	$signature = strtolower($dir.$image_base.'signature.png');
	if(!file_exists($picture))
	{
		$picture = strtolower($dir.$image_base.'.jpg');
	}
	if(!file_exists($picture))
	{
		$picture = strtolower($dir.$image_base.'.png');
	}
	if(!file_exists($signature))
	{
		$signature = strtolower($dir.$image_base.'signature.jpg');
	}
	if(!file_exists($signature))
	{
		$signature = strtolower($dir.$image_base.'signature.png');
	}
	//----------Display PDF
	if($y > 300)
	{
		$pdf->AddPage();
		$y = 10;
	}


	$number = strtoupper($row['number']);
	$alias = $row['nickname'];
	$name = $row['name'];
	$title = $row['title'];
	$address = $row['address'];
	$contact = $row['contact'];
	$tin = $row['tin'];
	$sss = $row['sss'];
	$emergency_name = $row['emergency_name'];
	$emergency_number = $row['emergency_number'];



	$pdf->Image('images/FrontEmpty.jpg', 40, $y, 58, 90);
	$pdf->Image('images/BackEmpty.jpg', 123, $y, 58, 90);

	$x = 40;
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
	$pdf->RotatedText($x+14, $y+82,$title,90);
	//id picture
	if($picture)
	{
		$pdf->Image($picture, $x+16, $y+24, 37, 40);

	}
	//id alias
	$alias = strtoupper($alias);
	$pdf->SetFont('Arial','B',15);
	$pdf->SetTextColor(221,252,126);
	$alias_len = $pdf->GetStringWidth($alias);
	$xpos = 16 + ((30-$alias_len) / 2);
	if($xpos < 17) $xpos = 17;
	$pdf->Text($x+$xpos, $y+72, $alias);
	//id number
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Text($x+38, $y+82, $number);
	$pdf->setXY(0,0);
	$pdf->Code128($x+15, $y+83, $number, 42, 7.1);


	//background
	$x = 123;

	//personal details
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('Arial','B',7);
	$pdf->Text($x+3, $y+14.5, 'Full Name:');
	$pdf->Text($x+3, $y+18, 'Address:');
	$pdf->Text($x+3, $y+25, 'Contact no:');
	$pdf->Text($x+3, $y+28.5, 'TIN:');
	$pdf->Text($x+3, $y+32, 'SSS:');
	//values
	$name = ucwords($name);
	$address = ucwords($address);
	$pdf->SetFont('Arial','',7);
	$pdf->Text($x+18, $y+14.5, $name);
	$pdf->SetXY($x+17, $y+16);
	$pdf->MultiCell(39, 3, $address, 0, 'L');
	$pdf->SetXY($x+0, $y+0);
	$pdf->Text($x+18, $y+25, $contact);
	$pdf->Text($x+18, $y+28.5, $tin);
	$pdf->Text($x+18, $y+32, $sss);
	//signature
	if($signature)
	{
		$pdf->Image($signature, $x+10, $y+34, 30, 7);

	}
	//emergency details
	$emergency_name = ucwords($emergency_name);
	$pdf->Text($x+10, $y+47, $emergency_name);
	$pdf->Text($x+10, $y+51, $emergency_number);

	$y += 100;

}

$pdf->Output();

?>
