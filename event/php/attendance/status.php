<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if(!empty($sid)){
	
        $query = "update attendance_tbl set status='2'";
        $query .= " where sid='".$sid."'";
        $result = mysqli_query($conn, $query);
		
        echo json_encode(array("sid" => $sid));
		
}else{
	  //최신 출석 이전에 데이터는 종료로 만들어준다.
	  $query = "update attendance_tbl set status='2' where code='".$code."' and del='N'";
	  mysqli_query($conn, $query);
	  	
      $result = mysqli_query($conn, "select max(orderby) maxs from attendance_tbl where code='".$code."' and del='N'");
      $row = mysqli_fetch_array($result);

      $max = $row['maxs'];

      $query = "INSERT INTO attendance_tbl SET ";
      $query .= "code='".$code."'";
      $query .= ",type='".$type."'";

      if(!empty($number)){
          $query .= ",number='".$number."'";
      }

      $query .= ",status='1'";
      $query .= ",orderby='".($max+1)."'";
      $query .= ",signdate='".time()."'";

      mysqli_query($conn, $query);
	  
	  $sid = mysqli_insert_id($conn);	
      echo json_encode(array("sid" => $sid));
}
?>
