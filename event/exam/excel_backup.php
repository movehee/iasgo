<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=exam_".date("Ymd").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select t1.*,t2.name_kr,t2.id,t2.email,t2.reg_kind,t2.gubun1,t2.gubun2,t2.license_number from exam_result_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t2.del='N' " .$fsql;
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
			<th>회원구분</th>
			<th><?=$_REG['gubun1_title']?></th>
			<th><?=$_REG['gubun2_title']?></th>
			<th>이름</th>
			<th>면허번호</th>
			<th>E-mail</th>
			<th>문제수/정답수</th>
			<th>점수</th>
			<th>합격여부</th>
			<th>제출일</th>
		</tr>
	</thead>
	<?	
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$ex_my_answer = explode(",",$d['exam_answer']);
	?>
	<tr>
		<th><?=$n?></th>
		<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
			<td><?=$_REG['gubun1'][$d['gubun1']]?></td>
			<td><?=$_REG['gubun2'][$d['gubun2']]?></td>
			<td><?=$d['name_kr']?></td>
			<td><?=$d['license_number']?></td>
			<td><?=$d['email']?></td>
			<td><?=$d['exam_cnt']?>/<?=$d['exam_score']?></td>	
			<td><?=ceil(($d['exam_score']/$d['exam_cnt'])*100)?></td>	
			<td style="color:<?=$_CONFIG['YN_color'][$d['exam_pass']]?>"><?=$_EXAM['pass'][$d['exam_pass']]?></td>	
			<td><?=date("m.d H:i:s",$d['signdate'])?></td>
	</tr>
	<?
		$n++;
		}
	?>
</table>