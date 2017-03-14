<div class="modal fade bs-example-modal-lg" tabindex="1" role="dialog" aria-labelledby="myLargeModalLabel" id="updateEmployeeStatus" aria-hidden="true">
  <div class="modal-dialog modal-md ">
      <div class="modal-body white-bg no-brd no-mg no-bx-sdw gray-text pd-t-20">
          <i class="fa fa-book fz-18 mg-r-10 mg-l-10" aria-hidden="true"></i>Select employee status.
          <div class="mg-t-20 col-md-12">
              <select class="global-inpt w100" id="EmpStats" ng-options="index as stats for (index, stats) in empStatus track by index" ng-model="update.employee.status"></select>
          </div>
      </div>
      <div class="modal-footer white-bg no-brd no-mg no-bx-sdw pd-15">
          <div class="col-md-12 mg-t-20">
            <button type="button" class="green-bg pd-tb-10 pd-lr-30 text-center white no-brd" id="update"><i class="fa fa-check mg-r-5"></i>Update</button>
            <button type="button" class="orange-bg pd-tb-10 pd-lr-30 text-center white no-brd" id="noupdate"><i class="fa fa-remove mg-r-5"></i>Cancel</button>
          </div>  
      </div>
  </div>
</div>
