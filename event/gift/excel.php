<?
	header("Content-Type: text/html; charset=UTF-8");
	if($_SERVER['REMOTE_ADDR']!='218.235.94.2s220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Gift_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
?>
<table class="tblDef" border=1>
	<colgroup>
		<col style="width: 20%;" />
		<col style="width: 6%;" />
		<col style="width: " />
	</colgroup>
	<thead>
		<tr>
			<th>성명</th>
			<th>면허번호</th>
			<th>소속</th>
			<th>이메일</th>
			<th>연락처</th>
			<th>상품명</th>
			<th >당첨일</th>
		</tr>
		
	</thead>
	<tbody>
		<?
			$query = "select t2.*,t1.gift,t1.signdate as gift_date from gift_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t2.del='N' and t1.gift!='N'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());

			while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
		?>
		<tr>
			<td><?=$d['name_kr']?></td>
			<td><?=$d['license_number']?></td>
			<td><?=$d['aff_kor']?></td>
			<td><?=$d['email']?></td>
			<td><?=$d['cell']?></td>
			<td><?=$_Gift['gift_'.$d['country']][$d['gift']]['title']?></td>
			<td><?=date("Y.m.d H:i:s",$d['gift_date'])?></td>
		</tr>
		<?}?>
		
	</tbody>
</table>