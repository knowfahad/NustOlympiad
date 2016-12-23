<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.
function resize_image($file, $newwidth, $newheight) {
    list($width, $height) = getimagesize($file);
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor( $newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0,  $newwidth, $newheight, $width, $height);
    imagejpeg($dst, $file, 100);
}

	var_dump($_FILES);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$img = $_FILES['img'];

	$info = pathinfo($img['name']);
	$ext=$info['extension'];
	$allowed = array('jpg', 'jpeg');
	$size=$img['size']/1048576;
	
	if($size<2){
		if(in_array($ext,$allowed)){
			$newname = "newname1.".$ext; 
			$target = __DIR__.'/photos/'.$newname;

			if (move_uploaded_file($img['tmp_name'], $target)) {
				resize_image($target, 200, 200);
				echo '<img src=/photos/'.$newname.'>';
			    echo "File is valid, and was successfully uploaded.\n";
			} 
			else {
			    echo "Possible file upload attack!\n";
			}

		}
		else{
				echo "must be jpeg or jpg";
		}	
	}
	else{
		echo "FILE SIZE MUST NOT MORE THEN 2 MB";
	}

}
	

?>

<!DOCTYPE html>
<html>
<head>
	<title>file upload</title>
</head>
<body>
	<form method="POST" enctype="multipart/form-data" action="/upload.php">
		<input type="file" name="img">
		<input type="text" name="hello" value="hello">
		<button type="submit">Upload</button>
	</form>
</body>
</html>
