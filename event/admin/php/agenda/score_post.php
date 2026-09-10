<?php
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

for($i=0; $i<$max_col; $i++) {
	
	$query = "";
	if($sid[$i]) {

		if($time[$i] && $score[$i]) {
			$query = "update score_set_tbl set time='".$time[$i]."',score='".$score[$i]."',ine='".$ine[$i]."' where sid='".$sid[$i]."'";

		} else {

			$query = "update score_set_tbl set del='Y' where sid='".$sid[$i]."'";
		}


	}
	else {
		if($time[$i] && $score[$i]) {
			$query = "insert into score_set_tbl set code='".$code."', agenda_sid='".$agenda_sid."', time='".$time[$i]."',score='".$score[$i]."',ine='".$ine[$i]."'";
		}
	}

	if($query) {
		$conn->query($query);
	}

}
?>
<script>
	opener.location.reload();
	window.close();
</script>