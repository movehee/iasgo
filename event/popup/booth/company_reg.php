<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$case_path = $_SERVER['DOCUMENT_ROOT'].'upload/booth/';
	$f_where = "";
	if($_FILES['logo_file']){
		if(!is_dir($case_path)){ @mkdir($case_path, 0707); }
		if(is_uploaded_file($_FILES['logo_file']['tmp_name'])){
			$realfile="logo_".date('YmdHis').'.'.rand(10, 10000).'.'.rand(1, 10).'.'.rand(1, 10);
			$filename=$_FILES['logo_file']['name'];
	
			$ex=explode('.', $filename);
			$extension=strtolower($ex[sizeof($ex)-1]);
	
			$dstfile = $realfile.".".$extension;
			move_uploaded_file($_FILES['logo_file']['tmp_name'], $case_path.$dstfile);
			
			$f_where .= ", logo_file='".$dstfile."'";
			
		}
	}
	if($_FILES['card_file']){
		if(!is_dir($case_path)){ @mkdir($case_path, 0707); }
		if(is_uploaded_file($_FILES['card_file']['tmp_name'])){
			$realfile="card_".date('YmdHis').'.'.rand(10, 10000).'.'.rand(1, 10).'.'.rand(1, 10);
			$filename=$_FILES['card_file']['name'];
	
			$ex=explode('.', $filename);
			$extension=strtolower($ex[sizeof($ex)-1]);
	
			$dstfile = $realfile.".".$extension;
			move_uploaded_file($_FILES['card_file']['tmp_name'], $case_path.$dstfile);
			
			$f_where .= ", card_file='".$dstfile."'";
			
		}
	}
	if($_FILES['brochures']){
		if(!is_dir($case_path)){ @mkdir($case_path, 0707); }
		if(is_uploaded_file($_FILES['brochures']['tmp_name'])){
			$realfile="brochures_".date('YmdHis').'.'.rand(10, 10000).'.'.rand(1, 10).'.'.rand(1, 10);
			$filename=$_FILES['brochures']['name'];
	
			$ex=explode('.', $filename);
			$extension=strtolower($ex[sizeof($ex)-1]);
	
			$dstfile = $realfile.".".$extension;
			move_uploaded_file($_FILES['brochures']['tmp_name'], $case_path.$dstfile);
			
			$f_where .= ", brochures='".$dstfile."'";
			
		}
	}

	
	
	$common_query = " content='$content'";
	$common_query .= ", name_kr='$name_kr'";
	$common_query .= ", cell='$cell'";
	$common_query .= ", tel='$tel'";
	$common_query .= ", fax='$fax'";
	$common_query .= ", department='$department'";
	$common_query .= ", address='$address'";
	$common_query .= ", homepage='$homepage'";
	$common_query .= ", email='$email'";
	$common_query .= ", facebook='$facebook'";
	$common_query .= ", blog='$blog'";
	$common_query .= ", linkedin='$linkedin'";
	$common_query .= ", youtube='$youtube'";
	$common_query .= ", instagram='$instagram'";
	$common_query .= ", booth_link='$booth_link'";
	$common_query .= ", vod_link='$vod_link'";
	$common_query .= ", vod_stamp='$vod_stamp'";
	$common_query .= $f_where;

	if($sid){
		$query = "update booth_company set " .$common_query;
		$query .= " where booth_sid='$booth_sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{
		$query = "insert into booth_company set " .$common_query;
		$query .= ", booth_sid='$booth_sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	OpenerReload_location("등록되었습니다.","company.php?sid=".$booth_sid."&mode=view");
?>