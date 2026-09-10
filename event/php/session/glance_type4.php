<?
$height2= 90;
$time_width = 20;
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
		if(strpos($time_d['time'], "-")==true){
			$temp = split("-",$time_d['time']);
		}else{
			$temp = split("~",$time_d['time']);
		}
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
		
		$top = round(($temp2[0]*60 + $temp2[1] - $startTime - $break_margin) * $height / 60 + $height2);
		$time_height = round(($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1]) * $height / 60) ;
	

	$total_height = $top + $time_height+1 + 50;


	$room_query="SELECT count(*) cnt FROM session_room_tbl  WHERE del='N' and  add_room='0' and code='".$code."'";
	$room_result=mysqli_query($conn, $room_query);
	$room_d = mysqli_fetch_array($room_result);
	$total_width = ($room_d['cnt']+1)*$def_width-$time_width;


}?>

<div id="zoom_div" style="height:<?=$total_width?>px;width:<?=$total_height?>px;">
<div style="position:relative;">
<?
	$roomlist = array();
	$roomlist2 = array();
	$timelist = array();
	$timelist2 = array();
	$break_time = array();
	$before ="";
?>
	<div class="glance_room" style="width:<?=$height2-1?>px; height:<?=$def_width-$time_width-1?>px; font-size:<?=$session_font_size?>px; top: 0px; left: 0px;line-height:<?=$def_width-$time_width-1?>px;"></div>

	<?
	$i=0;
	$room_query="SELECT a.sid, a.name,count(b.sid) cnt,a.orderby FROM session_room_tbl a left join session_tbl b on b.room = a.sid and b.tab='".$tab."' WHERE a.code='".$code."' and a.del='N' and a.add_room='0' and b.viewYN2='Y' group by a.sid order by a.orderby asc";

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

	

		<table class="glance_room" style="height:<?=$def_width+1?>px;font-size:<?=$session_font_size?>px; width:<?=$height2+1?>px; top: <?=$i*$def_width-$time_width-1?>px; left: 0px;"><tr><td><?=$room_d['name']?></td></tr></table>
		<?}?>

	
	<?}?>

	<?
	$i=0;
	$time_query="SELECT * FROM session_time_tbl where code='".$code."' and tab='".$tab."' and showYN='Y' order by orderby asc";
	$time_result=mysqli_query($conn, $time_query);
	while(is_array($time_d = mysqli_fetch_array($time_result))){
		$i++;
		$timelist[$time_d['sid']] = $i;
		$timelist2[$time_d['sid']] = $time_d['time'];
		if(strpos($time_d['time'], "-")==true){
			$temp = split("-",$time_d['time']);
		}else{
			$temp = split("~",$time_d['time']);
		}
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
		
		$top = ($temp2[0]*60 + $temp2[1] - $startTime - $break_margin) * $height / 60 + $height2;
		$time_height = ($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1]) * $height / 60 ;
	?>
	<table class="glance_time" style="height:<?=$def_width-$time_width+1?>px; width:<?=$time_height+1?>px;font-size:<?=$session_font_size?>px; top: 0px; left: <?=$top?>px;"><tr><td><?if($time_height>80){?><?=$time_d['time']?><?}else{?><?}?></td></tr></table>

	

	<?}while(is_array($d = mysqli_fetch_array($result))){

		$c_result = mysqli_query($conn, "select * from session_category_tbl where sid='".$d['category1']."'");
		$c_row = mysqli_fetch_array($c_result);
		if($c_row['glance_type']==2){
			$back_color=$c_row['glance_color'];
		}else{
			$back_color="#ffffff";
		}



		$width=$def_width;
		if(strpos($d['time_info'], "-")==true){
			$temp = split("-",$d['time_info']);
		}else{
			$temp = split("~",$d['time_info']);
		}

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

		$top = ($temp2[0]*60 + $temp2[1] - $startTime - $break_margin) * $height / 60 + $height2;

	

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
		
		}

		$time_height = ($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1] - $break_margin2) * $height / 60;
	?>
		
	<table onclick="javscript:location.href='./glance_sub.php?glance=<?=$d['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>'" style="font-weight:700; overflow: hidden;  position:absolute;color:<?=$fontcolor?>;border:1px solid #dbdbdb;max-height:<?=$widths?>px;font-size:<?=$font_size?>px; height:<?=$widths?>px; left: <?=$top?>px;top:<?=$left?>px;text-align:center;width:<?=$time_height+1?>px;background-color:<?=$back_color?>;word-break:keep-all">
	<tr><td style="word-break:keep-all;">


	<?
	$glance_view_style = $setting_col['glance_view_style'];
	$glance_view_style = str_replace("{theme}", $d['theme'], $glance_view_style);
	$glance_view_style = str_replace("{sub_theme}", $d['sub_theme'], $glance_view_style);
	$glance_view_style = str_replace("{cate1}", $c_row['info'], $glance_view_style);
	$glance_view_style = str_replace("{cate2}", $d['category2'], $glance_view_style);
	$glance_view_style = str_replace("{cate1(abb)}", $c_row['abb'], $glance_view_style);
	?>
	<?=$glance_view_style?>

	<?
		$bullet_eng = $setting_col['bullet_txt_eng']?$setting_col['bullet_txt_eng']:"ENG";
		$bullet_kor = $setting_col['bullet_txt_kor']?$setting_col['bullet_txt_kor']:"KOR";
	?>

	<?if($d['language'] =="1"){?>
		<span style="<?if($css_col['session_bullet_eng']){?>background-color:<?=$css_col['session_bullet_eng']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>" class="bullet<?=$setting_col['bullet_type']?> eng"><?=$bullet_eng?></span>
	<?}else if($d['language'] =="2"){?>
		<span style="<?if($css_col['session_bullet_kor']){?>background-color:<?=$css_col['session_bullet_kor']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>"  class="bullet<?=$setting_col['bullet_type']?> kor"><?=$bullet_kor?></span>
	<?}else if($d['language'] =="3"){?>
		<span style="<?if($css_col['session_bullet_eng']){?>background-color:<?=$css_col['session_bullet_eng']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>" class="bullet<?=$setting_col['bullet_type']?> eng"><?=$bullet_eng?></span>

		<span style="<?if($css_col['session_bullet_kor']){?>background-color:<?=$css_col['session_bullet_kor']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>"  class="bullet<?=$setting_col['bullet_type']?> kor"><?=$bullet_kor?></span>
	<?}else if($d['language'] =="4"){?>
		<span style="<?if($css_col['session_bullet_kor']){?>background-color:<?=$css_col['session_bullet_kor']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>"  class="bullet<?=$setting_col['bullet_type']?> kor"><?=$bullet_kor?></span>

		<span style="<?if($css_col['session_bullet_eng']){?>background-color:<?=$css_col['session_bullet_eng']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>" class="bullet<?=$setting_col['bullet_type']?> eng"><?=$bullet_eng?></span>
	<?}?>
	
	
	<?if($d['add_cnt']=="1"){?>
		<br><font class="glance_room">Room : <?=$d['room_info']?></font>
	<?}?>
	</td></tr></table>
	


	<?}?>

</div></div>