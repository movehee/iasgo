<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=booth_stamp.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 백업 </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
br {mso-data-placement:same-cell;}
.xl24
	{mso-style-parent tyle0;
	mso-number-format:"\@";}
</style> 


</HEAD>
<table border=1>
	<colgroup>
		<col style="width: 7%;">
		<col style="width: ;">
		<col style="width: 15%;">
		<col style="width: 25%;">
		<col style="width: 12%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>아이디</th>
			<th>이름</th>
			<th>면허번호</th>
			<th>참여일</th>
		</tr>
	</thead>
	<tbody id="product">
		<?
			$query = "select t1.*,t2.id,t2.name_kr,t2.name_eng,t2.license_number,t2.email from booth_stamp as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.booth_sid='$sid' and t2.member_level!='M' order by t1.signdate desc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			$n=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td><?=$n?></td>
			<td class="ac" ><?=$d['id']?></td>
			<td class="ac" ><?=$d['name_eng']?></td>
			<td class="ac" ><?=$d['license_number']?></td>
			<td class="ac" ><?=date("Y.m.d H:i:s",$d['signdate'])?></td>
		</tr>
		<?$n++;}?>
	</tbody>
</table>