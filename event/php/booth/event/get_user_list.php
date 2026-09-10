<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";

$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
$setting_result->free();


if($setting_col['booth_event_regist_type'] == '1') { //regist_tbl 사용
	
	$query = "select b.* from booth_event_tbl a join regist_tbl b on a.user_sid=b.sid 
		where a.code='".$code."' and a.booth_sid='".$booth_sid."' and b.code='".$code."'";
	$result = mysqli_query($conn, $query);

	
	if($setting_col['reg_name']){
		$temp_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_name']."' and del='N'";
		$temp_result = mysqli_query($conn, $temp_query);
		$temp_col = mysqli_fetch_array($temp_result);

	}

	if($setting_col['reg_office']){
		$temp2_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_office']."' and del='N'";
	}else{
		$temp2_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_office_en']."' and del='N'";
	}	
	$temp2_result = mysqli_query($conn, $temp2_query);
	$temp2_col = mysqli_fetch_array($temp2_result);



	if ($result) {
		while($row = mysqli_fetch_array($result)) {
		   $json[]=array(
				'name'=>$row['info'.$temp_col['info_orderby']],
				'office'=>$row['info'.$temp2_col['info_orderby']],
			);
		}
	}




} else if($setting_col['booth_event_regist_type'] == '2') { //login_tbl 사용 (이거 추가되면서 분기처리)

	$query = "select b.* from booth_event_tbl a join login_tbl b on a.user_sid=b.barcode 
		where a.code='".$code."' and a.booth_sid='".$booth_sid."' and b.code='".$code."'";
	$result = mysqli_query($conn, $query);

	if ($result) {
		while($row = mysqli_fetch_array($result)) {
		   $json[]=array(
				'name'=>$row['name'],
				'office'=>$row['office']
			);
		}
	}
}


echo json_encode($json);
?>