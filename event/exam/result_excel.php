<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=exam_result_".date("Ymd").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	procAdminLoginChk();

	$fsql = " where del='N' and day='$chkday'";
	
	$exam_query = "select * from exam_tbl where del='N' AND category='$category' and day='$chkday' order by exam_num asc";
	$exam_result=$conn->query($exam_query);
	if(DB::isError($exam_result)) die($exam_result->getMessage());
	
	while(is_array($e=$exam_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$exam_score_arr[] =  $e['score'];
		$exam_num_arr[] =  $e['exam_num'];
		$exam_ans_arr[] =  $e['answer'];
	}
	
	if(!$exam_num_arr){
		//PutMessageBack("등록된 문제가 없습니다.");
		//exit;
	}
	$query = "select a2.country,a2.name_kr,a2.name_eng, a2.license_number,a2.aff_kor,a2.aff_eng,a2.sid as usid,a2.etc_field2";
	if($exam_num_arr){
	foreach($exam_num_arr as $tkey=>$tval){
	$query .= ", group_concat(case when exam_num='".$tval."' then exam_pass else null end) exam_result".$tval;
	}
	}
	$query .= ", max(a1.signdate) as signdate"; 
	//$query .= "group_concat(case when exam_num='2' then exam_pass else null end) t2,";
	//$query .= "group_concat(case when exam_num='3' then exam_pass else null end) t3,";
	//$query .= "group_concat(case when exam_num='4' then exam_pass else null end) t4,";
	//$query .= "group_concat(case when exam_num='5' then exam_pass else null end) t5";

	if($chkday>2) {
		$add_query = "a1.usid>0 and";
	}

	$query .= " from exam_result_each_tbl as a1 left join registration_tbl as a2 on a1.usid=a2.sid where $add_query a1.day='$chkday' and a1.kind='$category' group by a1.usid";
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
			<th>등록번호</th>
			<th>이름</th>
			<th>면허번호</th>
			<th>소속</th>
			<?if($exam_num_arr){?>
			<?foreach($exam_num_arr as $tkey=>$tval){?>
			<th>문제<?=$tval?>(<?=$exam_score_arr[$tkey]?>점)</th>
			<?}?>
			<?}?>
			<th>결과</th>
			<th>제출일</th>
		</tr>
	</thead>
	<?
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$answer_ok=0;
		$total_score=0;
		
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$d['etc_field2']?></td>
		<td><?if($d['country']=='K'){?><?=$d['name_kr']?><?}else{?><?=$d['name_eng']?><?}?></td>
		<td><?=$d['license_number']?></td>
		<td><?if($d['country']=='K'){?><?=$d['aff_kor']?><?}else{?><?=$d['aff_eng']?><?}?></td>
		<?if($exam_num_arr){?>
		<?foreach($exam_num_arr as $tkey=>$tval){?>
		<td><span style="color:<?=$_EXAM['exam_result_color'][$d['exam_result'.$tval]]?>"><?=$_EXAM['exam_result'][$d['exam_result'.$tval]]?></span></td>
		<?
			if($d['exam_result'.$tval]=='Y'){
				 if($category=='A'){
					$answer_ok++;
				 }else if($category=='B'){
					 $answer_ok++;
					$total_score += $exam_score_arr[$tkey];
				 }
				 
			}
		}	
		?>
		<?}?>
		<td>
		<?
		if($category=='A'){
			echo "정답수 : ".$answer_ok;
		}else{
			echo $answer_ok;
		}
		?>
		</td>
		<td><?=date("m.d H:i",$d['signdate'])?></td>
	<?
		$n++;
		}
	?>
</table>