<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=booth_event.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "
    select a.num, b.* from 
    (select usid, count(distinct booth_sid) as num from booth_stamp where usid>0 group by usid) a 
    join registration_tbl b on a.usid=b.sid    
    ";


	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<thead>
		<tr>
			<th>No</th>
			<th>아이디</th>
			<th>이름</th>
			<th>연락처</th>
            <th>소속</th>
			<th>방문수</th>
		</tr>
	</thead>
	<?	
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

	?>
	<tr <?if(($n%2)==0){?>style="background:#F8F8F8;"<?}?>>
		<th><?=$n?></th>
		<td class="ac" ><?=$d['id']?></td>
        <td class="ac" ><?=$d['name_kr'] ? $d['name_kr'] : $d['name_eng']?></td>
        <td class="ac" ><?=$d['cell']?></td>
		
		<td class="ac" ><?=$d['aff_kor'] ? $d['aff_kor'] : $d['aff_eng']?></td>
		<td class="ac" ><?=$d['num']?></td>
	</tr>
<?$n++;}?>
</table>