<?php

function resizeP($width, $height, $nomeAnunciante){

	if(is_uploaded_file($_FILES['userImage']['tmp_name'])){
		$userImage = 'userImage';
	}

	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES[$userImage]['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	$path = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/'. md5($nomeAnunciante) .'_thumb_profile_'.$userImage.'.jpg';
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES[$userImage]['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);

	/* Save image */
	switch ($_FILES[$userImage]['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}

function resizeMain($width, $height, $nomeAnunciante){

	if(is_uploaded_file($_FILES['userImage1']['tmp_name'])){
		$userImage = 'userImage1';
	}elseif(is_uploaded_file($_FILES['userImage2']['tmp_name'])){
		$userImage = 'userImage2';
	}elseif(is_uploaded_file($_FILES['userImage3']['tmp_name'])){
		$userImage = 'userImage3';
	}elseif(is_uploaded_file($_FILES['userImage4']['tmp_name'])){
		$userImage = 'userImage4';
	}elseif(is_uploaded_file($_FILES['userImage5']['tmp_name'])){
		$userImage = 'userImage5';
	}

	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES[$userImage]['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	$path = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/'. md5($nomeAnunciante) .'_thumb_main_'.$userImage.'.jpg';
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES[$userImage]['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);

	/* Save image */
	switch ($_FILES[$userImage]['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}

function resize($width, $height, $nomeAnunciante){

	if(is_uploaded_file($_FILES['userImage1']['tmp_name'])){
		$userImage = 'userImage1';
	}elseif(is_uploaded_file($_FILES['userImage2']['tmp_name'])){
		$userImage = 'userImage2';
	}elseif(is_uploaded_file($_FILES['userImage3']['tmp_name'])){
		$userImage = 'userImage3';
	}elseif(is_uploaded_file($_FILES['userImage4']['tmp_name'])){
		$userImage = 'userImage4';
	}elseif(is_uploaded_file($_FILES['userImage5']['tmp_name'])){
		$userImage = 'userImage5';
	}

	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES[$userImage]['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	$path = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/'. md5($nomeAnunciante) .'_thumb_'.$userImage.'.jpg';
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES[$userImage]['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);

	/* Save image */
	switch ($_FILES[$userImage]['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}

function resize2($width, $height, $nomeAnunciante){

	if(is_uploaded_file($_FILES['userImage1']['tmp_name'])){
		$userImage = 'userImage1';
	}elseif(is_uploaded_file($_FILES['userImage2']['tmp_name'])){
		$userImage = 'userImage2';
	}elseif(is_uploaded_file($_FILES['userImage3']['tmp_name'])){
		$userImage = 'userImage3';
	}elseif(is_uploaded_file($_FILES['userImage4']['tmp_name'])){
		$userImage = 'userImage4';
	}elseif(is_uploaded_file($_FILES['userImage5']['tmp_name'])){
		$userImage = 'userImage5';
	}

	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES[$userImage]['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	$path = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/'. md5($nomeAnunciante) .'_thumb_'.$userImage.'.jpg';
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES[$userImage]['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);

	/* Save image */
	switch ($_FILES[$userImage]['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}

function resize3($width, $height, $nomeAnunciante){

	if(is_uploaded_file($_FILES['userImage1']['tmp_name'])){
		$userImage = 'userImage1';
	}elseif(is_uploaded_file($_FILES['userImage2']['tmp_name'])){
		$userImage = 'userImage2';
	}elseif(is_uploaded_file($_FILES['userImage3']['tmp_name'])){
		$userImage = 'userImage3';
	}elseif(is_uploaded_file($_FILES['userImage4']['tmp_name'])){
		$userImage = 'userImage4';
	}elseif(is_uploaded_file($_FILES['userImage5']['tmp_name'])){
		$userImage = 'userImage5';
	}

	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES[$userImage]['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	$path = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/'. md5($nomeAnunciante) .'_thumb_'.$userImage.'.jpg';
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES[$userImage]['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);

	/* Save image */
	switch ($_FILES[$userImage]['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}

function resize4($width, $height, $nomeAnunciante){

	if(is_uploaded_file($_FILES['userImage1']['tmp_name'])){
		$userImage = 'userImage1';
	}elseif(is_uploaded_file($_FILES['userImage2']['tmp_name'])){
		$userImage = 'userImage2';
	}elseif(is_uploaded_file($_FILES['userImage3']['tmp_name'])){
		$userImage = 'userImage3';
	}elseif(is_uploaded_file($_FILES['userImage4']['tmp_name'])){
		$userImage = 'userImage4';
	}elseif(is_uploaded_file($_FILES['userImage5']['tmp_name'])){
		$userImage = 'userImage5';
	}

	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES[$userImage]['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	$path = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/'. md5($nomeAnunciante) .'_thumb_'.$userImage.'.jpg';
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES[$userImage]['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);

	/* Save image */
	switch ($_FILES[$userImage]['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}

function resize5($width, $height, $nomeAnunciante){

	if(is_uploaded_file($_FILES['userImage1']['tmp_name'])){
		$userImage = 'userImage1';
	}elseif(is_uploaded_file($_FILES['userImage2']['tmp_name'])){
		$userImage = 'userImage2';
	}elseif(is_uploaded_file($_FILES['userImage3']['tmp_name'])){
		$userImage = 'userImage3';
	}elseif(is_uploaded_file($_FILES['userImage4']['tmp_name'])){
		$userImage = 'userImage4';
	}elseif(is_uploaded_file($_FILES['userImage5']['tmp_name'])){
		$userImage = 'userImage5';
	}

	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES[$userImage]['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	$path = '../img/uploads/'. md5($nomeAnunciante) .'/thumbs/'. md5($nomeAnunciante) .'_thumb_'.$userImage.'.jpg';
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES[$userImage]['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);

	/* Save image */
	switch ($_FILES[$userImage]['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}
?>