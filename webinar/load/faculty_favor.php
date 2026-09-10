<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
    $chking = $conn->getOne("select count(*) from faculty_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and faculty_sid='$faculty_sid'");
    if($chking>0){
        $query = "delete from faculty_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and faculty_sid='$faculty_sid'";
        $result = $conn->query($query);
        if(DB::isError($result)) {
            die($result->getMessage());
        }
    
        $conn->disconnect();
    }else{
        $query = "insert into faculty_favor_tbl set usid='".$_COOKIE['wmember_sid']."'";
        $query .= ", faculty_sid='$faculty_sid'";
        $result = $conn->query($query);
        if(DB::isError($result)) {
            die($result->getMessage());
        }
        $conn->disconnect();
    }


?>