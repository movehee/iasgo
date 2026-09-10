<?
include "config.php";

echo "<center><br/>등록중 ... <br/><img src='/image/icon/icon_wait.gif'/></center>";

/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;
*/

##그룹 등록
foreach($_POST['chk_num'] as $tkey=>$tval)
{
	$data = explode("|||",$tval);

	$chk_qry = "select c_index from tp_addgrinfo where c_code='$addr_list' and c_id='$data[0]' and c_name='$data[1]' and c_email='$data[2]' ";
	//echo $chk_qry."<br/>";
	$chk_sid =$conn->getOne($chk_qry);
	
	if($chk_sid) continue;
	
	$query = "insert into tp_addgrinfo set c_code='$addr_list', c_id='$data[0]', c_name='$data[1]', c_email='$data[2]', c_phone='$data[3]', reg_dt=now() "; 
	
	//echo $query."<br/>";

	$result = $conn->query($query);
	if(DB::isError($result)) {
	   die($result->getMessage());
	}

}

PutMessageRefreshURL("주소록 추가가 완료 되었습니다.", "/admin/member/");
exit;

?>