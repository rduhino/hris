<?php

$employees_file = '../db/employees.txt';
$dir = "../images/";
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
  switch($_GET['action']){
    case 'employees' :
        if(file_exists($employees_file)){
          $json = file_get_contents($employees_file);
          $array = json_decode($json, true);

          if(empty($array))
            response( array("status" => "error" , "data" => "No User Found.") );

          response( array("status" => "success", "data" => $array) );
        }else{
          response( array("status" => "error" , "data" => "File not found.") );
        }

      break;
    case 'addEmployee':
        $params = json_decode(file_get_contents('php://input'),true);
        $img = isset($params['avatar']) ? $params['avatar'] : null;
        $tempFilename = strtolower(str_replace('-', '', $params['number']));
        $uploadPath = $dir . $tempFilename . '.jpg';

        if (!upload($uploadPath, $img, 'image/jpeg'))
          response( array("status" => "error" , "data" => "Avatar Not Valid.") );

          unset($params['avatar']);
          $img = isset($params['signature']) ? $params['signature'] : null ;
          $tempFilename = strtolower(str_replace('-', '', $params['number'])) . "signature";
          $uploadPath = $dir . $tempFilename . '.png';

        if(!upload($uploadPath, $img , 'image/png') )
          response( array("status" => "error" , "data" => "Signature Not Valid.") );

          unset($params['signature']);

          $json = file_get_contents($employees_file);
      		$array = json_decode($json, true);

          $array[$params['number']] = $params;

          if(file_put_contents($employees_file, json_encode($array)))
            response( array("status" => "success" , "data" => "Employee Created.") );
          else
            response( array("status" => "error" , "data" => "Employee Error Creation.") );
      break;

    case 'deleteEmployee' :
        $empId = isset($_GET['empid']) ? $_GET['empid'] : null;

        if(!$empId)
          response( array("status" => "error" , "data" => "Invalid employee id.") );

        $json = file_get_contents($employees_file);
        $array = json_decode($json, true);

        if(!isset($array[$empId]))
          response( array("status" => "error" , "data" => "Employee not found.") );

        unset($array[$empId]);


        if( file_put_contents($employees_file, json_encode($array)) ){
          $uploadPath = $dir .strtolower(str_replace('-', '', $empId)). ".jpg";
          unlink($uploadPath);

          $uploadPath = $dir . strtolower(str_replace('-', '', $empId)) . "signature.png";
          unlink($uploadPath);

          response( array("status" => "success" , "data" => "Employee Deleted.") );
        }
        else
          response( array("status" => "error" , "data" => "Employee Error Deletion.") );

      break;
  }
}

function upload($filename, $imgsrc, $type){
  $img = $imgsrc; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
  $img = str_replace('data:'.$type.';base64,', '', $img);

  if (file_exists($filename)) {
      unlink($filename);
  }

  if (file_put_contents($filename, base64_decode($img))) {
    return true;
  }else {
    return false;
  }
}
function response($data){
  echo json_encode($data);
  exit;
}

?>
