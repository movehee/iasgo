<?php
header("Content-Type: text/html; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."/lib.php";
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

#!! IMPORTANT: 
#!! this file is just an example, it doesn't incorporate any security checks and 
#!! is not recommended to be used in production environment as it is. Be sure to 
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* 
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	exit; // finish preflight CORS requests here
}
*/

// 5 minutes execution time
@set_time_limit(0);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
$targetDir = $_SERVER['DOCUMENT_ROOT']."/upload/e_poster/";
//$targetDir = 'uploads';
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 1 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
	@mkdir($targetDir);
}


$fileNameWithoutExt = substr($_FILES["file"]["name"], 0, strrpos($_FILES["file"]["name"], "."));
if(!$poster_sid){
	$poster_sid = $conn->getOne("select sid from e_poster where poster_number='".$fileNameWithoutExt."' or code='".$fileNameWithoutExt."'");
}
// Get a file name
if (isset($_REQUEST["name"])) {
	$ori_filename = $_REQUEST["name"];
	$ext = substr(strrchr($_REQUEST["name"], '.'), 1);
	$fileName = $poster_sid."_".rand(1,99999)."_".time().".".$ext;
} elseif (!empty($_FILES)) {
	$ori_filename = $_FILES["file"]["name"];
	$fileName = $poster_sid."_".rand(1,99999)."_".$_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

$ex=explode('.', $fileName);
$extension=strtolower($ex[sizeof($ex)-1]);

$only_name = str_replace(".".$extension,"",$ori_filename);
$ex_fnames = explode("_",$only_name);

$query = "insert into e_poster_file set filename='$fileName', realfile='$ori_filename', psid='$poster_sid'";
$result = $conn->query($query);
if(!$result) {die($conn->error);}


//var_dump($targetDir);
// Remove old temp files	
if ($cleanupTargetDir) {
	
	
	
	if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	}

	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR .$file;
		
		

		// If temp file is current file proceed to the next
		if ($tmpfilePath == "{$filePath}.part") {
			continue;
		}

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}	


$fileName="{$filePath}.part";
// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "${fileName}"}');
}


if (!empty($_FILES)) {
	if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "${fileName}"}');
	}

	// Read binary input stream and append it to temp file
	if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "${fileName}"}');
	}
} else {	
	if (!$in = @fopen("php://input", "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "${fileName}"}');
	}
}

while ($buff = fread($in, 4096)) {
	fwrite($out, $buff);
}


@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off 
	rename("{$filePath}.part", $filePath);
}
 
// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "${fileName}"');
