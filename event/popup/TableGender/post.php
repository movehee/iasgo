<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";
	procAdminLoginChk();

	if(!$session){
		$code1 = $code_select;
		$place = $place_select;
	}
	
	$content = $_POST['mce_0'];
	

	$sch_tbl = "workshop_schedule_tbl";
	
	if($program1){
		$program1_arr = implode("|",$program1);
	}
	if($program2){
		$program2_arr = implode("|",$program2);
	}

	$case_path = $_SERVER['DOCUMENT_ROOT'].'upload/program/';
	$f_where = "";
	if($_FILES['program_file']){
		if(!is_dir($case_path)){ @mkdir($case_path, 0707); }
		if(is_uploaded_file($_FILES['program_file']['tmp_name'])){
			$realfile="logo_".date('YmdHis').'.'.rand(10, 10000).'.'.rand(1, 10).'.'.rand(1, 10);
			$filename=$_FILES['program_file']['name'];
	
			$ex=explode('.', $filename);
			$extension=strtolower($ex[sizeof($ex)-1]);
	
			$dstfile = $realfile.".".$extension;
			move_uploaded_file($_FILES['program_file']['tmp_name'], $case_path.$dstfile);
			
			$f_where .= ", program_file='".$dstfile."'";
			
		}else{
			if($program_filedel=='Y'){
				$f_where .= ", program_file=''";
			}
		}
	}

	
	
	$query = "update ".$sch_tbl." set content='$content', content2='$content2', content_position='$content_position', content2_position='$content2_position', session='$session', bg_color='$bg_color', font_color='$font_color'";
	$query .= ", code1='$ev_date', code2='$session_sid', code3='$code3', place='$place',w_size='$w_size',h_size='$h_size',bold='$bold',italic='$italic', radio='$radio', class_name='$class_name', linkurl='$linkurl',border_top='$border_top',border_bottom='$border_bottom',border_left='$border_left',border_right='$border_right' ";
	$query .= ", vertical_RL='$vertical_RL'";
	$query .= ", td_class='$td_class'";
	$query .= $f_where;
	$query .= " where sid='$sid'";

	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	
	include_once $_SERVER['DOCUMENT_ROOT']."program/html_create.php";

	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
?>