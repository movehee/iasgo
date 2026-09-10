<?
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


if(!$tab){
	$result = mysqli_query($conn, "SELECT sid from agenda_tbl where eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("y"))."' and glanceYN='Y' and code='".$code."' and del='N'");
	$row = mysqli_fetch_array($result);
	$tab = $row['sid'];

	if(!$tab){
		$result = mysqli_query($conn, "SELECT sid from agenda_tbl where code='".$code."' and del='N' and glanceYN='Y' order by sid asc limit 1");
		$row = mysqli_fetch_array($result);
		$tab = $row['sid'];
	}
}

$MIN_HEIGHT = 30;

$height= 144;
$height2= 50;
$def_width = 120;
if($setting_col['glance_width']){
	$def_width=$setting_col['glance_width'];
}
if($include){
	$def_width=134;
	$height=90;
}
if($setting_col['glance_height']){
	$height=$setting_col['glance_height'];
}

$width = $def_width;
//$time_width = 40;
$time_width = 80;



$padding_top = 12;

$font_size = 10;
if($css_col['glance_top_font_size']){
	$session_font_size = $css_col['glance_top_font_size'];
}else{
	$session_font_size = 10;
}
$fontcolor= $css_col['glance_theme_font'];

if($css_col['glance_theme_font_size']){
	$font_size = $css_col['glance_theme_font_size'];
	$fontcolor_size= $css_col['glance_theme_font_size'];
}

$back_color = "#ffffff";
$query = "select a.*,t.time time_info, r.name room_info, r.add_room, r.add_cnt from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.tab='".$tab."' and  a.viewYN2='Y' order by orderby asc";
$result = mysqli_query($conn, $query);


?>


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

	//추가
	//if($i == 1) {$s_time = $temp2[0];}
	//$e_time_min = ceil($temp3[0] + $temp3[1]/60);
	//if($e_time < $e_time_min) {$e_time = $e_time_min;}
	//
}

	//$time_num = $e_time - $s_time;
	//$b_height = ($height2 - 2) + ($time_num * $height);
?>

<div id="background_liner" style="position:absolute;width:<?=$total_width-2?>px;border:1px solid #dbdbdb;"></div>

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

