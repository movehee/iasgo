<?
	$roomlist = array();
	$roomlist2 = array();
	$timelist = array();
	$timelist2 = array();
	$break_time = array();
	$toplist = array();
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
		
		$top = floor(($temp2[0]*60 + $temp2[1] - $startTime - $break_margin) * $height / 60 + $height2);
		$time_height = ($temp3[0]*60 + $temp3[1] - $temp2[0]*60 - $temp2[1]) * $height / 60 ;
	

	$total_height = $top + $time_height+1 + 50;


	$room_query="SELECT count(*) cnt FROM session_room_tbl  WHERE del='N' and tab='".$tab."' and add_room='0' and code='".$code."'";
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
	<div class="glance_room" style="height:<?=$height2-2?>px; width:<?=$def_width-$time_width-2?>px; font-size:<?=$session_font_size?>px; top: 0px; left: 0px;line-height:<?=$height2?>px;"></div>

	<?
	$i=0;
	$room_query="SELECT a.sid, a.name,count(b.sid) cnt,a.orderby FROM session_room_tbl a left join session_tbl b on b.room = a.sid and b.tab='".$tab."' WHERE a.code='".$code."' and a.tab='".$tab."' and a.del='N' and b.viewYN2='Y' and a.add_room='0' group by a.sid order by a.orderby asc";

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

		<table class="glance_room" style="height:<?=$height2+1?>px;font-size:<?=$session_font_size?>px; width:<?=$def_width+1?>px; top: 0px; left: <?=$i*$def_width-$time_width-1?>px;"><tr><td><?=$room_d['name']?></td></tr></table>
		<?}?>

	
	<?}?>

	<?
	$ex_top = 0;
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
		

		/*최소높이셋팅*/
		$add_height = 0;
		if($time_height < $MIN_HEIGHT) {
			$b_time_height = $time_height;
			$time_height = $MIN_HEIGHT;
	
			$add_height = $MIN_HEIGHT - $b_time_height;			
			
		}

		$top += $ex_top;
		$ex_top += $add_height;	
		/*최소높이셋팅*/
		

	?>
	<table class="glance_time" style="height:<?=$time_height+1?>px;min-height:<?=$time_height+1?>px;max-height:<?=$time_height+1?>px; max-width:<?=$def_width-$time_width?>px;min-width:<?=$def_width-$time_width?>px;width:<?=$def_width-$time_width?>px; 
	<?if($time_height>20){?>
		font-size:<?=$session_font_size?>px;
	<?}else{?>
		<?if($code=="ksic2019s" && $tab=="75"){//예외처리?>
		font-size:11px;
		<?}else{?>
		font-size:<?=$time_height/2?>px;
		<?}?>
	<?}?> top: <?=$top-1?>px; left: 0px;"><tr><td><?if($time_height>80){?>
	<?if(strpos($time_d['time'], "-")==true){?>
		<?=str_replace("-","<br>-<br>",$time_d['time'])?>
	<?}else{?>
		<?=str_replace("~","<br>~<br>",$time_d['time'])?>
	<?}?>
	<?}else{?><?=$time_d['time']?><?}?></td></tr></table>

	

	<?}
	
	$ex_top = 0;
	while(is_array($d = mysqli_fetch_array($result))){

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


		//$temp = split("-",$d['time_info']);
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

		/*
		if($toplist[$top]){
			$top = $top-1;
		}*/
		

		if($d['add_room']=="0"){
			$ii = 0;
			foreach($roomlist2 as $key=>$val){
				if($val>0 && $roomlist[$d['room']] >= $key){
					$ii++;
				}
			}

			$left = $ii*$width-$time_width;
			$widths = $width;
		}else{
			$left = $roomlist[$d['add_room']]*$width-$time_width;
			$widths = $width*$d['add_cnt'];
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
		//$top_temp = $top + $time_height;
		//$toplist[$top_temp] = true;
		
		$totalquery = "SELECT count(*) cnt FROM session_tbl ";	
		$totalquery .= "  WHERE type = '2' ";
		if($d['link_session']){
			$totalquery .= " and link_session = '".$d['link_session']."' ";
		}else{
			$totalquery .= " and link_session = '".$d['sid']."' ";
		}
		
		$totalresult=mysqli_query($conn, $totalquery);
		$totalcol = mysqli_fetch_array($totalresult);
		
		/*최소높이셋팅*/
		$add_height = 0;
		if($time_height < $MIN_HEIGHT) {
			$b_time_height = $time_height;
			$time_height = $MIN_HEIGHT;
	
			$add_height = $MIN_HEIGHT - $b_time_height;			
			
		}

		$top += $ex_top;
		$ex_top += $add_height;	
		/*최소높이셋팅*/


		if($d['sid'] == '7380') {//포스터 이과
			$time_height = 336;
		}
		else if($d['sid'] == '7408') {//포스터 비과
			$time_height = 336;
			$top = 416;
		}
		else if($d['sid'] == '7409') {//포스터 두결부
			$time_height = 336;
			$top = 704;
		}

	?>
		
	<table <?if($totalcol['cnt']>0){?> onclick="javscript:location.href='./glance_sub.php?glance=<?=$d['sid']?>&code=<?=$code?>&deviceid=<?=$deviceid?>'" <?}?>style="font-weight:700; overflow: hidden;  position:absolute;color:<?=$fontcolor?>;border:1px solid #dbdbdb; width:<?=$widths+1?>px;max-width:<?=$widths+1?>px;min-width:<?=$widths+1?>px; top:<?=$top-1?>px;font-size:<?=$font_size?>px;left:<?=$left-1?>px;text-align:center;max-height:<?=$time_height+1?>px;min-height:<?=$time_height+1?>px;height:<?=$time_height+1?>px;background-color:<?=$back_color?>;word-break:keep-all;
	
	<?if($time_height>20){?>
		<?if($time_height<40){//주석처리?>
			-line-height:<?=$time_height-4?>px;
		<?}?>
		font-size:<?=$font_size?>px;
	<?}else{?>
		<?if($code=="ksic2019s" && $tab=="75"){//예외처리?>
		font-size:11px;
		<?}else{?>
		font-size:<?=$time_height/2?>px;
		<?}?>
	<?}?>
	
	">
	<tr><td style="word-break:keep-all;">

	<?
		$bullet_eng = $setting_col['bullet_txt_eng']?$setting_col['bullet_txt_eng']:"ENG";
		$bullet_kor = $setting_col['bullet_txt_kor']?$setting_col['bullet_txt_kor']:"KOR";
	?>
	
	<?if($d['language'] =="1"){?>
		<span style="<?if($css_col['session_bullet_eng']){?>background-color:<?=$css_col['session_bullet_eng']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>" class="bullet<?=$setting_col['bullet_type']?> eng"><?=$bullet_eng?></span>
	<?}else if($d['language'] =="2"){?>
		<span style="<?if($css_col['session_bullet_kor']){?>background-color:<?=$css_col['session_bullet_kor']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>"  class="bullet<?=$setting_col['bullet_type']?> kor"><?=$bullet_kor?></span>
	<?}else if($d['language'] =="3"){?>
		
		<span class="bullet_span<?=$setting_col['bullet_type']?>">
		<span style="position:relative;<?if($css_col['session_bullet_eng']){?>background-color:<?=$css_col['session_bullet_eng']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>" class="bullet<?=$setting_col['bullet_type']?> eng"><?=$bullet_eng?></span>
		<span style="position:relative;<?if($css_col['session_bullet_kor']){?>background-color:<?=$css_col['session_bullet_kor']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>"  class="bullet<?=$setting_col['bullet_type']?> <?=$setting_col['bullet_type']?> kor"><?=$bullet_kor?></span>
		</span>

	<?}else if($d['language'] =="4"){?>

		<span class="bullet_span<?=$setting_col['bullet_type']?>">
		<span style="position:relative;<?if($css_col['session_bullet_kor']){?>background-color:<?=$css_col['session_bullet_kor']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>"  class="bullet<?=$setting_col['bullet_type']?> kor"><?=$bullet_kor?></span>
		<span style="position:relative;<?if($css_col['session_bullet_eng']){?>background-color:<?=$css_col['session_bullet_eng']?> !important;<?}?> <?if($css_col['session_category_radius']){?>border-radius:<?=$css_col['session_category_radius']?>px;<?}?>" class="bullet<?=$setting_col['bullet_type']?> eng"><?=$bullet_eng?></span>
		</span>
	<?}?>


	<?
	$glance_view_style = $setting_col['glance_view_style'];
	$glance_view_style = str_replace("{theme}", $d['theme'], $glance_view_style);
	$glance_view_style = str_replace("{sub_theme}", $d['sub_theme'], $glance_view_style);
	$glance_view_style = str_replace("{cate1}", $c_row['info'], $glance_view_style);
	$glance_view_style = str_replace("{cate2}", $d['category2'], $glance_view_style);
	$glance_view_style = str_replace("{cate1(abb)}", $c_row['abb'], $glance_view_style);

	$glance_view_style = str_replace("[]","", $glance_view_style); //고민해보기
	?>
	<?=$glance_view_style?>

	<?if($d['add_cnt']=="1"){?>
		<br><font style="color:<?if($css_col['glance_room_font']){?><?=$css_col['glance_room_font']?><?}else{?> #ff0000<?}?>;<?if($css_col['glance_room_font_size']){?>font-size:<?=$css_col['glance_room_font_size']?>px<?}?>">Room : <?=$d['room_info']?></font>
	<?}?>
	</td></tr></table>
	

	<?}?>
<!--
 text-overflow:ellipsis; white-space:nowrap; max-width:<?=$widths?>px;
-->
</div></div>