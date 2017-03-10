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
	if (!empty($_FILES["signature"]["tmp_name"]) && $signatureFileType != "png") {
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="upload/verticalops.png">

    <title>HRIS</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/zabuto_calendar.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar nav-hdr">
        <div class="container-fluid">
   <img src="images/vops-white-logo.png" width="150" height="30"/>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar">
            <h2 class="blue fz-20 lh-20 mg-l-20"><b> <i class="fa fa-reorder mg-r-10"></i>MENU</b></h2>
                <ul class="mg-t-20">
                    <li class="active"><a href="#employee_list" ><i class="fa fa-tasks mg-r-5"></i> EMPLOYEE LIST </a></li>
                    <li><a href="#add_new_employee"><i class="fa fa-plus mg-r-5"></i> ADD EMPLOYEE </a></li>
                    <li><a href="#add_new_employee"><i class="fa fa-inbox mg-r-5" aria-hidden="true"></i> PHOTO GALLERY </a></li>
                    <li><a href="#add_new_employee"><i class="fa fa-users mg-r-5" aria-hidden="true"></i> ADMINS </a></li>
                </ul>

                <!-- <div class="pd-15 mg-t-20">
            		<div id="my-calendar"></div>
            	</div> -->
            </div>

            <!-- Add New Employee -->
            <div class="emp-list-con main addNewEmployee">
                <h2 class="blue fz-20 lh-20 no-mg"><b> <i class="fa fa-plus mg-r-10"></i>ADD NEW EMPLOYEE </b></h2>
                <p class="fz-12 gray-text mg-b-20"> Please fill up the form to add new employee.</p>

                <div class="formContainer">
                    <!-- <p class="help-block">Signup here</p>  -->
                    <div class="bs-example" data-example-id="basic-forms">

                    	<form method="post" action="index.php" enctype="multipart/form-data">
                    	<?php
							if ($error > '') {
								?>
										<?php echo $error; ?>
								<?php
							}
						?>

                    	<div class="row">
                    		<div class="col-md-6">
	                    		<label for="" class="fz-10 gray-text"> Full Name </label>
	                    		<input class="global-inpt w100" type="text" name="fullname" value="<?php echo $name; ?>" placeholder="Full Name" />
	                    	</div>
	                    		<div class="clearfix"></div>
	                    	<div class="col-md-3">
	                    		<label for="" class="fz-10 gray-text"> ID Number </label>
	                    		<input class="global-inpt w100" type="text" name="number" value="<?php echo $number; ?>" placeholder="ID Number" />
	                    		<label for="" class="fz-10 gray-text"> Contact Number </label>
	                    		<input class="global-inpt w100" type="text" name="contact" placeholder="Contact Number" value="<?php echo $contact; ?>" />
	                    		<label for="" class="fz-10 gray-text"> BIR TIN Number </label>
	                    		<input class="global-inpt w100" type="text" name="tin" placeholder="Enter TIN" value="<?php echo $tin; ?>" />
	                    		<label for="" class="fz-10 gray-text"> SSS Number</label>
	                    		<input class="global-inpt w100" type="text" name="sss" placeholder="Enter SSS" value="<?php echo $sss; ?>" />
	                    	</div>
	                    	<div class="col-md-3">
	                    		<label for="" class="fz-10 gray-text"> Job Title </label>
	                    		<input class="global-inpt w100" type="text" name="title" value="<?php echo $title; ?>" placeholder="Job Title" />
	                    		<label for="" class="fz-10 gray-text"> Emergency Contact Person's Name </label>
	                    		<input class="global-inpt w100" type="text" name="emergency_name" placeholder="Emergency Contact Person Name" value="<?php echo $emergency_name; ?>" />
	                    		<label for="" class="fz-10 gray-text"> Emergency Contact Person's Number </label>
	                    		<input class="global-inpt w100" type="text" name="emergency_number" placeholder="Emergency Contact Number" value="<?php echo $emergency_number; ?>" />
	                    		<label for="" class="fz-10 gray-text"> Nick Name </label>
	                    		<input class="global-inpt w100" type="text" name="nickname"  value="<?php echo $alias; ?>" placeholder="Nickname" />
	                    	</div>
	                    	<div class="clearfix"></div>
	                    	<div class="col-md-6">
	                    		<label for="" class="fz-10 gray-text"> Complete Address </label>
	                    		<textarea class="global-inpt w100" placeholder="Full Address" name="address" rows="4" cols="20" ><?php echo $address; ?></textarea>
	                    	</div>

	                    	<div class="clearfix"></div>

	                    	<div class="upImage pd-20">
								<div><div class="msg"></div>ID Picture: <input type="file" name="picture"></div>
								<div><div class="msg"></div>Signature: <input type="file" name="signature" id = "signature"></div>
							</div>

	                    	<!-- <input class="btn btn-primary mg-l-20 fz-12" type="submit" value="ADD EMPLOYEE" name="submit"> -->
	                    	<button class="btn btn-primary mg-l-20 fz-12 bd-rd-none blue-bg no-brd pd-lr-30 pd-tb-10" type="submit" name="submit"> <i class="fa fa-plus mg-r-5"></i>ADD EMPLOYEE</button>
                    		
                    	</div>
						</form>
                    </div>
                </div>
            </div>
            <!-- End of employee list -->
   <div class="emp-list-con main employeeList">
            <!-- Employee List -->
            <div class="clearfix"></div>
            

     
        <form class="navbar-form navbar-right w30">
        	<input type="text" class="form-control w100 global-inpt" placeholder="Employee Quick Search..." id  = "filter">
        </form>     
        <h2 class="fz-20 lh-20 no-mg blue"><b> <i class="fa fa-tasks mg-r-10"></i>EMPLOYEE LIST AND INFORMATION</b></h2>
        <p class="fz-12 gray-text mg-b-20"> Here you can view employee information and able to print for IDs.</p>
        
        <div class="table-responsive emp-list-tbl-con">

<?php
$json = file_get_contents($employees_file);
$array = json_decode($json, true);
?>
	                <table class="table emp-list-tbl">
	                	<thead>
	                		<th>ID No.</th>
                            <th>Nickname</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>TIN</th>
                            <th>SSS</th>
                            <th>Emergency Name</th>
                            <th>Emergency Number</th>
                            <th>Actions</th>
	                	</thead>
	                	<tbody>

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
						<td style = "width:120px;">
							
							<div class="actions">
								<a href="<?php echo $picture; ?>" class = "imagepop"> <span class = "glyphicon glyphicon-picture" title = "View Picture"></span></a>
								<a href="<?php echo $signature; ?>" class = "imagepop"> <span class = "glyphicon glyphicon-qrcode" title = "View Signature"></span></a>
									<div class="print-optn" href="bank.php?id=<?php echo $row['number']; ?>" target="_blank">
										<i class="fa fa-print fz-14" aria-hidden="true"></i>
										<div class="print-optn-con">
											<a href="bank.php?p=front&&id=<?php echo $row['number']; ?>" target="_blank"> <i class="fa fa-print" aria-hidden="true"></i> Print Front </a>
											<a href="bank.php?p=back&&id=<?php echo $row['number']; ?>" target="_blank"> <i class="fa fa-print" aria-hidden="true"></i> Print Back </a>
										</div>
									</div>

								<a href="?action=edit&id=<?php echo $row['number']; ?>"> <span class = "glyphicon glyphicon-edit" title = "Edit details"></span> </a>
								<a href="javascript:void(0);" onclick="var x = confirm('Are you sure you want to delete this entry?'); if(x) document.location='?action=delete&id=<?php echo $row['number']; ?>';">
								<span class = "glyphicon glyphicon-trash" title = "Delete Data"></span> </a>
							</div>
						</div>
						</td>
					</tr>
<?php
}
?>
</tbody>
                	</table>
                	<!-- To print popup -->

                	<!-- image  popup -->
                	<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<img src="" class="imagepreview" style="width: 100%;" >
								</div>
							</div>
						</div>
					</div>

                </div>
            </div>
            <!-- End of employee list -->

        </div>
    </div>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script>window.jQuery || document.write('<script src="../../assets/js/jquery.min.js"><\/script>')</script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/zabuto_calendar.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function () {
		    $("#my-calendar").zabuto_calendar({
		        language: "en",
		        today: true,
		      show_previous: false,
		      show_next: 2
		    });
		});
    </script>
    </body>
</html>
