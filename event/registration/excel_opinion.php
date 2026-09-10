<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Registration_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and opinion is not null and opinion!=''";
	}else{
		$fsql = " where del='N'  and opinion is not null and opinion!=''";
	}

	$query = "select * from registration_tbl " . $fsql;
	$query .= "   order by sid desc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<tr>
		<th>No</th>
		<th>등록구분</th>
		<th>회원구분</th>
		<th>전문과목</th>
		<th>ID</th>
		<th>성명</th>
		<th>비밀번호</th>
		<th>면허번호</th>	
		<th>의견</th>
		
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$_REG['class_kind'][$d['classification']]?></td>
		<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
		<td><?=$_REG['gubun1'][$d['gubun1']]?></td>
		<td><?=$d['id']?></td>
		<td><?=$d['name_kr']?></td>
		<td><?=$d['passwd']?></td>
		<td><?=$d['license_number']?></td>
		<td class="al"><?=nl2br($d['opinion'])?></td>
	</tr>
	<?$n++;?>
	<?}?>
</table>