<?
if(!$_COOKIE['abs_font'])
{
	setcookie('abs_font', '1', 0, '/', "");
	$_COOKIE['abs_font']="1";
}
?>
<?include "./../header.php";?>


<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
$abs_setting_result = mysqli_query($conn, $abs_setting_query);
$abs_setting_col = mysqli_fetch_array($abs_setting_result);



$query = "select * from session_tbl WHERE sid = '".$sid."'";
$result = mysqli_query($conn, $query);
$subcol = mysqli_fetch_array($result);

$query = "select * from session_tbl WHERE sid = '".$subcol['link_session']."'";
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);


$temp_result = mysqli_query($conn, "select count(*) cnt from session_favor_tbl WHERE code='".$code."' and session_sid='".$sid."' and deviceid='".$deviceid."'");
$temp_row = mysqli_fetch_array($temp_result);
$fav = $temp_row['cnt'];


$temp_result = mysqli_query($conn, "select count(*) cnt from session_like_tbl WHERE code='".$code."' and session_sid='".$sid."' and deviceid='".$deviceid."'");
$temp_row = mysqli_fetch_array($temp_result);
$mylike = $temp_row['cnt'];

$temp_result = mysqli_query($conn, "select count(*) cnt from session_like_tbl WHERE code='".$code."' and session_sid='".$sid."'");
$temp_row = mysqli_fetch_array($temp_result);
$like_cnt = $temp_row['cnt'];



$evaluation_result = mysqli_query($conn, "select * from session_evaluation_tbl WHERE code='".$code."' and session_sid='".$sid."' and deviceid='".$deviceid."'");
$evaluation_row = mysqli_fetch_array($evaluation_result);

$memo_result = mysqli_query($conn, "select * from session_memo_tbl WHERE code='".$code."' and session_sid='".$sid."' and deviceid='".$deviceid."'");
$memo_row = mysqli_fetch_array($memo_result);

if($code == "ksc2019" && $subcol['abs_no']) {
	$abs_no_arr = explode('||', $subcol['abs_no']);
	$subcol['abs_no'] = $abs_no_arr['2'];
}


if($subcol['abs_no']){
$abs_query = "select * from abstract_tbl WHERE code='$code' and abs_no = '".$subcol['abs_no']."'";
$abs_result = mysqli_query($conn, $abs_query);
$abs_col = mysqli_fetch_array($abs_result);
}
?>

<div class="wrapper">
	<!-- container -->
	<div id="containerWrap">
		<?if($toptext){?>
		<div class="ws_titArea">
			<h2>2019년 춘계학술대회</h2>
			<p><a href="close.php">닫기</a></p>
		</div>
	<?}?>
	<?if(!$glanceYN || $title){?>
<div class="titArea">
	<h2><?if($title){?><?=$title?><?}else{?><?=$setting_col['program_txt']?><?}?></h2>
	<p class="fixedBtn">
		<a onclick="javascript:history.back();" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
	</p>
</div>
<?}?>


<div class="session">
	<p class="sessionSub_Brief">
		<?if($setting_col['abs_sid']=="Y" && $subcol['abs_sid']){?>
			<span class="sessionCode"><?=$subcol['abs_sid']?></span>
		<?}?>
		<?if($setting_col['abs_no']=="Y" && $subcol['abs_no']){?>
			<span class="sessionCode2"><?if(strpos($subcol['abs_no'], "]")===false){?>[<?}?><?=$subcol['abs_no']?><?if(strpos($subcol['abs_no'], "]")===false){?>]<?}?></span>

		<?}?>

		<?if($setting_col['title']=="Y" && $subcol['title']){?>
			<span class="sessionTit"><?=$subcol['title']?></span>
		<?}?>

		<?if($subcol['time']){?>
			<span class="speaker"><?=$subcol['time']?></span>
		<?}?>

		<?
			$faculty_session_sid=$subcol['sid'];
			$faculty_info="speaker";
			$faculty_view_type=3;
			$session_sid=$subcol['sid'];
			include "./speaker.php";
		?>

		<?if($setting_col['etc_speaker']=='Y'){?>
		<?if($subcol['etc_speaker']){?>
			<span class="etc_speaker"><?=$subcol['etc_speaker']?></span>

		<?}}?>
	</p>

	<ul class="sessionUtil">

		<?if($setting_col['sub_favor']=="Y"){?>
		<li>
			<a href="javascript:favor2('<?=$subcol['sid']?>','<?=$deviceid?>')" id="favor" class="favorTxt <?if($fav){echo " on";}?>" title="즐겨찾기 추가하기"><i class="fas fa-star"></i> <?=$setting_col['favor_txt']?></a>
		</li>
		<?}?>

		<?if($subcol['lecture_file']){?>
			<li><a href="/upload/session/<?=$subcol['lecture_file']?>" class="btnLect" target="_blabk;"><i class="fas fa-book"></i> <?=$setting_col['lecture_txt']?><?if($subcol['lecture_file2']){?><?}?></a></li>
		<?}?>
		<?if($subcol['lecture_file2']){?>
			<li><a href="/upload/session/<?=$subcol['lecture_file']?>" class="btnLect"><i class="fas fa-book"></i> <?=$setting_col['lecture_txt']?></a></li>
		<?}?>

		<?if($subcol['abstract_file']){?>
			<li><a href="/upload/session/<?=$subcol['abstract_file']?>" class="btnAbs"><i class="far fa-file-alt"></i> <?=$abs_setting_col['abstract_btn_txt']?></a></li>
		<?}?>

		<?if(file_exists("../../upload/code/".$code."/".str_replace("]","",str_replace("[","",$subcol['abs_no'])).".pdf")){?>
			<li><a href="/upload/code/<?=$code?>/<?=str_replace("]","",str_replace("[","",$subcol['abs_no']))?>.pdf" class="btnAbs"><i class="far fa-file-alt"></i> <?=$abs_setting_col['abstract_txt']?></a></li>
		<?}?>
		<?if($setting_col['speaker_info']=="Y"){?>
		<?if($setting_col['faculty_type']==1 && $speaker_sid){?>
		<!--
			<?if($cv_file){?>
			<li><a href="<?if($setting_col['cv_file']=="Y"){?>/upload/faculty/<?}?><?=$cv_file?>" class="btnCV"><i class="fas fa-book"></i> CV</a></li>
			<?}?>
		-->
			<li><a href="./list.php?tab=-5&code=<?=$code?>&sid=<?=$speaker_sid?>&deviceid=<?=$deviceid?>&glanceYN=<?=$glanceYN?>" class="btnCV"><i class="fas fa-user"></i> <?=$setting_col['speaker_info_txt']?></a></li>

		<?}else{?>
		<?if($subcol['cv_file']){?>
			<li><a href="/upload/session/<?=$subcol['cv_file']?>" class="btnCV"><i class="far fa-user-circle"></i> CV</a></li>
		<?}}?>
		<?}?>


		<?if($setting_col['memo']=="Y"){?>
			<li><a class="btnMemo"><i class="fas fa-edit"></i> <?=$setting_col['memo_txt2']?></a></li>
		<?}?>
		
		<?if($setting_col['evaluation']=="Y"){?>
			<li><a class="btnEvaluation"><i class="fas fa-star"></i><?=$setting_col['lecture_evaluation_txt']?></a></li>
		<?}?>

		<?if($setting_col['islike']=="Y"){?>
			<li><a class="btnLike <?if($mylike){echo "on";}?>" id="session_like" href="javascript:sessionlike('<?=$code?>','<?=$subcol['sid']?>','<?=$deviceid?>','<?=$setting_col['like_txt']?>')"><i class="fas fa-heart"></i> <?=$like_cnt?> <?=$setting_col['like_txt']?></a></li>
		<?}?>

		
		<?if($setting_col['isshare']=='Y'){?>
			<li><a class="btnShare" href="social.php?code=<?=$code?>&sid=<?=$subcol['sid']?>&title=<?=rawurlencode($subcol['title'])?>&time=<?=rawurlencode($subcol['time'])?>"><i class="far fa-share-square"></i> Share</a></li>
		<?}?>



	</ul>

<?
if($abs_setting_col['abs_sync']=='Y') {
	$view_from = "session";
	include_once $_SERVER['DOCUMENT_ROOT']."/php/abstract/$code/view.php";
} else {
?>

	<?if(($abs_setting_col['abs_info1'] && $abs_col['info1']) || ($abs_setting_col['abs_info2'] && $abs_col['info2']) || ($abs_setting_col['abs_info3'] && $abs_col['info3']) || ($abs_setting_col['abs_info4'] && $abs_col['info4']) || ($abs_setting_col['abs_info5'] && $abs_col['info5']) || ($abs_setting_col['abs_info6'] && $abs_col['info6']) || ($abs_setting_col['abs_info7'] && $abs_col['info7']) || ($abs_setting_col['abs_info8'] && $abs_col['info8']) || 
	($abs_setting_col['abs_info9'] && $abs_col['info9']) || ($abs_setting_col['abs_info10'] && $abs_col['info10']) || 
	($abs_setting_col['abs_info11'] && $abs_col['info11']) || ($abs_setting_col['abs_info12'] && $abs_col['info12']) || ($abs_setting_col['abs_info13'] && $abs_col['info13']) || ($abs_setting_col['abs_info14'] && $abs_col['info14']) || ($abs_setting_col['abs_info15'] && $abs_col['info15']) || ($abs_setting_col['abs_info16'] && $abs_col['info16']) ){?>
	<div class="abstractCon plus<?=$_COOKIE['abs_font']?>" id="abstractCon">
		<dl class="fontUtil">
			<dt><a href="#" class="trigger"><span class="font01"><?=$string['abs_zoom_txt']?></span> <?=$string['abs_zoom_txt']?></a></dt>
			<dd class="toggleCon">
				<ul>
					<li <?if($_COOKIE['abs_font']=="1"){?>class="on" <?}?> id="font1"><a href="javascript:font_size(1)" class="font01"><?=$string['abs_zoom_txt']?></a></li>
					<li <?if($_COOKIE['abs_font']=="2"){?>class="on" <?}?> id="font2"><a href="javascript:font_size(2)" class="font02"><?=$string['abs_zoom_txt']?></a></li>
					<li <?if($_COOKIE['abs_font']=="3"){?>class="on" <?}?> id="font3"><a href="javascript:font_size(3)" class="font03"><?=$string['abs_zoom_txt']?></a></li>
				</ul>
			</dd>
		</dl>

		<dl class="<?if($abs_setting_col['abs_align']=="1"){?>txtAlignJ<?}else{?>txtAlignL<?}?>">

		<?for($ano=1; $ano<=16; $ano++) {?>
			<?if($abs_setting_col['abs_info'.$ano] && $abs_col['info'.$ano]){?>
				<dt class="absTit"><?=$setting_col['abs_info'.$ano]?></dt>
				<dd><?=str_replace("\n","<br>",$abs_col['info'.$ano])?></dd>
			<?}?>
		<?}?>
		
		<!--
		<?if($setting_col['abs_info1'] && $abs_col['info1']){?>
			<dt class="absTit"><?=$setting_col['abs_info1']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info1'])?></dd>
		<?}?>
		<?if($setting_col['abs_info2'] && $abs_col['info2']){?>
			<dt class="absTit"><?=$setting_col['abs_info2']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info2'])?></dd>
		<?}?>
		<?if($setting_col['abs_info3'] && $abs_col['info3']){?>
			<dt class="absTit"><?=$setting_col['abs_info3']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info3'])?></dd>
		<?}?>
		<?if($setting_col['abs_info4'] && $abs_col['info4']){?>
			<dt class="absTit"><?=$setting_col['abs_info4']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info4'])?></dd>
		<?}?>
		<?if($setting_col['abs_info5'] && $abs_col['info5']){?>
			<dt class="absTit"><?=$setting_col['abs_info5']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info5'])?></dd>
		<?}?>
		<?if($setting_col['abs_info6'] && $abs_col['info6']){?>
			<dt class="absTit"><?=$setting_col['abs_info6']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info6'])?></dd>
		<?}?>
		<?if($setting_col['abs_info7'] && $abs_col['info7']){?>
			<dt class="absTit"><?=$setting_col['abs_info7']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info7'])?></dd>
		<?}?>
		<?if($setting_col['abs_info8'] && $abs_col['info8']){?>
			<dt class="absTit"><?=$setting_col['abs_info8']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info8'])?></dd>
		<?}?>
		<?if($setting_col['abs_info9'] && $abs_col['info9']){?>
			<dt class="absTit"><?=$setting_col['abs_info9']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info9'])?></dd>
		<?}?>
		<?if($setting_col['abs_info10'] && $abs_col['info10']){?>
			<dt class="absTit"><?=$setting_col['abs_info10']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info10'])?></dd>
		<?}?>

		<?if($setting_col['abs_info11'] && $abs_col['info11']){?>
			<dt class="absTit"><?=$setting_col['abs_info11']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info11'])?></dd>
		<?}?>
		<?if($setting_col['abs_info12'] && $abs_col['info12']){?>
			<dt class="absTit"><?=$setting_col['abs_info12']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info12'])?></dd>
		<?}?>
		<?if($setting_col['abs_info13'] && $abs_col['info13']){?>
			<dt class="absTit"><?=$setting_col['abs_info13']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info13'])?></dd>
		<?}?>
		<?if($setting_col['abs_info14'] && $abs_col['info14']){?>
			<dt class="absTit"><?=$setting_col['abs_info14']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info14'])?></dd>
		<?}?>
		<?if($setting_col['abs_info15'] && $abs_col['info15']){?>
			<dt class="absTit"><?=$setting_col['abs_info15']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info15'])?></dd>
		<?}?>
		<?if($setting_col['abs_info16'] && $abs_col['info16']){?>
			<dt class="absTit"><?=$setting_col['abs_info16']?></dt>
			<dd><?=str_replace("\n","<br>",$abs_col['info16'])?></dd>
		<?}?>
		-->

		</dl>
	</div>
	<?}?>
	<?
		$photo_cnt_query = "select count(*) cnt from abstract_file_tbl WHERE abstract_sid = '".$abs_col['sid']."'";
		$photo_cnt_result = mysqli_query($conn, $photo_cnt_query);
		$photo_cnt_col = mysqli_fetch_array($photo_cnt_result);
		if($photo_cnt_col['cnt']>0){
	?>
	<div style="margin: 10px;">
		<ul class="thumbnailwrap">
		<?
		$photo_query = "select * from abstract_file_tbl WHERE abstract_sid = '".$abs_col['sid']."'";
			//echo $photo_query;
		$photo_result = mysqli_query($conn, $photo_query);
		
		while(is_array($photo_col = mysqli_fetch_array($photo_result))){?>
			<li><a href="/upload/abstract/thumbnail/<?=$photo_col['file']?>"><!-- <span class="thumbTit">타이틀</span> --><img  src="/upload/abstract/thumbnail/<?=$photo_col['file']?>"></a>
		</li>
		<?}?>
		</ul>
	</div>
	<?}?>
<?}?>


<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
 
</div>

<?
	include "./memo.php";
?>

<?
	include "./evaluation.php";
?>

<?
if($setting_col['session_show']=="1"){
$sub_view = true;
$tab="0";
$query = "select a.*,t.time time_info, r.name room_info, r.photo room_photo from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.viewYN='Y' ";
$query .= " and a.sid='".$subcol['link_session']."' ";
$query .= " order by a.tab asc, a.orderby asc";
$result = mysqli_query($conn, $query);
include "./info.php";

include "./alarm.php";

}?>

<script>
	
	function sessionlike(code, sid, deviceid,txt){

		$.ajax({
			type:"POST",
			url:"./like.php",
			data:"code="+code+"&session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				var temp = msg.split("|");
				if(temp[0] == "Y"){
					$('#session_like').addClass("on");
				}else{
					$('#session_like').removeClass("on");
				}

				document.getElementById("session_like").innerHTML="<i class='fas fa-heart'></i> "+temp[1] +" "+txt;

				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});

	}


	function favor2(sid, deviceid){

		$.ajax({
			type:"POST",
			url:"./favor.php",
			data:"code=<?=$code?>&type=2&session_sid="+sid+"&deviceid="+deviceid,
			success:function(msg){
				if(msg == "Y"){
					$('#favor').addClass("on");
				}else{
					$('#favor').removeClass("on");
				}

				//location.href="KNA://sid="+gubun+sid+"&favor=N";

			}
		});

	}

	function font_size(font){

		var setCookie = function(name, value, exp) {
			  var date = new Date();
			  date.setTime(date.getTime() + exp*24*60*60*1000);
			  document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
			};
			setCookie('abs_font', font, 7);


		if(font=="1"){
			$('#abstractCon').addClass("plus1");
			$('#abstractCon').removeClass("plus2");
			$('#abstractCon').removeClass("plus3");
			$('#font1').addClass("on");
			$('#font2').removeClass("on");
			$('#font3').removeClass("on");


		}else if(font=="2"){
			$('#abstractCon').removeClass("plus1");
			$('#abstractCon').addClass("plus2");
			$('#abstractCon').removeClass("plus3");
			$('#font1').removeClass("on");
			$('#font2').addClass("on");
			$('#font3').removeClass("on");

		}else if(font=="3"){
			$('#abstractCon').removeClass("plus1");
			$('#abstractCon').removeClass("plus2");
			$('#abstractCon').addClass("plus3");
			$('#font1').removeClass("on");
			$('#font2').removeClass("on");
			$('#font3').addClass("on");

		}
	}

</script>


</body>
</html>
