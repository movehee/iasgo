<?
	$im = new imagick('CV_2018_01.pdf[0]');
	$im->setImageFormat('jpg');
	header('Content-Type: image/jpeg');
	echo $im;
?>