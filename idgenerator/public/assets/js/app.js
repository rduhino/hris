
(function() {
  'use strict';

  /************* SERVICE *************/
  var Service = function($http) {
      var serviceBase = '../user_mgt/services/';
      var obj = {};
      obj.getEmployee = function() {
          return $http.get("api/api.php?action=employees");
      }

      obj.addEmployee = function(employee) {
          return $http.post("api/api.php?action=addEmployee", employee).then(function(results) {
              return results;
          });
      };

      obj.deleteEmployee = function(employeeID) {
        return $http.post("api/api.php?action=deleteEmployee&empid=" + employeeID).then(function(results) {
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
                       console.log(value)
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
            link: function(scope, element, attrs, ngModel) {
                element.bind("change", function(evt){
                  var filesToUpload = evt.target.files;
                  var file = filesToUpload[0];

                  var img = document.createElement("img");
                  var reader = new FileReader();

                  reader.onload = function(e){
                    img.src = e.target.result;

                    var canvas = document.createElement("canvas");
                    //var canvas = $("<canvas>", {"id":"testing"})[0];
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);

                    var MAX_WIDTH = 230;
                    var MAX_HEIGHT = 230;
                    var width = img.width;
                    var height = img.height;

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
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, MAX_HEIGHT, MAX_WIDTH);


                    if(attrs.id == 'avatar'){
                      var dataurl = canvas.toDataURL("image/jpeg");
                      scope.add.employee.avatar = dataurl;
                    }
                    else{
                      var dataurl = canvas.toDataURL("image/png");
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

      $scope.employees = {};
      $scope.origemployees = {}

      $scope.view = {};
      $scope.add = {};

      $scope.searchExp = "";
      $scope.pdfid = '';

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
            $scope.employees = response.data.data

            uc.sortEmployees();
          }

          $scope.ViewEmployee = function(id){
            $.each($scope.employees, function(number, emp){
              if(number == id){
                $scope.view.employee = emp;
              }
            });
          };

          $scope.DeleteEmployee = function(id){
            $('#deleteEmployee').modal({ backdrop: 'static', keyboard: false })
            .on('click', '#delete', function() {
                var vm = this;
                Services.deleteEmployee(id).then(function(response){
                  if(response.data.status == "success"){
                    delete $scope.employees[id];
                    delete $scope.origemployees[id];

                    $(vm).closest(".modal").modal('toggle');
                  }

                  $scope.notifConfig.set({
                    message : response.data.data,
                    type : response.data.status
                  });

                });
            });
          };

          $scope.SearchEmployee = function(){
            var search = $scope.searchExp.toLowerCase();
            $scope.employees = {};
            var obj = {};
            $.each($scope.origemployees, function(number, emp){
              if(emp.name){
                if(emp.name.toLowerCase().indexOf(search) > -1){
                  $scope.employees[number] = emp;
                }
              }
            });
          };

          $scope.SetPdf = function(id, position){
            $scope.pdfid = 'bank.php?p=' + position + '&&id='+ id;
            $timeout(function (){
                  window.frames['objAdobePrint'].print();
            }, 1000);
          }

      });

      $scope.ToAddUser = function(){
          $scope.add.employee = {};
          document.getElementById("EmployeeForm").reset();
          $scope.add.employee.number = "GWO-";
      }

      $scope.AddUser = function(){
          var msg = "";
          var skip = false;

          if(typeof $scope.employees[$scope.add.employee.number] != 'undefined' ){
            msg = "Employee already exist!";
            skip = true;
          }

          if(!skip && !$scope.add.employee.avatar){
            msg =  'Please Upload an ID Picture!',
            skip = true;
          }

          if(!skip && !$scope.add.employee.signature){
            msg =  'Please Upload an ID Picture!',
            skip = true;
          }

          if(!skip && $scope.add.employee.number == 'GWO-'){
            msg =  'Please Add Employee ID Number',
            skip = true;
          }

          if(!skip){
            if($scope.EmployeeForm.$valid){
              Services.addEmployee($scope.add.employee).then(function(response) {
                if(response.data.status == "success"){
                  $scope.employees[$scope.add.employee.number] = $scope.add.employee;
                  uc.sortEmployees();
                  $('#showAddEmpModal').modal('toggle');
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

      uc.sortEmployees = function(){
        var tmpObj = {};
        Object.keys($scope.employees).sort().forEach( function(key){
          tmpObj[key] = $scope.employees[key];
        });

        $scope.origemployees = $scope.employees = tmpObj;
      }
  }

  var app = angular.module('hris',['ngRoute'])
                   .service('Services', ['$http', Service])
                   .filter('ConvertIdToImage', ConvertIdToImage)
                   .controller('EmpController', EmpController)
                   .directive('employeeAvatar', employeeAvatar)
                   .directive('fileupload', fileupload)
                   .directive('notification', ['$timeout', dirNotification])
  //
  EmpController.$inject = ['$scope', '$sce', '$timeout', 'Services'];

  // $('#deleteEmployee').modal({ backdrop: 'static', keyboard: false })
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

// SIDEBAR SELECT
var selector = $('.sidebar ul li'),
	empList = $('.main.employeeList'),
	empAddNew = $('.main.addNewEmployee');
	empAddNew.hide();

selector.on('click', function(e){
	e.preventDefault();

    $(selector).removeClass('active');
    $(this).addClass('active');

    var current = $(this).find('a').attr('href');
    switch (current) {
    	case '#add_new_employee':
    		$('input[type ="text"]').val("");
    		$('textarea').val("");
    		$('.addNewEmployee .page-header').text("Add New Employee");
    		empList.hide(); empAddNew.fadeIn();
    	break;
    	case '#employee_list':
    		empAddNew.hide(); empList.fadeIn();
    	break;
    }
});

// IMAGE POPUP
$('.imagepop').on('click', function(e) {
	e.preventDefault();

	$('.imagepreview').attr('src', $(this).attr('href'));
	$('#imagemodal').modal('show');
});

$('.glyphicon-edit').on('click', function(e) {
	e.preventDefault();
	var tr = $(this).parents('tr');

	$(".formContainer input[name='number']").val( $(tr).find('td:first-child').text() );
	$(".formContainer input[name='fullname']").val( $(tr).find('td:nth-child(3)').text() );
	$(".formContainer input[name='nickname']").val( $(tr).find('td:nth-child(2)').text() );
	$(".formContainer input[name='title']").val( $(tr).find('td:nth-child(4)').text() );

	// $(".formContainer input[name='address']").val();
	$(".formContainer input[name='contact']").val( $(tr).find('td:nth-child(6)').text() );
	$(".formContainer input[name='tin']").val( $(tr).find('td:nth-child(7)').text() );
	$(".formContainer input[name='sss']").val( $(tr).find('td:nth-child(8)').text() );
	$(".formContainer input[name='emergency_name']").val( $(tr).find('td:nth-child(9)').text() );
	$(".formContainer input[name='emergency_number']").val( $(tr).find('td:nth-child(10)').text() );

	$('.addNewEmployee .page-header').text("Edit Employee");

	empAddNew.show();
	empList.hide();
});


// LIVE search
$(document).ready(function(){
    $("#filter").keyup(function(){

 		var empList = $('.main.employeeList');
 		if( empList.css('display') == 'none' ) {
 			$('.main.addNewEmployee').css('display','none');
			empList.css('display','block');
			$('ul.nav.nav-sidebar > li:last-child').removeClass('active');
			$('ul.nav.nav-sidebar > li:first-child').addClass('active');
		}
        var filter = $(this).val(), count = 0;

        $(".main.employeeList table tbody tr").each(function(){

            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
            	$(this).hide();
            } else {
                $(this).show();
                count++;
            }
        });
    });
});
