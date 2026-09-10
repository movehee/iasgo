<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";


if($excel_type!='view') {
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$_COOKIE['code']."_question.xls"); 
	header( "Content-Description: PHP4 Generated Data" ); 
}
	//print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");
	
	$query="SELECT * FROM event_tbl where code='".$_COOKIE['code']."'";
	$result = mysqli_query($conn, $query);
	$event_db= mysqli_fetch_array($result);

	if($event_db['session_sync']=='Y') {

		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/voting_sync/config/'.$code.'.php')) {
			include_once $_SERVER['DOCUMENT_ROOT']."/voting_sync/config/".$code.".php";
		}
		
		$sync_url = $_URL['qna'];
		//echo $sync_url;
		$json_string = file_get_contents($sync_url);
		$session_arr = json_decode($json_string, true);

	}

	//$query = "select a.* from question_tbl where code='".$_COOKIE['code']."' and del='N'";
	$query = "select a.*,b.name name2, b.office office2 from question_tbl a LEFT join token_tbl b ON  a.deviceid = b.deviceid AND b.CODE='".$_COOKIE['code']."' WHERE a.CODE='".$_COOKIE['code']."' and a.del='N' order by signdate desc";
	//echo $query;
	$result = mysqli_query($conn, $query);


	
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<style>
table{ width:100%; font-size: 14px; border-collapse: collapse;}
table tr th,
table tr td{padding: 5px 10px;text-align:center;}
table tr th{background-color: #ececec; padding: 15px 10px;}
</style>

<table border=1>
	<tr>
		<th width="10%">Name</th>
		<th width="10%">Office</th>
		<th width="10%">Lecture</th>
		<th width="*%">Question</th>
		<th width="10%">Session Time</th>
		<th width="10%">Room</th>
		<th width="10%">Session</th>
		<th width="10%">Session Title</th>
		<th width="10%">Q&A Time</th>
	</tr>
	<?
		while(is_array($col = mysqli_fetch_array($result))){

		$session_col = $sub_col = "";

		if($col['name2']){
			$col['name'] = $col['name2'];
		}
		if($col['office2']){
			$col['office'] = $col['office2'];
		}

		if($col['session']){
			
			if($event_db['session_sync'] == 'Y') {
				$session_col = $session_arr[$col['session']];
			}
			else {

				$session_query = "SELECT a.*,t.time time_info, r.name room_info, r.photo room_photo FROM session_tbl a, session_room_tbl r, session_time_tbl t ";
				$session_query .= "  WHERE a.time=t.sid and a.room=r.sid and a.sid='".$col['session']."'";

				$session_result = mysqli_query($conn, $session_query);
				$session_col = mysqli_fetch_array($session_result);
			}

		}


		if($col['sub']){
			$sub_query = "SELECT * FROM session_tbl WHERE sid='".$col['sub']."'";
			$sub_result = mysqli_query($conn, $sub_query);
			$sub_col = mysqli_fetch_array($sub_result);
		}

	?>
	
		<tr>
			<td><?=$col['name']?></td>
			<td><?=$col['office']?></td>
			<td><?=$col['lecture']?></td>
			<td style="text-align:left;"><?=$col['question']?></td>

			<td><?=$session_col['time_info']?></td>
			<td><?=$session_col['room_info']?></td>
			<td><?=$session_col['theme']?></td>
			<td><?=$sub_col['title']?></td>
			<td><?=date("y/m/d H:i", $col['signdate'])?></td>

		</tr>
	<?
	}		
	?>
</table>
