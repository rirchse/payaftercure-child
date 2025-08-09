<?php
// ini_set('display_errors', 1); 
// error_reporting(E_ALL);
// include 'mp_functions.php';

if($_SERVER['REQUEST_METHOD'] == "POST")
{
  /** exist prescription image upload */
  function prescripUpload($rawfile, $target_dir)
  {
    $base_dir = $_SERVER['DOCUMENT_ROOT'];
    $data = [];
    $data['msg'] = NULL;
    $data['img_file'] = NULL;
    $data['status'] = NULL;
    if($rawfile["name"])
    {
      $target_file = $target_dir . basename($rawfile["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $resizeFileName = time();
      $upload = 1;

      if($rawfile["size"] == 0 || $rawfile["size"] > 5000000)
      {
        $upload = 0;
        $data['msg'] = 'File size max 5MB';
        $data['status'] = 'error';
        return $data;
      }

      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif")
      {
        $upload = 0;
        $data['msg'] = 'Image format does not match';
        $data['status'] = 'error';
        return $data;
      }

      if($upload == 1)
      {
        $raw_image = $rawfile['tmp_name'];
        $image_size = getimagesize($raw_image);
      
        $ratio = 0;
        $img_width = 1200;
        $img_height = 1200;
      
        if($image_size[0] > $image_size[1] && $image_size[0] > $img_width)
        {
          $ratio = $image_size[0] / $image_size[1];
          $img_height = round($img_width / $ratio);
        }
        elseif($image_size[1] > $image_size[0] && $image_size[1] > $img_height)
        {
          $ratio = $image_size[1] / $image_size[0];
          $img_width = round($img_height / $ratio);
        }
        else
        {
          $img_width = $image_size[0];
          $img_height = $image_size[1];
        }

        $resourceType = @imagecreatefromjpeg($raw_image);
        if($resourceType !== false)
        {
          $imageLayer = imagecreatetruecolor($img_width, $img_height);
          imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $img_width, $img_height, $image_size[0], $image_size[1]);
          
          imagejpeg($imageLayer, $base_dir.$target_dir . $resizeFileName.'_' .$rawfile["name"]);
      
          // return $base_dir;
          $data['img_file'] = $target_dir . $resizeFileName.'_' .$rawfile["name"];
          return $data;
        }
        else
        {
          $data['msg'] = 'Please select valid image.';
          $data['status'] = 'error';
          return $data;
        }
      }
    }
  }
  $case_photo = prescripUpload($_FILES["file"], '/wp-content/uploads/prescription_image/');
  echo json_encode($case_photo);
}
?>