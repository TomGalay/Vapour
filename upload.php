<?php
//UPLOAD PHP

//include('config.php');


if(isset($_POST['upload'])){
    $target_dir = "./assets/marketplace/portrait/";
    $target_file = $target_dir .$array_from_query[0][0].'.'. pathinfo($_FILES["fileToUpload"]["name"] ,PATHINFO_EXTENSION); //$target_dir . basename($_FILES["fileToUpload"]["name"]); //
    //$newFileName = $target_dir .'YourfileName'.'.'. pathinfo($_FILES["fileToUpload"]["name"] ,PATHINFO_EXTENSION); //get the file extension and append it to the new file name
    $uploadOk = 1;
    //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
    
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    
    if (file_exists($_FILES["fileToUpload"]["name"])) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    if ($_FILES["fileToUpload"]["size"] > 100000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    if($imageFileType != "png") {
      echo "Sorry, only PNG files are allowed.";
      $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";

    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $ok_upload = true;
        $g_img = $array_from_query[0][0];
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
}

if(isset($_POST['upload'])){
  $target_dir = "./assets/marketplace/landscape/";
  $target_file = $target_dir .$array_from_query[0][0].'.'. pathinfo($_FILES["fileToUpload"]["name"] ,PATHINFO_EXTENSION); //$target_dir . basename($_FILES["fileToUpload2"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
  
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
  
  if (file_exists($_FILES["fileToUpload"]["name"])) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  
  if ($_FILES["fileToUpload2"]["size"] > 100000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  if($imageFileType != "png") {
    echo "Sorry, only PNG files are allowed.";
    $uploadOk = 0;
  }
  
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

  } else {
    if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
      $ok_upload = true;
      $g_img = $array_from_query[0][0];
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}



?>