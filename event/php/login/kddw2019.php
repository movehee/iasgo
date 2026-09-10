<?
	
	header('Content-Type: text/html; charset=UTF-8');
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	
	$code = "kddw2019";
	
	$query = "select * from login_tbl where code='$code' and name='$name' ";
	$result = mysqli_query($conn, $query);
	$sid = "";
	$isLogin = true;
	if($result->num_rows) {
		
			$row = mysqli_fetch_array($result);
			$sid = $row['sid'];

	} else {
			$query = "insert into login_tbl (name, deviceid, code, signdate) values ('$name', '$deviceid', '$code', '".time()."')";
			$result = mysqli_query($conn, $query);
			if ( $result ) {
					$sid = (String)mysqli_insert_id($conn);
					$isLogin = false;
			}

	}
	
	$param  = array(
				'duplication'=>$isLogin,
				'regist_sid'=>$sid,
				'name'=>$name,
			);

			
	echo json_encode($param);