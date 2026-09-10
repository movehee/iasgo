<?php
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

$user_scalable=true;
ini_set('allow_url_fopen', 'On');

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


if($setting_col['glance_type']=="M") {
	include "glance_new.php";
} else {
	include "./../header.php";
?>
<style>

	table tr td span {font-weight:500};
</style>

<?




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
$time_width = 40;
//$time_width = 80;



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

if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	echo $setting_col['glance_type'];
	//$setting_col['glance_type']=6;
}

if($code == 'ksc2019') { include "./glance_ksc2019.php"; }
else if($code == 'korl2019') { include "./glance_korl2019.php"; }
else if($code == 'icorl2020') { include "./glance_icorl2020.php"; }
else {

	if($setting_col['glance_type']=="1") {
		include "./glance_type1.php";
	}else if($setting_col['glance_type']=="2") {
		include "./glance_type2.php";
	}else if($setting_col['glance_type']=="5") {
		include "./glance_type2_30.php";
	}else if($setting_col['glance_type']=="6") {
		include "./glance_type2_h.php";
	}else if($setting_col['glance_type']=="3") {
		include "./glance_type3.php";
	}else if($setting_col['glance_type']=="4") {
		include "./glance_type4.php";
	}
}

?>



<?if(!$include && $setting_col['glance_full']=="Y"){?>
<script>
jQuery(function($) {
	var zoomval = $(window).width() / $("div#zoom_div").width() * 100;
	$("div#zoom_div").css('zoom',zoomval+'%');
	$("td").css('-webkit-text-size-adjust',zoomval+'%');
	$("span").css('-webkit-text-size-adjust',zoomval+'%');
	$("div").css('-webkit-text-size-adjust',zoomval+'%');
	
});
</script>
<?}?>


</body>
</html>

<?}?>