<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=survey.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
    $ccode = "K";

	// $query = "select t1.*,t2.first_name,t2.last_name,t2.name_kr,t2.email,t2.regist_kind from workshop_feedback_result as t1 inner join registration_tbl as t2 on t1.id=t2.id where t2.del='N' and t2.status='Y'" .$fsql;
	// $query .= $sort_sql;
	// $result=$conn->query($query);

    $query = "select *, a.signdate as regdate from feedback_result_tbl a join registration_tbl b on a.usid=b.sid where b.country='$ccode'";
//	$query .= " and a.usid=2001";

	$query .= " order by a.sid asc";
	//$query .= " limit 0,20";
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
        <th rowspan="3">No</th>
        <th rowspan="3">ID</th>
        <th rowspan="3">Name</th>
        <th rowspan="3">작성일</th>

        <th colspan="27">대회 프로그램 만족도</th>
        <th colspan="12">Virtual Platform 프로그램 만족도</th>
        <th colspan="3">공식 홈페이지(kcr4u.org) 서비스 만족도</th>
        <th colspan="2">KCR 2023 기타 만족도</th>
        <th colspan="4">KCR 2024 설문조사 (개최일: 2024년 10월 02일(수) - 10월 05일(토))</th>
        
    </tr>
    <tr>
        <th colspan="11">학술대회 운영 만족도</th>
        <th colspan="4">Eco-friendly KCR 운영 만족도</th>
        <th colspan="5">공식/사교 행사 및 대회 식음료 운영 만족도</th>
        <th colspan="3">전시 참여 만족도</th>
		<th colspan="3">현장 이벤트 만족도</th>
		<th colspan="1">기타</th>

		<th colspan="4">Virtual Platform 기능 만족도</th>
		<th colspan="4">Quiz 만족도</th>
		<th colspan="4">온라인 플랫폼 전반 운영 만족도</th>


		<th colspan="3">KCR 2023 공식 홈페이지 서비스 만족도</th>

		<th colspan="2">KCR 2023 기타 만족도</th>

		<th colspan="4">KCR 2024에 대한 의견 조사</th>

    </tr>

	<tr>
        <?for($i=1; $i<=11; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=15; $i<=18; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=19; $i<=23; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=24; $i<=26; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>
        

        <?for($i=28; $i<=30; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>
		<th>
            <?=$_SURVEY['question_s_'.$ccode][1]?>
        </th>

        <?for($i=33; $i<=36; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=37; $i<=40; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=41; $i<=43; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>
		<th><?=$_SURVEY['question_s_'.$ccode][2]?></th>

        <?for($i=44; $i<=45; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        

        <th><?=$_SURVEY['question_s_'.$ccode][3]?></th>
		<th><?=$_SURVEY['question_s_'.$ccode][4]?></th>
		<th><?=$_SURVEY['question_s_'.$ccode][5]?></th>
		<th><?=$_SURVEY['question_s_'.$ccode][6]?></th>
		<th><?=$_SURVEY['question_s_'.$ccode][7]?></th>
		<th><?=$_SURVEY['question_s_'.$ccode][8]?></th>
		<th><?=$_SURVEY['question_s_'.$ccode][9]?></th>
    </tr>



    <?	
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
    <tr>
        <td><?=$n?></td>
        <td><?=$d['id']?></td>
        <td><?=$d['name_eng']?></td>
		<td><?=date('Y-m-d', $d['regdate'])?></td>
        <?for($i=1; $i<=11; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<?for($i=15; $i<=18; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>

		<?for($i=19; $i<=23; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<?for($i=24; $i<=26; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<?for($i=28; $i<=30; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<td><?=stripslashes($d['memo1'])?></td>
		 <?for($i=33; $i<=36; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<?for($i=37; $i<=40; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<?for($i=41; $i<=43; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<td><?=stripslashes($d['memo2'])?></td>
		 <?for($i=44; $i<=45; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>

        <td><?=stripslashes($d['memo3'])?></td>
        <td><?=stripslashes($d['memo4'])?></td>
        <td><?=stripslashes($d['memo5'])?></td>
        <td><?=stripslashes($d['memo6'])?></td>
        <td><?=stripslashes($d['memo7'])?></td>
        <td><?=stripslashes($d['memo8'])?></td>
		<td><?=stripslashes($d['memo9'])?></td>

    </tr>

    <?$n++;}?>
</thead>
</table>