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

function secureUpload($fileField = null, $uploadPath = 'uploads/', $maxSize = 8000000, $newName = 1, $isImage = true, $checkImage = false, $allowedMimeTypes = []) {
  // Create an array to hold any outputs:
  $output = [];

  if($isImage)
    $allowedMimeTypes =
      ['jpeg'=> 'image/jpeg',
       'jpg' => 'image/jpeg',
       'png' => 'image/png',
       'bmp' => 'image/bmp',
       'gif' => 'image/gif'];
  elseif(!is_array($allowedMimeTypes) || @count($allowedMimeTypes) < 1)
    $allowedMimeTypes =
      ['ez'=>'application/andrew-inset','hqx'=>'application/mac-binhex40','cpt'=>'application/mac-compactpro',
      'doc'=>'application/msword','bin'=>'application/octet-stream','dms'=>'application/octet-stream','lha'=>'application/octet-stream',
      'lzh'=>'application/octet-stream','exe'=>'application/octet-stream','class'=>'application/octet-stream','so'=>'application/octet-stream',
      'dll'=>'application/octet-stream','oda'=>'application/oda','pdf'=>'application/pdf','ai'=>'application/postscript','eps'=>'application/postscript',
      'ps'=>'application/postscript','smi'=>'application/smil','smil'=>'application/smil','wbxml'=>'application/vnd.wap.wbxml','wmlc'=>'application/vnd.wap.wmlc',
      'wmlsc'=>'application/vnd.wap.wmlscriptc','bcpio'=>'application/x-bcpio','vcd'=>'application/x-cdlink','pgn'=>'application/x-chess-pgn','cpio'=>'application/x-cpio',
      'csh'=>'application/x-csh','dcr'=>'application/x-director','dir'=>'application/x-director','dxr'=>'application/x-director','dvi'=>'application/x-dvi','spl'=>'application/x-futuresplash',
      'gtar'=>'application/x-gtar','hdf'=>'application/x-hdf','js'=>'application/x-javascript','skp'=>'application/x-koan','skd'=>'application/x-koan','skt'=>'application/x-koan',
      'skm'=>'application/x-koan','latex'=>'application/x-latex','nc'=>'application/x-netcdf','cdf'=>'application/x-netcdf','sh'=>'application/x-sh','shar'=>'application/x-shar',
      'swf'=>'application/x-shockwave-flash','sit'=>'application/x-stuffit','sv4cpio'=>'application/x-sv4cpio','sv4crc'=>'application/x-sv4crc','tar'=>'application/x-tar',
      'tcl'=>'application/x-tcl','tex'=>'application/x-tex','texinfo'=>'application/x-texinfo','texi'=>'application/x-texinfo','t'=>'application/x-troff','tr'=>'application/x-troff',
      'roff'=>'application/x-troff','man'=>'application/x-troff-man','me'=>'application/x-troff-me','ms'=>'application/x-troff-ms','ustar'=>'application/x-ustar',
      'src'=>'application/x-wais-source','xhtml'=>'application/xhtml+xml','xht'=>'application/xhtml+xml','zip'=>'application/zip','au'=>'audio/basic','snd'=>'audio/basic','mid'=>'audio/midi',
      'midi'=>'audio/midi','kar'=>'audio/midi','mpga'=>'audio/mpeg','mp2'=>'audio/mpeg','mp3'=>'audio/mpeg','aif'=>'audio/x-aiff','aiff'=>'audio/x-aiff','aifc'=>'audio/x-aiff',
      'm3u'=>'audio/x-mpegurl','ram'=>'audio/x-pn-realaudio','rm'=>'audio/x-pn-realaudio','rpm'=>'audio/x-pn-realaudio-plugin','ra'=>'audio/x-realaudio','wav'=>'audio/x-wav',
      'pdb'=>'chemical/x-pdb','xyz'=>'chemical/x-xyz','bmp'=>'image/bmp','gif'=>'image/gif','ief'=>'image/ief','jpeg'=>'image/jpeg','jpg'=>'image/jpeg','jpe'=>'image/jpeg',
      'png'=>'image/png','tiff'=>'image/tiff','tif'=>'image/tif','djvu'=>'image/vnd.djvu','djv'=>'image/vnd.djvu','wbmp'=>'image/vnd.wap.wbmp','ras'=>'image/x-cmu-raster',
      'pnm'=>'image/x-portable-anymap','pbm'=>'image/x-portable-bitmap','pgm'=>'image/x-portable-graymap','ppm'=>'image/x-portable-pixmap','rgb'=>'image/x-rgb','xbm'=>'image/x-xbitmap',
      'xpm'=>'image/x-xpixmap','xwd'=>'image/x-windowdump','igs'=>'model/iges','iges'=>'model/iges','msh'=>'model/mesh','mesh'=>'model/mesh','silo'=>'model/mesh','wrl'=>'model/vrml',
      'vrml'=>'model/vrml','css'=>'text/css','html'=>'text/html','htm'=>'text/html','asc'=>'text/plain','txt'=>'text/plain','rtx'=>'text/richtext','rtf'=>'text/rtf',
      'sgml'=>'text/sgml','sgm'=>'text/sgml','tsv'=>'text/tab-seperated-values','wml'=>'text/vnd.wap.wml','wmls'=>'text/vnd.wap.wmlscript','etx'=>'text/x-setext',
      'xml'=>'text/xml','xsl'=>'text/xml','mpeg'=>'video/mpeg','mpg'=>'video/mpeg','mpe'=>'video/mpeg','qt'=>'video/quicktime','mov'=>'video/quicktime','mxu'=>'video/vnd.mpegurl',
      'avi'=>'video/x-msvideo','movie'=>'video/x-sgi-movie','ice'=>'x-conference-xcooltalk'];
  else if(isset($allowedMimeTypes['0'])) $output['errors'][] = 'The allowed extensions must be used as index for each MIME type in the ‘$allowedMimeTypes’ array.';

  $uploadPath = rtrim($uploadPath, '/') . '/'; // Checking if path ends in '/' ... if not then tack it on.

  //        || Validation ||

  if(!$fileField) $output['errors'][] = 'Please specify a valid file field.';
  if(!$uploadPath) $output['errors'][] = 'Please specify a valid upload path.';
  if(@count($output['errors']) > 0) return $output;

  if((!empty($_FILES[$fileField])) && ($_FILES[$fileField]['error'] == 0)) {
    // Get file info:
    $fileInfo = pathinfo($_FILES[$fileField]['name']);
    $fileName = $fileInfo['filename'];
    $fileSize = $_FILES[$fileField]['size'];
    $fileExt  = strtolower($fileInfo['extension']);

    // Check if the file has the right extension and type:
    if(!@isset($allowedMimeTypes[$fileExt])) $output['errors'][] = 'Invalid file format.'; //'Invalid file extension.';
    if(!@in_array($_FILES[$fileField]['type'], $allowedMimeTypes)) $output['errors'][] = 'Invalid file type.';

    // Check that the file is not too big .. Given $maxSize in (byets).
    if($fileSize > $maxSize) $output['errors'][] = 'File is too big. Max allowed size is: '.($maxSize / 1024).' Kb, yours is '.($fileSize / 1024).' Kb.';

    // If ‘$isImage’ AND ‘$checkImage’ are set to ‘true’
    // Then, using getimagesize(), we'll be processing the image with the GD library.
    // If it isn’t an image, this will fail and therefor the entire upload will fail:
    if($checkImage && $isImage){if(!getimagesize($_FILES[$fileField]['tmp_name'])) $output['errors'][] = 'Uploaded file is not a valid image.';}

    $newFileName = ($newName === 1 ? sprintf('%s.%s', md5_file($_FILES[$fileField]['tmp_name']), $fileExt) // If ($newName = 1) <- $newFileName = Md5_file
                 : ($newName === 2 ? sprintf('%s.%s', substr(md5(microtime()),0,15), $fileExt)             // If ($newName = 2) <- $newFileName = Random name
                 : ($newName === 3 ? sprintf('%s.%s', $fileName, $fileExt)                                 // If ($newName = 3) <- $newFileName = Same name
                 : sprintf('%s.%s', $newName, $fileExt))));                                                // Else              <- $newFileName = The name passed in ‘$newName’

    // Check if file already exists on server:
    if(file_exists($uploadPath.$newFileName)) $output['errors'][] = 'A file with the same name already exists.';

    // Create the $uploadPath if it doesn't already exist:
    if(!is_dir($uploadPath)) @mkdir($uploadPath) OR $output['errors'][] = 'Error creating directory: '.str_replace(['mkdir(): ','File'],['','Directory'], error_get_last()['message']);

    // The file has not correctly validated:
    if(@count($output['errors']) > 0) return $output;

    if(move_uploaded_file($_FILES[$fileField]['tmp_name'], $uploadPath.$newFileName)) {
      $output['filename'] = $newFileName;
      $output['filepath'] = $uploadPath;
      $output['filesize'] = $fileSize;
    } else $output['errors'][] = 'Server error.';
  } else $output['errors'][] = 'No file uploaded.';

  return $output;
}

?>
