<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.2220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=survey.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select t1.*,t2.first_name,t2.last_name,t2.name_kr,t2.email,t2.regist_kind from workshop_feedback_result as t1 inner join registration_tbl as t2 on t1.id=t2.id where t2.del='N' and t2.status='Y'" .$fsql;
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
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
	<thead>
		<tr>
			<th>No</th>
			<th>이름</th>
			<th>E-mail</th>
			<th>본 행사에 초청된 연자에 만족 하십니까?</th>
			<th>본 강의 내용이 실제 진료 및 연구에 얼마나 도움이 되셨습니까?</th>
			<th>강의 중 도움이 된 부분</th>
			<th>향후 행사에서 다루어졌으면 하는 토픽</th>
			<th>등록일</th>
		</tr>
	</thead>
	<?	
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
	<tr>
		<th><?=$n?></th>
		<td >
		<?
			if($d['regist_kind']=="Kor"){
				echo $d['name_kr'];
			}else{
				echo $d['first_name']." ".$d['last_name'];
			}
		?>
		</td>
		<td><?=$d['id']?></td>
		<td><?=$_SURVEY['answer'][$d['answer1']]?></td>
		<td><?=$_SURVEY['answer'][$d['answer2']]?></td>
		<td><?=$d['answer3']?></td>
		<td><?=$d['answer4']?></td>
		<td><?=date("Y.m.d H:i:s",$d['signdate'])?></td>
	</tr>
	<?
		$n++;
		}
	?>
</table>