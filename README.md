# PHPFileUploader
This fuction provides a full secure file upload in PHP.

Configuration
==========
For composer installations: Copy the folder ‘vendor’ into your your server.

For non-composer installations: Download and unzip the ‘fileUploader.php’ in include folder in your server.
See detailed information below ..

How to use
==========
Let’s suppose the you downloaded it inside the folder ‘include’. 

Simply include the function and call the `secureUpload()` function!

At the begin of your main script, add this code:

```php
<?php
require 'include/fileUploader.php';

// Call the ‘secureUpload’ function and pass it’s parameters:
$uploader = secureUpload($fileField, $uploadPath, $maxSize, $newName, $isImage, $checkImage, $allowedMimeTypes);
```

Suppose that we want to upload an image with a field name ‘profile_pic’ ($_FILES['profile_pic'])

Since it's a picture, we can validate it as follows:

```php
secureUpload('profile_pic', 'uploads/', 2000000, 'user_111112', true, true);
```


The returned array ‘$uploader’ will contain either an ‘errers’ array (in case any error occured), or a ‘filename’ index which means that the file is uploaded successfully.

You can detect that programmably as follows:

```php
if(@$uploader['filename'])
  echo 'File uploaded successfully.';

else
  echo $uploader['errors'][0];
```

You can also print the ‘$uploader’ array to see the output:

```php
echo '<pre>'; print_r($uploader); echo '</pre>';
```


### Contribute

* Fork the repo
* Create your branch
* Commit your changes
* Create a pull request

## Discussion

For any queries contact me at: **me@ryadpasha.com**
