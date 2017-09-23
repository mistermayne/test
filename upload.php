<?php

foreach($_FILES['files']['name'] as $i => $name) {

	$name = $_FILES['files']['name'][$i];
	$size = $_FILES['files']['size'][$i];
	$type = $_FILES['files']['type'][$i];
	$tmp = $_FILES['files']['tmp_name'][$i];

	$explode = explode('.', $name);

	$ext = end($explode);

	$path = 'uploads/';
	$path = $path . basename( $explode[0] . time() .'.'. $ext);
	
	$errors = array();

	if(empty($_FILES['files']['tmp_name'][$i])) {
		$errors[] = 'Please choose at least 1 file to be uploaded.';
	}else {

		$allowed = array('jpg','jpeg','gif','bmp','png');

		$max_size = 4000000; // 4MB

		if(in_array($ext, $allowed) === false) {
			$errors[] = 'The file <b>'.$name.'</b> extension is not allowed.';
		}

		if($size > $max_size) {
			$errors[] = 'The file <b>'.$name.'</b> size is too hight.';
		}

	}

	if(empty($errors)) {
		
		if(!file_exists('uploads')) {
			mkdir('uploads', 0777);
		}

		if(move_uploaded_file($tmp, $path)) {
			echo '<p>The file <b>'.$name.'</b> successfully uploaded</p>';
		}else {
			echo 'Something went wrong while uploading the file <b>'.$name.'</b>';
		}

	}else {
		foreach($errors as $error) {
			echo '<p>'.$error.'<p>';
		}
	}

}