<?
	header('Content-Type: text/html; charset=UTF-8');
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	
	$code = "kses191130";
	
	/*
	$name = $_POST['name'];
	$license_number = $_POST['license_number'];
	*/
	
	if ( $isCheck == "true" ) { 
		//2. 이름이 중복되서 면허번호나 코드로 검사.
			$query = "SELECT * FROM regist_tbl where code = '$code' and info2='$license'";
			$result = mysqli_query($conn, $query);
			$rows = $result->num_rows;
		
			if ( $license == "kses1130" || $rows > 0) {
				echo  "Y";
			} else {
				echo "N";
			}
		
		} else {
			
			//1. 맨처음 이름으로만 검사.
			$query = "SELECT * FROM regist_tbl where code = '$code' and info1='$name'";
			$result = mysqli_query($conn, $query);
			$rows = $result->num_rows;
			
			if ( $rows == 1) {
				echo "Y";
			} else if ( $rows >= 2 ) {
				echo "면허번호 및 안내받은 코드를 입력해주세요.";
			} else {
				//매칭되는 데이터 없음.
				echo "N";
			}
		}
	
	
/*
	if($rows) {
	
		$row = mysqli_fetch_array($result);
	
		$param  = array(
			'regist_sid'=>$row['sid'],
			'name'=>$row['info1']
		);
		
	
		$login_query_in = "insert into login_tbl (code, deviceID, name, license_number, signdate) values ('$code', '$deviceid', '$name', '$license_number', '".time()."')";
		mysqli_query($conn, $login_query_in);
	
		$json  = array('rows'=>$rows, 'data'=>$param);
	
	}
	else {
	
		$json  = array('rows'=>$rows);
	}
*/
	
	
	//echo json_encode($json);
	
