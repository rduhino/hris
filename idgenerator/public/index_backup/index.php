<?php
$employees_file = 'db/employees.txt';
$dir = "images/";
$number = '';
$alias = '';
$name = '';
$title = '';
$address = '';
$contact = '';
$tin = '';
$sss = '';
$emergency_name = '';
$emergency_number = '';
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'delete') {
		$json = file_get_contents($employees_file);
		$array = json_decode($json, true);
		unset($array[$_GET['id']]);
		file_put_contents($employees_file, json_encode($array));
		header("location:index.php");
	} else if ($_GET['action'] == 'edit') {
		$json = file_get_contents($employees_file);
		$array = json_decode($json, true);
		if (isset($_GET['id']) && !empty($_GET['id'])) {
			$array = $array[$_GET['id']];
		}
		$number = strtoupper($array['number']);
		$alias = $array['nickname'];
		$name = $array['name'];
		$title = $array['title'];
		$address = $array['address'];
		$contact = $array['contact'];
		$tin = $array['tin'];
		$sss = $array['sss'];
		$emergency_name = $array['emergency_name'];
		$emergency_number = $array['emergency_number'];
	}

}

if (isset($_POST['submit'])) {
	$pictureFileType = pathinfo($dir . basename($_FILES["picture"]["name"]), PATHINFO_EXTENSION);
	$signatureFileType = pathinfo($dir . basename($_FILES["signature"]["name"]), PATHINFO_EXTENSION);
	$image_base = str_replace('-', '', $_POST['number']);
	$uploadOk = 1;
	$error = '';
	$pictureFileType = strtolower($pictureFileType);
	$signatureFileType = strtolower($signatureFileType);
	// Allow certain file formats
	if (!empty($_FILES["picture"]["tmp_name"]) && $pictureFileType != "jpg" && $pictureFileType != "png" && $pictureFileType != "jpeg") {
		$error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed of Picture ID.<br>";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if (!empty($_FILES["signature"]["tmp_name"]) && $signatureFileType != "jpg" && $signatureFileType != "png" && $signatureFileType != "jpeg") {
		$error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed of Signature.<br>";
		$uploadOk = 0;
	}
	if ($uploadOk == 1) {
		$picture = strtolower($dir . $image_base . '.' . $pictureFileType);
		$signature = strtolower($dir . $image_base . 'signature.' . $signatureFileType);

		if (isset($_FILES["picture"]["tmp_name"])) {
			move_uploaded_file($_FILES["picture"]["tmp_name"], $picture);
		}
		if (isset($_FILES["signature"]["tmp_name"])) {
			move_uploaded_file($_FILES["signature"]["tmp_name"], $signature);
		}
		$number = strtoupper($_POST['number']);
		$nickname = $_POST['nickname'];
		$name = $_POST['fullname'];
		$title = $_POST['title'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];
		$tin = $_POST['tin'];
		$sss = $_POST['sss'];
		$emergency_name = $_POST['emergency_name'];
		$emergency_number = $_POST['emergency_number'];

		$json = file_get_contents($employees_file);
		$array = json_decode($json, true);
		$post_array = [];
		$post_array['number'] = $number;
		$post_array['nickname'] = $nickname;
		$post_array['name'] = $name;
		$post_array['title'] = $title;
		$post_array['address'] = $address;
		$post_array['contact'] = $contact;
		$post_array['tin'] = $tin;
		$post_array['sss'] = $sss;
		$post_array['emergency_name'] = $emergency_name;
		$post_array['emergency_number'] = $emergency_number;
		$array[$number] = $post_array;

		file_put_contents($employees_file, json_encode($array));

		echo "<script>alert('You entry has been successfully saved!');</script>";
	} else {
		$error .= 'Cannot upload image';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Greenwire ID Generator</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <style type="text/css">
    	table.registrationForm {
		    width: 100%;
		    background: #f9f9f9;
		    box-shadow: 10px 10px 5px #9b9b9b;
		}
		h3 {
		    margin-top: 81px;
		}
		input.btn.btn-primary {
		    margin-bottom: 25px;
		}
		th.title {
		    text-align: center;
		    line-height: 5;
		    font-size: x-large;
		}
		.upImage {
		    width: 1024px;
		    margin: 0 auto;
		    line-height: 2;
		}
		input[name=emergency_number] {
		    position: relative;
		    bottom: 30px;
		}
		input.form-control, textarea.form-control {
		    width: 98%;
		        margin-bottom: 5px;
		}
		input.btn.btn-primary {
		    margin-bottom: 25px;
		    position: relative;
		    bottom: 40px;
		    width:115px;
		}
		table.table.table-striped {
		    font-size: 12px;
		}
    </style>
    <body>
		<form method="post" action="index.php" enctype="multipart/form-data">
			<table cellpadding="5" cellspacing="0" border="0" style="margin:0 auto;" class = "registrationForm">
				<tr>
					<th colspan="2" class = "title">Greenwire ID Printing</th>
				</tr>
				<?php
if ($error > '') {
	?>
					<tr>
						<td colspan="2"><?php echo $error; ?></td>
					</tr>
					<?php
}
?>
				<tr>
					<td>
						<table style = "width: 1024px;margin: 0 auto;" cellspacing="0" cellspacing="0">
							<tr>
								<td><input class="form-control" type="text" name="number" value="<?php echo $number; ?>" placeholder="ID Number" /></td>
								<td><input class="form-control" type="text" name="contact" placeholder="Contact Number" value="<?php echo $contact; ?>" /></td>
							</tr>
							<tr>
								<td><input class="form-control" type="text" name="fullname" value="<?php echo $name; ?>" placeholder="Full Name" /></td>
								<td><input class="form-control" type="text" name="tin" placeholder="Enter TIN" value="<?php echo $tin; ?>" /></td>
							</tr>
							<tr>
								<td><input class="form-control" type="text" name="nickname"  value="<?php echo $alias; ?>" placeholder="Nickname" /></td>
								<td><input class="form-control" type="text" name="sss" placeholder="Enter SSS" value="<?php echo $sss; ?>" /></td>
							</tr>
							<tr>
								<td><input class="form-control" type="text" name="title" value="<?php echo $title; ?>" placeholder="Job Title" /></td>
								<td><input class="form-control" type="text" name="emergency_name" placeholder="Emergency Contact Person Name" value="<?php echo $emergency_name; ?>" /></td>
							</tr>
							<tr>
								<td><textarea class="form-control" placeholder="Full Address" name="address" rows="4" cols="20" ><?php echo $address; ?></textarea></td>
								<td><input class="form-control" type="text" name="emergency_number" placeholder="Emergency Contact Number" value="<?php echo $emergency_number; ?>" /></td>
							</tr>
						</table>
						<div class="upImage">
							<div style = "color:gray;">ID Picture: <input type="file" name="picture"></div>
							<div style = "color:gray;">Signature: <input type="file" name="signature"></div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input class="btn btn-primary" type="submit" value="Save" name="submit"></td>
				</tr>

			</table>
			<h3>Employees List &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="id.php" target="_blank" class = "btn btn-default"> <span class = "glyphicon glyphicon-print"></span> Print for ID</a>
				<a href="bank.php" target="_blank" class = "btn btn-default"> <span class = "glyphicon glyphicon-print"></span> Print for bank</a>
			</h3>
			<?php
$json = file_get_contents($employees_file);
$array = json_decode($json, true);
?>
			<table class="table table-striped" cellspacing="0" cellpadding="0" border="1">
				<tr>
					<th>ID</th>
					<th>Nickname</th>
					<th>Name</th>
					<th>Title</th>
					<th>Address</th>
					<th>Contact</th>
					<th>TIN</th>
					<th>SSS</th>
					<th>Emergency Name</th>
					<th>Emergency Number</th>
					<th>&nbsp;</th>
				<?php
foreach ($array as $key => $row) {
	$image_base = str_replace('-', '', $row['number']);
	$picture = strtolower($dir . $image_base . '.jpg');
	$signature = strtolower($dir . $image_base . 'signature.jpg');
	if (!file_exists($picture)) {
		$picture = strtolower($dir . $image_base . '.jpeg');
	}
	if (!file_exists($picture)) {
		$picture = strtolower($dir . $image_base . '.png');
	}
	if (!file_exists($signature)) {
		$signature = strtolower($dir . $image_base . 'signature.jpeg');
	}
	if (!file_exists($signature)) {
		$signature = strtolower($dir . $image_base . 'signature.png');
	}
	?>
				<tr>
					<td><?php echo $row['number']; ?></td>
					<td><?php echo $row['nickname']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['contact']; ?></td>
					<td><?php echo $row['tin']; ?></td>
					<td><?php echo $row['sss']; ?></td>
					<td><?php echo $row['emergency_name']; ?></td>
					<td><?php echo $row['emergency_number']; ?></td>
					<td style = "width:115px;">
						<a href="<?php echo $picture; ?>" target="_blank"> <span class = "glyphicon glyphicon-picture" title = "View Picture" style= "color:gray;"></span></a>
						<a href="<?php echo $signature; ?>" target="_blank"> <span class = "glyphicon glyphicon-qrcode" title = "View Signature" style= "color:gray;"></span></a>
						<a href="bank.php?id=<?php echo $row['number']; ?>" target="_blank"> <span class = "glyphicon glyphicon-print" title = "Print ID"></span> </a>
						|
						<a href="?action=edit&id=<?php echo $row['number']; ?>"> <span class = "glyphicon glyphicon-edit" style= "color:green;" title = "Edit details"></span> </a>
						<a href="javascript:void(0);" onclick="var x = confirm('Are you sure you want to delete this entry?'); if(x) document.location='?action=delete&id=<?php echo $row['number']; ?>';"> <span class = "glyphicon glyphicon-remove" style= "color:red;" title = "Delete Data"></span> </a>

					</td>
				</tr>
				<?php
}
?>
			</table>
		</form>
	<script src="assets/js/jquery-3.1.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>
