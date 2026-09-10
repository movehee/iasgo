<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from session_set_tbl where code='".$_COOKIE['code']."'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];

for($i=1; $i<=8; $i++) {
	if(substr($_POST['vip_color'.$i],0,1)!="#" && strlen($_POST['vip_color'.$i])>2){
		$_POST['vip_color'.$i] = "#".$_POST['vip_color'.$i];
	}
}


if($cnt>0)
{
	$query = "update session_set_tbl SET ";

	$query .= " vip_info1='".$_POST['vip_info1']."'";
	$query .= ", vip_info2='".$_POST['vip_info2']."'";
	$query .= ", vip_info3='".$_POST['vip_info3']."'";
	$query .= ", vip_info4='".$_POST['vip_info4']."'";
	$query .= ", vip_info5='".$_POST['vip_info5']."'";
	$query .= ", vip_info6='".$_POST['vip_info6']."'";
	$query .= ", vip_info7='".$_POST['vip_info7']."'";
	$query .= ", vip_info8='".$_POST['vip_info8']."'";

	$query .= ", vip_width1='".$_POST['vip_width1']."'";
	$query .= ", vip_width2='".$_POST['vip_width2']."'";
	$query .= ", vip_width3='".$_POST['vip_width3']."'";
	$query .= ", vip_width4='".$_POST['vip_width4']."'";
	$query .= ", vip_width5='".$_POST['vip_width5']."'";
	$query .= ", vip_width6='".$_POST['vip_width6']."'";
	$query .= ", vip_width7='".$_POST['vip_width7']."'";
	$query .= ", vip_width8='".$_POST['vip_width8']."'";

	$query .= ", vip_color1='".$_POST['vip_color1']."'";
	$query .= ", vip_color2='".$_POST['vip_color2']."'";
	$query .= ", vip_color3='".$_POST['vip_color3']."'";
	$query .= ", vip_color4='".$_POST['vip_color4']."'";
	$query .= ", vip_color5='".$_POST['vip_color5']."'";
	$query .= ", vip_color6='".$_POST['vip_color6']."'";
	$query .= ", vip_color7='".$_POST['vip_color7']."'";
	$query .= ", vip_color8='".$_POST['vip_color8']."'";


	$query .= ", booth_ui_type='".$_POST['booth_ui_type']."'";
	$query .= ", booth_ui_type2='".$_POST['booth_ui_type2']."'";
	$query .= ", booth_group_YN='".$_POST['booth_group_YN']."'";
	$query .= ", booth_event_cnt='".$_POST['booth_event_cnt']."'";
	$query .= ", booth_event_cnt2='".$_POST['booth_event_cnt2']."'";
	$query .= ", booth_event_num_YN='".$_POST['booth_event_num_YN']."'";
	$query .= ", booth_top_text='".$_POST['booth_top_text']."'";
	$query .= ", booth_bottom_text='".$_POST['booth_bottom_text']."'";

	$query .= ", sponsor_top_text='".$_POST['sponsor_top_text']."'";
	$query .= ", sponsor_bottom_text='".$_POST['sponsor_bottom_text']."'";

	$query .= ", booth_txt='".$_POST['booth_txt']."'";
	$query .= ", sponsor_txt='".$_POST['sponsor_txt']."'";

	
	
	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO session_set_tbl SET ";

	$query .= " vip_info1='".$_POST['vip_info1']."'";
	$query .= ", vip_info2='".$_POST['vip_info2']."'";
	$query .= ", vip_info3='".$_POST['vip_info3']."'";
	$query .= ", vip_info4='".$_POST['vip_info4']."'";
	$query .= ", vip_info5='".$_POST['vip_info5']."'";
	$query .= ", vip_info6='".$_POST['vip_info6']."'";
	$query .= ", vip_info7='".$_POST['vip_info7']."'";
	$query .= ", vip_info8='".$_POST['vip_info8']."'";

	$query .= ", vip_width1='".$_POST['vip_width1']."'";
	$query .= ", vip_width2='".$_POST['vip_width2']."'";
	$query .= ", vip_width3='".$_POST['vip_width3']."'";
	$query .= ", vip_width4='".$_POST['vip_width4']."'";
	$query .= ", vip_width5='".$_POST['vip_width5']."'";
	$query .= ", vip_width6='".$_POST['vip_width6']."'";
	$query .= ", vip_width7='".$_POST['vip_width7']."'";
	$query .= ", vip_width8='".$_POST['vip_width8']."'";

	$query .= ", vip_color1='".$_POST['vip_color1']."'";
	$query .= ", vip_color2='".$_POST['vip_color2']."'";
	$query .= ", vip_color3='".$_POST['vip_color3']."'";
	$query .= ", vip_color4='".$_POST['vip_color4']."'";
	$query .= ", vip_color5='".$_POST['vip_color5']."'";
	$query .= ", vip_color6='".$_POST['vip_color6']."'";
	$query .= ", vip_color7='".$_POST['vip_color7']."'";
	$query .= ", vip_color8='".$_POST['vip_color8']."'";

	$query .= ", booth_ui_type='".$_POST['booth_ui_type']."'";
	$query .= ", booth_ui_type2='".$_POST['booth_ui_type2']."'";
	$query .= ", booth_group_YN='".$_POST['booth_group_YN']."'";
	$query .= ", booth_event_cnt='".$_POST['booth_event_cnt']."'";
	$query .= ", booth_event_cnt2='".$_POST['booth_event_cnt2']."'";
	$query .= ", booth_event_num_YN='".$_POST['booth_event_num_YN']."'";
	$query .= ", booth_top_text='".$_POST['booth_top_text']."'";
	$query .= ", booth_bottom_text='".$_POST['booth_bottom_text']."'";

	$query .= ", sponsor_top_text='".$_POST['sponsor_top_text']."'";
	$query .= ", sponsor_bottom_text='".$_POST['sponsor_bottom_text']."'";

	$query .= ", booth_txt='".$_POST['booth_txt']."'";
	$query .= ", sponsor_txt='".$_POST['sponsor_txt']."'";

	$query .= "code='".$code."'";
	
}
mysqli_query($conn, $query);
?>
<script>
	opener.location.reload();
	window.close();
</script>