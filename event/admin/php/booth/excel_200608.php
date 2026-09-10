<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$query="SELECT * FROM booth_event_tbl a, regist_tbl b where a.user_sid=b.sid and a.code='".$code."' and b.code='".$code."' and a.booth_sid='".$sid."'";
echo $query;
$result = mysqli_query($conn, $query);

if($excel_type!='view') {

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=".$code."_".$sid.".xls"); 
header( "Content-Description: PHP4 Generated Data" ); 

}


if($code == "koa2019f") {
	$query="SELECT * FROM booth_event_tbl a where a.code='".$code."' and a.booth_sid='".$sid."'";
	$result = mysqli_query($conn, $query);

}
else {


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


}
?>


<table class="tblList">
	<tr>
		<td>Name</td>
		<td>Office</td>
	</tr>

	<?if($code == "koa2019f"){
	
		$hostName = "121.254.129.98";
		$userName = "koa2016";
		$userPassword = "koa2016!@#";
		$dbName = "koa2019";

		##### 데이터베이스에 연결한다.
		if(!class_exists("DB")) {
		   include "DB.php";
		}

		##### 데이터베이스에 연결한다.
		$dsn = "mysql://$userName:$userPassword@$hostName/$dbName";
		$local_conn = DB::connect($dsn);
		if(DB::isError($local_conn)) {
		   die ($local_conn->getMessage());
		}
		$local_conn->query("set names utf8");

		unset($dsn);




	?>
		<?while(is_array($d = mysqli_fetch_array($result))){
		
			$query = "SELECT * from prepare_tbl where sid='$d[user_sid]' ";
			$pre_result=$local_conn->query($query);
			if(DB::isError($pre_result)) die($pre_result->getMessage());
			$pre_result->fetchInto(&$pre, DB_FETCHMODE_ASSOC);
			$pre_result->free();
			
		?>
			<tr>
				<td>
					<?=$pre['name']?>
				</td>
				<td>
					<?=$pre['hname']?>
				</td>
			</tr>

		<?}?>
	<?}else{?>

	

	<?while(is_array($d = mysqli_fetch_array($result))){?>
		<tr>
			<td>
				<?=$d['info'.$temp_col['info_orderby']]?>
			</td>
			<td>
				<?=$d['info'.$temp2_col['info_orderby']]?>
			</td>
		</tr>

	<?}?>

	<?}?>
</table>
   

<?include "./../footer.php";?>