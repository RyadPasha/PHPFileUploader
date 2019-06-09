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
  $fileField  = 'archive_source';

  $uploadPath = 'uploads/';

  $maxSize    = 9000000;   // Max allowed size in byets.

  $newName    = 'my_file'; // 1 gets you a Md5 hash of the file
                           // 2 gets you a Random name
                           // 3 gets you the same file name
                           // Anything else will be used as a specified name for the file.
  $isImage    = false;

  $checkImage = false;

  $allowedMimeTypes = ['rar' => 'application/x-rar-compressed',
                       'zip' => 'application/zip'];

  $uploader = secureUpload($fileField, $uploadPath, $maxSize, $newName, $isImage, $checkImage, $allowedMimeTypes);


  if(@$uploader['filename'])
    echo 'File uploaded successfully.';

  else
    echo $uploader['errors'][0];

    // You can also print the ‘$uploader’ array to see the output.
    // echo '<pre>'; print_r($uploader); echo '</pre>';
}

?>

<form method='post' action='#' enctype='multipart/form-data'>
  <input type='file' name='archive_source'>
  <input type='submit' name='submit' value='submit'>
</form>
