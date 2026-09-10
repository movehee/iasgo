<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if($excel_type!='view') {

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=".$code."_".$sid.".xls"); 
header( "Content-Description: PHP4 Generated Data" ); 

}



$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

if($setting_col['booth_event_regist_type'] == '1') { //regist_tbl 사용
	$query="SELECT * FROM booth_event_tbl a, regist_tbl b where a.user_sid=b.sid and a.code='".$code."' and b.code='".$code."' and a.booth_sid='".$sid."'";

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

} else if($setting_col['booth_event_regist_type'] == '2') { //login_tbl 사용
	$query="SELECT * FROM booth_event_tbl a, login_tbl b where a.user_sid=b.barcode and a.code='".$code."' and b.code='".$code."' and a.booth_sid='".$sid."'";
}
echo $query;
$result = mysqli_query($conn, $query);
?>


<table class="tblList">
	<tr>
		<td>Name</td>
		<td>Office</td>
	</tr>

		

	<?while(is_array($d = mysqli_fetch_array($result))){ ?>
		<?if($setting_col['booth_event_regist_type'] == '1') {?>
		<tr>
			<td>
				<?=$d['info'.$temp_col['info_orderby']]?>
			</td>
			<td>
				<?=$d['info'.$temp2_col['info_orderby']]?>
			</td>
		</tr>
		<?} else if($setting_col['booth_event_regist_type'] == '2'){?>
		<tr>
			<td>
				<?=$d['name']?>
			</td>
			<td>
				<?=$d['office']?>
			</td>
		</tr>
		<?}?>

	<?}?>
</table>
   

<?include "./../footer.php";?>