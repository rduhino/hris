<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="showViewEmpModal">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content no-brd bd-rd-none pd-20 no-bx-sdw">

		
    <div class="white-bg">
 		<div class="clearfix"></div>
        <button ng-show="onEdit" type="button" class="close pull-right" aria-label="Close" ng-click="CloseEdit()"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
        
		<button ng-show="!onEdit" type="button" class="close pull-right" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
	</div>

	<div class="clearfix"></div>

	<div class="view-emp-con">
        <form role="form" enctype="multipart/form-data" novalidate class="css-form" name="EmployeeForm" id="EditEmployeeForm">
            <i class="fa fa-pencil mg-r-5 gray-bg white pull-right form-info-1 fz-14 update-emp-status-btn" ng-click="ToggleEdit(1)"></i>
            <i class="fa fa-close pull-right form-edit-1 update-emp-status-btn orange-bg" ng-click="CloseEdit(1)"></i>
            <i class="fa fa-check pull-right form-edit-1 update-emp-status-btn green-bg" ng-click="UpdateEmployee(1)"></i>
            
	        <label class="img-uploader-thumb mg-t-20 form-edit-1">
	            <input id="inputImage2"
	                type="file"
	                accept="image/png"
	                image="cs.image"
	                resize-max-height="230"
	                resize-max-width="230"
	                resize-type="image/png"/>
	            <img height="230" width="230" ng-src="images/{{ view.employee.number | ConvertIdToImage : '-' : ''}}.jpg" employee-avatar/>
	        </label>
            
            <label class="img-uploader-thumb mg-t-20 form-info-1">
                <img height="230" width="230" ng-src="images/{{ view.employee.number | ConvertIdToImage : '-' : ''}}.jpg" employee-avatar/>
            </label>
            
	        <div class="clearfix"></div>
	    
            <h3 class="gray-text text-center fw-bld mg-tb-5 form-info-1"> {{view.employee.name}} ({{view.employee.nickname}})</h3>
            <div class="col-md-12 form-edit-1 fw-bld ">
                <div class="col-md-8">
                    <p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Full Name </p>
              		<input class="global-inpt w100" type="text" name="name" placeholder="Full Name" ng-model="view.employee.name" required/>
                </div>
                
                <div class="col-md-4 ">
                    <p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Nick Name </p>
              		<input class="global-inpt w100" type="text" name="nickname" placeholder="Nick Name" ng-model="view.employee.nickname" required/>
                </div>
                
            </div>
            <div class="clearfix"></div>
            
            <p class="gray-text text-center fz-12 no-mg form-info-1"> {{view.employee.title}}</p>
            <div class="col-md-12 form-edit-1 fw-bld form-edit-1">
                <div class="col-md-12">
                    <p for="" class="fz-10 gray-text fw-reg mg-t-10 mg-b-0"> Job Title </p>
              		<select class="global-slct w100 gray-text" type="submit" name="title" placeholder="Job Title" ng-model="view.employee.title" required/>
                        <option value="Human Resource"> Human Resource </option>
                        <option value="Web Developer"> Web Developer </option>
                        <option value="Web Designer"> Web Designer </option>
                        <option value="Customer Service Rep"> Customer Service Rep </option>
                        <option value="Technical Admin"> Technical Admin </option>
                        <option value="Team Leader"> Team Leader </option>
                        <option value="Quality Assurance"> Quality Assurance </option>
                        <option value="Quality Control"> Quality Control </option>
                        <option value="Sales Executive"> Sales Executive </option>
                        <option value="Admin Staff"> Admin Staff </option>
                    </select>
                </div>  
            </div>
            <div class="clearfix"></div>
            
			<div class="row pd-20">
				<h2 class="pull-left gray-text fw-bld fz-14"> <i class="fa fa-reorder mg-r-10"></i>EMPLOYEE INFORMATION</h2>
				<div class="clearfix"></div>

				<div class="separator"></div>
                <div class="col-md-12 no-pd">
                    <a href=""><i class="fa fa-pencil mg-r-5 gray-bg white pull-right form-info-2 fz-14 update-emp-status-btn" ng-click="ToggleEdit(2)"></i></a>
                    <a href=""><i class="fa fa-close pull-right form-edit-2 update-emp-status-btn orange-bg" ng-click="CloseEdit(2)"></i></a>
                    <a href=""><i class="fa fa-check pull-right form-edit-2 update-emp-status-btn green-bg" ng-click="UpdateEmployee(2)"></i></a>
                </div>
			    <div class="col-md-6 mg-t-20 pd-r-5">

		    		<p class="gray-text fz-12 fw-bld no-mg"> COMPLETE ADDRESS:</p>
	  			 	<p class="fw-reg fz-12 gray-text">
                        <span class="form-info-2 ">{{view.employee.address}}</span>
                        <span class="form-edit-2 pd-r-5">
                            <input class="global-inpt w100" type="text" name="address" placeholder="Full Address" ng-model="view.employee.address" required >
                        </span>
                    </p>

	  	    		<p class="gray-text fz-12 fw-bld no-mg"> CONTACT NO.:</p>
	  			 	<p class="fw-reg fz-12 gray-text">
                        <span class="form-info-2 ">{{view.employee.contact}}</span>
                        <span class="form-edit-2 pd-r-5">
                            <input class="global-inpt w100" type="text" name="contact" placeholder="Contact Number" ng-model="view.employee.contact" required/>
                        </span>
                    </p>

	  			 	<p class="gray-text fz-12 fw-bld no-mg"> SSS NO.:</p>
	  			 	<p class="fw-reg fz-12 gray-text">
                        <span class="form-info-2 ">{{view.employee.sss}}</span>
                        <span class="form-edit-2 pd-r-5">
                            <input class="global-inpt w100" type="text" name="sss" placeholder="SSS Number" ng-model="view.employee.sss" required/>
                        </span>
                    </p>

	  			 	<p class="gray-text fz-12 fw-bld no-mg"> TIN NO.:</p>
	  			 	<p class="fw-reg fz-12 gray-text">
                        <span class="form-info-2 ">{{view.employee.tin}}</span>
                        <span class="form-edit-2 pd-r-5">
                            <input class="global-inpt w100" type="text" name="tin" placeholder="BIR TIN Number" ng-model="view.employee.tin" required/>
                        </span>
                    </p>
			    </div>

		    	<div class="col-md-6 mg-t-20 pd-l-5">

	          		<p class="gray-text fz-12 fw-bld no-mg"> Emergency Person's Name:</p>
	  			 	<p class="fw-reg fz-12 gray-text">
                        <span class="form-info-2 ">{{view.employee.emergency_name}}</span>
                        <span class="form-edit-2 ">
                            <input class="global-inpt w100" type="text" name="emergency_name" placeholder="Emergency Person's Name" ng-model="view.employee.emergency_name" required/>
                        </span>
                    </p>

	  	    		<p class="gray-text fz-12 fw-bld no-mg"> Emergency Person's Contact Number:</p>
	  			 	<p class="fw-reg fz-12 gray-text">
                        <span class="form-info-2 ">{{view.employee.emergency_number}}</span>
                        <span class="form-edit-2 ">
                            <input class="global-inpt w100" type="text" name="emergency_number" placeholder="Emergency Person's Contact Number" ng-model="view.employee.emergency_number" required/>
                        </span>
                    </p>

	  			 	<p class="gray-text fz-12 fw-bld no-mg"> Date Hired:</p>
	  			 	<p class="fw-reg fz-12 gray-text"> {{view.employee.datehired}} </p>

	  			 	<p class="gray-text fz-12 fw-bld no-mg"> Date Started:</p>
	  			 	<p class="fw-reg fz-12 gray-text"> {{view.employee.datestarted}} </p>
			    </div>
		    </div>
         </form>
		 	<h2 class="pull-left gray-text fw-bld fz-14"> <i class="fa fa-cubes mg-r-10"></i>EMPLOYEE REQUIREMENTS AND FILES</h2>
			<div class="clearfix"></div>

			<div class="separator"></div>

			<div class="mg-t-20">

				<ul class="emp-reqs-list">
					<li>
						<p>
							<input type="checkbox" id="1" />
				 			<label for="1"></label>	<span class="gray-text fz-12 fw-reg">Medical Records <i class="fa fa-eye mg-l-10"></i></span>
						</p>
					</li>

					<li>
						<p>
							<input type="checkbox" id="2" />
				 			<label for="2"></label>	<span class="gray-text fz-12 fw-reg">PAG-IBIG</span>
						</p>
					</li>

					<li>
						<p>
							<input type="checkbox" id="3" />
				 			<label for="3"></label>	<span class="gray-text fz-12 fw-reg">Social Security System (SSS)</span>
						</p>
					</li>

					<li>
						<p>
							<input type="checkbox" id="4" />
				 			<label for="4"></label>	<span class="gray-text fz-12 fw-reg">BIR (2316)</span>
						</p>
					</li>

					<li>
						<p>
							<input type="checkbox" id="5" />
				 			<label for="5"></label>	<span class="gray-text fz-12 fw-reg">Certificate of Employment</span>
						</p>
					</li>
				</ul>
			</div>

	    </div>

	    <!-- Action Buttons Here -->
        <div class="col-md-12 no-pd">
            <button class="pull-right white mg-t-20 fz-12 bd-rd-none orange-bg no-brd pd-lr-30 pd-tb-10 fw-bld" type="submit" name="submit" data-dismiss="modal" aria-label="Close"> <i class="fa fa-remove mg-r-5"></i>CANCEL</button>
            <button class="pull-right white mg-t-20 fz-12 bd-rd-none green-bg no-brd pd-lr-30 pd-tb-10 fw-bld mg-r-10" data-dismiss="modal" type="submit" name="submit"> <i class="fa fa-check mg-r-5"></i>UPDATE</button>
        </div>
        <div class="clearfix"></div>
	  </div>
  </div>
</div>
