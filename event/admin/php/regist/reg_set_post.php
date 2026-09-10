<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$result = mysqli_query($conn, "select count(*) cnt from session_set_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);

$cnt = $row['cnt'];

$pre_regist_sdates = explode("-",$_POST['pre_regist_sdate']);
$pre_regist_edates = explode("-",$_POST['pre_regist_edate']);


if($cnt>0)
{
	$query = "update session_set_tbl SET ";
	$query .= " reg_money='".$_POST['reg_money']."'";
	$query .= ", reg_money_gubun='".$_POST['reg_money_gubun']."'";
	$query .= ", reg_name='".$_POST['reg_name']."'";
	$query .= ", reg_name_en='".$_POST['reg_name_en']."'";
	$query .= ", reg_office='".$_POST['reg_office']."'";
	$query .= ", reg_office_en='".$_POST['reg_office_en']."'";
	$query .= ", reg_vip='".$_POST['reg_vip']."'";
	$query .= ", reg_hp='".$_POST['reg_hp']."'";
	$query .= ", reg_license='".$_POST['reg_license']."'";
	$query .= ", reg_mem_gubun='".$_POST['reg_mem_gubun']."'";
	$query .= ", reg_office_post='".$_POST['reg_office_post']."'";	
	$query .= ", regist_top_text='".$_POST['regist_top_text']."'";
	$query .= ", regist_alert_message='".$_POST['regist_alert_message']."'";
	


	$query .= ", pre_regist_sdate='".mktime(0, 0, 0, $pre_regist_sdates[1], $pre_regist_sdates[2], $pre_regist_sdates[0])."'";
	$query .= ", pre_regist_edate='".mktime(23, 59, 59, $pre_regist_edates[1], $pre_regist_edates[2], $pre_regist_edates[0])."'";
	$query .= ", regist_money_type1='".$_POST['regist_money_type1']."'";
	$query .= ", regist_money_type2='".$_POST['regist_money_type2']."'";
	$query .= ", regist_money_type3='".$_POST['regist_money_type3']."'";
	
	$query .= " where code='".$code."'";
}
else
{
	$query = "INSERT INTO session_set_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ", reg_money='".$_POST['reg_money']."'";
	$query .= ", reg_money_gubun='".$_POST['reg_money_gubun']."'";
	$query .= ", reg_name='".$_POST['reg_name']."'";
	$query .= ", reg_name_en='".$_POST['reg_name_en']."'";
	$query .= ", reg_office='".$_POST['reg_office']."'";
	$query .= ", reg_office_en='".$_POST['reg_office_en']."'";
	$query .= ", reg_vip='".$_POST['reg_vip']."'";
	$query .= ", reg_hp='".$_POST['reg_hp']."'";
	$query .= ", reg_license='".$_POST['reg_license']."'";
	$query .= ", reg_mem_gubun='".$_POST['reg_mem_gubun']."'";
	$query .= ", reg_office_post='".$_POST['reg_office_post']."'";
	$query .= ", regist_top_text='".$_POST['regist_top_text']."'";
	$query .= ", regist_alert_message='".$_POST['regist_alert_message']."'";
	
	$query .= ", pre_regist_sdate='".mktime(0, 0, 0, $pre_regist_sdates[1], $pre_regist_sdates[2], $pre_regist_sdates[0])."'";
	$query .= ", pre_regist_edate='".mktime(23, 59, 59, $pre_regist_edates[1], $pre_regist_edates[2], $pre_regist_edates[0])."'";
	$query .= ", regist_money_type1='".$_POST['regist_money_type1']."'";
	$query .= ", regist_money_type2='".$_POST['regist_money_type2']."'";
	$query .= ", regist_money_type3='".$_POST['regist_money_type3']."'";

}
mysqli_query($conn, $query);
?>

<script>
	opener.location.reload();
	window.close();
</script>
