<?
	include "config.php";
	
	procAdminLoginChk();
	
	$search_url ="&search_key=${search_key}&search_value=${search_value}";	

	//그룹 테이블에 있는 항목을 지운다.
	$query = "delete from tp_addgrcode where c_index='${c_index}'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	   die($result->getMessage());
	}	
	
	//주소록에 포함된 회원들을 지운다.
	$query = "delete from tp_addgrinfo where c_code='${c_index}'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	   die($result->getMessage());
	}	
		
	PutMessageLocation("정상 삭제되었습니다.","/admin/mail/group_list.php?page=${page}${search_url}");
?>