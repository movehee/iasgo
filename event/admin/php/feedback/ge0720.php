<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

$LIST_TITLE[1] = "일반의 및 복부 전문의 2년 이하";
$LIST_TITLE[2] = "2년초과~5년";
$LIST_TITLE[3] = "5년 초과";
$LIST_TITLE[4] = "Academic teaching hospital (교육 대학병원)";
$LIST_TITLE[5] = "Private group with academic responsibility (대학병원 아닌 수련병원)";
$LIST_TITLE[6] = "Private group, or hospital (준종합 병원, 개인 그룹 병원)";
$LIST_TITLE[7] = "Private office based (개인 병원)";

$ANS_NUM[1] = 3;
$ANS_NUM[2] = 4;

$code = "ge0720";

for($i=1;$i<=2;$i++) {
	
	
	for($j=1;$j<=$ANS_NUM[$i];$j++) {
		
		$kk++;

		$query = "select deviceid from feedback_result_tbl where code='$code' and tab=999 and answer$i = '$j'";
		//echo $query."<br>";
		
		$d_arr = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result)) {
			$d_arr[]=$row['deviceid'];
		}

		$result->close();

		${"d_list".$kk} = "'".implode("','",$d_arr)."'";
		
		//echo "d_list".$kk." => ";
		//echo ${"d_list".$kk}."<br><br>";
		

	}
}

for($i=1;$i<=7;$i++) {
echo "<div><h2>$LIST_TITLE[$i]</h2></div>";
echo "<table border='1'>";
$query = "select a.* from voting_tbl a, lecture_tbl b where a.lecture=b.sid and a.del='N' and b.del='N' and a.code='$code' and a.lecture!=49";
$result = mysqli_query($conn, $query);
while($d = mysqli_fetch_array($result)) {

	$sub_query = "select 
	sum(case when val='1' then 1 end) v1
	,sum(case when val='2' then 1 end) v2
	,sum(case when val='3' then 1 end) v3
	,sum(case when val='4' then 1 end) v4
	,sum(case when val='5' then 1 end) v5
	,sum(case when val='6' then 1 end) v6 
	from voting_result_tbl where code='$code' and voting_sid='$d[sid]' and deviceid in (".${"d_list".$i}.")";
	
	$result_sub = mysqli_query($conn, $sub_query);
	$sub = mysqli_fetch_array($result_sub);

	$sum = $sub['v1']+$sub['v2']+$sub['v3']+$sub['v4']+$sub['v5']+$sub['v6'];

	$per1 = $sub['v1']?number_format($sub['v1']/$sum*100,1)."%":"";
	$per2 = $sub['v2']?number_format($sub['v2']/$sum*100,1)."%":"";
	$per3 = $sub['v3']?number_format($sub['v3']/$sum*100,1)."%":"";
	$per4 = $sub['v4']?number_format($sub['v4']/$sum*100,1)."%":"";
	$per5 = $sub['v5']?number_format($sub['v5']/$sum*100,1)."%":"";
	$per6 = $sub['v6']?number_format($sub['v6']/$sum*100,1)."%":"";


echo "<tr>";
echo "<td rowspan='3' style='width:400px;'>$d[question]</td>";
echo "<td>$d[answer1]</td>";
echo "<td>$d[answer2]</td>";
echo "<td>$d[answer3]</td>";
echo "<td>$d[answer4]</td>";
echo "<td>$d[answer5]</td>";
echo "<td>$d[answer6]</td>";
echo "<td rowspan='3'>$sum</td>";
echo "</tr>";

echo "<tr>";
echo "<td>$sub[v1]</td>";
echo "<td>$sub[v2]</td>";
echo "<td>$sub[v3]</td>";
echo "<td>$sub[v4]</td>";
echo "<td>$sub[v5]</td>";
echo "<td>$sub[v6]</td>";
echo "</tr>";

echo "<tr>";
echo "<td>$per1</td>";
echo "<td>$per2</td>";
echo "<td>$per3</td>";
echo "<td>$per4</td>";
echo "<td>$per5</td>";
echo "<td>$per6</td>";
echo "</tr>";

}

echo "</table>";

}