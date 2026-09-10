<?php
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

if($excel_type=="down") {
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=image_contest_result.xls"); 
	header( "Content-Description: PHP4 Generated Data" ); 
}

$name_arr = array('1'=>'이재영',
'2'=>'이재영',
'3'=>'Hyun Jin Kim',
'4'=>'Ju-Yeon Hong',
'5'=>'박혜아',
'6'=>'이주희',
'7'=>'남지나',
'8'=>'홍서연',
'9'=>'Min-Jeong Kim',
'10'=>'남지나',
'11'=>'김소윤',
'12'=>'권도연',
'13'=>'김소윤',
'14'=>'Ji Eun Lee',
'15'=>'Ji Eun Lee',
'16'=>'정예원',
'17'=>'정예원',
'18'=>'홍지윤',
'19'=>'Seong-Eon Park',
'20'=>'Ji Won Song');

$office_arr = array('1'=>'제주 서귀포의료원 산부인과',
'2'=>'제주 서귀포의료원 산부인과',
'3'=>'울산의대 산부인과',
'4'=>'고려의대 산부인과',
'5'=>'성균관의대 산부인과',
'6'=>'울산의대 산부인과',
'7'=>'이화의대 산부인과',
'8'=>'성균관의대 산부인과',
'9'=>'고려의대 산부인과',
'10'=>'이화의대 산부인과',
'11'=>'강서미즈메디병원 산부인과',
'12'=>'성균관의대 산부인과',
'13'=>'강서미즈메디병원 산부인과',
'14'=>'연세의대 산부인과',
'15'=>'연세의대 산부인과',
'16'=>'울산의대 산부인과',
'17'=>'울산의대 산부인과',
'18'=>'성균관의대 산부인과',
'19'=>'계명의대 산부인과',
'20'=>'성균관의대 산부인과');




$query = "select * from feedback_tbl where sid=943";
$result = mysqli_query($conn, $query);
$q = mysqli_fetch_array($result);

for($i=1;$i<=20;$i++){
/*테스트용
$score_query[] = "
select 
'$i' as no,
sum(case when sid%2=1 then 1 end) as s1, 
sum(case when sid%2=0 then 1 end) * 2 as s2  
 
from feedback_result_tbl a where FIND_IN_SET('$i', a.answer$i) and answer$i!=''
";
*/
$score_query[] = "
select 
'$i' as no,
sum(case when b.type=1 then 1 end) as s1, 
sum(case when b.type=2 then 1 end) * 2 as s2  
 
from feedback_result_tbl a, login_tbl b where a.regist_sid=b.sid and FIND_IN_SET('$i', a.answer1) and a.code='ksoug2019f'
";
}

$query = "select no, s1, s2, ifnull(s1, 0)+ifnull(s2, 0) as s3 from (";
$query .= implode(" union ", $score_query);
$query .= ") a";

if($order) {
	$query .= " order by $order desc";
}
//echo nl2br($query);

$result = mysqli_query($conn, $query);
?>

<table border='1'>
	<tr>
		<th></th>
		<th>발표자</th>
		<th>소속</th>
		<th>제목</th>
		<th>일반회원점수</th>
		<th>심사위원점수</th>
		<th>총점</th>
	</tr>
	<?while($d = mysqli_fetch_array($result)) {?>
	<tr>
		<td><?=$d['no']?></td>
		<td><?=$name_arr[$d['no']]?></td>
		<td><?=$office_arr[$d['no']]?></td>
		<td><?=$q['sub'.$d['no']]?></td>
		<td><?=$d['s1']?></td>
		<td><?=$d['s2']?></td>
		<td><?=$d['s3']?></td>
	</tr>
	<?}?>
</table>