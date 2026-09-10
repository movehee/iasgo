<?
	$roomlist = array();
	$roomlist2 = array();
	$timelist = array();
	$timelist2 = array();
	$break_time = array();
	$before ="";

	$i=0;
	$time_query="SELECT * FROM session_time_tbl where code='".$code."' and tab='".$tab."' and showYN='Y' order by orderby asc";
	$time_result=mysqli_query($conn, $time_query);
	while(is_array($time_d = mysqli_fetch_array($time_result))){
		$i++;
		$timelist[$time_d['sid']] = $i;
		$timelist2[$time_d['sid']] = $time_d['time'];
		$temp = split("-",$time_d['time']);
		$temp2 = split(":",$temp[0]);
		$temp3 = split(":",$temp[1]);
		$break_margin = 0;

		if($i==1){
			$startTime = $temp2[0]*60 + $temp2[1];
		}else{
			if($temp2[0]*60 + $temp2[1] - $before > 0) {
				$break_time[$before] = $temp2[0]*60 + $temp2[1];
			}
		}

		foreach($break_time as $key=>$val){
			$break_margin = $break_margin + $val-$key;
		}


		$before = $temp3[0]*60 + $temp3[1];
		
		$top = floor(($temp2[0]*60 + $temp2[1] - $startTime - $break_margin) * $height / 60 + $height2);
		$time_height = ($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1]) * $height / 60 ;
	

	$total_height = $top + $time_height+1 + 50;


	$room_query="SELECT count(*) cnt FROM session_room_tbl  WHERE del='N' and  add_room='0' and code='".$code."'";
	$room_result=mysqli_query($conn, $room_query);
	$room_d = mysqli_fetch_array($room_result);
	$total_width = ($room_d['cnt']+1)*$def_width-$time_width;


}?>

<div id="zoom_div" style="height:<?=$total_height?>px;width:<?=$total_width?>px;">
<div style="position:relative;">
<?
	$roomlist = array();
	$roomlist2 = array();
	$timelist = array();
	$timelist2 = array();
	$break_time = array();
	$before ="";
?>
	<div class="glance_room" style="height:<?=$height2-1?>px; width:<?=$def_width-$time_width-1?>px; font-size:<?=$session_font_size?>px; top: 0px; left: 0px;line-height:<?=$height2-1?>px;"></div>

	<?
	$i=0;
	$room_query="SELECT a.sid, a.name,count(b.sid) cnt,a.orderby FROM session_room_tbl a left join session_tbl b on b.room = a.sid and b.tab='".$tab."' WHERE a.code='".$code."' and a.del='N' and a.add_room='0' group by a.sid order by a.orderby asc";

	//$room_query="SELECT a.sid, a.name FROM session_room_tbl a WHERE a.del='N' and  a.add_room='0' and a.code='".$code."' group by a.sid order by a.orderby asc";

	$room_result=mysqli_query($conn, $room_query);
	while(is_array($room_d = mysqli_fetch_array($room_result))){
		$i++;
		$roomlist[$room_d['sid']] = $i;
		$roomlist2[$i] = $room_d['cnt'];
		if($room_d['cnt']>=0){
			$ii = 0;
			foreach($roomlist2 as $key=>$val){
				if($val>0){
					$ii++;
				}
			}


	?>

		<div class="glance_room" style="height:<?=$height2-1?>px;line-height:<?=$height2-1?>px;font-size:<?=$session_font_size?>px; width:<?=$def_width-1?>px; top: 0px; left: <?=$i*$def_width-$time_width?>px;"><?=$room_d['name']?></div>
		<?}?>

	
	<?}?>

	<?
	$i=0;
	$time_query="SELECT * FROM session_time_tbl where code='".$code."' and tab='".$tab."' and showYN='Y' order by orderby asc";
	$time_result=mysqli_query($conn, $time_query);
	$time_top=0;
	while(is_array($time_d = mysqli_fetch_array($time_result))){
		$i++;

		$temp = split("-",$time_d['time']);
		$temp2 = split(":",$temp[0]);
		$temp3 = split(":",$temp[1]);

		$timelist[$time_d['sid']] = $time_top;
		$timelist2[$time_d['sid']] = round(($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1]) * $height / 60);

		$time_top = $time_top + round(($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1]) * $height / 60);

	?>
	<table class="glance_time" style="height:<?=$time_height?>px; width:<?=$def_width-$time_width+1?>px;font-size:<?=$session_font_size?>px; top: <?=$top?>px; left: 0px;"><tr><td><?if($time_height>80){?><?=str_replace("-","<br>-<br>",$time_d['time'])?><?}else{?><?=$time_d['time']?><?}?></td></tr></table>

	

	<?}while(is_array($d = mysqli_fetch_array($result))){

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
		$break_margin2 = 0;

		foreach($break_time as $key=>$val){
			if($key>$temp3[0]*60 + $temp3[1]){
			
			}else if($val<=$temp2[0]*60 + $temp2[1]){
				$break_margin = $break_margin + $val-$key;
			}
			if($key>=$temp2[0]*60 + $temp2[1] && $val<=$temp3[0]*60 + $temp3[1]){
				$break_margin2 = $break_margin2 + $val-$key;
			}
		}

		$top = round(($temp2[0]*60 + $temp2[1] - $startTime - $break_margin) * $height / 60 + $height2);

		if($d['add_room']=="0"){
			$ii = 0;
			foreach($roomlist2 as $key=>$val){
				if($val>0 && $roomlist[$d['room']] >= $key){
					$ii++;
				}
			}

			$left = $ii*$width-$time_width;
			$widths = $width+1;
		}else{
			$left = $roomlist[$d['add_room']]*$width-$time_width;
			$widths = $width*$d['add_cnt']+1;
			/*
			$ii = 0;
			foreach($roomlist2 as $key=>$val){
				if($val>0 && $roomlist[$d['add_room']] >= $key){
					$ii++;
				}
			}

			
			$left = $ii*$width-$time_width;
			*/
			//$left = $roomlist[$d['add_room']]*$width-$time_width;

			/*
			$ii = 0;
			foreach($roomlist2 as $key=>$val){
				if($val>0 && $roomlist[$d['add_room']] <= $key && $roomlist[$d['add_room']]+$d['add_cnt'] > $key){
					$ii++;
				}
			}

			$widths = $width*$ii+1;
			*/

			//$widths = $width*$d['add_cnt']+1;
		}

		$time_height = round(($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1] - $break_margin2) * $height / 60);

		
		
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
		
	<table <?if($totalcol['cnt']>0){?> onclick="javscript:location.href='./glance_sub.php?glance=<?=$d['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>'" <?}?>style="font-weight:700; overflow: hidden;  position:absolute;color:<?=$fontcolor?>;border:1px solid #dbdbdb;font-size:<?=$font_size?>px; width:<?=$widths+1?>px; top: <?=$top-1?>px;left:<?=$left-1?>px;text-align:center;height:<?=$time_height+2?>px;background-color:<?=$back_color?>;word-break:keep-all">
	<tr><td style="word-break:keep-all;">
	<?if($setting_col['glance_view_type']=="2"){
		$d['theme'] = "[".$d['theme']."]";
		if($d['sub_theme']){
			
			$d['theme'] = $d['theme']."<span style='font-weight:500'><br>".$d['sub_theme']."</span>";
		}
	}?>
	<?if($d['language'] =="1"){?>
		<span class="bullet" style="background-color:#2d63bb;">E</span>
	<?}else if($d['language'] =="2"){?>
		<span class="bullet" style="background-color:#2d63bb;">K</span>
	<?}?>
	<?if($c_row['glance_type']==1){?>
	<span class="bullet" style="background-color:<?=$c_row['glance_color']?>"><?=$c_row['abb']?></span>
	<?}?>
	
	<?if($d['add_cnt']=="1"){?>
		<font style="color:#ff0000">room : <?=$d['room_info']?><br></font>
	<?}?>
	<?=$d['theme']?></td></tr></table>


	<?}?>

</div></div>