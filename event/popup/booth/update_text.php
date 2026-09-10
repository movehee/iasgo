<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	if($kind=='broc'){
		$field_val = trim(urldecode($field_val));
		$query = "update booth_brochures set ".$field."='".$field_val."'";
		$query .= " where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='movie'){
		$field_val = trim(urldecode($field_val));
		$query = "update booth_movie set ".$field."='".$field_val."'";
		$query .= " where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	} else if($kind=='survey') {
		$field_val = trim(urldecode($field_val));
		$query = "update survey_tbl set ".$field."='".$field_val."'";
		$query .= " where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	} else if($kind=='w_notice') {
		$field_val = trim(urldecode($field_val));
		$query = "update w_notice_tbl set ".$field."='".$field_val."'";
		$query .= " where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}

	$conn->disconnect();
?>