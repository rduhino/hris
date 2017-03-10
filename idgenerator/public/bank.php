<?php
require_once 'fpdf/pdf.php';

$employees_file = 'db/employees.txt';
$dir = "images/";
$toPrint = "";

$json = file_get_contents($employees_file);
$array = json_decode($json, true);
$pdf = new PDF('P', 'mm', array(58, 90));
$tarray = [];
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$tarray[] = $array[$_GET['id']];
	$array = $tarray;

	$toPrint = (isset($_GET['p']) && $_GET['p'] == "front") ? "front" : "back";
}
foreach ($array as $key => $row) {
	$image_base = str_replace('-', '', $row['number']);
	$picture = strtolower($dir . $image_base . '.jpg');
	$signature = strtolower($dir . $image_base . 'signature.png');

	$picture = (!file_exists($picture)) ? strtolower($dir . $image_base . '.jpg') : $picture;
	$signature = (!file_exists($signature)) ? strtolower($dir . $image_base . 'signature.png') : $signature;

	$pdf->AddPage();

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

	$y = 0;
	$x = 0;

	switch ($toPrint) {
	case 'front':
		$pdf->Image('upload/front.jpg', 0, 0, 58, 90);

		append($pdf, array('name' => 'position', 'data' => $title));
		append($pdf, array('name' => 'picture', 'data' => $picture));
		append($pdf, array('name' => 'name', 'data' => $alias));
		append($pdf, array('name' => 'id_barCode', 'data' => $number));
		break;
	case 'back':
		$pdf->Image('upload/back.jpg', 0, 0, 58, 90);

		append($pdf, array('name' => 'details',
			'data' => array('fullName' => $name,
				'address' => $address,
				'contact' => $contact,
				'tin' => $tin,
				'sss' => $sss,
			)));
		append($pdf, array('name' => 'signature', 'data' => $signature));
		append($pdf, array('name' => 'emergency_details', 'data' => array(
			'name' => $emergency_name,
			'number' => $emergency_number,
		)));
		break;
	}
}

function getAutomaticFont($pdf, array $stringDetails, array $fontDetails) {
	$size = $fontDetails['size'];

	if ($stringDetails['stringLength'] > $stringDetails['block']) {
		$sizeAdjustment = $stringDetails['stringLength'] - $stringDetails['block'];
		$sizeAdjustment = (round($stringDetails['stringLength']) == 85) ? $sizeAdjustment * 3 : $sizeAdjustment;
		$size = $size - round($sizeAdjustment);

		$size = convertEvenNumber($size);
	}

	$fontSize = $pdf->SetFont($fontDetails['family'], '', $size);
	$pdf->SetTextColor($fontDetails['color']);

	return $fontSize;
}

function convertEvenNumber($number) {
	return ($number % 2 == 0) ? $number : $number - 1;
}

function getAutomaticPostion($firstLine, $lastLine, $lineAdjuster = 0) {
	$emptyLineDivider = 2;

	if ($lineAdjuster > 0) {
		$firstLine = $firstLine + $lineAdjuster;
	}

	$calculation = $firstLine + ($lastLine - $firstLine) / $emptyLineDivider;
	$position = $calculation;

	return $position;
}

function append($pdf, array $view) {
	$y = 0;
	$x = 0;
	switch ($view['name']) {
	case 'position':
		$size = 18;
		$lastLine = 83;
		$pdf->AddFont('Century-Gothic-Bold', '');
		$pdf->SetFont('Century-Gothic-Bold', '', $size);
		$title = strtoupper($view['data']);
		$title_len = $pdf->GetStringWidth($title);
		getAutomaticFont($pdf,
			array('stringLength' => ($title_len > $lastLine) ? $title_len : getAutomaticPostion($title_len, $lastLine, 20), 'block' => $lastLine),
			array('family' => 'Century-Gothic-Bold', 'size' => $size, 'color' => '255, 255, 255')
		);
		$title_len = $pdf->GetStringWidth($title);
		$verticalPosition = getAutomaticPostion($title_len, $lastLine, 20);

		$pdf->RotatedText($x + 13.7, $verticalPosition, $title, 90);
		break;
	case 'picture':
		$pdf->Image($view['data'], $x + 16, $y + 22, 30, 38);
		break;
	case 'name':
		$size = 14;
		$startLine = 16;
		$lastLine = 30;
		$alias = strtoupper($view['data']);

		$pdf->SetFont('Century-Gothic-Bold', '', $size);
		$alias_len = $pdf->GetStringWidth($alias);
		getAutomaticFont($pdf,
			array('stringLength' => $alias_len, 'block' => $lastLine),
			array('family' => 'Century-Gothic-Bold', 'size' => $size, 'color' => '000, 000, 000')
		);
		$alias_len = $pdf->GetStringWidth($alias);
		if ($alias_len > 17) {
			$excess = $alias_len - 17;
			$startLine = $startLine - $excess;
		}
		$horizontalPosition = getAutomaticPostion($startLine, 30);
		$pdf->Text($horizontalPosition, $y + 67, $alias);
		break;
	case 'id_barCode':
		$pdf->SetFont('Arial', '', 10);
		$pdf->Text($x + 40, $y + 82, $view['data']);
		$pdf->setXY(0, 0);
		$pdf->Code128($x + 16, $y + 83, $view['data'], 42, 7.1);
		break;
	case 'details':
		$name = ucwords($view['data']['fullName']);
		$pdf->SetFont('Arial', '', 6);
		$pdf->Text($x + 18, $y + 14.5, $name);

		$pdf->SetXY($x + 17, $y + 16);
		$address = ucwords($view['data']['address']);
		$pdf->MultiCell(39, 2.5, $address, 0, 'L');

		$pdf->Text($x + 18, $y + 23.5, $view['data']['contact']);
		$pdf->Text($x + 18, $y + 26.5, $view['data']['tin']);
		$pdf->Text($x + 18, $y + 29.5, $view['data']['sss']);
		break;
	case 'signature':
		$pdf->Image($view['data'], $x + 16, $y + 33, 0, 10);
		break;
	case 'emergency_details':
		$emergency_name = ucwords($view['data']['name']);
		$pdf->Text($x + 20, $y + 47, $emergency_name);
		$pdf->Text($x + 20, $y + 51, $view['data']['number']);
		break;
	}
}

$pdf->Output();

?>
