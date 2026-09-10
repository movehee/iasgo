<?
	$i=0;
	$time_query="SELECT * FROM session_time_tbl where code='".$code."' and tab='".$tab."'";
	$time_result=mysqli_query($conn, $time_query);
	while(is_array($time_d = mysqli_fetch_array($time_result))){

		$temp = split("-",$time_d['time']);

		$temp2 = split(":",$temp[0]);
		$temp3 = split(":",$temp[1]);
		if($temp2[0]<$min_time){
			$min_time = $temp2[0];
		}
		if($temp3[1]>0){
			$temp3[0] = $temp3[0]+1;
		}
		if($temp3[0]>$max_time){
			$max_time = $temp3[0];
		}

		$break_margin = 0;

		if($i==1){
			$startTime = $temp2[0]*60 + $temp2[1];
		}
	}


	$startTime = $min_time*60;

	for ($i = $min_time; $i < $max_time; $i++) {
		$total_height = ($i*60-$startTime)*$height/60+$height2 + $height+2 + 50;
	}
?>

<div class="wrapper" style="height:<?=$total_height?>px">
<div style="position:relative;margin-bottom:50px">
<?
	$roomlist = array();	
	$min_time = "999";
	$max_time = "0";
?>
	<div class="glance_room" style="height:<?=$height2-1?>px;width:<?=$def_width-$time_width-1?>px; top: 0px; left: 0px;line-height:<?=$height2?>px;font-size:<?=$session_font_size?>px;"></div>

	<?
	$i=0;
	//$room_query="SELECT a.sid, a.name FROM session_room_tbl a, session_tbl b WHERE b.room = a.sid and a.del='N' and b.tab='".$tab."' and a.add_room='0' group by a.sid order by a.sid asc";
/*
	$room_query="SELECT a.sid, a.name FROM session_room_tbl a WHERE a.del='N' and  a.add_room='0'  and a.tab='".$tab."' and  viewYN2='Y' and code='".$code."' group by a.sid order by a.orderby asc";
*/
	$room_query="SELECT a.sid, a.name,count(b.sid) cnt,a.orderby FROM session_room_tbl a left join session_tbl b on b.room = a.sid and b.tab='".$tab."' WHERE a.code='".$code."' and a.tab='".$tab."' and a.del='N' and b.viewYN2='Y' and a.add_room='0' group by a.sid order by a.orderby asc";


	$room_result=mysqli_query($conn, $room_query);
	while(is_array($room_d = mysqli_fetch_array($room_result))){
		$i++;
		$roomlist[$room_d['sid']] = $i;
	?>

		<div class="glance_room" style="height:<?=$height2-1?>px;width:<?=$def_width-1?>px; top: 0px;font-size:<?=$session_font_size?>px; left: <?=$i*$def_width-$time_width?>px;line-height:<?=$height2?>px;"><?=$room_d['name']?></div>

	
	<?}?>



	<?
	$i=0;
	$time_query="SELECT * FROM session_time_tbl where code='".$code."' and tab='".$tab."'";
	$time_result=mysqli_query($conn, $time_query);
	while(is_array($time_d = mysqli_fetch_array($time_result))){

		$temp = split("-",$time_d['time']);

		$temp2 = split(":",$temp[0]);
		$temp3 = split(":",$temp[1]);
		if($temp2[0]<$min_time){
			$min_time = $temp2[0];
		}
		if($temp3[1]>0){
			$temp3[0] = $temp3[0]+1;
		}
		if($temp3[0]>$max_time){
			$max_time = $temp3[0];
		}

		$break_margin = 0;

		if($i==1){
			$startTime = $temp2[0]*60 + $temp2[1];
		}
	}


	$startTime = $min_time*60;

	for ($i = $min_time; $i < $max_time; $i++) {?>
		<table class="glance_time"  style="height:<?=$height+2?>px;font-size:<?=$session_font_size?>px;width:<?=$def_width-$time_width+1?>px; top: <?=($i*60-$startTime)*$height/60+$height2?>px; left: 0px;"><tr><td><?=$i?><br>-<br><?=$i+1?></td></tr></table>
	<?}
	
	
	while(is_array($d = mysqli_fetch_array($result))){

		$c_result = mysqli_query($conn, "select * from session_category_tbl where sid='".$d['category1']."'");
		$c_row = mysqli_fetch_array($c_result);
		if($c_row['glance_type']==2){
			$back_color=$c_row['glance_color'];
		}else{
			$back_color="#ffffff";
		}

		$width=$def_width;
		$temp = split("-",$d['time_info']);
		$temp2 = split(":",$temp[0]);
		$temp3 = split(":",$temp[1]);
		$break_margin = 0;

		$top = ($temp2[0]*60 + $temp2[1] - $startTime - $break_margin) * $height / 60 + $height2;

		if($d['add_room']=="0"){
			$left = $roomlist[$d['room']]*$width-$time_width;
			$widths = $width+1;
		}else{
			$left = $roomlist[$d['add_room']]*$width-$time_width;
			$widths = $width*$d['add_cnt']+1;
		}

		$time_height = ($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1]) * $height / 60;
		
		$totalquery = "SELECT count(*) cnt FROM session_tbl ";	
		$totalquery .= "  WHERE type = '2' ";
		if($d['link_session']){
			$totalquery .= " and link_session = '".$d['link_session']."' ";
		}else{
			$totalquery .= " and link_session = '".$d['sid']."' ";
		}
		
		$totalresult=mysqli_query($conn, $totalquery);
		$totalcol = mysqli_fetch_array($totalresult);

	?>
		
	<table <?if($totalcol['cnt']>0){?>onclick="javscript:location.href='./glance_sub.php?glance=<?=$d['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>'"<?}?> style="font-weight:500;overflow: hidden;  position:absolute;color:<?=$fontcolor?>;border:1px solid #dbdbdb;font-size:<?=$session_font_size?>px; width:<?=$widths?>px; top: <?=$top?>px;left:<?=$left?>px;font-size:<?=$fontcolor_size?>;text-align:center;height:<?=$time_height+1?>px;background-color:<?=$back_color?>;">
	<tr><td><?if($c_row['glance_type']==1){?>
	<span class="bullet" style="background-color:<?=$c_row['glance_color']?>"><?=$c_row['abb']?></span><br>
	<?}?>
	<?=$d['theme']?></td></tr></table>


	<?}?>

