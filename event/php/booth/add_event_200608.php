<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

if($barcode){
	$user_sid = $barcode;
}

if($booth_id){
	$query="SELECT * FROM booth_tbl where sid='".$booth_id."' and code='".$code."' and event_YN='Y' and del='N'";
	$result = mysqli_query($conn, $query);
	$booth_col = mysqli_fetch_array($result);
	$booth_sid = $booth_col['sid'];
}

if($user_sid){

	if($setting_col['booth_event_regist_type'] == '1') { //regist_tbl 사용

		$query="SELECT * FROM regist_tbl where sid='".$user_sid."' and code='".$code."' and del='N'";
		$result = mysqli_query($conn, $query);
		$user_col = mysqli_fetch_array($result);

		
		if($setting_col['reg_name']){
			$temp_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_name']."' and del='N'";
		}else{
			//$temp_query="SELECT * FROM regist_type_tbl where sid='".$setting_col['reg_name']."' and del='N'";
		}

		$temp_result = mysqli_query($conn, $temp_query);
		$temp_col = mysqli_fetch_array($temp_result);


		if($setting_col['reg_office']){
			$temp2_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_office']."' and del='N'";
		}else{
			$temp2_query="SELECT * FROM regist_set_tbl where sid='".$setting_col['reg_office_en']."' and del='N'";
		}	
		$temp2_result = mysqli_query($conn, $temp2_query);
		$temp2_col = mysqli_fetch_array($temp2_result);

		$regist_name = $user_col['info'.$temp_col['info_orderby']];
		$regist_office = $user_col['info'.$temp2_col['info_orderby']];



	} else if($setting_col['booth_event_regist_type'] == '2') { //login_tbl 사용 (이거 추가되면서 분기처리)

		$temp_query="SELECT * FROM login_tbl where barcode='".$user_sid."'";
		$temp_result = mysqli_query($conn, $temp_query);
		$temp_col = mysqli_fetch_array($temp_result);

		$regist_name = $temp_col['name'];
		$regist_office = $temp_col['office'];
	}



	
}

$query = "INSERT INTO booth_event_tbl SET ";
$query .= "code='".$code."'";
$query .= ",booth_sid='".$booth_sid."'";
$query .= ",user_sid='".$user_sid."'";
$query .= ",signdate='".time()."'";

mysqli_query($conn, $query);


$json=array(
	'image'=>$booth_col['image'],
	'name'=>$regist_name,
	'office'=>$regist_office
);
echo json_encode($json);


?>