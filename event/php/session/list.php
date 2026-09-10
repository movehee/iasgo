<?include "./../header.php";?>
<?

$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
$abs_setting_result = mysqli_query($conn, $abs_setting_query);
$abs_setting_col = mysqli_fetch_array($abs_setting_result);



$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$title=$setting_col['program_txt'];
if($tab=="-1"){ //now session
	$title=$setting_col['now_txt'];
}else if($tab=="-2"){ //즐겨찾기
	$title=$setting_col['favor_txt'];
}else if($tab=="-3"){ //검색
	$title=$setting_col['search_txt'];
}else if($tab=="-4"){
	$title="Program by Session";
}else if($tab=="-5"){ //faculty 검색
	if($setting_col['faculty']){
		$title=$setting_col['faculty'];
	}else{
		$title="faculty";
	}
}else if($tab=="-6"){
	$title=$setting_col['memo_txt'];
}else if($tab=="-7"){
	$title=$abs_setting_col['abstract_txt'];
}else if($tab=="-8"){
	$title="Highlight";
}

if(!$tab){
	$result = mysqli_query($conn, "SELECT sid from agenda_tbl where eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("y"))."' and code='".$code."' and del='N'");
	$row = mysqli_fetch_array($result);
	$tab = $row['sid'];

	if(!$tab){
		$result = mysqli_query($conn, "SELECT sid from agenda_tbl where code='".$code."' and del='N' order by sid asc limit 1");
		$row = mysqli_fetch_array($result);
		$tab = $row['sid'];
	}
}?>


<?
		
	//1125Y Start
	$query_str = "and a.viewYN='Y' ";
	
		if ( $code == "kddw2019" ) {
			$query_str = "and (a.viewYN='Y'or highlight = 1 ) ";
		}
		
		//1125Y End
	
	
if($tab=="-1"){

	$result = mysqli_query($conn, "SELECT sid from agenda_tbl where eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("y"))."' and code='".$code."' and del='N'");
	$row = mysqli_fetch_array($result);
	$day = $row['sid'];

	if($day){

		$time_query = "select * from session_time_tbl where tab='".$day."' and del='N' order by orderby asc";
		$time_result = mysqli_query($conn, $time_query);



		$query = "SELECT a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo FROM session_tbl a, session_room_tbl r, session_time_tbl t ";
		//1125Y
		$query .= "  WHERE a.time=t.sid and a.room=r.sid and a.type = '1'  and a.code='".$code."'  $query_str";//and a.viewYN='Y' ";
		
		
		
		$query .= " and a.tab = '".$day."' ";

		$query .= " and a.time in ('0'";
		while(is_array($time_col = mysqli_fetch_array($time_result))){
			$time_temp = explode('-', $time_col['time']);
			/*if($time_temp[0]<date("H:i") && $time_temp[1]>date("H:i")){
			$query .=",'".$time_col['sid']."'";
			}*/
			if($time_temp[0]<=date("H:i") && $time_temp[1]>=date("H:i")){
			$query .=",'".$time_col['sid']."'";
			}
		}
		$query .= ")";
		$query .= " order by a.orderby asc";
		$result = mysqli_query($conn, $query);
	}
}else if($tab=="-2"){
	$query = "SELECT a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo FROM session_tbl a, session_favor_tbl b, session_room_tbl r, session_time_tbl t ";
	//1125Y
	$query .= "  WHERE a.time=t.sid and a.room=r.sid and a.sid=b.session_sid and a.type = '1' and a.code='".$code."' $query_str ";//and a.viewYN='Y' ";
	
	
	$query .= " and b.deviceid = '".$deviceid."' ";
	$query .= " order by a.tab, a.orderby asc";
	$result = mysqli_query($conn, $query);
}else if($tab=="-3"){
	if($search) {
		if($setting_col['faculty_type']==1){

			$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo
			from session_tbl a LEFT JOIN session_faculty_tbl b ON a.sid=b.session_sid LEFT JOIN faculty_tbl c ON b.faculty_sid=c.sid Inner JOIN session_room_tbl r ON a.room=r.sid Inner JOIN session_time_tbl t ON a.time=t.sid
			WHERE a.code='".$code."'
			and a.type='1' $query_str"; //1125Y
			
			$query .= "  and (a.theme like '%".$search."%' or a.sub_theme like '%".$search."%' or c.name like '%".$search."%' or c.name_en like '%".$search."%' or a.etc_faculty like '%".$search."%')
			group by a.sid order by a.tab asc, a.orderby asc";

		}else{
			$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t  where a.time=t.sid and a.room=r.sid and a.type='1' and a.code='".$code."' ";
			$query .= " and (a.theme like '%".$search."%' or a.sub_theme like '%".$search."%' or a.chair like '%".$search."%' or a.panel like '%".$search."%' or a.discusser like '%".$search."%' or a.etc_faculty like '%".$search."%') order by tab asc, orderby asc";

		}
		//echo "<br><Br><br>".$query;
		$result = mysqli_query($conn, $query);
	}
}else if($tab=="-4"){
//1125Y
	$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' $query_str";//and a.viewYN='Y' ";

	
	if($category){
		$query .= " and a.category1='".$category."' ";
	}
	$query .= " order by a.tab asc, a.orderby asc";
	$result = mysqli_query($conn, $query);

}else if($tab=="-5"){ //faculty 검색

	

	if($setting_col['faculty_session_type']==2){
//1125Y
		$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_faculty_tbl b, faculty_tbl c, session_room_tbl r, session_time_tbl t,session_tbl a left join session_tbl s on a.sid=s.link_session where a.time=t.sid and a.room=r.sid and (a.sid=b.session_sid or s.sid=b.session_sid) and b.faculty_sid=c.sid and a.code='".$code."' and a.type='1'  $query_str ";//and a.viewYN='Y'
		
		
		$query .= " and b.faculty_sid = '".$sid."' ";
		$query .= "group by a.sid order by a.tab asc, a.orderby asc";
		$result = mysqli_query($conn, $query);
		//echo $query;
	
	
	}else{
		//1125Y
		$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_faculty_tbl b, faculty_tbl c, session_room_tbl r, session_time_tbl t  where a.time=t.sid and a.room=r.sid and a.sid=b.session_sid and b.faculty_sid=c.sid and a.code='".$code."' and a.type='1' $query_str";//and a.viewYN='Y' ";
		
		
		$query .= " and b.faculty_sid = '".$sid."' ";
		$query .= "group by a.sid order by a.tab asc, a.orderby asc";
		$result = mysqli_query($conn, $query);
	}



	$faculty_query = "select * from faculty_tbl where sid='".$sid."'";
	$faculty_result = mysqli_query($conn, $faculty_query);
	$faculty_row = mysqli_fetch_array($faculty_result);

}else if($tab=="-7"){

	$query = "select a.* from session_tbl a, session_tbl b  where a.sid=b.link_session and a.type='1' and a.code='".$code."' and (b.abs_no not in ('') or b.lecture_file not in ('')) and b.abs_no is not null";
	if($category){
		$query .= " and a.category1='".$category."' ";
	}
	$query .= " group by a.sid order by a.tab asc, a.orderby asc";
	$result = mysqli_query($conn, $query);


}else if($tab=="-8"){

	$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' and highlight='1'";
	$query .= " order by a.tab asc, a.orderby asc";
	$result = mysqli_query($conn, $query);
} else {
	$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.view_type, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.tab='".$tab."' $query_str ";//and a.viewYN='Y' ";
	if($room){
		$query .= " and a.room='".$room."' ";
	}
	if($category){
		$query .= " and a.category1='".$category."' ";
	}
	$query .= " order by a.tab asc, a.orderby asc";
	$result = mysqli_query($conn, $query);
}
?>


<div class="wrapper" >


<div id="fixedTop">

	<!-- container -->
	<div id="containerWrap">
	<?if($toptext){?>
		<div class="ws_titArea">
			<h2><?=$toptext?></h2>
			<p><a href="close.php">닫기</a></p>
		</div>
	<?}?>
<?if(!$glanceYN){?>
		<div class="titArea">
			<h2><?=$title?></h2>
			<p class="fixedBtn">
				<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
				<?if($tab!="-3"){?>
				<a href="./list.php?tab=-3&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>" class="search"><i class="fas fa-search" title="검색"></i></a>
				<?}?>
			</p>
		</div>
<?}else{?>
	<div class="titArea">
		<h2><?=$title?$title:"Program at a Glance";?></h2>
		<p class="fixedBtn">
			<a href="back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		</p>
	</div>
<?}?>
<?
	if($tab=="-3"){?>

	<div class="searchArea">
		<form id="" name="" action="./list.php" method="post">
			<fieldset>
				<legend>Search</legend>
				<input type="hidden" name="tab" value="<?=$tab?>">
				<input type="hidden" name="code" value="<?=$code?>">
				<input type="hidden" name="deviceid" value="<?=$deviceid?>">
				<input type="hidden" name="toptext" value="<?=$toptext?>">
				<input type="text" name="search" id="search" value="<?=$search?>" placeholder="<?=$string['search_keyword_txt']?>">
				<button class="search"><i class="fab fa-sistrix" title="검색"></i></button>
			</fieldset>
		</form>
	</div>

	<?
	}else if ($tab>"0"){
		include "./day_select.php";
		include "./select_box.php";
	}else if($tab=="-5"){
	?>

		<div class="speakersInfo">
		<?if($setting_col['faculty_photo']=="1"){?>
			<p class="photo">
			<?if($faculty_row['photo']){?><img src="/upload/faculty/<?=$faculty_row['photo']?>">
			<?}else if($setting_col['faculty_def_image']){?>

			<img src="/upload/faculty/<?=$setting_col['faculty_def_image']?>" alt="">
			<?}else{?>
			<img src="/image/photo_bg.jpg" alt="">
			<?}?>
			</p>
		<?}?>
			<dl>
			<?

				//$faculty_view_txt = str_replace($faculty_row['name_en'], '', $faculty_view_txt);

				if($faculty_row['foreigner']=='Y') {
					$faculty_view_txt = $setting_col['faculty_txt_type_view_eng'];
				}
				else {
					$faculty_view_txt = $setting_col['faculty_txt_type_view_kor'];
				}
				

				$faculty_view_txt = str_replace("{성함(국문)}", $faculty_row['name'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{성함(영문)}", $faculty_row['name_en'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{소속(국문)}", $faculty_row['office'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{소속(영문)}", $faculty_row['office_en'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{국가}", $faculty_row['country'], $faculty_view_txt);
				$faculty_view_txt = str_replace("{역할}", $faculty_row['role'], $faculty_view_txt);
			?>
			<?=$faculty_view_txt?>
			</dl>

			<?if($faculty_row['cv_file']){?>
			<p class="btn"><a href="<?if($setting_col['cv_file']=="Y"){?>/upload/faculty/<?}?><?=$faculty_row['cv_file']?>" class="btnBdPoint"  style="height:33px"><i class="fas fa-user-circle"></i> CV</a> </p>
			<?}?>
		</div>
	<?}else if($tab=="-2" || $tab=="-6"){
		if($setting_col['memo']=="Y"){?>
		<ul class="tabMenu">
			<li class="menu<?if($tab=="-2"){echo " on";}?>" style="width:50%"><a href="./list.php?tab=-2&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>"><?=$setting_col['favor_txt']?></a></li>

			<li class="menu<?if($tab=="-6"){echo " on";}?>" style="width:50%"><a href="./list.php?tab=-6&code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>"><?=$setting_col['memo_txt']?></a></li>
		</ul>
	<?}}?>
</div>
</div>
<?if($tab>0){?>
<div>
<?=$setting_col['session_top_txt']?>
</div>
<?}?>
<?

if($tab=='-2' && $code=='koa2019f') {
	include "./info_integration.php";
}
else {

	include "./info.php";
	include "./info_sub.php";

	if($tab=="-3" && $search){
		
		include "./info_faculty.php";
	}

	if($tab=="-3" && $search && $setting_col['abs_search']=='Y'){ //abstract 검색
		
		if($abs_setting_col['abs_sync'] == 'Y') {
			//include_once $_SERVER['DOCUMENT_ROOT']."/php/abstract/".$code."/list.php";
			include_once $_SERVER['DOCUMENT_ROOT']."/php/abstract/".$code."/list_search.php";
		}
		else {
			//나중에 추가
		}
	}

}
?>

<?if($cnt2==0 && $cnt3==0 && $cnt_f==0 && $tab != -5){?>
<div style="text-align:center;" class="resultArea <?if($search){?> noBg<?}else if($tab=="-1"){?> nonow<?}?>">
<?
if($search){?>
	<div class="noResult"><?=$string['search_no_result_txt']?></div> 
<?}else{?>
	<?if($tab != -1){?>
	<div class="noResult"><?=$string['search_keyword_default_txt']?></div> 
	<?}?>
<?}?>

<!-- <div class="noResult">No search results</div> -->
</div>
<?}?>

<?
	include "./memo.php";
?>
<?
if($setting_col['evaluation']=="Y2" || $setting_col['evaluation']=="Y3"){
	$setting_col['evaluation']="N"; //하단에 보이기 기능 때문에 리스트에서 안보이게하기
}
	include "./evaluation.php";
?>

</div>

<div style="width:100%;height:20px">&nbsp</div>



<div id="fixedArea">
	<?
	include "./alarm.php";
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
<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>



<script>
jQuery(function($) {

	$("ul.programMenu > li").css('width',$(window).width()/$("ul.programMenu > li").size()-1);
	//alert($("ul.programMenu > li") .size());
	//alert($("span.sessionTit").css('font-size'));
	//$("span.sessionTit").css('font-size','20px');
	//$("p.sessionBrief a span").css('font-size','20px');
	
	$(".btnFeedback").click(function(){
		
		var sid = $(this).attr("data");
		
		if( $(this).hasClass("feedon") ){
			var status = "N";
			$(this).html("Feedback On");
			$(this).removeClass("feedon");
		}else{
			var status = "Y";
			
			$(".btnFeedback").html("Feedback On");
			$(".btnFeedback").removeClass("feedon");
			
			$(this).html("Feedback Off");
			$(this).addClass("feedon");
		}
		
		$.ajax({
			type:"POST",
			url:"./feedback_ajax.php",
			data:{ status : status, sid : sid, code : '<?=$_GET['code']?>' },
			async: false,
			success:function(data){
				console.log(data);
			}
		});
		
	});
	
});



window.onload = function() {
	var array = document.location.href.split('#');
	if ( document.getElementById(array[1]+"_sub")  != null )document.getElementById(array[1]+"_sub").style.display ="block";
	
	
}





</script>



</body>
</html>
