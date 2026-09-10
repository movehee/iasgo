<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=booth_stamp_All.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select * from booth where del='N'";
	$query .= " order by booth_sid asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<thead>
		<tr>
			<th>No</th>
			<th>부스명</th>
			<th>아이디</th>
			<th>이름</th>
			<th>면허번호</th>
			<th>소속</th>
			<th>이메일</th>
			<th>연락처</th>
			<th>참여일</th>
		</tr>
	</thead>
	<?	
		$bnum=1;
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

			$query2 = "select t1.*,t2.id,t2.name_kr,t2.license_number,t2.aff_kor,t2.email,t2.cell from booth_stamp as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.booth_sid='$d[sid]' order by t1.signdate desc";
			$result2=$conn->query($query2);
			if(DB::isError($result2)) die($result2->getMessage());
			while(is_array($col=$result2->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
	<tr <?if(($bnum%2)==0){?>style="background:#F8F8F8;"<?}?>>
		<th><?=$n?></th>
		<th><?=$d['title']?></th>
		<td class="ac" ><?=$col['id']?></td>
		<td class="ac" ><?=$col['name_kr']?></td>
		<td class="ac" ><?=$col['license_number']?></td>
		<td class="ac" ><?=$col['aff_kor']?></td>
		<td class="ac" ><?=$col['email']?></td>
		<td class="ac" ><?=$col['cell']?></td>
		<td class="ac" ><?=date("Y.m.d H:i:s",$col['signdate'])?></td>
	</tr>
	<?
	$n++;
		}
	?>
<?$bnum++;}?>
</table>