<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.png">

    <title> Verticalops HRIS </title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="assets/css/fontawesome.css" rel="stylesheet">
    <link href="assets/css/helpers.css" rel="stylesheet">
    <link href="assets/css/notif.css" rel="stylesheet">
    <link href="assets/css/angular-animate.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">

</head>

<body ng-app = "hris" ng-controller="EmpController">
<notification alert-data="notifConfig"></notification>
<div class="nav-hdr">
	<div class="col-md-6">
		<img src="assets/images/vops-white-logo.png" alt="" style="width: 168px; height: 30px;">
	</div>

	<div class="col-md-6">

		<a href=""><button class="orange-bg white pd-tb-5 pd-lr-20 fz-12 no-brd pull-right fw-reg bd-rd-50"> LOGOUT </button></a>

		<div class="pull-right mg-r-20">
			<div class="user-img-con pull-right">
				<img src="assets/images/anne.jpg" alt="">
			</div>
			<p class="pull-right white fw-light fz-12 mg-r-10 lh-25 mg-tb-0"> Howdy, Admin! </p>
		</div>
	</div>
</div>

<div class="nav-sidebar">

	<ul class="sidebar-mnu">
		<p class="gray-text fz-10 fw-bld mg-l-20 mg-t-20"> MAIN MENU </p>
		<a href="" class="current"><i class="fa fa-tasks gray-text mg-r-10 fz-15"></i>Employee List</a>
		<a href="#" data-toggle="modal" data-target="#showAddEmpModal" ng-click="ToAddUser()"><i class="fa fa-plus-circle gray-text mg-r-10 fz-15"></i>Add Employee</a>
		<a href=""><i class="fa fa-inbox gray-text mg-r-10 fz-15"></i>Photo Gallery</a>
		<a href=""><i class="fa fa-fire gray-text mg-r-10 fz-15"></i>Fire Employee</a>
	</ul>

	<p class="gray-text fz-10 fw-bld mg-l-20 mg-t-30"> SORT EMPLOYEES</p>

	<p><button class="no-brd green-bg pd-tb-5 pd-lr-20 white mg-l-20 mg-t-10 fw-reg fz-10" ng-click="sort = 'name'"> SORT BY NAME </button></p>
	<p><button class="no-brd orange-bg pd-tb-5 pd-lr-20 white mg-l-20 mg-t-5 fw-reg fz-10" ng-click="sort = 'title'"> SORT BY JOB TITLE </button></p>
	<p><button class="no-brd purple-bg pd-tb-5 pd-lr-20 white mg-l-20 mg-t-5 fw-reg fz-10" ng-click="sort = 'number'"> SORT BY ID NUMBER </button></p>

</div>

<div class="main-body-con">
	<div class="container-fluid no-pd">
		<div class="emp-list-con">
  		<div class="mg-t-20 col-md-6 pull-left">
  			<h2 class="gray-text fz-20 fw-bld no-mg"> <i class="fa fa-tasks mg-r-10 torquoise"></i>EMPLOYEE LIST AND INFORMATION</h2>
  			<p class="gray-text fz-12 no-mg">  Here you can view and edit employee information.</p>
  		</div>

  		<div class="mg-t-20 col-md-6 pull-right">
  			<input type="text" class="emp-search" placeholder="Quick Employee Search..." ng-model="searchExp" ng-change="SearchEmployee()">
  		</div>
  		<div class="clearfix"></div>
  		<div class="separator mg-tb-20"></div>
      <!-- User Box -->
			<div class="emp-list-box" ng-repeat="employee in employees">
				<div class="emp-img-con">
					<img ng-src="images/{{ employee.number | ConvertIdToImage : '-' : ''}}.jpg?decache={{decache}}" alt="" employee-avatar>
					<div class="id-nmbr"> {{employee.number}} </div>
<!--                    <div ng-if="!employee.status" class="emp-status green-bg fz-12 fw-reg" > Active </div>-->
					<div class="emp-status fz-12 fw-reg" ng-class="(employee.status) ? {0: 'green-bg', 1 : 'yellow-bg' , 2 : 'orange-bg' , 3  : 'red-bg'}[employee.status] : 'green-bg'"  > {{employee.status ? empStatus[employee.status] : 'Active'}} </div>
				</div>

				<div class="emp-info-con">
					<p class="gray-text fw-bld fz-15 no-mg">{{employee.name}} </p>
					<p class="gray-text fz-10 no-mg"> {{employee.title}}</p>

					<div class="separator"></div>

					<p class="gray-text fz-12 fw-reg no-mg"> TIN No.: {{employee.tin}} </p>
					<p class="gray-text fz-12 fw-reg no-mg"> SSS No.: {{employee.sss}} </p>

					<div class="separator"></div>
					<div class="actions-con mg-b-10">
						<a href="#" ng-click="SetPdf(employee.number, 'front')" ><button class="pd-tb-10 pd-lr-5 fz-10 fw-reg act-btn blue-bg no-brd white"> <i class="fa fa-print mg-r-5"></i>PRINT FRONT </button></a>
						<a href="#" ng-click="SetPdf(employee.number, 'back')" ><button class="pd-tb-10 pd-lr-5 fz-10 fw-reg act-btn torquoise-bg no-brd white"> <i class="fa fa-print mg-r-5"></i>PRINT BACK </button></a>
					</div>

					<div class="actions-con mg-b-10">
						<button class="fw-reg text-center act-btn card-btn gray-text white" data-toggle="modal" data-target="#showViewEmpModal" ng-click="ViewEmployee(employee.number)"> <i class="fa fa-eye mg-r-5"></i> VIEW </button>

						<button class="fw-reg text-center act-btn card-btn gray-text white" ng-click='UpdateEmpStatus(employee.number)'> <i class="fa fa-fire mg-r-5"></i> STATUS </button>
					</div>
				</div>
			</div>
      <iframe ng-src="{{pdfid}}" id="objAdobePrint" name="objAdobePrint" height="95%" width="100%" frameborder=0 style="display: none;"></iframe>
      <!-- <object type="application/pdf" data="bank.php?p=front&&id={{pdfid}}" width="100%" height="500" style="height: 85vh;display: none;" id="pdfDocument">No Support</object> -->



      <?php include 'partials/view-emp-info-modal.php'; ?>
      <?php include 'partials/add-emp-modal.php'; ?>
      <?php include 'partials/update-status-modal.php'; ?>
      <?php include 'partials/cancel-edit-modal.php'; ?>

		</div>
	</div>
</div>

    <script src="assets/js/vendors-min.js"></script>
    <script src="assets/js/angular.min.js"></script>
    <script src="assets/js/angular-route.min.js"></script>
    <script src="assets/js/angular-animate.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
    	$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
    </script>
    </body>
</html>
