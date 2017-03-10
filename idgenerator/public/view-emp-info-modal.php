<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="showViewEmpModal">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content no-brd bd-rd-none pd-20 no-bx-sdw">


    <div class="white-bg">
     <div class="clearfix"></div>
		<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	</div>
     <form action="upload.php" method="post" enctype="multipart/form-data">
        <label class="img-uploader-thumb mg-t-20">
            <input id="inputImage2"
                type="file"
                accept="image/png"
                image="cs.image"
                resize-max-height="230"
                resize-max-width="230"
                resize-type="image/png"/>

            <img height="230" width="230" ng-src="images/{{ view.employee.number | ConvertIdToImage : '-' : ''}}.jpg" employee-avatar/>

        </label>
        <div class="clearfix"></div>
    </form>

	<h3 class="gray-text text-center fw-bld mg-tb-5"> {{view.employee.name}} ({{view.employee.nickname}})</h3>
	<p class="gray-text text-center fz-12 no-mg"> {{view.employee.title}}</p>

		<div class="row pd-20">
			<h2 class="pull-left gray-text fw-bld fz-14"> <i class="fa fa-reorder mg-r-10"></i>EMPLOYEE INFORMATION</h2>
			<div class="clearfix"></div>

			<div class="separator"></div>
		    <div class="col-md-6 mg-t-20 no-pd">

	    		<p class="gray-text fz-12 fw-bld no-mg"> COMPLETE ADDRESS:</p>
  			 	<p class="fw-reg fz-12 gray-text">{{view.employee.address}}</p>

  	    		<p class="gray-text fz-12 fw-bld no-mg"> CONTACT NO.:</p>
  			 	<p class="fw-reg fz-12 gray-text">{{view.employee.contact}}</p>

  			 	<p class="gray-text fz-12 fw-bld no-mg"> SSS NO.:</p>
  			 	<p class="fw-reg fz-12 gray-text">{{view.employee.sss}}</p>

  			 	<p class="gray-text fz-12 fw-bld no-mg"> TIN NO.:</p>
  			 	<p class="fw-reg fz-12 gray-text">{{view.employee.tin}}</p>
		    </div>
		    <div class="col-md-6 mg-t-20 no-pd">

          <p class="gray-text fz-12 fw-bld no-mg"> Emergency Person's Name:</p>
  			 	<p class="fw-reg fz-12 gray-text">{{view.employee.emergency_name}}</p>

  	    	<p class="gray-text fz-12 fw-bld no-mg"> Emergency Person's Contact Number:</p>
  			 	<p class="fw-reg fz-12 gray-text">{{view.employee.emergency_number}}</p>
		    </div>
	    </div>

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
  </div>
</div>
