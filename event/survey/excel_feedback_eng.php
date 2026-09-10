<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=survey.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
    $ccode = "F";

	// $query = "select t1.*,t2.first_name,t2.last_name,t2.name_kr,t2.email,t2.regist_kind from workshop_feedback_result as t1 inner join registration_tbl as t2 on t1.id=t2.id where t2.del='N' and t2.status='Y'" .$fsql;
	// $query .= $sort_sql;
	// $result=$conn->query($query);

    $query = "select * from feedback_result_tbl a join registration_tbl b on a.usid=b.sid where b.country='$ccode'";
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

        <th colspan="27">Onsite Program</th>
        <th colspan="12">Virtual Platform Program</th>
        <th colspan="3">Website (kcr4u.org)</th>
        <th colspan="2">Overall Impressions and Suggestions for KCR 2023</th>
        <th colspan="4">Expectations for KCR 2024 (October 2 (Wed) –5 (Sat), 2024)</th>
        
    </tr>
    <tr>
        <th colspan="11">Overall Management & Operations</th>
        <th colspan="4">Eco-friendly KCR</th>
        <th colspan="5">Official Programs</th>
        <th colspan="3">Technical Exhibition Hall</th>
		<th colspan="3">Onsite Events</th>
		<th colspan="1">Comments</th>

		<th colspan="4">Functional Operations</th>
		<th colspan="4">KCR Quiz</th>
		<th colspan="4">Overall Satifaction</th>

		<th colspan="3">Overall Satisfaction</th>

		<th colspan="2">What impressed you during KCR 2023?</th>

		<th colspan="4">KCR 2024</th>

    </tr>

	<tr>
        <?for($i=1; $i<=11; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=12; $i<=15; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=16; $i<=20; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=21; $i<=23; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>
         <th><?=$_SURVEY['question_s_'.$ccode][1]?></th>

        <?for($i=24; $i<=27; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

         <?for($i=28; $i<=31; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>

        <?for($i=32; $i<=34; $i++){ ?>
        <th>
            <?=$_SURVEY['question_m_'.$ccode][$i]?>
        </th>
        <?}?>
		<th><?=$_SURVEY['question_s_'.$ccode][2]?></th>

        <?for($i=35; $i<=37; $i++){ ?>
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
        
    </tr>



    <?	
		$n=1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
    <tr>
        <td><?=$n?></td>
        <td><?=$d['id']?></td>
        <td><?=$d['name_eng']?></td>
       <?for($i=1; $i<=11; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		 <?for($i=12; $i<=15; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		 <?for($i=16; $i<=20; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		 <?for($i=21; $i<=23; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		 <td><?=stripslashes($d['memo1'])?></td>
		<?for($i=24; $i<=27; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		 <?for($i=28; $i<=31; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		 <?for($i=32; $i<=34; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
		<td><?=stripslashes($d['memo2'])?></td>
		 <?for($i=35; $i<=37; $i++){ ?>
            <td><?=$_SURVEY['ans_m_'.$ccode][$d['answer'.$i]]?></td>
        <?}?>
        <td><?=stripslashes($d['memo3'])?></td>
        <td><?=stripslashes($d['memo4'])?></td>
        <td><?=stripslashes($d['memo5'])?></td>
        <td><?=stripslashes($d['memo6'])?></td>
        <td><?=stripslashes($d['memo7'])?></td>
        <td><?=stripslashes($d['memo8'])?></td>

    </tr>

    <?$n++;}?>
</thead>
</table>