<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Evaluation_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}

	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$query = "SELECT t2.etc_field2,name_kr,name_eng,email,aff_kor,aff_eng,cell,COUNT(t1.usid) AS Tcnt FROM session_evaluation_tbl AS t1 INNER JOIN ";
	$query .= " registration_tbl AS t2 ON t1.usid=t2.sid GROUP BY usid ORDER BY Tcnt desc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<style>
td{mso-number-format:\@;} 
</style>
<table border=1>
	<tr>
		<th>No</th>
		<th>등록번호</th>
		<th>이름(국문)</th>
		<th>이름(영문)</th>
		<th>이메일</th>	
		<th>소속(국문)</th>	
		<th>소속(영문)</th>	
		<th>연락처</th>
		<th>참여수</th>
	</tr>
<?	
	$pnum=1;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
?>
<tr>
	<td><?=$pnum?></td>
	<td><?=$d['etc_field2']?></td>
	<td><?=$d['name_kr']?></td>
	<td><?=$d['name_eng']?></td>
	<td><?=$d['email']?></td>
	<td><?=$d['aff_kor']?></td>
	<td><?=$d['aff_eng']?></td>
	<td><?=$d['cell']?></td>
	<td><?=$d['Tcnt']?></td>
</tr>

<?$pnum++;}?>
</table>