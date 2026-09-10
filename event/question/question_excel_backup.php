<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225' && $_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Question_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	procAdminLoginChk();
	
	// $query = "select t1.*,t2.cell,t2.license_number,t2.email from question_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.day='$ev_date' order by t1.signdate desc"; //t1.del='N' and 
	$query = "select * from question_tbl as t1 where t1.day='$ev_date' order by t1.signdate desc";
	$query .= $sort_sql; //and t1.room='$room' 
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<tr>
		<th>No</th>
		<th>Room</th>
		<th>이름</th>
		<th>면허번호</th>
		<th>이메일</th>
		<th>연락처</th>
		<th>질문 시간</th>
		<th>Session</th>
		<th>질문내용</th>
		<th>답변완료</th>
	</tr>
	<?
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

			unset($license_number);
			unset($name);
			if($d['usid']) {
				$result_user = $conn->query("select * from registration_tbl where sid=".$d['usid']);
				$result_user->fetchInto(&$user, DB_FETCHMODE_ASSOC);
				$result_user->free();

				$name = $d['name'];
				$license_number = $user['license_number'];
			} else {
				$name = "현장";
			}
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$d['room']?></td>
		<td><?=$name?></td>
		<td><?=$license_number?></td>
		<td><?=$d['email']?></td>
		<td ><?=$d['cell']?></td>
		<td><?if($d['signdate']){?><?=date("m.d H:i",$d['signdate'])?><?}?></td>
		<td ><?
				echo "<b>".strip_tags($d['session'])."</b>";
				if($d['session_detail']){
					echo "<div style='font-size:12px;padding-left:10px;'>".strip_tags($d['session_detail']).'</div>';
				}
			?></td>
		<td ><?=nl2br($d['question'])?></td>
		<td ><?=$d['answer_ok']?></td>
	</tr>
	<?$n++;?>
	<?}?>
</table>