<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";

    for($i=1; $i<=56; $i++) {
        $in_query[] = "answer".$i." = '". $_POST["answer".$i] ."'";
    }

    for($i=1; $i<=9; $i++) {
        $in_query[] = "memo".$i." = '". addslashes($_POST["memo".$i]) ."'";
    }


    if($_POST['sid']) {

        $query = "update feedback_result_tbl set ";
        $query .= implode(",", $in_query);
        $query .= " where sid=".$_POST['sid'];


    } else {
        $query = "insert into feedback_result_tbl set usid='".$_COOKIE['wmember_sid']."',signdate=".time().",";
        $query .= implode(",", $in_query);
    }



    $result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	echo json_encode(array('push'=>"Y"));
	exit;