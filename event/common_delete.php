<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	if(!$kind){
		echo "N";
		exit;
	}
	if($kind=="registration"){
		$sid = (int)$sid;
		$oldRow = regLogSnapshot($sid, array('del'));
		$query = "update registration_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		$oldDel = isset($oldRow['del']) ? $oldRow['del'] : '';
		regLogWrite($sid, 'delete', 'delete', array(
			'del' => array($oldDel, 'Y')
		));
	}else if($kind=='w_notice'){
		$query = "update w_notice_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=='sessions'){
		$query = "update workshop_session_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=='video'){
		$query = "update video_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=='brochure'){
		$query = "update brochure_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=='question'){
		$query = "update question_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="booth_grade"){
		$query = "update booth_grade set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}

		$query = "update booth set del='Y' where booth_sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="booth"){
		$query = "update booth set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="poster_category"){
		$query = "update e_poster_category set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}

		$query = "update e_poster_category set del='Y' where psid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="poster_category_sub"){
		$query = "update e_poster_category set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="broc"){
		$query = "delete from booth_brochures where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="movie"){
		$query = "delete from booth_movie where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="survey"){
		$query = "delete from survey_tbl where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="broc_file"){
		
		$query = "update booth_brochures set ";
		if($type=='cover'){
			$query .= " cover_file=''";
		}else if($type=='broc'){
			$query .= " broc_file=''";
		}
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}	
	}else if($kind=="movie_file"){
		
		$query = "update booth_movie set ";
		$query .= " movie_file=''";
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}	
	}else if($kind=="booth_image"){
		
		$query = "update booth set ";
		$query .= " $type=''";
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}	
	}else if($kind=="e_poster"){
		
		$query = "update e_poster set del='Y'";
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}	
	}else if($kind=="e_poster_file"){
		$query = "delete from e_poster_file where psid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="session_detail"){
		$query = "update workshop_session_detail_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="cv_file"){
		$query = "update e_poster set cv_file='' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="tech"){
		$query = "update technical_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="session_category"){
		$query = "update workshop_session_category set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="program_copy"){
		$query = "delete from workshop_schedule_tbl_copy where backup_time='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="voting_day"){
		$query = "delete from event_tbl where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="voting_lecture"){
		$query = "update lecture_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="voting_list"){
		$query = "update voting_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="feedback"){
		$query = "update feedback_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}

		$query = "update feedback_tbl set sort_num=sort_num-1 where sid>$sid";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="exam"){
		$query = "update exam_tbl set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="faculty_detail"){
		$query = "delete from faculty_matching where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="faculty_all"){
		$query = "delete from faculty_tbl";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}

		$query = "delete from faculty_matching";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=='faculty_category'){
		$query = "update faculty_category set del='Y' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}

		$query = "update faculty_category set del='Y' where psid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="checkin_ind"){
		$query = "delete from checkin_tbl_ind where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="faculty"){
		$query = "delete from faculty_tbl where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="gift"){
		$query = "delete from gift_tbl where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}

	

	echo "Y";
?>