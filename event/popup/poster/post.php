<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();
	

	$author = $_POST['mce_0'];
	$co_author = $_POST['mce_2'];

	if($sid) {
		$query = "update e_poster set category='$category'";
		$query .= ", category_sub='$category_sub'";
		$query .= ", poster_number='$poster_number'";
		$query .= ", subject='".addslashes($subject)."'";
		$query .= ", email='$email'";
		$query .= ", co_author='$co_author'";
		$query .= ", movie='$movie'";
		$query .= ", award='$award'";
		$query .= ", author='$author'";
		$query .= ", co_author='$co_author'";
		$query .= ", affiliation='$affiliation'";

		$query .= ", code='$code'";
		$query .= ", presenter='$presenter'";
		$query .= ", presenter_aff='$presenter_aff'";
		$query .= ", presenter_email='$presenter_email'";
		for($i=1;$i<=6;$i++){
			$query .= ", author".$i."='".${'author'.$i}."'";
			$query .= ", author_aff".$i."='".${'author_aff'.$i}."'";
			$query .= ", position".$i."='".${'position'.$i}."'";
		}
		$query .= ", invited='$invited'";

		$query .= " where sid = $sid";
		
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}

	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");

?>