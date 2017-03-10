<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="showAddEmpModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content no-brd bd-rd-none pd-20 no-bx-sdw">

      <div class="white-bg">
    	  <h2 class="pull-left gray-text fw-bld fz-14 no-mg"> <i class="fa fa-plus-circle mg-r-10"></i>ADD EMPLOYEE</h2>
		    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
	    </div>

      <form role="form" enctype="multipart/form-data" novalidate class="css-form" name="EmployeeForm">
            <label class="img-uploader-thumb mg-t-20">
                <input id="avatar"
                    type="file"
                    accept="image/png"
                    image="cs.image"
                    resize-max-height="230"
                    resize-max-width="230"
                    resize-type="image/png" fileupload/>

                <img ng-src="{{add.employee.avatar ?  add.employee.avatar : 'assets/images/image-uploader.png'}}"/>

            </label>
            <div class="clearfix"></div>


        <h2 class="pull-left gray-text fw-bld fz-14"> <i class="fa fa-book mg-r-10"></i>EMPLOYEE INFORMATION</h2>
    	  <div class="clearfix"></div>

      	<div class="row">
      		<div class="col-md-12">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Full Name </p>
          		<input class="global-inpt w100" type="text" name="name" placeholder="Full Name" ng-model="add.employee.name" required/>
          	</div>

          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Job Title </p>
          		<input class="global-inpt w100" type="text" name="title" placeholder="Job Title" ng-model="add.employee.title" required/>
          	</div>

          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Nick Name </p>
          		<input class="global-inpt w100" type="text" name="nickname" placeholder="Nick Name" ng-model="add.employee.nickname" required/>
          	</div>

          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> ID Number </p>
          		<input class="global-inpt w100" type="text" name="number" placeholder="ID Number" ng-model="add.employee.number" required/>
          	</div>

          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Contact Number </p>
          		<input class="global-inpt w100" type="text" name="contact" placeholder="Contact Number" ng-model="add.employee.contact" required/>
          	</div>

          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> SSS Number </p>
          		<input class="global-inpt w100" type="text" name="sss" placeholder="SSS Number" ng-model="add.employee.sss" required/>
          	</div>

          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> BIR TIN Name </p>
          		<input class="global-inpt w100" type="text" name="tin" placeholder="BIR TIN Name" ng-model="add.employee.tin" required/>
          	</div>

          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Emergency Person's Contact Number </p>
          		<input class="global-inpt w100" type="text" name="emergency_name" placeholder="Emergency Person's Contact Number" ng-model="add.employee.emergency_name" required/>
          	</div>
          	<div class="col-md-6">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Emergency Person's Name </p>
          		<input class="global-inpt w100" type="text" name="emergency_number" placeholder="Emergency Person's Name" ng-model="add.employee.emergency_number" required/>
          	</div>

          	<div class="clearfix"></div>
          	<div class="col-md-12">
          		<p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Complete Address </p>
          		<textarea class="global-inpt w100" placeholder="Full Address" name="address" rows="4" cols="20" ng-model="add.employee.address" required></textarea>
          	</div>

          	<div class="clearfix"></div>
            <div class="col-md-12">
              <p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Signature </p>
              <label class="img-uploader-thumb mg-t-20">
                  <input id="signature"
                      type="file"
                      accept="image/png"
                      image="cs.image"
                      resize-max-height="230"
                      resize-max-width="100"
                      resize-type="image/png" fileupload/>

                  <img width = '230' height= '100' ng-src="{{add.employee.signature ?  add.employee.signature : 'assets/images/image-uploader.png'}}"/>

              </label>
            </div>
            <div class="clearfix"></div>


          	<div class="col-md-12">
          		<button class="pull-right white mg-t-20 fz-12 bd-rd-none green-bg no-brd pd-lr-30 pd-tb-10 fw-bld" type="submit" name="submit" ng-click="AddUser()"> <i class="fa fa-plus-circle mg-r-5"></i>ADD EMPLOYEE</button>
          	</div>
        	<!-- <input class="btn btn-primary mg-l-20 fz-12" type="submit" value="ADD EMPLOYEE" name="submit"> -->
    	   </div>
       </form>
    </div>
  </div>
</div>
