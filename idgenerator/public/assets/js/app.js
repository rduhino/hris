(function () {

    'use strict';

    /************* SERVICE *************/
    var Service = function ($http) {

      var serviceBase = 'api/api.php',
          obj = {};

      obj.getEmployee = function () {
          return $http.get (serviceBase + "?action=employees");
      }

      obj.addEmployee = function (employee) {
          return $http.post (serviceBase + "?action=addEmployee", employee).then(function(results) {
              return results;
          });
      };

      obj.updateEmployeeStatus = function(employee) {
        return $http.post (serviceBase + "?action=updateEmployeeStatus", employee).then(function(results) {
            return results;
        });
      }

      obj.updateEmployee = function(employee) {
        return $http.post (serviceBase + "?action=updateEmployee", employee).then(function(results) {
            return results;
        });
      }

      return obj;
  }




  /************* DIRECTIVES *************/

  // /user-avatar
  var employeeAvatar = function(){
      return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                var placeholder = './assets/images/default-logo.png';

                scope.$watch(function() {
                    return attrs.ngSrc;
                }, function (value) {
                    if (!value) {
                        element.attr('src', placeholder);
                    }
                });

                element.bind('error', function() {
                    element.attr('src', placeholder);
                });
            }
        };
  }

  var fileupload = function (){
        return {
            restrict: 'A',
            link: function (scope, element, attrs, ngModel) {
                element.bind("change", function(evt){
                  var filesToUpload = evt.target.files,
                      file = filesToUpload[0],
                      img = document.createElement("img"),
                      reader = new FileReader();

                  reader.onload = function(e){
                    img.src = e.target.result;

                    var canvas = document.createElement("canvas"),
                        ctx = canvas.getContext("2d");

                    ctx.drawImage(img, 0, 0);

                    var MAX_WIDTH = 230,
                        MAX_HEIGHT = 230,
                        width = img.width,
                        height = img.height;

                    // if (width > height) {
                    //   if (width > MAX_WIDTH) {
                    //     height *= MAX_WIDTH / width;
                    //     width = MAX_WIDTH;
                    //   }
                    // } else {
                    //   if (height > MAX_HEIGHT) {
                    //     width *= MAX_HEIGHT / height;
                    //     height = MAX_HEIGHT;
                    //   }
                    // }

                    canvas.width = MAX_WIDTH; //width
                    canvas.height = MAX_HEIGHT; //height
                    ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, MAX_HEIGHT, MAX_WIDTH);

                    var dataurl = null;
                    if(attrs.id == 'avatar'){
                      dataurl = canvas.toDataURL("image/jpeg");
                      scope.add.employee.avatar = dataurl;
                    }
                    else{
                      dataurl = canvas.toDataURL("image/png");
                      scope.add.employee.signature = dataurl;
                    }


                    scope.$apply();

                  }
                  if(file)
                    reader.readAsDataURL(file);
                });
                //element.trigger('click');
            }
        };

  }

  var dirNotification =  function ($timeout) {
      return {
          restrict: 'E',
          template:"<div class='notification-box-{{alertData.type}}' ng-class='{ \"show-notification\" : alertData.show == 1 }'   ng-if='alertData.show'>" +
                   '<p class="no-mg-pd"> <i class="fa fa-check green fz-18 mg-r-5" ng-class="{ \'fa-check green\' : alertData.type == \'success\' , \'fa-times orange\' : alertData.type == \'error\' }"> </i>{{alertData.head}}</p> ' +
                   '<p class="gray-text no-mg-pd fz-12">{{alertData.message}}</p> ' +
                   "</div>",
          scope:{
            alertData:"="
          },
          link: function(scope, element, attrs) {
              scope.$watch('alertData.show', function(newVal, oldVal) {
                 if (newVal) {
                      $timeout(function (){
                          scope.alertData.show = false;
                      }, 5000);
                 }
              }, true);
          },
      };
  }




  /************* FILTERS *************/
  var ConvertIdToImage = function(){
    return function (input, from, to) {
      input = input || '';
      from = from || '';
      to = to || '';
      input = input.replace(new RegExp(from, 'g'), to);
      return input.toLowerCase();
    };
  }



  /************* CONTROLLER *************/
  var EmpController = function($scope, $sce, $timeout, Services){
      var uc = this;
      var backUpEmployee = {};

      $scope.employees = {};
      $scope.origemployees = {};

      $scope.sort = 'name';

      $scope.view = {};
      $scope.add = {};
      $scope.update = {};

      $scope.searchExp = "";
      $scope.pdfid = '';
      $scope.onEdit = false;
      $scope.noView = false;

      $scope.empStatus = ["Active","Resigned","Terminated"];

      $scope.notifConfig = {show: false, message: null, head: "Success", type: 'success',
                            set : function(options){
                                  if(typeof options == "undefined"){
                                    this.show = false;
                                    this.message = null;
                                    this.head = "Success";
                                    this.type = 'success';
                                  }else{
                                    this.show = typeof options.show == "undefined" ? false : options.show;
                                    this.message = typeof options.message == "undefined" ? false : options.message;
                                    this.type = typeof options.type == "undefined" ? "success" : options.type;
                                    this.head = typeof options.type == "undefined" ? "Success" : options.type.charAt(0).toUpperCase() + options.type.slice(1);
                                    this.head = typeof options.head == "undefined" ? this.head : options.head;
                                  }

                                  this.show = 1;
                                }
                            };
      $scope.loading = true;

      Services.getEmployee().then(function(response) {
          if(response.data.status == "success"){
            $scope.tmpemployees = response.data.data;
            // $scope.employees = response.data.data;

            uc.setEmployees();

            $scope.$watch('sort', function(value){
                //TODO: SORT FUNCTION
                var tmp = [];
                var tmpObj = {};
                $.each($scope.origemployees, function(k, obj){
                  tmp.push(obj);
                });
                tmp.sort(function(a, b) {
                  if(!a[value])
                    return -1;

                  if(!a[value])
                    return 1;

                  return a[value].localeCompare(b[value]);
                });

                $.each(tmp, function(k, obj){
                  tmpObj[obj.number] = obj
                });

                $scope.employees = angular.copy(tmpObj);
                $scope.origemployees = angular.copy($scope.employees )
            });
          }

          /** VIEW TO EDIT **/
          $scope.ViewEmployee = function(id){
              $scope.view.employee = $scope.employees[id];
          };

          $scope.ToggleEdit = function (element){
              backUpEmployee = angular.copy($scope.view.employee);

              if(typeof element == "undefined"){
                for(var ctr = 1 ; ctr <= 2 ; ctr++){
                    $scope.ToggleEdit(ctr);
                }
              }else{
                $('.form-edit-' + element).toggle();
                $('.form-info-' + element).toggle();
                $('#EditEmployeeForm').toggleClass('editing-' + element);
              }

              $scope.onEdit = uc.CheckIfEditing();

              return true;
          }

          $scope.CloseEdit = function (element){
             if($scope.onEdit){
               if(typeof element == 'undefined'){
                   $('#cancelEdit').modal ({ backdrop: 'static', keyboard: false })
                   .one('click', '#yesCancel', function () {
                      var vm = this;

                      $scope.view.employee = angular.copy(backUpEmployee);

                      if(typeof element == 'undefined')
                          $scope.noView = true;

                      if($scope.ToggleEdit(element))
                          $(vm).closest(".modal").modal('hide');

                  })
               }else{
                    $scope.view.employee = backUpEmployee;
                    $scope.ToggleEdit(element);
               }
             }else{
              $('#showViewEmpModal').modal('hide');
             }
             

          }

          $scope.UpdateEmployee = function(element){
              $scope.update.employee = {};
              $scope.update.employee = $scope.view.employee;

              Services.updateEmployee( $scope.update.employee).then(function(response){
                  if(response.data.status == "success"){
                    uc.initEmployees();
                    $scope.ToggleEdit(element);
                  }

                  $scope.notifConfig.set({
                    message : response.data.data,
                    type : response.data.status
                  });

              });
          }


          /** UPDATE STATUS **/
          $scope.UpdateEmpStatus = function(id){
            $scope.update.employee = {};
            $scope.update.employee = $scope.employees[id];

            $('#updateEmployeeStatus').modal ({ backdrop: 'static', keyboard: false })
            .one('click', '#update', function () {
                var vm = this;
                Services.updateEmployeeStatus( $scope.update.employee).then(function(response){
                  if(response.data.status == "success"){
                    uc.initEmployees();
                    $(vm).closest(".modal").modal('hide');
                  }

                  $scope.notifConfig.set({
                    message : response.data.data,
                    type : response.data.status
                  });

                });
            })
            .one('click','#noupdate', function(){
              var vm = this;
              $scope.employees[id] = angular.copy($scope.origemployees[id]);
              $scope.$apply();
              $(vm).closest(".modal").modal('hide');
            });
          };


          /** SEARCH EMPLOYEE **/
          $scope.SearchEmployee = function (){
            var search = $scope.searchExp.toLowerCase();
            $scope.employees = {};

            $.each($scope.origemployees, function(number, emp){
              if(emp.name){
                if(emp.name.toLowerCase().indexOf(search) > -1){
                  $scope.employees[number] = emp;
                }
              }
            });
          };

          $scope.SetPdf = function(id, position){
            $scope.pdfid = 'api/bank.php?p=' + position + '&&id='+ id;
            $timeout(function (){
                  window.frames.objAdobePrint.print();
            }, 1000);
          }

      });

      $scope.ToAddUser = function(){
          $scope.add.employee = {};
          document.getElementById("EmployeeForm").reset();
          $scope.add.employee.number = "GWO-";
          $scope.add.employee.status = 0;
          $scope.add.employee.datehired = new Date();
      }

      $scope.AddUser = function(){
          var msg = "";
          var skip = false;

          if(typeof $scope.employees[$scope.add.employee.number] != 'undefined' ){
            msg = "Employee already exist!";
            skip = true;
          }

          if(!skip && !$scope.add.employee.avatar){
            msg =  'Please Upload an ID Picture!';
            skip = true;
          }

          if(!skip && !$scope.add.employee.signature){
            msg =  'Please Upload a Signature Picture!';
            skip = true;
          }

          if(!skip && $scope.add.employee.number == 'GWO-'){
            msg =  'Please Add Employee ID Number';
            skip = true;
          }

          if(!skip){
            if($scope.EmployeeForm.$valid){
              Services.addEmployee($scope.add.employee).then(function(response) {
                if(response.data.status == "success"){
                  $scope.employees[$scope.add.employee.number] = $scope.add.employee;
                  uc.initEmployees();
                  $('#showAddEmpModal').modal('hide');
                }

                $scope.notifConfig.set({
                  message : response.data.data,
                  type : response.data.status
                });

              });
            }else{
              $scope.notifConfig.set({
                message : 'Please fill form fields.',
                type : 'error'
              });
            }
            return;
          }

          $scope.notifConfig.set({
            message : msg,
            type : 'error'
          });

      }

      uc.initEmployees = function(){
        $scope.origemployees = angular.copy($scope.employees);
      }
      uc.setEmployees = function(){
        var tmpObj = {};
        // Object.keys($scope.employees).sort().forEach( function(key){
        //   tmpObj[key] = $scope.employees[key];
        //
        // });

        // $scope.employees = tmpObj;
        // $scope.origemployees = angular.copy($scope.employees);
        //Animate List
        Object.keys($scope.tmpemployees).sort().forEach( function(key, index){
            $timeout(function (){
                $scope.employees[key] = $scope.tmpemployees[key];
                $scope.origemployees = angular.copy($scope.employees);
            }, 50 * index);
        });

      }


      uc.CheckIfEditing = function (){
          for(var ctr = 1 ; ctr <= 2 ; ctr++){
            if($('#EditEmployeeForm').hasClass('editing-' + ctr))
                return true;
          }

          return false;
      }

      $('#cancelEdit').on("hidden.bs.modal", function(e){
          if(!$scope.noView)
            $('#showViewEmpModal').modal('show');
          else{
            for(var ctr = 1 ; ctr <= 2 ; ctr++){
                    $('.form-edit-' + ctr).hide();
                    $('.form-info-' + ctr).show();
                    $('#EditEmployeeForm').removeClass('editing-' + ctr);
            }
              $scope.onEdit = false;
          }
          $scope.noView = false;
      });

      $('#cancelEdit').on("show.bs.modal", function(e){
          $('#showViewEmpModal').modal('hide');
      });

      $('#updateEmployeeStatus').on("shown.bs.modal", function(e){
          $("#EmpStats").val($scope.update.employee.status);
      });
  }

  var app = angular.module ('hris', ['ngRoute', 'ngAnimate'])
                   .service ('Services', ['$http', Service])
                   .filter ('ConvertIdToImage', ConvertIdToImage)
                   .controller ('EmpController', EmpController)
                   .directive ('employeeAvatar', employeeAvatar)
                   .directive ('fileupload', fileupload)
                   .directive ('notification', ['$timeout', dirNotification]);

  EmpController.$inject = ['$scope', '$sce', '$timeout', 'Services'];

})();


(function($) {
    $.fn.checkFileType = function(options) {
        var defaults = {
            allowedExtensions: [],
            success: function() {},
            error: function() {}
        };
        options = $.extend(defaults, options);

        return this.each(function() {

            $(this).on('change', function() {
                var msg = $(this).parent().find(".msg");
                var value = $(this).val(),
                    file = value.toLowerCase(),
                    extension = file.substring(file.lastIndexOf('.') + 1);

                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
					$(this).val("");

						msg.addClass("error");
						msg.html("Invalid image type! Type must (png).");
                } else {
                		msg.html("Signature image type is valid!");
						msg.addClass("success");
						msg.fadeOut(5000);
                    options.success();
                }

            });

        });
    };

})(jQuery);

$(function() {
    $('#signature').checkFileType({
        allowedExtensions: ['png'],
        success: function() {
        },
        error: function() {
        }
    });

});
