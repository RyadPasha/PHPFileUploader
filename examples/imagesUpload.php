<?php
/**
  * @project: PHP File Uploader
  *
  * @purpose: This fuction provides a full secure file upload in PHP.
  * @version: 1.0
  *
  * @author: Mohamed Riyad
  * @created on: 9 Jun, 2019
  *
  * @url: http://ryadpasha.com
  * @email: me@ryadpasha.com
  * @license: GNU General Public License v3.0
  *
  * @see: https://github.com/ryadpasha/PHPFileUploader
  * @examples: https://github.com/ryadpasha/PHPFileUploader/tree/master/examples
  */

require '../fileUploader.php';


if(isset($_REQUEST['submit'])){
  $fileField  = 'profile_pic';

  $uploadPath = 'uploads/';

  $maxSize    = 2000000;  // Max allowed size in byets.

  $newName    = 1;        // 1 gets you a Md5 hash of the file
                          // 2 gets you a Random name
                          // 3 gets you the same file name
                          // Anything else will be used as a specified name for the file.
  $isImage    = true;

  $checkImage = true;    // Using getimagesize(), we'll be processing the image with the GD library.
                         // If it isn’t an image, this will fail and therefor the entire upload will fail.

  $uploader = secureUpload($fileField, $uploadPath, $maxSize, $newName, $isImage, $checkImage);

  echo '<pre>';
    print_r($uploader);
  echo '</pre>';
}

?>

<form method='post' action='#' enctype='multipart/form-data'>
  <input type='file' name='profile_pic'>
  <input type='submit' name='submit' value='submit'>
</form>
