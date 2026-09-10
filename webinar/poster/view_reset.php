<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$query = "delete from e_poster_view_tbl";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	PutLocation("/poster/");
?>