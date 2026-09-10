<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

	if($excel_type!='view') {
	
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$code."_evaluation.xls"); 
	header( "Content-Description: PHP4 Generated Data" ); 

	}

	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");
	
	$query="SELECT * FROM event_tbl where code='".$code."'";
	$result = mysqli_query($conn, $query);
	$event_db= mysqli_fetch_array($result);
	if($event_db['session_sync']=='Y') {
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/voting_sync/config/'.$code.'.php')) {
			include_once $_SERVER['DOCUMENT_ROOT']."/voting_sync/config/".$code.".php";
		}

		$sync_url = $_URL['eval']."?code=".$code;
		//echo $sync_url;
		$json_string = file_get_contents($sync_url);
		$arr = json_decode($json_string, true);
		//

		$session_arr = $arr['session_arr'];
		$lecture_arr = $arr['lecture_arr'];


		//print_r($session_arr);
		//echo "<br><Br>";
		//print_r($lecture_arr);
	}

	


	

	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<table border=1>
	<tr>
		<td>title</td>
		<td>speaker</td>
		<td>score</td>
		<td>memo</td>
		<td>time</td>
		<td>deviceid</td>
	</tr>
	<?
	if($event_db['session_sync']=='Y') {
		$query = "select * from session_evaluation_tbl a where a.code='".$code."'";
		$result = mysqli_query($conn, $query);
		while(is_array($col = mysqli_fetch_array($result))){

			if($col['lecture_sid']) {
				$s_sid = $col['lecture_sid'];

				$title = $lecture_arr[$s_sid]['theme'];
				$speaker = $lecture_arr[$s_sid]['speaker'];
			} else {
				$s_sid = $col['session_sid'];

				$title = $session_arr[$s_sid]['theme'];
				$speaker = $session_arr[$s_sid]['speaker'];
			}

	?>
	<tr>

		<td><?=iconv("UTF-8", "EUC-KR", $title)?></td>
		<td><?=iconv("UTF-8", "EUC-KR", $speaker)?></td>


		<td><?=iconv("UTF-8", "EUC-KR", $col['score'])?></td>
		<td><?=iconv("UTF-8", "EUC-KR", $col['memo'])?></td>
		<td><?=$col['signdate']?date('Y-m-d H:i', $col['signdate']):""?></td>
		<td><?=$col['deviceid']?></td>
		<!-- <td><?=$col['session_sid']?><br><?=$col['lecture_sid']?></td> -->



	</tr>

	<?
		}

	} else {
		


		$query = "select a.*,b.title,b.theme,b.sid session_sid, b.speaker speaker2 from session_evaluation_tbl a, session_tbl b where a.session_sid=b.sid and b.code='".$code."'";
		
		$result = mysqli_query($conn, $query);
		while(is_array($col = mysqli_fetch_array($result))){
		
			if($setting_col['faculty_type']==1){
				$faculty_query = "SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$col['session_sid']."' order by a.sid asc";
				$faculty_result = mysqli_query($conn, $faculty_query);
				$faculty_d = mysqli_fetch_array($faculty_result);
				$speaker= $faculty_d['name'];
				//echo $faculty_query = "SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$col['session_sid']."' order by a.sid asc";;
			}else{
				$speaker= $col['speaker2'];
			}



			?>
	
		<tr>
			<td><?if($col['title']){?><?=iconv("UTF-8", "EUC-KR", $col['title'])?><?}else{?><?=iconv("UTF-8", "EUC-KR", $col['theme'])?><?}?></td>

			<td><?=iconv("UTF-8", "EUC-KR", $speaker)?></td>


			<td><?=iconv("UTF-8", "EUC-KR", $col['score'])?></td>
			<td><?=iconv("UTF-8", "EUC-KR", $col['memo'])?></td>
			<td><?=$col['signdate']?date('Y-m-d H:i', $col['signdate']):""?></td>
			<td><?=$col['deviceid']?></td>



		</tr>
		<?
		}		
		?>
	<?}?>
</table>
