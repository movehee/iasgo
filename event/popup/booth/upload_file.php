<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	
	if($_FILES[$fname]['name']){

		$stat = "Y";

		$ext = explode(".",$_FILES[$fname]['name']);
		$len = sizeof($ext)-1;
		$extension = $ext[$len];

		$filename = $fname."_".time() . "." . $extension;
		$realfilename = $_FILES[$fname]['name'];
		
		//if($_SERVER['REMOTE_ADDR']!="112.76.194.32"){
		if(floor(filesize($_FILES[$fname]['tmp_name'])/1024)>55000){
			$stat = "O";
		}
		//}
		if(!copy($_FILES[$fname]['tmp_name'],$_SERVER['DOCUMENT_ROOT'] . "upload/booth/" . $filename)){
			//popup_msg("업로드가 정상적으로 되지 않았습니다.");
			//exit;
			$stat = "N";
		}
		$ex_fname = explode("_",$fname);
		$file_kind = $ex_fname[0];

		if($type=='broc'){
			$query = "update booth_brochures set";
			if($ex_fname[0]=='cover'){
				$query .= " cover_file='$filename'";
			}else if($ex_fname[0]=='broc'){
				$query .= " broc_file='$filename'";
			}
			$query .= " where sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
			  die($result->getMessage());
			}
		}else if($type=='movie'){
			$query = "update booth_movie set";
			$query .= " movie_file='$filename'";
			$query .= " where sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
			  die($result->getMessage());
			}	
		}else if($type=='logo_file' || $type=='booth_file' || $type=='front_file1' || $type=='front_file2' || $type=='front_file3' || $type=='front_file4' || $type=='booth_ground_file' || $type=='stamp_file' || $type=='booth_bottom_file'){
			$query = "update booth set";
			$query .= " $type='$filename'";
			$query .= " where sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
			  die($result->getMessage());
			}	
		}
		
	}
	$conn->disconnect();
?>
<script>
	setTimeout(function() {
		parent.flist_load('<?=$fname?>','<?=$sid?>','<?=$type?>','<?=$stat?>','<?=$file_kind?>');
	}, 500);
</script>