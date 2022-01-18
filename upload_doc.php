<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
header("Content-type: application/json; charset=utf-8");

if(isset($_POST['secret']) && $_POST['secret'] == "secret"){
  $files = (isset($_FILES)) ? $_FILES : array();
  if(isset($files) && count($files) > 0){
    for($jkl=0;$jkl<count($files['docs']['name']);$jkl++){
      $fileName = $files['docs']['name'][$jkl];
      $fileTmpLoc = $files['docs']['tmp_name'][$jkl];
      $fileType = $files['docs']['type'][$jkl];
      $fileSize = $files['docs']['size'][$jkl];
      $fileErrorMsg = $files['docs']['error'][$jkl];

      if (!$fileTmpLoc) {
        $res[] = "ERROR: Please browse for a file before clicking the upload button.";
        $msg = "error";
        die();
      }
      
      $path = "telegram/storage/";
      if(move_uploaded_file($fileTmpLoc, $path.$fileName)){
        $res[] = "Upload doc to storage, success!";
        $msg = "OK";
      } else {
        $res[] = "move_uploaded_file $fileName failed.";
        $msg = "error";
      }
      echo '{"data":"'.json_encode($res).'", "message":"'.$msg.'"}';
    }
  }
}
