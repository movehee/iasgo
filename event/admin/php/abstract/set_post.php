<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from abstract_set_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);


for($i=1;$i<=4;$i++) {
	if(${"abs_top_menu_info".$i}) $abs_top_menu_info_val .= ${"abs_top_menu_info".$i}."|";
}

if($abs_top_menu_info_val) {
	$abs_top_menu_info_val = substr($abs_top_menu_info_val, 0, -1);
}

if($row['cnt']>0)
{
	$query = "update abstract_set_tbl SET ";
	$query .= " abstract_txt='".$_POST['abstract_txt']."'";
	$query .= ", abs_info1='".$_POST['abs_info1']."'";
	$query .= ", abs_info2='".$_POST['abs_info2']."'";
	$query .= ", abs_info3='".$_POST['abs_info3']."'";
	$query .= ", abs_info4='".$_POST['abs_info4']."'";
	$query .= ", abs_info5='".$_POST['abs_info5']."'";
	$query .= ", abs_info6='".$_POST['abs_info6']."'";
	$query .= ", abs_info7='".$_POST['abs_info7']."'";
	$query .= ", abs_info8='".$_POST['abs_info8']."'";
	$query .= ", abs_info9='".$_POST['abs_info9']."'";
	$query .= ", abs_info10='".$_POST['abs_info10']."'";
	$query .= ", abs_info11='".$_POST['abs_info11']."'";
	$query .= ", abs_info12='".$_POST['abs_info12']."'";
	$query .= ", abs_info13='".$_POST['abs_info13']."'";
	$query .= ", abs_info14='".$_POST['abs_info14']."'";
	$query .= ", abs_info15='".$_POST['abs_info15']."'";
	$query .= ", abs_info16='".$_POST['abs_info16']."'";

	$query .= ", abs_info1_chk='".$_POST['abs_info1_chk']."'";
	$query .= ", abs_info2_chk='".$_POST['abs_info2_chk']."'";
	$query .= ", abs_info3_chk='".$_POST['abs_info3_chk']."'";
	$query .= ", abs_info4_chk='".$_POST['abs_info4_chk']."'";
	$query .= ", abs_info5_chk='".$_POST['abs_info5_chk']."'";
	$query .= ", abs_info6_chk='".$_POST['abs_info6_chk']."'";
	$query .= ", abs_info7_chk='".$_POST['abs_info7_chk']."'";
	$query .= ", abs_info8_chk='".$_POST['abs_info8_chk']."'";
	$query .= ", abs_info9_chk='".$_POST['abs_info9_chk']."'";
	$query .= ", abs_info10_chk='".$_POST['abs_info10_chk']."'";
	$query .= ", abs_info11_chk='".$_POST['abs_info11_chk']."'";
	$query .= ", abs_info12_chk='".$_POST['abs_info12_chk']."'";
	$query .= ", abs_info13_chk='".$_POST['abs_info13_chk']."'";
	$query .= ", abs_info14_chk='".$_POST['abs_info14_chk']."'";
	$query .= ", abs_info15_chk='".$_POST['abs_info15_chk']."'";
	$query .= ", abs_info16_chk='".$_POST['abs_info16_chk']."'";

	$query .= ", abs_top_menu='".$_POST['abs_top_menu']."'";
	$query .= ", abs_top_menu_txt1='".$_POST['abs_top_menu_txt1']."'";
	$query .= ", abs_top_menu_txt2='".$_POST['abs_top_menu_txt2']."'";
	$query .= ", abs_top_menu_info='".$abs_top_menu_info_val."'";
	$query .= ", abs_align='".$_POST['abs_align']."'";
	$query .= ", abs_view_type='".$_POST['abs_view_type']."'";

		

	

	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO abstract_set_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ", abstract_txt='".$_POST['abstract_txt']."'";
	$query .= ", abs_info1='".$_POST['abs_info1']."'";
	$query .= ", abs_info2='".$_POST['abs_info2']."'";
	$query .= ", abs_info3='".$_POST['abs_info3']."'";
	$query .= ", abs_info4='".$_POST['abs_info4']."'";
	$query .= ", abs_info5='".$_POST['abs_info5']."'";
	$query .= ", abs_info6='".$_POST['abs_info6']."'";
	$query .= ", abs_info7='".$_POST['abs_info7']."'";
	$query .= ", abs_info8='".$_POST['abs_info8']."'";
	$query .= ", abs_info9='".$_POST['abs_info9']."'";
	$query .= ", abs_info10='".$_POST['abs_info10']."'";
	$query .= ", abs_info11='".$_POST['abs_info11']."'";
	$query .= ", abs_info12='".$_POST['abs_info12']."'";
	$query .= ", abs_info13='".$_POST['abs_info13']."'";
	$query .= ", abs_info14='".$_POST['abs_info14']."'";
	$query .= ", abs_info15='".$_POST['abs_info15']."'";
	$query .= ", abs_info16='".$_POST['abs_info16']."'";
	
	$query .= ", abs_info1_chk='".$_POST['abs_info1_chk']."'";
	$query .= ", abs_info2_chk='".$_POST['abs_info2_chk']."'";
	$query .= ", abs_info3_chk='".$_POST['abs_info3_chk']."'";
	$query .= ", abs_info4_chk='".$_POST['abs_info4_chk']."'";
	$query .= ", abs_info5_chk='".$_POST['abs_info5_chk']."'";
	$query .= ", abs_info6_chk='".$_POST['abs_info6_chk']."'";
	$query .= ", abs_info7_chk='".$_POST['abs_info7_chk']."'";
	$query .= ", abs_info8_chk='".$_POST['abs_info8_chk']."'";
	$query .= ", abs_info9_chk='".$_POST['abs_info9_chk']."'";
	$query .= ", abs_info10_chk='".$_POST['abs_info10_chk']."'";
	$query .= ", abs_info11_chk='".$_POST['abs_info11_chk']."'";
	$query .= ", abs_info12_chk='".$_POST['abs_info12_chk']."'";
	$query .= ", abs_info13_chk='".$_POST['abs_info13_chk']."'";
	$query .= ", abs_info14_chk='".$_POST['abs_info14_chk']."'";
	$query .= ", abs_info15_chk='".$_POST['abs_info15_chk']."'";
	$query .= ", abs_info16_chk='".$_POST['abs_info16_chk']."'";
	$query .= ", abs_top_menu='".$_POST['abs_top_menu']."'";
	$query .= ", abs_top_menu_txt1='".$_POST['abs_top_menu_txt1']."'";
	$query .= ", abs_top_menu_txt2='".$_POST['abs_top_menu_txt2']."'";
	$query .= ", abs_top_menu_info='".$abs_top_menu_info_val."'";
	$query .= ", abs_align='".$_POST['abs_align']."'";
	$query .= ", abs_view_type='".$_POST['abs_view_type']."'";

}
//echo $query;
mysqli_query($conn, $query);

?>
<script>
	opener.location.reload();
	window.close();
</script>