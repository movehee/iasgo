<?
	$mode = "file_down";
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	if($kind=='booth_brochures'){
		
		$query = "select broc_file,stamp,booth_sid from booth_brochures where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		$files = $d['broc_file'];


		if($files){
			$link = $_Azure['link'].'upload/booth/'.$files;
		}
	}else if($kind=='company_brochures'){
		$files = $conn->getOne("select brochures from booth_company where booth_sid='$sid'");
		if($files){
			$link = $_Azure['link'].'upload/booth/'.$files;
		}

	}else if($kind=='faculty_cv'){
		$files = $conn->getOne("select faculty_cv from faculty_tbl where sid='$faculty_sid'");
		if($files){
			$link = $_Azure['link'].'upload/faculty_cv/'.$files;
		}
	}else if($kind=='faculty_abs'){
		$files = $conn->getOne("select faculty_abs from faculty_tbl where sid='$faculty_sid'");
		if($files){
			$link = $_Azure['link'].'upload/faculty_abs/'.$files;
		}
	}else if($kind=='detail_abs'){
		$files = $conn->getOne("select abs_file from workshop_session_detail_tbl where sid='$sid'");
		
		if($files){
			$link = $_Azure['link'].'upload/session/'.$files;
		}
	}else if($kind=='detail_cv'){
		$files = $conn->getOne("select cv_file from workshop_session_detail_tbl where sid='$sid'");
		
		if($files){
			$link = $_Azure['link'].'upload/session/'.$files;
		}
	}else if($kind=='room'){
		//$link = "https://webinar2cdnstorage.blob.core.windows.net/cdn/imkasid/Proceeding_IMKASID%202022_Final.pdf";
	}else if($kind=='program'){
		$link = "https://webinar2cdnstorage.blob.core.windows.net/cdn/ssbh/SSBH_2022_Program_Book.pdf";
	}else if($kind=='abstract'){
		$link = "https://webinar2cdnstorage.blob.core.windows.net/cdn/ssbh/SSBH_2022_Abstract_Book.pdf";
	}

	
	if(!$link){
		PutMessageClose("강의파일이 없습니다.");
	}
?>
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script style="text/javascript">
	$(function(){
		window.resizeTo(1200,950);
	});
</script>
<body style="margin:0px;padding:0px;">
<script>
setTimeout( function () {
	location.href="<?=$link?>";
}, 500);
</script>
</body>
