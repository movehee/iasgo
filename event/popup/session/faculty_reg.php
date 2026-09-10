<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";
	include $_SERVER['DOCUMENT_ROOT'] . "func/func.thumb.php";
	procAdminLoginChk();

	$fac_path = $_SERVER['DOCUMENT_ROOT'].'upload/faculty/';
	$cv_path = $_SERVER['DOCUMENT_ROOT'].'upload/faculty_cv/';
	$abs_path = $_SERVER['DOCUMENT_ROOT'].'upload/faculty_abs/';
	

	$f_where = "";
	if($_FILES['photo_file']){
		if(!is_dir($fac_path)){ @mkdir($fac_path, 0707); }
		if(is_uploaded_file($_FILES['photo_file']['tmp_name'])){
			$realfile="faculty_".date('YmdHis').'.'.rand(10, 10000).'.'.rand(1, 10).'.'.rand(1, 10);
			$filename=$_FILES['photo_file']['name'];
	
			$ex=explode('.', $filename);
			$extension=strtolower($ex[sizeof($ex)-1]);
	
			$dstfile = $realfile.".".$extension;


			
			move_uploaded_file($_FILES['photo_file']['tmp_name'], $fac_path.$dstfile);

			$thumbfile = $_SERVER['DOCUMENT_ROOT'] . "/upload/faculty/thumb/" . $dstfile;
			thumbnail($_SERVER['DOCUMENT_ROOT'].'upload/faculty/'. $dstfile,$thumbfile, 300);
			
			$f_where .= ", faculty_photo='".$dstfile."'";
			
		}else{
			if($photo_filedel=='Y'){
				$f_where .= ", faculty_photo=''";
			}
		}
	}

	if($_FILES['cv_file']){
		if(!is_dir($cv_path)){ @mkdir($cv_path, 0707); }
		if(is_uploaded_file($_FILES['cv_file']['tmp_name'])){
			$realfile="cv_".date('YmdHis').'.'.rand(10, 10000).'.'.rand(1, 10).'.'.rand(1, 10);
			$filename=$_FILES['cv_file']['name'];
	
			$ex=explode('.', $filename);
			$extension=strtolower($ex[sizeof($ex)-1]);
	
			$dstfile = $realfile.".".$extension;
			move_uploaded_file($_FILES['cv_file']['tmp_name'], $cv_path.$dstfile);
			
			$f_where .= ", faculty_cv='".$dstfile."'";
			
		}else{
			if($cv_filedel=='Y'){
				$f_where .= ", faculty_cv=''";
			}
		}
	}

	if($_FILES['abs_file']){
		if(!is_dir($abs_path)){ @mkdir($abs_path, 0707); }
		if(is_uploaded_file($_FILES['abs_file']['tmp_name'])){
			$realfile="abs_".date('YmdHis').'.'.rand(10, 10000).'.'.rand(1, 10).'.'.rand(1, 10);
			$filename=$_FILES['abs_file']['name'];
	
			$ex=explode('.', $filename);
			$extension=strtolower($ex[sizeof($ex)-1]);
	
			$dstfile = $realfile.".".$extension;
			move_uploaded_file($_FILES['abs_file']['tmp_name'], $abs_path.$dstfile);
			
			$f_where .= ", faculty_abs='".$dstfile."'";
			
		}else{
			if($abs_filedel=='Y'){
				$f_where .= ", faculty_abs=''";
			}
		}
	}

	

	$query = "update faculty_tbl set faculty_name='$faculty_name'";
	$query .= ", faculty_aff='$faculty_aff'";
	$query .= ", faculty_info='$faculty_info'";
	$query .= ", faculty_country='$faculty_country'";
	$query .= ", faculty_none='$faculty_none'";
	
	$query .= $f_where;
	$query .= " where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	$conn->disconnect();
	PutMessageCloseOpenerReload("수정되었습니다.");
?>