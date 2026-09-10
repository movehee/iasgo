<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/php/header.php";
	
	$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
	$abs_setting_result = mysqli_query($conn, $abs_setting_query);
	$abs_setting_col = mysqli_fetch_array($abs_setting_result);

	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);

	$tab = "-1";
	$result = mysqli_query($conn, "SELECT sid from agenda_tbl where eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("y"))."' and code='".$code."' and del='N'");
	$row = mysqli_fetch_array($result);
	$day = $row['sid'];
	//$day = 211;
	if($day){

		$time_query = "select * from session_time_tbl where tab='".$day."' and del='N' order by orderby asc";
		$time_result = mysqli_query($conn, $time_query);

		$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' and a.liveYN='Y'";
		
		$query .= " and a.tab = '".$day."' ";

		if($room){
			$query .= " and a.room='".$room."' ";
		}

		$query .= " and a.time in ('0'";
		while(is_array($time_col = mysqli_fetch_array($time_result))){
			$time_temp = explode('-', $time_col['time']);

			if($time_temp[0]<=date("H:i") && $time_temp[1]>=date("H:i")){
			$query .=",'".$time_col['sid']."'";
			}
		}
		$query .= ")";
		$query .= " order by a.orderby asc";
		$result = mysqli_query($conn, $query);
	}


	/*
	$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' and a.liveYN='Y' and a.tab='211'";
	
	if($room){
		$query .= " and a.room='".$room."' ";
	}

	$query .= " order by a.tab asc, a.orderby asc";
	$result = mysqli_query($conn, $query);
	*/
?>
<style>
ul.roomInfo, ul.roomInfo li, ul.roomInfo a {margin: 0;padding: 0;list-style:none;text-decoration: none;}
ul.roomInfo {padding: 5px;}
ul.roomInfo:after {clear: both;display: block;height: 0;line-height: 0;font-size: 0;content: " ";}
ul.roomInfo > li {float: left;width: calc(50% - 10px);padding: 5px;}
ul.roomInfo a {display: block;line-height: 60px;border-radius:5px;text-align: center;background-color: #d3e0e7;color: #31657f;font-size: 15px;font-weight: bold;}
</style>
<div class="wrapper" >


<div id="fixedTop">

	<!-- container -->
	<div id="containerWrap">

		<div class="titArea">
			<h2>Live Streaming</h2>
			<p class="fixedBtn">
				<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
			</p>
		</div>
	</div>
</div>

<?


	include_once $_SERVER['DOCUMENT_ROOT']."/php/session/info.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/php/session/info_sub.php";



?>

<?if($cnt2==0 && $cnt3==0 && $cnt_f==0 && $tab != -5){?>
<div style="text-align:center;" class="resultArea <?if($search){?> noBg<?}else if($tab=="-1"){?> nonow<?}?>">
<?
if($search){?>
	<div class="noResult"><?=$string['search_no_result_txt']?></div> 
<?}else{?>
	<?if($tab != -1){?>
	<div class="noResult">라이브 세션이 없습니다.</div> 
	<?}?>
<?}?>

<!-- <div class="noResult">No search results</div> -->
</div>
<?}?>

<?
	//include "./memo.php";
?>
<?
if($setting_col['evaluation']=="Y2" || $setting_col['evaluation']=="Y3"){
	$setting_col['evaluation']="N"; //하단에 보이기 기능 때문에 리스트에서 안보이게하기
}
//	include "./evaluation.php";
?>

</div>

<div style="width:100%;height:20px">&nbsp</div>



<div id="fixedArea">
	<?
	//include "./alarm.php";
	?>

	<ul class="programMenu">
		<?if($tab!="-1" && $setting_col['bottom_menu_now']=="Y"){?>
			<li><a href="./list.php?code=<?=$code?>&toptext=<?=$toptext?>&tab=-1&deviceid=<?=$deviceid?>"><img src="/image/programMenu_01.png" alt="NOW"> </a></li>
		<?}?>

		<?if($tab<"0" && $setting_col['bottom_menu_program']=="Y"){?>
			<li><a href="./list.php?code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>"><img src="/image/programMenu_04.png" alt="Program"> </a></li>
		<?}?>

		<?if($setting_col['bottom_menu_glance']=="Y"){?>
		<li><a href="./glance.php?code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>"><img src="/image/programMenu_02.png" alt="Program At a Glance"> </a></li>
		<?}?>

		<?if($tab!="-2" && $setting_col['bottom_menu_myfav']=="Y"){?>
			<li><a href="./list.php?code=<?=$code?>&toptext=<?=$toptext?>&tab=-2&deviceid=<?=$deviceid?>"><img src="/image/programMenu_03.png" alt="My Schedule"> </a></li>
		<?}?>

		<?if($setting_col['bottom_menu_category']=="Y"){?>
			<li><a href="./category.php?code=<?=$code?>&tab=-5&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>"><img src="/image/programMenu_05.png" alt="My Schedule"> </a></li>
		<?}?>
	</ul>
</div>

<ul class="roomInfo">
	<?if($day == '211') {?>
	<li><a href="live_list.php?code=<?=$code?>&room=797">Convention A</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=798">Convention B</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=799">Convention C</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=800">Emerald A</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=801">Emerald B</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=802">Diamond</a></li>
	<?} else if($day == '212') {?>
	<li><a href="live_list.php?code=<?=$code?>&room=812">Convention A</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=813">Convention B</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=814">Convention C</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=815">Emerald A</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=816">Emerald B</a></li>
	<li><a href="live_list.php?code=<?=$code?>&room=817">Diamond</a></li>
	<?}?>
</ul>

<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>



<script>
jQuery(function($) {

	$("ul.programMenu > li").css('width',$(window).width()/$("ul.programMenu > li").size()-1);
	//alert($("ul.programMenu > li") .size());
	//alert($("span.sessionTit").css('font-size'));
	//$("span.sessionTit").css('font-size','20px');
	//$("p.sessionBrief a span").css('font-size','20px');


});


window.onload = function() {
	var array = document.location.href.split('#');
	if ( document.getElementById(array[1]+"_sub")  != null )document.getElementById(array[1]+"_sub").style.display ="block";
	
	
}





</script>



</body>
</html>
