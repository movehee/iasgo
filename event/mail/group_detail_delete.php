<?
include "config.php";
?>
<?
	procAdminLoginChk();
	
	$search_url ="&search_key=${search_key}&search_value=${search_value}";
	
	
	$query = "delete from tp_addgrinfo where c_index='${del_c_index}'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	   die($result->getMessage());
	}	
	PutMessageLocation("정상 삭제되었습니다.","/admin/mail/group_detail_list.php?page=${page}${search_url}&c_index=${gr_c_index}");
?>