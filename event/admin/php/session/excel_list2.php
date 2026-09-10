<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<table border=1>
	<tr>
		<td>day</td>
		<td>Room</td>
		<td>time</td>
		<td>title</td>
		<td>speaker</td>
	</tr>

<?
	$query = "SELECT a.sid, a.theme, r.name as room_name, t.time as session_time, d.name as day_name FROM session_tbl a, session_room_tbl r, session_time_tbl t, agenda_tbl d where a.room=r.sid and a.time=t.sid and a.tab=d.sid and a.code='".$code."' and a.type='1' order by a.tab";
	$result = mysqli_query($conn, $query);
	while(is_array($col = mysqli_fetch_array($result))){
?>

	<tr>
		<td><?=str_replace('<br>','',$col['day_name'])?></td>
		<td><?=$col['room_name']?></td>
		<td><?=$col['session_time']?></td>
		<td><?=$col['theme']?></td>
		<td></td><!--speaker-->
	
	
	</tr>

	<?
		$sub_query = "select * from session_tbl a where a.code='$code' and link_session='$col[sid]'";
		$sub_result = mysqli_query($conn, $sub_query);
		if($sub_result->num_rows) {
			while(is_array($sub = mysqli_fetch_array($sub_result))){
	?>

		<tr>
			<td></td>
			<td></td>
			<td><?=$sub['time']?></td>
			<td><?=$sub['title']?></td>
			<td><?=$sub['speaker']?>
			<?
				$f_query = "select a.* from faculty_tbl a join session_faculty_tbl b on a.sid=b.faculty_sid and b.gubun='speaker' where a.code='$code' and b.session_sid='$sub[sid]'";
				$f_result = mysqli_query($conn, $f_query);
				if($sub_result->num_rows) {
					$speakers = array();
				while(is_array($f = mysqli_fetch_array($f_result))){
					$speakers[] = $f['name'];
				} echo implode(",", $speakers);}
			?>
			</td>
		</tr>
<?		
			}
		}

	}

?>